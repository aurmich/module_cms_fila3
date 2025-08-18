<?php

declare(strict_types=1);

use Modules\Media\Models\Media;

test('media can be created', function () {
    $media = createMedia([
        'name' => 'test-image.jpg',
        'file_name' => 'test-image.jpg',
        'mime_type' => 'image/jpeg',
        'size' => 1024,
    ]);

    expect($media)
        ->toBeMedia()
        ->and($media->name)->toBe('test-image.jpg')
        ->and($media->mime_type)->toBe('image/jpeg')
        ->and($media->size)->toBe(1024);
});

test('media has required attributes', function () {
    $media = makeMedia();

    expect($media)
        ->toHaveProperty('name')
        ->toHaveProperty('file_name')
        ->toHaveProperty('mime_type')
        ->toHaveProperty('size')
        ->toHaveProperty('disk')
        ->toHaveProperty('collection_name');
});

test('media can determine if it is image', function () {
    $imageMedia = createMedia(['mime_type' => 'image/jpeg']);
    $documentMedia = createMedia(['mime_type' => 'application/pdf']);
    
    expect($imageMedia->isImage())->toBeTrue()
        ->and($documentMedia->isImage())->toBeFalse();
});

test('media can get url', function () {
    $media = createMedia([
        'file_name' => 'test.jpg',
        'disk' => 'public',
    ]);
    
    expect($media->getUrl())->toBeString()->toContain('test.jpg');
});
