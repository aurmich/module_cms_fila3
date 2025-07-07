<?php

declare(strict_types=1);

use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\User\Models\User;
use function Pest\Laravel\assertAuthenticatedAs;

// Skip this test if the test database is not configured
if (!env('DB_CONNECTION') || (env('DB_CONNECTION') === 'sqlite' && !file_exists(database_path('database.sqlite')))) {
    return;
}

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->widget = new LoginWidget();
});

test('it can render widget', function (): void {
    expect(LoginWidget::getView())->toContain('user::filament.widgets.login');
});

test('it has correct form schema', function (): void {
    $schema = $this->widget->getFormSchema();
    
    expect($schema)->toHaveCount(3);
    expect($schema)->toHaveKey('email');
    expect($schema)->toHaveKey('password');
    expect($schema)->toHaveKey('remember');
});

test('it can authenticate user', function (): void {
    // Skip if we can't use the database
    if (!class_exists('CreateUsersTable')) {
        $this->markTestSkipped('Database not available for testing');
        return;
    }
    
    /** @var \Modules\User\Models\User $user */
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);

    $this->widget->form->fill([
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => true,
    ]);

    $this->widget->save();

    assertAuthenticatedAs($user);
});

test('it validates credentials', function (): void {
    $this->widget->form->fill([
        'email' => 'nonexistent@example.com',
        'password' => 'wrongpassword',
    ]);

    expect(fn () => $this->widget->save())
        ->toThrow(ValidationException::class);
});

test('it requires email and password', function (): void {
    $this->widget->form->fill([
        'email' => '',
        'password' => '',
    ]);

    expect(fn () => $this->widget->save())
        ->toThrow(ValidationException::class);
});
