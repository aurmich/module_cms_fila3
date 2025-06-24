<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Widgets;

use Filament\Forms\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\User\Models\User;
use Tests\TestCase;

<<<<<<< HEAD
=======
// Skip this test if the test database is not configured
if (!env('DB_CONNECTION') || env('DB_CONNECTION') === 'sqlite' && !file_exists(database_path('database.sqlite'))) {
    return;
}

>>>>>>> 4c632a28 (✨ (bashscripts): add new scripts for managing MCP MySQL server and PHPStan analysis)
class LoginWidgetTest extends TestCase
{
    use RefreshDatabase;

    protected LoginWidget $widget;

    protected function setUp(): void
    {
        parent::setUp();
        $this->widget = new LoginWidget();
    }

    /** @test */
    public function it_can_render_widget()
    {
        $this->assertStringContainsString(
            'user::filament.widgets.login',
            $this->widget::getView()
        );
    }

    /** @test */
    public function it_has_correct_form_schema()
    {
        $schema = $this->widget->getFormSchema();
        
        $this->assertCount(3, $schema);
        $this->assertArrayHasKey('email', $schema);
        $this->assertArrayHasKey('password', $schema);
        $this->assertArrayHasKey('remember', $schema);
    }

    /** @test */
    public function it_can_authenticate_user()
    {
<<<<<<< HEAD
=======
        // Skip if we can't use the database
        if (!class_exists('CreateUsersTable')) {
            $this->markTestSkipped('Database not available for testing');
            return;
        }

>>>>>>> 4c632a28 (✨ (bashscripts): add new scripts for managing MCP MySQL server and PHPStan analysis)
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

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_validates_credentials()
    {
        $this->expectException(ValidationException::class);
        
        $this->widget->form->fill([
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->widget->save();
    }

    /** @test */
    public function it_requires_email_and_password()
    {
        $this->expectException(ValidationException::class);
        
        $this->widget->form->fill([
            'email' => '',
            'password' => '',
        ]);

        $this->widget->save();
    }
}
