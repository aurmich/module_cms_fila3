<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Modules\Notify\Datas\EmailData;
use Aws\CloudFront\CloudFrontClient;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\ComponentContainer;
use Modules\UI\Filament\Clusters\Test;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Actions\CloudFront\GetCloudFrontSignedUrlAction;
use Aws\S3\S3Client;
use Aws\Sts\StsClient;
use Aws\Exception\AwsException;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use function Safe\json_decode;
use function Safe\json_encode;

/**
 * @property ComponentContainer $form
 */
class S3Test extends XotBasePage
{
    protected static ?string $cluster = Test::class;
    
    public array $debugResults = [];
    
    private const DEFAULT_REGION = 'eu-west-1';
    private const TEST_FILE_PREFIX = 'test-upload-';
    private const PERMISSION_TEST_PREFIX = 'test-permissions-';
    private const CLOUDFRONT_TEST_FILE = 'test-file.txt';
    private const DEBUG_OUTPUT_ROWS = 15;
    private const URL_PREVIEW_LENGTH = 100;

    public function mount(): void
    {
        $this->fillForms();
        
    }

    protected function getForms(): array
    {
        return [
            'form',
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('testCredentials')
                ->label(__('ui::s3test.actions.testCredentials.label'))
                ->color('secondary')
                ->action('testCredentials'),
                
            Action::make('testS3Connection')
                ->label(__('ui::s3test.actions.testS3Connection.label'))
                ->color('info')
                ->action('testS3Connection'),
            
            Action::make('testPermissions')
                ->label(__('ui::s3test.actions.testPermissions.label'))
                ->color('warning')
                ->action('testPermissions'),
                
            Action::make('testBucketPolicy')
                ->label(__('ui::s3test.actions.testBucketPolicy.label'))
                ->color('danger')
                ->action('testBucketPolicy'),
                
            Action::make('testCloudFront')
                ->label(__('ui::s3test.actions.testCloudFront.label'))
                ->color('success')
                ->action('testCloudFront'),
                
            Action::make('testFileOperations')
                ->label(__('ui::s3test.actions.testFileOperations.label'))
                ->color('primary')
                ->action('testFileOperations'),
                
            Action::make('debugConfig')
                ->label(__('ui::s3test.actions.debugConfig.label'))
                ->color('gray')
                ->action('debugConfig'),
                
            Action::make('clearResults')
                ->label(__('ui::s3test.actions.clearResults.label'))
                ->color('warning')
                ->action('clearResults'),
                
            Action::make('sendEmail')
                ->label(__('ui::s3test.actions.sendEmail.label'))
                ->submit('sendEmail'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    FileUpload::make('attachment')
                        ->disk('s3')
                        ->directory('form-attachments')
                        ->visibility('private')
                        ->columnSpan(1),
                    
                    Textarea::make('debug_output')
                        ->rows(self::DEBUG_OUTPUT_ROWS)
                        ->default($this->getDebugOutput())
                        ->disabled()
                        ->columnSpan(1),
                ]),
        ];
    }

    protected function fillForms(): void
    {
        $this->form->fill([
            'debug_output' => $this->getDebugOutput()
        ]);
    }

    
    public function testS3Connection(): void
    {
        $this->debugResults['s3_connection'] = $this->testS3ConnectionDetails();
        $this->updateDebugOutput();
    }

    public function testPermissions(): void
    {
        $this->debugResults['permissions'] = $this->testS3Permissions();
        $this->updateDebugOutput();
    }

    public function testCloudFront(): void
    {
        $this->debugResults['cloudfront'] = $this->testCloudFrontConnection();
        $this->updateDebugOutput();
    }

    public function testCredentials(): void
    {
        $this->debugResults['credentials'] = $this->performCredentialsTest();
        $this->updateDebugOutput();
        
        Notification::make()
            ->title(__('ui::s3test.notifications.credentials_tested'))
            ->success()
            ->send();
    }

    public function testBucketPolicy(): void
    {
        $this->debugResults['bucket_policy'] = $this->checkBucketPolicy();
        $this->updateDebugOutput();
        
        Notification::make()
            ->title(__('ui::s3test.notifications.bucket_policy_tested'))
            ->success()
            ->send();
    }

    public function testFileOperations(): void
    {
        $this->debugResults['file_operations'] = $this->testFileUploadDownload();
        $this->updateDebugOutput();
        
        Notification::make()
            ->title(__('ui::s3test.notifications.file_operations_tested'))
            ->success()
            ->send();
    }

    public function debugConfig(): void
    {
        $this->debugResults['config'] = $this->buildConfigDebugData();
        $this->updateDebugOutput();
        
        Notification::make()
            ->title(__('ui::s3test.notifications.config_debugged'))
            ->success()
            ->send();
    }

    public function clearResults(): void
    {
        $this->debugResults = [];
        $this->updateDebugOutput();
        
        Notification::make()
            ->title(__('ui::s3test.notifications.results_cleared'))
            ->success()
            ->send();
    }
    

    private function buildConfigDebugData(): array
    {
        return [
            'title' => '📋 Configuration',
            'status' => 'info',
            'data' => [
                'AWS_ACCESS_KEY_ID' => substr((string) (config('filesystems.disks.s3.key', '')), 0, 8) . '...',
                'AWS_SECRET_ACCESS_KEY' => config('filesystems.disks.s3.secret') ? '✅ Present' : '❌ Missing',
                'AWS_DEFAULT_REGION' => config('filesystems.disks.s3.region'),
                'AWS_BUCKET' => config('filesystems.disks.s3.bucket'),
                'AWS_USE_PATH_STYLE_ENDPOINT' => config('filesystems.disks.s3.use_path_style_endpoint', 'false'),
                'CLOUDFRONT_BASE_URL' => config('services.cloudfront.base_url', env('CLOUDFRONT_RESOURCE_KEY_BASE_URL')),
                'CLOUDFRONT_KEYPAIR_ID' => config('services.cloudfront.key_pair_id', env('CLOUDFRONT_KEYPAIR_ID')),
                'CLOUDFRONT_PRIVATE_KEY' => config('services.cloudfront.private_key') || env('CLOUDFRONT_PRIVATE_KEY') ? '✅ Present' : '❌ Missing',
            ]
        ];
    }

    private function performCredentialsTest(): array
    {
        try {
            $sts = new StsClient([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ]
            ]);
            
            $result = $sts->getCallerIdentity();
            
            return [
                'title' => '🔐 AWS Credentials',
                'status' => 'success',
                'data' => [
                    'Valid' => '✅ Yes',
                    'Account ID' => $result['Account'],
                    'User ARN' => $result['Arn'],
                ]
            ];
            
        } catch (AwsException $e) {
            return [
                'title' => '🔐 AWS Credentials',
                'status' => 'error',
                'data' => [
                    'Valid' => '❌ No',
                    'Error' => $e->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $e->getMessage(),
                ]
            ];
        }
    }

    private function testS3ConnectionDetails(): array
    {
        try {
            $s3 = new S3Client([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ]
            ]);
            
            // Test bucket accessibility
            $s3->headBucket(['Bucket' => config('filesystems.disks.s3.bucket')]);
            
            // Get bucket region
            $location = $s3->getBucketLocation(['Bucket' => config('filesystems.disks.s3.bucket')]);
            $bucketRegion = $location['LocationConstraint'] ?: 'us-east-1';
            
            $regionMatch = $bucketRegion === config('filesystems.disks.s3.region');
            
            return [
                'title' => '☁️ S3 Connection',
                'status' => 'success',
                'data' => [
                    'Bucket Accessible' => '✅ Yes',
                    'Bucket Region' => $bucketRegion,
                    'Config Region' => config('filesystems.disks.s3.region'),
                    'Region Match' => $regionMatch ? '✅ Yes' : '⚠️ No - This might cause issues',
                ]
            ];
            
        } catch (AwsException $e) {
            return [
                'title' => '☁️ S3 Connection',
                'status' => 'error',
                'data' => [
                    'Bucket Accessible' => '❌ No',
                    'Error Code' => $e->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $e->getMessage(),
                    'Solution' => $this->getSolutionForError($e->getAwsErrorCode() ?? null),
                ]
            ];
        }
    }

    private function testS3Permissions(): array
    {
        $tests = [
            'ListBucket' => 's3:ListBucket',
            'PutObject' => 's3:PutObject',
            'GetObject' => 's3:GetObject',
            'DeleteObject' => 's3:DeleteObject',
        ];
        
        $results = [
            'title' => '🔒 S3 Permissions',
            'status' => 'info',
            'data' => []
        ];
        
        try {
            $s3 = new S3Client([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ]
            ]);
            
            $bucket = config('filesystems.disks.s3.bucket');
            $testKey = self::PERMISSION_TEST_PREFIX . time() . '.txt';
            
            // Test ListBucket
            try {
                $s3->listObjectsV2(['Bucket' => $bucket, 'MaxKeys' => 1]);
                $results['data']['ListBucket'] = '✅ OK';
            } catch (AwsException $e) {
                $results['data']['ListBucket'] = '❌ ' . ($e->getAwsErrorCode() ?? 'UnknownError');
            }
            
            // Test PutObject
            try {
                $s3->putObject([
                    'Bucket' => $bucket,
                    'Key' => $testKey,
                    'Body' => 'Test permissions',
                    'ACL' => 'private'
                ]);
                $results['data']['PutObject'] = '✅ OK';
                
                // Test GetObject (only if put succeeded)
                try {
                    $s3->getObject(['Bucket' => $bucket, 'Key' => $testKey]);
                    $results['data']['GetObject'] = '✅ OK';
                } catch (AwsException $e) {
                    $results['data']['GetObject'] = '❌ ' . ($e->getAwsErrorCode() ?? 'UnknownError');
                }
                
                // Test DeleteObject (cleanup)
                try {
                    $s3->deleteObject(['Bucket' => $bucket, 'Key' => $testKey]);
                    $results['data']['DeleteObject'] = '✅ OK';
                } catch (AwsException $e) {
                    $results['data']['DeleteObject'] = '❌ ' . ($e->getAwsErrorCode() ?? 'UnknownError');
                }
                
            } catch (AwsException $e) {
                $results['data']['PutObject'] = '❌ ' . ($e->getAwsErrorCode() ?? 'UnknownError');
                $results['data']['GetObject'] = 'Skipped (PutObject failed)';
                $results['data']['DeleteObject'] = 'Skipped (PutObject failed)';
            }
            
            $results['status'] = 'success';
            
        } catch (\Exception $e) {
            $results['status'] = 'error';
            $results['data']['Error'] = $e->getMessage();
        }
        
        return $results;
    }

    private function checkBucketPolicy(): array
    {
        try {
            $s3 = new S3Client([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ]
            ]);
            
            $policy = $s3->getBucketPolicy(['Bucket' => config('filesystems.disks.s3.bucket')]);
            
            return [
                'title' => '📜 Bucket Policy',
                'status' => 'info',
                'data' => [
                    'Policy Exists' => '✅ Yes',
                    'Policy' => json_encode(json_decode((string) $policy['Policy']), JSON_PRETTY_PRINT),
                ]
            ];
            
        } catch (AwsException $e) {
            if (($e->getAwsErrorCode() ?? '') === 'NoSuchBucketPolicy') {
                return [
                    'title' => '📜 Bucket Policy',
                    'status' => 'info',
                    'data' => [
                        'Policy Exists' => 'ℹ️ No (This is usually OK)',
                    ]
                ];
            }
            
            return [
                'title' => '📜 Bucket Policy',
                'status' => 'error',
                'data' => [
                    'Error' => $e->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $e->getMessage(),
                ]
            ];
        }
    }

    private function testCloudFrontConnection(): array
    {
        try {
            // Test CloudFront configuration
            $baseUrl = config('services.cloudfront.base_url', env('CLOUDFRONT_RESOURCE_KEY_BASE_URL'));
            $keyPairId = config('services.cloudfront.key_pair_id', env('CLOUDFRONT_KEYPAIR_ID'));
            $privateKey = config('services.cloudfront.private_key', env('CLOUDFRONT_PRIVATE_KEY'));
            
            if (!$baseUrl || !$keyPairId || !$privateKey) {
                return [
                    'title' => '☁️ CloudFront',
                    'status' => 'error',
                    'data' => [
                        'Configuration' => '❌ Incomplete',
                        'Missing' => collect([
                            'Base URL' => !$baseUrl,
                            'Key Pair ID' => !$keyPairId,
                            'Private Key' => !$privateKey,
                        ])->filter()->keys()->implode(', ')
                    ]
                ];
            }
            
            // Test signed URL generation
            $testUrl = GetCloudFrontSignedUrlAction::execute(self::CLOUDFRONT_TEST_FILE, 5);
            
            return [
                'title' => '☁️ CloudFront',
                'status' => 'success',
                'data' => [
                    'Configuration' => '✅ Complete',
                    'Base URL' => $baseUrl,
                    'Key Pair ID' => $keyPairId,
                    'Signed URL Test' => '✅ Success',
                    'Sample URL' => substr((string) $testUrl, 0, self::URL_PREVIEW_LENGTH) . '...',
                ]
            ];
            
        } catch (\Exception $e) {
            return [
                'title' => '☁️ CloudFront',
                'status' => 'error',
                'data' => [
                    'Error' => $e->getMessage(),
                ]
            ];
        }
    }

    private function getSolutionForError(?string $errorCode): string
    {
        if ($errorCode === null) {
            return 'Unknown error - check AWS credentials and configuration';
        }
        
        $solutions = [
            'AccessDenied' => 'Check IAM permissions for your AWS user',
            'SignatureDoesNotMatch' => 'Verify AWS_SECRET_ACCESS_KEY in .env',
            'InvalidAccessKeyId' => 'Check AWS_ACCESS_KEY_ID in .env',
            'NoSuchBucket' => 'Verify bucket name and region',
            'BucketRegionError' => 'Update AWS_DEFAULT_REGION to match bucket region',
        ];
        
        return $solutions[$errorCode] ?? 'Check AWS documentation for error: ' . $errorCode;
    }

    private function getDebugOutput(): string
    {
        if (empty($this->debugResults)) {
            return __('ui::s3test.debug.run_tests_message');
        }
        
        $output = [];
        foreach ($this->debugResults as $category => $result) {
            $output[] = "=== {$result['title']} ===";
            $output[] = "Status: {$result['status']}";
            $output[] = "";
            
            foreach ($result['data'] as $key => $value) {
                if (is_array($value)) {
                    $output[] = "{$key}: " . json_encode($value, JSON_PRETTY_PRINT);
                } else {
                    $output[] = "{$key}: {$value}";
                }
            }
            
            $output[] = "";
            $output[] = str_repeat("-", 50);
            $output[] = "";
        }
        
        return implode("\n", $output);
        }

    public function sendEmail(): void
    {
        try {
            $data = $this->form->getState();
            $filePath = $data['attachment'] ?? null;
            
            if (!$filePath) {
                Notification::make()
                    ->warning()
                    ->title(__('ui::s3test.notifications.no_attachment'))
                    ->body(__('ui::s3test.notifications.upload_file_first'))
                    ->send();
                return;
            }

            // Test email data
            $emailData = EmailData::from([
                'to' => 'test@example.com',
                'subject' => __('ui::s3test.email.subject'),
                'body' => __('ui::s3test.email.body'),
                'attachment_path' => $filePath,
                'attachment_name' => basename((string) $filePath),
            ]);

            // Generate CloudFront signed URL for attachment
            $signedUrl = GetCloudFrontSignedUrlAction::execute((string) $filePath, 60);
            
            // In a real implementation, you would send the email here
            // Mail::to($emailData->to)->send(new EmailDataEmail($emailData));
            
            // For testing purposes, just log the email data
            Log::info('S3 Test Email Sent', [
                'to' => $emailData->to,
                'subject' => $emailData->subject,
                'attachment_path' => $filePath,
                'signed_url' => $signedUrl,
            ]);

            Notification::make()
                ->success()
                ->title(__('ui::s3test.notifications.email_sent'))
                ->body(__('ui::s3test.notifications.email_with_attachment'))
                ->send();
                
        } catch (\Exception $e) {
            Log::error('S3 Test Email Failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            Notification::make()
                ->danger()
                ->title(__('ui::s3test.notifications.email_failed'))
                ->body($e->getMessage())
                ->send();
        }
    }

    /**
     * Test file upload and download operations.
     * 
     * @return array<string, mixed>
     */
    private function testFileUploadDownload(): array
    {
        try {
            $testData = 'This is a test file content for S3 upload/download test.';
            $testFileName = 'test-file-' . time() . '.txt';
            $localTestPath = sys_get_temp_dir() . '/' . $testFileName;
            
            // Create test file
            file_put_contents($localTestPath, $testData);
            
            // Test upload
            $uploadResult = Storage::disk('s3')->put($testFileName, $testData);
            
            if (!$uploadResult) {
                return [
                    'status' => 'error',
                    'message' => 'Failed to upload test file to S3',
                    'details' => ['file' => $testFileName]
                ];
            }
            
            // Test download
            $downloadedContent = Storage::disk('s3')->get($testFileName);
            
            if ($downloadedContent !== $testData) {
                return [
                    'status' => 'error', 
                    'message' => 'Downloaded content does not match uploaded content',
                    'details' => [
                        'expected_length' => strlen($testData),
                        'actual_length' => strlen($downloadedContent ?? '')
                    ]
                ];
            }
            
            // Test file info
            $exists = Storage::disk('s3')->exists($testFileName);
            $size = Storage::disk('s3')->size($testFileName);
            
            // Cleanup
            Storage::disk('s3')->delete($testFileName);
            unlink($localTestPath);
            
            return [
                'status' => 'success',
                'message' => 'File upload/download test completed successfully',
                'details' => [
                    'file_uploaded' => true,
                    'file_downloaded' => true,
                    'content_verified' => true,
                    'file_exists_check' => $exists,
                    'file_size' => $size,
                    'cleanup_completed' => true,
                    'test_file' => $testFileName
                ]
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'File operations test failed: ' . $e->getMessage(),
                'details' => [
                    'error_class' => get_class($e),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine()
                ]
            ];
        }
    }
    
    private function updateDebugOutput(): void
    {
        $this->form->fill([
            'debug_output' => $this->getDebugOutput()
        ]);
    }

    public function save(): void
    {
        try {
            // Test basic S3 operation
            $filename = self::TEST_FILE_PREFIX . time() . '.txt';
            Storage::disk('s3')->put($filename, 'Hello World from Filament Test');
            
            // Test CloudFront signed URL
            $cloudFrontUrl = GetCloudFrontSignedUrlAction::execute($filename, 5);
            
            // Test Laravel temporary URL
            /** @var \Illuminate\Filesystem\FilesystemAdapter $s3Disk */
            $s3Disk = Storage::disk('s3');
            $temporaryUrl = $s3Disk->temporaryUrl($filename, now()->addMinutes(5));

            $data = $this->form->getState();
            $filePath = $data['attachment'] ?? null;

            $results = [
                'test_file' => [
                    'path' => $filename,
                    'cloudfront_url' => $cloudFrontUrl,
                    'temporary_url' => $temporaryUrl,
                ],
                'uploaded_file' => $filePath ? [
                    'path' => (string) $filePath,
                    'cloudfront_url' => GetCloudFrontSignedUrlAction::execute((string) $filePath, 30),
                    'temporary_url' => $s3Disk->temporaryUrl((string) $filePath, now()->addMinutes(30)),
                ] : null,
            ];

            // Clean up test file
            Storage::disk('s3')->delete($filename);

            Notification::make()
                ->success()
                ->title(__('ui::s3test.notifications.s3_test_successful'))
                ->body(__('ui::s3test.notifications.operations_completed'))
                ->send();

            // Log results for debugging
            Log::info('S3 Test Results', $results);

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title(__('ui::s3test.notifications.test_failed'))
                ->body($e->getMessage())
                ->send();

            // Log error for debugging
            Log::error('S3 Test Failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}