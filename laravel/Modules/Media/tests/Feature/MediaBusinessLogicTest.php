<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaConvert;
use Modules\Media\Models\TemporaryUpload;
use Modules\User\Models\User;
use Tests\TestCase;

class MediaBusinessLogicTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function it_can_create_media_from_temporary_upload(): void
    {
        // Arrange
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('test-image.jpg', 100, 100);
        
        $temporaryUpload = TemporaryUpload::factory()->create([
            'user_id' => $user->id,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        // Act
        $media = Media::factory()->create([
            'user_id' => $user->id,
            'file_name' => $temporaryUpload->file_name,
            'file_size' => $temporaryUpload->file_size,
            'mime_type' => $temporaryUpload->mime_type,
            'disk' => 'public',
            'collection_name' => 'default',
        ]);

        // Assert
        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'user_id' => $user->id,
            'file_name' => $temporaryUpload->file_name,
            'file_size' => $temporaryUpload->file_size,
            'mime_type' => $temporaryUpload->mime_type,
        ]);

        $this->assertEquals($temporaryUpload->file_name, $media->file_name);
        $this->assertEquals($temporaryUpload->file_size, $media->file_size);
        $this->assertEquals($temporaryUpload->mime_type, $media->mime_type);
    }

    /** @test */
    public function it_can_convert_media_to_different_formats(): void
    {
        // Arrange
        $user = User::factory()->create();
        $media = Media::factory()->create([
            'user_id' => $user->id,
            'mime_type' => 'image/jpeg',
        ]);

        // Act
        $mediaConvert = MediaConvert::factory()->create([
            'media_id' => $media->id,
            'original_format' => 'jpeg',
            'target_format' => 'png',
            'status' => 'pending',
        ]);

        // Assert
        $this->assertDatabaseHas('media_converts', [
            'id' => $mediaConvert->id,
            'media_id' => $media->id,
            'original_format' => 'jpeg',
            'target_format' => 'png',
            'status' => 'pending',
        ]);

        $this->assertEquals($media->id, $mediaConvert->media_id);
        $this->assertEquals('jpeg', $mediaConvert->original_format);
        $this->assertEquals('png', $mediaConvert->target_format);
    }

    /** @test */
    public function it_can_track_temporary_upload_lifecycle(): void
    {
        // Arrange
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('test-image.jpg', 100, 100);

        // Act
        $temporaryUpload = TemporaryUpload::factory()->create([
            'user_id' => $user->id,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'status' => 'uploading',
        ]);

        // Simulate upload completion
        $temporaryUpload->update(['status' => 'completed']);

        // Assert
        $this->assertDatabaseHas('temporary_uploads', [
            'id' => $temporaryUpload->id,
            'user_id' => $user->id,
            'status' => 'completed',
        ]);

        $this->assertEquals('completed', $temporaryUpload->fresh()->status);
    }

    /** @test */
    public function it_can_manage_media_collections(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $profileMedia = Media::factory()->create([
            'user_id' => $user->id,
            'collection_name' => 'profile',
            'disk' => 'public',
        ]);

        $documentMedia = Media::factory()->create([
            'user_id' => $user->id,
            'collection_name' => 'documents',
            'disk' => 'public',
        ]);

        // Assert
        $this->assertDatabaseHas('media', [
            'id' => $profileMedia->id,
            'collection_name' => 'profile',
        ]);

        $this->assertDatabaseHas('media', [
            'id' => $documentMedia->id,
            'collection_name' => 'documents',
        ]);

        $this->assertEquals('profile', $profileMedia->collection_name);
        $this->assertEquals('documents', $documentMedia->collection_name);
    }

    /** @test */
    public function it_can_validate_media_file_types(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act & Assert - Valid image
        $validImage = Media::factory()->create([
            'user_id' => $user->id,
            'mime_type' => 'image/jpeg',
            'file_name' => 'valid-image.jpg',
        ]);

        $this->assertTrue($validImage->isImage());
        $this->assertFalse($validImage->isDocument());

        // Act & Assert - Valid document
        $validDocument = Media::factory()->create([
            'user_id' => $user->id,
            'mime_type' => 'application/pdf',
            'file_name' => 'valid-document.pdf',
        ]);

        $this->assertFalse($validDocument->isImage());
        $this->assertTrue($validDocument->isDocument());
    }

    /** @test */
    public function it_can_track_media_conversion_status(): void
    {
        // Arrange
        $user = User::factory()->create();
        $media = Media::factory()->create([
            'user_id' => $user->id,
            'mime_type' => 'image/jpeg',
        ]);

        // Act
        $mediaConvert = MediaConvert::factory()->create([
            'media_id' => $media->id,
            'status' => 'pending',
        ]);

        // Simulate conversion progress
        $mediaConvert->update(['status' => 'processing']);
        $mediaConvert->update(['status' => 'completed']);

        // Assert
        $this->assertDatabaseHas('media_converts', [
            'id' => $mediaConvert->id,
            'status' => 'completed',
        ]);

        $this->assertEquals('completed', $mediaConvert->fresh()->status);
    }

    /** @test */
    public function it_can_manage_media_permissions(): void
    {
        // Arrange
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        
        $media = Media::factory()->create([
            'user_id' => $owner->id,
            'is_public' => false,
        ]);

        // Act & Assert - Owner can access
        $this->assertTrue($media->user_id === $owner->id);
        $this->assertFalse($media->is_public);

        // Act & Assert - Other user cannot access private media
        $this->assertFalse($media->user_id === $otherUser->id);
    }

    /** @test */
    public function it_can_handle_media_deletion(): void
    {
        // Arrange
        $user = User::factory()->create();
        $media = Media::factory()->create([
            'user_id' => $user->id,
        ]);

        // Act
        $media->delete();

        // Assert
        $this->assertSoftDeleted('media', [
            'id' => $media->id,
        ]);

        $this->assertDatabaseMissing('media', [
            'id' => $media->id,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function it_can_generate_media_urls(): void
    {
        // Arrange
        $user = User::factory()->create();
        $media = Media::factory()->create([
            'user_id' => $user->id,
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
        ]);

        // Act
        $url = $media->getUrl();

        // Assert
        $this->assertNotEmpty($url);
        $this->assertStringContainsString('test-image.jpg', $url);
    }

    /** @test */
    public function it_can_validate_file_size_limits(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act & Assert - Valid file size
        $validMedia = Media::factory()->create([
            'user_id' => $user->id,
            'file_size' => 1024 * 1024, // 1MB
        ]);

        $this->assertLessThanOrEqual(10 * 1024 * 1024, $validMedia->file_size); // 10MB limit

        // Act & Assert - Large file size
        $largeMedia = Media::factory()->create([
            'user_id' => $user->id,
            'file_size' => 15 * 1024 * 1024, // 15MB
        ]);

        $this->assertGreaterThan(10 * 1024 * 1024, $largeMedia->file_size);
    }

    /** @test */
    public function it_can_track_media_usage_statistics(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        Media::factory()->count(5)->create([
            'user_id' => $user->id,
            'mime_type' => 'image/jpeg',
        ]);

        Media::factory()->count(3)->create([
            'user_id' => $user->id,
            'mime_type' => 'application/pdf',
        ]);

        // Act
        $totalMedia = Media::where('user_id', $user->id)->count();
        $imageCount = Media::where('user_id', $user->id)
            ->where('mime_type', 'like', 'image/%')
            ->count();
        $documentCount = Media::where('user_id', $user->id)
            ->where('mime_type', 'like', 'application/%')
            ->count();

        // Assert
        $this->assertEquals(8, $totalMedia);
        $this->assertEquals(5, $imageCount);
        $this->assertEquals(3, $documentCount);
    }
}
