<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Modules\Activity\Models\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ActivityBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_activity_with_basic_information(): void
    {
        $activityData = [
            'log_name' => 'default',
            'description' => 'User logged in',
            'subject_type' => 'App\Models\User',
            'subject_id' => 123,
            'causer_type' => 'App\Models\User',
            'causer_id' => 123,
            'properties' => json_encode([
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'login_method' => 'email',
            ]),
            'event' => 'created',
            'batch_uuid' => Str::uuid()->toString(),
        ];

        $activity = Activity::create($activityData);

        $this->assertDatabaseHas('activity_log', [
            'id' => $activity->id,
            'log_name' => 'default',
            'description' => 'User logged in',
            'subject_type' => 'App\Models\User',
            'subject_id' => 123,
            'event' => 'created',
        ]);

        $this->assertEquals('default', $activity->log_name);
        $this->assertEquals('User logged in', $activity->description);
        $this->assertEquals('App\Models\User', $activity->subject_type);
        $this->assertEquals(123, $activity->subject_id);
        $this->assertEquals('created', $activity->event);
    }

    /** @test */
    public function it_can_track_user_authentication_activities(): void
    {
        $loginActivity = Activity::create([
            'log_name' => 'auth',
            'description' => 'User logged in successfully',
            'subject_type' => 'App\Models\User',
            'subject_id' => 456,
            'causer_type' => 'App\Models\User',
            'causer_id' => 456,
            'properties' => json_encode([
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Chrome/91.0.4472.124',
                'login_time' => now()->toISOString(),
            ]),
            'event' => 'login',
        ]);

        $logoutActivity = Activity::create([
            'log_name' => 'auth',
            'description' => 'User logged out',
            'subject_type' => 'App\Models\User',
            'subject_id' => 456,
            'causer_type' => 'App\Models\User',
            'causer_id' => 456,
            'properties' => json_encode([
                'ip_address' => '192.168.1.100',
                'session_duration' => 3600,
                'logout_time' => now()->toISOString(),
            ]),
            'event' => 'logout',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $loginActivity->id,
            'event' => 'login',
            'log_name' => 'auth',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $logoutActivity->id,
            'event' => 'logout',
            'log_name' => 'auth',
        ]);

        $this->assertEquals('login', $loginActivity->event);
        $this->assertEquals('logout', $logoutActivity->event);
    }

    /** @test */
    public function it_can_track_model_crud_activities(): void
    {
        $createActivity = Activity::create([
            'log_name' => 'models',
            'description' => 'User created',
            'subject_type' => 'App\Models\User',
            'subject_id' => 789,
            'causer_type' => 'App\Models\User',
            'causer_id' => 1,
            'properties' => json_encode([
                'old' => null,
                'attributes' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ],
            ]),
            'event' => 'created',
        ]);

        $updateActivity = Activity::create([
            'log_name' => 'models',
            'description' => 'User updated',
            'subject_type' => 'App\Models\User',
            'subject_id' => 789,
            'causer_type' => 'App\Models\User',
            'causer_id' => 1,
            'properties' => json_encode([
                'old' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ],
                'attributes' => [
                    'name' => 'John Smith',
                    'email' => 'john.smith@example.com',
                ],
            ]),
            'event' => 'updated',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $createActivity->id,
            'event' => 'created',
            'subject_id' => 789,
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $updateActivity->id,
            'event' => 'updated',
            'subject_id' => 789,
        ]);

        $this->assertEquals('created', $createActivity->event);
        $this->assertEquals('updated', $updateActivity->event);
    }

    /** @test */
    public function it_can_track_file_upload_activities(): void
    {
        $uploadActivity = Activity::create([
            'log_name' => 'files',
            'description' => 'File uploaded successfully',
            'subject_type' => 'App\Models\File',
            'subject_id' => 101,
            'causer_type' => 'App\Models\User',
            'causer_id' => 202,
            'properties' => json_encode([
                'file_name' => 'document.pdf',
                'file_size' => 2048576,
                'file_type' => 'application/pdf',
                'file_path' => '/uploads/documents/document.pdf',
                'upload_time' => now()->toISOString(),
            ]),
            'event' => 'uploaded',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $uploadActivity->id,
            'event' => 'uploaded',
            'log_name' => 'files',
        ]);

        $this->assertEquals('uploaded', $uploadActivity->event);
        $this->assertEquals('files', $uploadActivity->log_name);

        $properties = json_decode($uploadActivity->properties, true);
        $this->assertEquals('document.pdf', $properties['file_name']);
        $this->assertEquals(2048576, $properties['file_size']);
        $this->assertEquals('application/pdf', $properties['file_type']);
    }

    /** @test */
    public function it_can_track_security_violation_activities(): void
    {
        $securityActivity = Activity::create([
            'log_name' => 'security',
            'description' => 'Multiple failed login attempts detected',
            'subject_type' => 'App\Models\User',
            'subject_id' => 303,
            'causer_type' => 'App\Models\User',
            'causer_id' => 303,
            'properties' => json_encode([
                'ip_address' => '192.168.1.200',
                'attempted_actions' => ['login', 'password_reset'],
                'failure_count' => 5,
                'risk_level' => 'high',
                'blocked_until' => now()->addMinutes(30)->toISOString(),
            ]),
            'event' => 'security_violation',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $securityActivity->id,
            'event' => 'security_violation',
            'log_name' => 'security',
        ]);

        $this->assertEquals('security_violation', $securityActivity->event);
        $this->assertEquals('security', $securityActivity->log_name);

        $properties = json_decode($securityActivity->properties, true);
        $this->assertEquals('192.168.1.200', $properties['ip_address']);
        $this->assertEquals(5, $properties['failure_count']);
        $this->assertEquals('high', $properties['risk_level']);
    }

    /** @test */
    public function it_can_use_batch_uuid_for_grouping_activities(): void
    {
        $batchUuid = Str::uuid()->toString();

        $activity1 = Activity::create([
            'log_name' => 'batch',
            'description' => 'Batch operation started',
            'subject_type' => 'App\Models\Import',
            'subject_id' => 404,
            'causer_type' => 'App\Models\User',
            'causer_id' => 505,
            'properties' => json_encode(['step' => 'start']),
            'event' => 'batch_started',
            'batch_uuid' => $batchUuid,
        ]);

        $activity2 = Activity::create([
            'log_name' => 'batch',
            'description' => 'Batch operation completed',
            'subject_type' => 'App\Models\Import',
            'subject_id' => 404,
            'causer_type' => 'App\Models\User',
            'causer_id' => 505,
            'properties' => json_encode(['step' => 'complete', 'records_processed' => 1000]),
            'event' => 'batch_completed',
            'batch_uuid' => $batchUuid,
        ]);

        $this->assertEquals($batchUuid, $activity1->batch_uuid);
        $this->assertEquals($batchUuid, $activity2->batch_uuid);

        $batchActivities = Activity::where('batch_uuid', $batchUuid)->get();
        $this->assertCount(2, $batchActivities);
        $this->assertTrue($batchActivities->contains($activity1));
        $this->assertTrue($batchActivities->contains($activity2));
    }

    /** @test */
    public function it_can_filter_activities_by_log_name(): void
    {
        Activity::create([
            'log_name' => 'auth',
            'description' => 'Login activity',
            'subject_type' => 'App\Models\User',
            'subject_id' => 606,
            'causer_type' => 'App\Models\User',
            'causer_id' => 606,
            'properties' => json_encode([]),
            'event' => 'login',
        ]);

        Activity::create([
            'log_name' => 'models',
            'description' => 'Model activity',
            'subject_type' => 'App\Models\User',
            'subject_id' => 606,
            'causer_type' => 'App\Models\User',
            'causer_id' => 606,
            'properties' => json_encode([]),
            'event' => 'created',
        ]);

        $authActivities = Activity::where('log_name', 'auth')->get();
        $modelActivities = Activity::where('log_name', 'models')->get();

        $this->assertCount(1, $authActivities);
        $this->assertCount(1, $modelActivities);
        $this->assertEquals('auth', $authActivities->first()->log_name);
        $this->assertEquals('models', $modelActivities->first()->log_name);
    }

    /** @test */
    public function it_can_filter_activities_by_event_type(): void
    {
        Activity::create([
            'log_name' => 'default',
            'description' => 'Created event',
            'subject_type' => 'App\Models\User',
            'subject_id' => 707,
            'causer_type' => 'App\Models\User',
            'causer_id' => 808,
            'properties' => json_encode([]),
            'event' => 'created',
        ]);

        Activity::create([
            'log_name' => 'default',
            'description' => 'Updated event',
            'subject_type' => 'App\Models\User',
            'subject_id' => 707,
            'causer_type' => 'App\Models\User',
            'causer_id' => 808,
            'properties' => json_encode([]),
            'event' => 'updated',
        ]);

        $createdActivities = Activity::where('event', 'created')->get();
        $updatedActivities = Activity::where('event', 'updated')->get();

        $this->assertCount(1, $createdActivities);
        $this->assertCount(1, $updatedActivities);
        $this->assertEquals('created', $createdActivities->first()->event);
        $this->assertEquals('updated', $updatedActivities->first()->event);
    }

    /** @test */
    public function it_can_track_activity_with_complex_properties(): void
    {
        $complexActivity = Activity::create([
            'log_name' => 'complex',
            'description' => 'Complex operation with nested data',
            'subject_type' => 'App\Models\Order',
            'subject_id' => 909,
            'causer_type' => 'App\Models\User',
            'causer_id' => 1010,
            'properties' => json_encode([
                'order_details' => [
                    'items' => [
                        ['id' => 1, 'name' => 'Product A', 'quantity' => 2, 'price' => 25.99],
                        ['id' => 2, 'name' => 'Product B', 'quantity' => 1, 'price' => 15.50],
                    ],
                    'total_amount' => 67.48,
                    'currency' => 'EUR',
                    'payment_method' => 'credit_card',
                ],
                'customer_info' => [
                    'name' => 'Jane Smith',
                    'email' => 'jane@example.com',
                    'phone' => '+1234567890',
                ],
                'shipping_address' => [
                    'street' => '123 Main St',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip' => '10001',
                    'country' => 'USA',
                ],
                'metadata' => [
                    'source' => 'web',
                    'campaign' => 'summer_sale',
                    'referrer' => 'google',
                ],
            ]),
            'event' => 'order_placed',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $complexActivity->id,
            'event' => 'order_placed',
            'log_name' => 'complex',
        ]);

        $properties = json_decode($complexActivity->properties, true);
        $this->assertEquals(67.48, $properties['order_details']['total_amount']);
        $this->assertEquals('EUR', $properties['order_details']['currency']);
        $this->assertEquals('Jane Smith', $properties['customer_info']['name']);
        $this->assertEquals('web', $properties['metadata']['source']);
    }

    /** @test */
    public function it_can_handle_activity_with_null_values(): void
    {
        $activityWithNulls = Activity::create([
            'log_name' => null,
            'description' => 'Activity with null values',
            'subject_type' => null,
            'subject_id' => null,
            'causer_type' => null,
            'causer_id' => null,
            'properties' => null,
            'event' => null,
            'batch_uuid' => null,
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $activityWithNulls->id,
            'description' => 'Activity with null values',
        ]);

        $this->assertNull($activityWithNulls->log_name);
        $this->assertNull($activityWithNulls->subject_type);
        $this->assertNull($activityWithNulls->subject_id);
        $this->assertNull($activityWithNulls->causer_type);
        $this->assertNull($activityWithNulls->causer_id);
        $this->assertNull($activityWithNulls->properties);
        $this->assertNull($activityWithNulls->event);
        $this->assertNull($activityWithNulls->batch_uuid);
    }

    /** @test */
    public function it_can_track_activity_timestamps_correctly(): void
    {
        $now = now();
        
        $activity = Activity::create([
            'log_name' => 'timestamps',
            'description' => 'Activity with specific timestamps',
            'subject_type' => 'App\Models\Test',
            'subject_id' => 1111,
            'causer_type' => 'App\Models\User',
            'causer_id' => 1212,
            'properties' => json_encode([]),
            'event' => 'tested',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->assertDatabaseHas('activity_log', [
            'id' => $activity->id,
            'created_at' => $now->toDateTimeString(),
            'updated_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($now->timestamp, $activity->created_at->timestamp);
        $this->assertEquals($now->timestamp, $activity->updated_at->timestamp);
    }

    /** @test */
    public function it_can_query_activities_by_date_range(): void
    {
        $yesterday = now()->subDay();
        $today = now();
        $tomorrow = now()->addDay();

        Activity::create([
            'log_name' => 'date_test',
            'description' => 'Yesterday activity',
            'subject_type' => 'App\Models\Test',
            'subject_id' => 1313,
            'causer_type' => 'App\Models\User',
            'causer_id' => 1414,
            'properties' => json_encode([]),
            'event' => 'tested',
            'created_at' => $yesterday,
        ]);

        Activity::create([
            'log_name' => 'date_test',
            'description' => 'Today activity',
            'subject_type' => 'App\Models\Test',
            'subject_id' => 1313,
            'causer_type' => 'App\Models\User',
            'causer_id' => 1414,
            'properties' => json_encode([]),
            'event' => 'tested',
            'created_at' => $today,
        ]);

        Activity::create([
            'log_name' => 'date_test',
            'description' => 'Tomorrow activity',
            'subject_type' => 'App\Models\Test',
            'subject_id' => 1313,
            'causer_type' => 'App\Models\User',
            'causer_id' => 1414,
            'properties' => json_encode([]),
            'event' => 'tested',
            'created_at' => $tomorrow,
        ]);

        $todayActivities = Activity::whereDate('created_at', today())->get();
        $this->assertCount(1, $todayActivities);
        $this->assertEquals('Today activity', $todayActivities->first()->description);

        $recentActivities = Activity::where('created_at', '>=', $yesterday)->get();
        $this->assertCount(2, $recentActivities);
    }
}
