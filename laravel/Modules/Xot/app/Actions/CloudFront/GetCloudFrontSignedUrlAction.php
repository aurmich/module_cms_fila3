<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\CloudFront;

use Spatie\QueueableAction\QueueableAction;
use Aws\CloudFront\CloudFrontClient;


/**
 * Action per la traduzione di elementi di una collezione.
 */
class GetCloudFrontSignedUrlAction
{
    use QueueableAction;

   
    public static function execute(string $key, int $expiry = 30): string
    {
        $cloudFront = new CloudFrontClient([
            'region' => env('CLOUDFRONT_REGION', 'eu-west-1'),
            'version' => 'latest'
        ]);

        return $cloudFront->getSignedUrl([
            'url' => env('CLOUDFRONT_RESOURCE_KEY_BASE_URL') . '/' . ltrim($key, '/'),
            'expires' => time() + ($expiry * 60),
            'key_pair_id' => env('CLOUDFRONT_KEYPAIR_ID'),
            'private_key' => self::formatPrivateKey(self::getPrivateKeyFromEnv()),
        ]);
    }

    /**
     * Get private key from environment with type safety.
     * 
     * @throws \RuntimeException
     */
    private static function getPrivateKeyFromEnv(): string
    {
        $privateKey = env('CLOUDFRONT_PRIVATE_KEY');
        
        if (!is_string($privateKey) || trim($privateKey) === '') {
            throw new \RuntimeException('CLOUDFRONT_PRIVATE_KEY environment variable is not set or empty');
        }
        
        return $privateKey;
    }

    private static function formatPrivateKey(string $key): string
    {
        return str_replace('\n', "\n", $key);
    }
}
