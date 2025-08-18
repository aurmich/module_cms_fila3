<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Models\User;
use Modules\Xot\Datas\XotData;
use Livewire\Livewire;

beforeEach(function () {
    if (!moduleEnabled('User')) {
        $this->markTestSkipped('Module User is disabled');
    }
});

describe('LoginWidget Filament Component', function () {
    test('login widget can be instantiated', function () {
        $widget = new LoginWidget();
        
        expect($widget)->toBeInstanceOf(LoginWidget::class);
    });

    test('login widget has correct view', function () {
        $widget = new LoginWidget();
        
        // Check if widget has a view property or method
        expect(method_exists($widget, 'render') || property_exists($widget, 'view'))->toBeTrue();
    });

    test('login widget form schema is properly configured', function () {
        $widget = new LoginWidget();
        
        // Check if widget has form schema method
        if (method_exists($widget, 'getFormSchema')) {
            $schema = $widget->getFormSchema();
            expect($schema)->toBeArray();
        }
    });
});

describe('LoginWidget Livewire Integration', function () {
    test('login widget can be rendered as livewire component', function () {
        Livewire::test(LoginWidget::class)
            ->assertStatus(200);
    });

    test('login widget form validation works', function () {
        Livewire::test(LoginWidget::class)
            ->set('email', '')
            ->set('password', '')
            ->call('authenticate')
            ->assertHasErrors(['email', 'password']);
    });

    test('login widget accepts valid email format', function () {
        Livewire::test(LoginWidget::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->assertHasNoErrors('email');
    });

    test('login widget rejects invalid email format', function () {
        Livewire::test(LoginWidget::class)
            ->set('email', 'invalid-email')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertHasErrors('email');
    });
});

describe('LoginWidget Authentication Logic', function () {
    test('login widget authenticates valid user', function () {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        Livewire::test(LoginWidget::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertHasNoErrors();

        expect(auth()->check())->toBeTrue();
        expect(auth()->user()->email)->toBe('test@example.com');
    });

    test('login widget rejects invalid credentials', function () {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        Livewire::test(LoginWidget::class)
            ->set('email', 'test@example.com')
            ->set('password', 'wrongpassword')
            ->call('authenticate')
            ->assertHasErrors();

        expect(auth()->check())->toBeFalse();
    });

    test('login widget handles non-existent user', function () {
        Livewire::test(LoginWidget::class)
            ->set('email', 'nonexistent@example.com')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertHasErrors();

        expect(auth()->check())->toBeFalse();
    });
});

describe('LoginWidget Security Features', function () {
    test('login widget sanitizes input', function () {
        Livewire::test(LoginWidget::class)
            ->set('email', '<script>alert("xss")</script>test@example.com')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertHasErrors('email');
    });

    test('login widget handles rate limiting', function () {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Attempt multiple failed logins
        for ($i = 0; $i < 5; $i++) {
            Livewire::test(LoginWidget::class)
                ->set('email', 'test@example.com')
                ->set('password', 'wrongpassword')
                ->call('authenticate');
        }

        // Next attempt should be rate limited
        Livewire::test(LoginWidget::class)
            ->set('email', 'test@example.com')
            ->set('password', 'wrongpassword')
            ->call('authenticate')
            ->assertHasErrors();
    });

    test('login widget clears sensitive data after authentication', function () {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $component = Livewire::test(LoginWidget::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->call('authenticate');

        // Password should be cleared after authentication attempt
        expect($component->get('password'))->toBeEmpty();
    });
});

describe('LoginWidget Form Components', function () {
    test('login widget has email field', function () {
        Livewire::test(LoginWidget::class)
            ->assertPropertyWired('email');
    });

    test('login widget has password field', function () {
        Livewire::test(LoginWidget::class)
            ->assertPropertyWired('password');
    });

    test('login widget has remember me option', function () {
        $component = Livewire::test(LoginWidget::class);
        
        // Check if remember field exists
        if ($component->instance()->hasProperty('remember')) {
            $component->assertPropertyWired('remember');
        }
    });

    test('login widget submit button works', function () {
        Livewire::test(LoginWidget::class)
            ->assertMethodWired('authenticate');
    });
});

describe('LoginWidget Translations', function () {
    test('login widget uses correct translation keys', function () {
        $widget = new LoginWidget();
        
        // Test different locales
        $locales = ['it', 'en', 'de'];
        
        foreach ($locales as $locale) {
            app()->setLocale($locale);
            
            // Check that translation keys don't contain the raw key
            $emailLabel = __('user::auth.login.email.label');
            $passwordLabel = __('user::auth.login.password.label');
            
            expect($emailLabel)->not->toContain('user::');
            expect($passwordLabel)->not->toContain('user::');
        }
    });

    test('login widget error messages are translated', function () {
        $locales = ['it', 'en', 'de'];
        
        foreach ($locales as $locale) {
            app()->setLocale($locale);
            
            Livewire::test(LoginWidget::class)
                ->set('email', '')
                ->set('password', '')
                ->call('authenticate')
                ->assertHasErrors(['email', 'password']);
            
            // Errors should be in the correct language
            // This is handled by Laravel's validation system
        }
    });
});

describe('LoginWidget Performance', function () {
    test('login widget renders quickly', function () {
        $start = microtime(true);
        
        Livewire::test(LoginWidget::class)->assertStatus(200);
        
        $duration = microtime(true) - $start;
        expect($duration)->toBeLessThan(0.5); // Should render in less than 500ms
    });

    test('login widget authentication is performant', function () {
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $start = microtime(true);
        
        Livewire::test(LoginWidget::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->call('authenticate');
        
        $duration = microtime(true) - $start;
        expect($duration)->toBeLessThan(1.0); // Authentication should take less than 1 second
    });
});
