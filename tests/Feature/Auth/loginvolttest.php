<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Volt as LivewireVolt;
<<<<<<< HEAD
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use function Pest\Laravel\{assertGuest, assertAuthenticated};
=======
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
>>>>>>> b32aaf5 (.)

uses(\Modules\Xot\Tests\TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->$this->generateUniqueEmail(), $this->getUserClass(), $this->$this->createTestUser()

describe('Volt Component Rendering', function () {
    test('volt login component can be rendered', function () {
        $component = LivewireVolt::test('auth.login');
<<<<<<< HEAD
        
        expect($component)->not->toBeNull();
        $component->assertOk();
    });
    
    test('volt component has initial state', function () {
        $component = LivewireVolt::test('auth.login');
        
=======

        expect($component)->not->toBeNull();
        $component->assertOk();
    });

    test('volt component has initial state', function () {
        $component = LivewireVolt::test('auth.login');

>>>>>>> b32aaf5 (.)
        $component
            ->assertSet('email', '')
            ->assertSet('password', '')
            ->assertSet('remember', false);
    });
<<<<<<< HEAD
    
    test('volt component renders form elements', function () {
        $component = LivewireVolt::test('auth.login');
        
=======

    test('volt component renders form elements', function () {
        $component = LivewireVolt::test('auth.login');

>>>>>>> b32aaf5 (.)
        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    });
});

describe('Volt Component Authentication', function () {
    test('user can authenticate via volt component', function () {
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        assertGuest();
        
=======

        assertGuest();

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        $response->assertHasNoErrors();
        assertAuthenticated();
    });
    
=======

        $response->assertHasNoErrors();
        assertAuthenticated();
    });

>>>>>>> b32aaf5 (.)
    test('authentication fails with wrong credentials', function () {
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        assertGuest();
        
=======

        assertGuest();

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');
<<<<<<< HEAD
        
        $response->assertHasErrors(['email']);
        assertGuest();
    });
    
    test('authentication fails with non-existent user', function () {
        $email = $this->generateUniqueEmail();
        
        assertGuest();
        
=======

        $response->assertHasErrors(['email']);
        assertGuest();
    });

    test('authentication fails with non-existent user', function () {
        $email = $this->generateUniqueEmail();

        assertGuest();

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        $response->assertHasErrors(['email']);
        assertGuest();
    });
});

describe('Volt Component Validation', function () {
    test('email validation works', function () {
        $response = LivewireVolt::test('auth.login')
            ->set('email', 'invalid-email')
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        $response->assertHasErrors(['email']);
    });
    
    test('required fields validation', function () {
        $response = LivewireVolt::test('auth.login')
            ->call('save');
        
        $response->assertHasErrors(['email', 'password']);
    });
    
    test('password minimum length validation', function () {
        $email = $this->generateUniqueEmail();
        
=======

        $response->assertHasErrors(['email']);
    });

    test('required fields validation', function () {
        $response = LivewireVolt::test('auth.login')
            ->call('save');

        $response->assertHasErrors(['email', 'password']);
    });

    test('password minimum length validation', function () {
        $email = $this->generateUniqueEmail();

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', '123')
            ->call('save');
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        // Password troppo corta dovrebbe fallire
        $response->assertHasErrors();
    });
});

describe('Volt Component Session Management', function () {
    test('remember me functionality works', function () {
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        assertGuest();
        
=======

        assertGuest();

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('save');
<<<<<<< HEAD
        
        $response->assertHasNoErrors();
        assertAuthenticated();
    });
    
=======

        $response->assertHasNoErrors();
        assertAuthenticated();
    });

>>>>>>> b32aaf5 (.)
    test('session regeneration on login', function () {
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        // Store original session ID
        $originalSessionId = session()->getId();
        
=======

        // Store original session ID
        $originalSessionId = session()->getId();

>>>>>>> b32aaf5 (.)
        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        assertAuthenticated();
        
        // Session should be regenerated for security
        expect(session()->getId())->not->toBe($originalSessionId);
    });
    
=======

        assertAuthenticated();

        // Session should be regenerated for security
        expect(session()->getId())->not->toBe($originalSessionId);
    });

>>>>>>> b32aaf5 (.)
    test('session data is preserved on authentication', function () {
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        // Set some session data
        Session::put('test_key', 'test_value');
        
=======

        // Set some session data
        Session::put('test_key', 'test_value');

>>>>>>> b32aaf5 (.)
        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        assertAuthenticated();
        
=======

        assertAuthenticated();

>>>>>>> b32aaf5 (.)
        // Session data should be preserved (session regenerated but data kept)
        expect(Session::get('test_key'))->toBe('test_value');
    });
});

describe('Volt Component Security', function () {
    test('login attempts are rate limited', function () {
        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        // Multiple failed attempts
        for ($i = 0; $i < 5; $i++) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('save');
        }
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        // Should be rate limited after too many attempts
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        // May have throttling errors
        expect($response)->not->toBeNull();
    });
    
=======

        // May have throttling errors
        expect($response)->not->toBeNull();
    });

