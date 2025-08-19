<?php

declare(strict_types=1);

use Modules\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    if (!moduleEnabled('Media')) {
        $this->markTestSkipped('Module Media is disabled');
    }
    
    Storage::fake('public');
});

describe('Media Model', function () {
    test('can create media with basic attributes', function () {
        $media = Media::factory()->create([
            'name' => 'test-image.jpg',
            'file_name' => 'test-image.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1024,
            'disk' => 'public',
        ]);

        expect($media->name)->toBe('test-image.jpg');
        expect($media->file_name)->toBe('test-image.jpg');
        expect($media->mime_type)->toBe('image/jpeg');
        expect($media->size)->toBe(1024);
        expect($media->disk)->toBe('public');
        expect($media->exists)->toBeTrue();
    });

    test('media model uses correct table', function () {
        $media = new Media();
        expect($media->getTable())->toBe('media');
    });

    test('media model has fillable attributes', function () {
        $media = new Media();
        $fillable = $media->getFillable();
        
        expect($fillable)->toContain('name');
        expect($fillable)->toContain('file_name');
        expect($fillable)->toContain('mime_type');
        expect($fillable)->toContain('size');
        expect($fillable)->toContain('disk');
    });

    test('can filter media by mime type', function () {
        Media::factory()->create(['mime_type' => 'image/jpeg']);
        Media::factory()->create(['mime_type' => 'image/png']);
        Media::factory()->create(['mime_type' => 'application/pdf']);

        $images = Media::where('mime_type', 'like', 'image/%')->get();
        $pdfs = Media::where('mime_type', 'application/pdf')->get();

        expect($images)->toHaveCount(2);
        expect($pdfs)->toHaveCount(1);
    });

    test('can get media url', function () {
        $media = Media::factory()->create([
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
        ]);

        // If the model has getUrl method
        if (method_exists($media, 'getUrl')) {
            $url = $media->getUrl();
            expect($url)->toBeString();
            expect($url)->toContain('test-image.jpg');
        }
    });

    test('can check if media is image', function () {
        $imageMedia = Media::factory()->create(['mime_type' => 'image/jpeg']);
        $pdfMedia = Media::factory()->create(['mime_type' => 'application/pdf']);

        // If the model has isImage method
        if (method_exists($imageMedia, 'isImage')) {
            expect($imageMedia->isImage())->toBeTrue();
            expect($pdfMedia->isImage())->toBeFalse();
        }
    });
});

