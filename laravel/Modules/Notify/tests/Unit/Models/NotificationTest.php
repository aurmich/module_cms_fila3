<?php

declare(strict_types=1);

use Modules\Notify\Models\Notification;
use Modules\User\Models\User;

test('notification can be created', function () {
    $user = User::factory()->create();
    
    $notification = createNotification([
        'user_id' => $user->id,
        'title' => 'Test Notification',
        'message' => 'Test Message',
        'type' => 'info',
    ]);

    expect($notification)
        ->toBeNotification()
        ->and($notification->title)->toBe('Test Notification')
        ->and($notification->message)->toBe('Test Message')
        ->and($notification->type)->toBe('info');
});

test('notification belongs to user', function () {
    $user = User::factory()->create();
    $notification = createNotification(['user_id' => $user->id]);
    
    expect($notification->user)
        ->toBeInstanceOf(User::class)
        ->and($notification->user->id)->toBe($user->id);
});

test('notification can be marked as read', function () {
    $notification = createNotification(['read_at' => null]);
    
    $notification->markAsRead();
    
    expect($notification->fresh()->read_at)->not->toBeNull();
});

test('notification scope unread works', function () {
    createNotification(['read_at' => null]); // Unread
    createNotification(['read_at' => now()]); // Read
    
    $unreadCount = Notification::unread()->count();
    
    expect($unreadCount)->toBe(1);
});