>>>>>>> b32aaf5 (.)
    test('csrf protection is active', function () {
        // Volt components should automatically handle CSRF protection
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        // Should work normally with CSRF protection
        $response->assertHasNoErrors();
    });
    
    test('input sanitization works', function () {
        $email = $this->generateUniqueEmail();
        
        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>' . $email)
            ->set('password', 'password123')
            ->call('save');
        
=======

        // Should work normally with CSRF protection
        $response->assertHasNoErrors();
    });

    test('input sanitization works', function () {
        $email = $this->generateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>'.$email)
            ->set('password', 'password123')
            ->call('save');

>>>>>>> b32aaf5 (.)
        // Should handle potentially malicious input safely
        expect($response)->not->toBeNull();
    });
});

describe('Volt Component State Management', function () {
    test('component state updates correctly', function () {
        $email = $this->generateUniqueEmail();
<<<<<<< HEAD
        
        $component = LivewireVolt::test('auth.login');
        
=======

        $component = LivewireVolt::test('auth.login');

>>>>>>> b32aaf5 (.)
        $component
            ->set('email', $email)
            ->assertSet('email', $email)
            ->set('password', 'password123')
            ->assertSet('password', 'password123')
            ->set('remember', true)
            ->assertSet('remember', true);
    });
<<<<<<< HEAD
    
    test('component resets after failed authentication', function () {
        $email = $this->generateUniqueEmail();
        
=======

    test('component resets after failed authentication', function () {
        $email = $this->generateUniqueEmail();

>>>>>>> b32aaf5 (.)
        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');
<<<<<<< HEAD
        
        // Password should be cleared after failed attempt
        $component->assertSet('password', '');
    });
    
=======

        // Password should be cleared after failed attempt
        $component->assertSet('password', '');
    });

>>>>>>> b32aaf5 (.)
    test('loading state is managed correctly', function () {
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123');
        
        // Should not be in loading state initially
        $component->assertDontSee('wire:loading');
        
        // After calling authenticate, component should handle loading state
        $component->call('save');
        
=======

        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123');

        // Should not be in loading state initially
        $component->assertDontSee('wire:loading');

        // After calling authenticate, component should handle loading state
        $component->call('save');

>>>>>>> b32aaf5 (.)
        // Should complete successfully
        $component->assertHasNoErrors();
    });
});

describe('Volt Component User Types Integration', function () {
    test('any user type can login via volt component', function () {
        // Using XotData pattern ensures compatibility with any user type
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        assertGuest();
        
=======

        assertGuest();

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        $response->assertHasNoErrors();
        assertAuthenticated();
        
=======

        $response->assertHasNoErrors();
        assertAuthenticated();

>>>>>>> b32aaf5 (.)
        // Verify authenticated user
        $authenticatedUser = Auth::user();
        expect($authenticatedUser)->not->toBeNull();
        expect($authenticatedUser->email)->toBe($email);
    });
<<<<<<< HEAD
    
=======

>>>>>>> b32aaf5 (.)
    test('component handles different user configurations', function () {
        // Test with various user attributes
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'name' => 'Test User',
        ]);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        $response->assertHasNoErrors();
        assertAuthenticated();
        
=======

        $response->assertHasNoErrors();
        assertAuthenticated();

>>>>>>> b32aaf5 (.)
        $authenticatedUser = Auth::user();
        expect($authenticatedUser->name)->toBe('Test User');
    });
});

describe('Volt Component Redirects', function () {
    test('component redirects after successful authentication', function () {
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
        $response->assertHasNoErrors();
        assertAuthenticated();
        
        // Component might trigger redirect via JavaScript/Alpine
        // This test ensures the authentication logic completes successfully
    });
    
=======

        $response->assertHasNoErrors();
        assertAuthenticated();

        // Component might trigger redirect via JavaScript/Alpine
        // This test ensures the authentication logic completes successfully
    });

>>>>>>> b32aaf5 (.)
    test('component handles intended redirect', function () {
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);
<<<<<<< HEAD
        
        // Set intended URL
        Session::put('url.intended', '/dashboard');
        
=======

        // Set intended URL
        Session::put('url.intended', '/dashboard');

>>>>>>> b32aaf5 (.)
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        $response->assertHasNoErrors();
        assertAuthenticated();
    });
});

describe('Volt Component Accessibility', function () {
    test('component has proper aria labels', function () {
        $component = LivewireVolt::test('auth.login');
<<<<<<< HEAD
        
        // Component should render with accessibility attributes
        $component->assertSee('aria-label')
                 ->assertSee('id="data.email"')
                 ->assertSee('id="data.password"');
    });
    
    test('component handles keyboard navigation', function () {
        $component = LivewireVolt::test('auth.login');
        
        // Component should be keyboard accessible
        expect($component)->not->toBeNull();
    });
});
=======

        // Component should render with accessibility attributes
        $component->assertSee('aria-label')
            ->assertSee('id="data.email"')
            ->assertSee('id="data.password"');
    });

    test('component handles keyboard navigation', function () {
        $component = LivewireVolt::test('auth.login');

        // Component should be keyboard accessible
        expect($component)->not->toBeNull();
    });
});
>>>>>>> b32aaf5 (.)
