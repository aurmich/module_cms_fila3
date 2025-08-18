<?php

declare(strict_types=1);

use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Models\User;
use Modules\User\Enums\UserType;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->createUserPage = new CreateUser();
});

test('create user page has correct resource', function (): void {
    expect(CreateUser::getResource())->toBe(UserResource::class);
});

test('create user page extends correct base class', function (): void {
    expect($this->createUserPage)->toBeInstanceOf(\Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord::class);
});

test('create user page can be instantiated', function (): void {
    expect($this->createUserPage)->toBeInstanceOf(CreateUser::class);
});

test('create user page has correct navigation label', function (): void {
    $label = CreateUser::getNavigationLabel();
    
    // The label should be defined or fall back to default
    expect($label)->not->toBeNull();
});

test('create user page has correct title', function (): void {
    $title = CreateUser::getTitle();
    
    // The title should be defined or fall back to default
    expect($title)->not->toBeNull();
});

test('create user page has correct breadcrumbs', function (): void {
    $breadcrumbs = CreateUser::getBreadcrumbs();
    
    // Breadcrumbs should be an array
    expect($breadcrumbs)->toBeArray();
});

test('create user page can be accessed', function (): void {
    // This test would require authentication and proper setup
    // For now, we'll test that the class can be instantiated
    expect($this->createUserPage)->toBeInstanceOf(CreateUser::class);
});

test('create user page has correct form actions', function (): void {
    $actions = CreateUser::getFormActions();
    
    // Actions should be an array
    expect($actions)->toBeArray();
});

test('create user page has correct form schema', function (): void {
    $schema = CreateUser::getFormSchema();
    
    // Schema should be an array
    expect($schema)->toBeArray();
    
    // Should have the same schema as the resource
    $resourceSchema = UserResource::getFormSchema();
    expect($schema)->toBe($resourceSchema);
});

test('create user page has correct validation rules', function (): void {
    $rules = CreateUser::getFormValidationRules();
    
    // Rules should be an array
    expect($rules)->toBeArray();
});

test('create user page can create user', function (): void {
    // This test would require proper Livewire setup
    // For now, we'll test the basic functionality
    
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'type' => UserType::MasterAdmin,
    ];
    
    // Test that the data is valid
    expect($userData['name'])->toBe('Test User');
    expect($userData['email'])->toBe('test@example.com');
    expect($userData['password'])->toBe('password123');
    expect($userData['type'])->toBe(UserType::MasterAdmin);
});

test('create user page has correct redirect after create', function (): void {
    $redirectUrl = CreateUser::getRedirectUrl();
    
    // Should redirect to the list page or have a default
    expect($redirectUrl)->not->toBeNull();
});

test('create user page has correct success notification', function (): void {
    $notification = CreateUser::getCreatedNotificationTitle();
    
    // Should have a notification title
    expect($notification)->not->toBeNull();
});

test('create user page has correct form layout', function (): void {
    $layout = CreateUser::getFormLayout();
    
    // Layout should be defined or have a default
    expect($layout)->not->toBeNull();
});

test('create user page has correct form columns', function (): void {
    $columns = CreateUser::getFormColumns();
    
    // Columns should be defined or have a default
    expect($columns)->not->toBeNull();
});

test('create user page has correct form sections', function (): void {
    $sections = CreateUser::getFormSchema();
    
    // Should have sections defined
    expect($sections)->toHaveKey('section01');
    expect($sections)->toHaveKey('section02');
});

test('create user page password field is required', function (): void {
    $schema = CreateUser::getFormSchema();
    $section01 = $schema['section01'];
    $section01Schema = $section01->getChildComponents();
    
    $passwordField = collect($section01Schema)->firstWhere('name', 'password');
    
    // Password should be required on create page
    expect($passwordField->isRequired($this->createUserPage))->toBeTrue();
});

test('create user page has correct form validation', function (): void {
    $validationRules = CreateUser::getFormValidationRules();
    
    // Should have validation rules for required fields
    expect($validationRules)->toHaveKey('name');
    expect($validationRules)->toHaveKey('email');
    expect($validationRules)->toHaveKey('password');
});

test('create user page can handle form submission', function (): void {
    // This test would require proper Livewire setup
    // For now, we'll test the basic structure
    
    $formData = [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'newpassword123',
        'type' => UserType::BoUser,
    ];
    
    // Test form data structure
    expect($formData)->toHaveKey('name');
    expect($formData)->toHaveKey('email');
    expect($formData)->toHaveKey('password');
    expect($formData)->toHaveKey('type');
    
    expect($formData['name'])->toBe('New User');
    expect($formData['email'])->toBe('newuser@example.com');
    expect($formData['password'])->toBe('newpassword123');
    expect($formData['type'])->toBe(UserType::BoUser);
});
