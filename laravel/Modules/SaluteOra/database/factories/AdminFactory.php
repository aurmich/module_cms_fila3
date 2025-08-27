<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\Models\Admin;

/**
 * AdminFactory for SaluteOra module.
 * 
 * Generates realistic admin data for system administrators.
 * Extends UserFactory to inherit base user functionality and adds
 * administrative privileges, multi-studio access, and security features.
 * 
 */
class AdminFactory extends UserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\Admin>
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return array_merge(parent::definition(), [
            // Admin type and state
            'type' => UserTypeEnum::ADMIN->value,
            'state' => $this->faker->randomElement([
                Active::class, // Most admins are active when created
                Pending::class,
                IntegrationRequested::class
            ]),

            // Administrative level and scope
            'admin_level' => $this->faker->randomElement(['studio', 'regional', 'system']),
            'security_clearance' => $this->faker->randomElement(['basic', 'elevated', 'admin']),
            'admin_role' => $this->faker->randomElement([
                'system_administrator', 'studio_manager', 'clinical_coordinator',
                'finance_manager', 'hr_manager', 'it_support', 'marketing_manager'
            ]),

            // Multi-studio access management
            'can_access_all_studios' => $this->faker->boolean(40),
            'assigned_studios' => function (array $attributes) {
                return $attributes['can_access_all_studios'] 
                    ? null 
                    : $this->faker->numberBetween(1, 5);
            },
            'primary_studio_id' => $this->faker->optional(0.8)->numberBetween(1, 10),

            // Department and responsibilities
            'department' => $this->faker->randomElement([
                'administration', 'finance', 'clinical', 'marketing', 
                'human_resources', 'it', 'quality_assurance', 'legal'
            ]),
            'supervisor_level' => $this->faker->numberBetween(1, 4),
            'reports_to' => $this->faker->optional(0.7)->numberBetween(1, 20),
            'direct_reports_count' => $this->faker->numberBetween(0, 15),

            // Permissions and access rights
            'permissions' => $this->generateAdminPermissions(),
            'module_access' => $this->generateModuleAccess(),
            'data_access_level' => $this->faker->randomElement([
                'read_only', 'read_write', 'full_access', 'restricted'
            ]),

            // Security settings
            'two_factor_enabled' => $this->faker->boolean(70),
            'session_timeout_minutes' => $this->faker->randomElement([30, 60, 120, 240]),
            'last_password_change' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'password_expiry_days' => $this->faker->randomElement([90, 180, 365]),
            'failed_login_attempts' => 0, // Reset for new admin
            'account_locked_until' => null,

            // Contact and emergency information
            'emergency_contact_admin' => $this->faker->optional(0.8)->passthrough($this->faker->name()),
            'emergency_contact_phone' => $this->faker->optional(0.8)->passthrough($this->faker->phoneNumber()),
            'backup_email' => $this->faker->optional(0.6)->passthrough($this->faker->unique()->safeEmail()),

            // Professional information
            'employee_id' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'hire_date' => $this->faker->dateTimeBetween('-10 years', 'now'),
            'contract_type' => $this->faker->randomElement(['full_time', 'part_time', 'contractor', 'intern']),
            'salary_band' => $this->faker->randomElement(['junior', 'mid', 'senior', 'lead', 'executive']),

            // Work schedule and availability
            'work_schedule' => $this->generateWorkSchedule(),
            'remote_work_allowed' => $this->faker->boolean(60),
            'on_call_rotation' => $this->faker->boolean(30),
            'vacation_days_remaining' => $this->faker->numberBetween(0, 25),

            // System preferences
            'dashboard_layout' => $this->faker->randomElement(['default', 'compact', 'detailed']),
            'notification_preferences' => $this->generateNotificationPreferences(),
            'language_preference' => $this->faker->randomElement(['it', 'en']),
            'timezone' => 'Europe/Rome',

            // Audit and compliance
            'last_training_date' => $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'next_review_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'compliance_certificates' => $this->generateComplianceCertificates(),
            'gdpr_training_completed' => $this->faker->boolean(85),
            'security_training_completed' => $this->faker->boolean(90),

            // Performance metrics
            'performance_rating' => $this->faker->optional(0.7)->randomFloat(1, 3.0, 5.0),
            'last_performance_review' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'goals_achieved_percentage' => $this->faker->optional(0.6)->numberBetween(60, 100),

            // Technical specifications
            'ip_whitelist' => $this->faker->optional(0.3)->randomElements([
                '192.168.1.100', '10.0.0.50', '172.16.0.25'
            ], $this->faker->numberBetween(1, 3)),
            'device_restrictions' => $this->faker->optional(0.4)->randomElements([
                'desktop_only', 'mobile_allowed', 'tablet_allowed'
            ], $this->faker->numberBetween(1, 2)),
            'vpn_required' => $this->faker->boolean(50),

            // Emergency and backup
            'backup_admin_id' => $this->faker->optional(0.6)->numberBetween(1, 20),
            'emergency_procedures_trained' => $this->faker->boolean(80),
            'incident_response_role' => $this->faker->optional(0.5)->randomElement([
                'first_responder', 'escalation_contact', 'communications', 'technical_lead'
            ]),
        ]);
    }

    /**
     * Generate comprehensive admin permissions.
     *
     * @return array<string, bool>
     */
    private function generateAdminPermissions(): array
    {
        $permissions = [];
        
        // User management permissions
        $userPermissions = [
            'create_users' => 60,
            'edit_users' => 70,
            'delete_users' => 30,
            'view_users' => 90,
            'manage_user_roles' => 40,
            'reset_user_passwords' => 50,
            'deactivate_users' => 40,
        ];
        
        // Studio management permissions
        $studioPermissions = [
            'create_studios' => 20,
            'edit_studios' => 40,
            'delete_studios' => 10,
            'view_studios' => 80,
            'manage_studio_staff' => 50,
            'studio_financial_reports' => 30,
        ];
        
        // System permissions
        $systemPermissions = [
            'view_system_logs' => 40,
            'manage_system_settings' => 25,
            'backup_database' => 20,
            'manage_integrations' => 30,
            'view_analytics' => 60,
            'export_data' => 50,
        ];
        
        // Clinical permissions
        $clinicalPermissions = [
            'view_patient_records' => 70,
            'edit_patient_records' => 40,
            'view_appointments' => 80,
            'manage_appointments' => 50,
            'view_medical_reports' => 60,
        ];
        
        // Financial permissions
        $financialPermissions = [
            'view_financial_reports' => 50,
            'manage_billing' => 40,
            'process_payments' => 30,
            'manage_insurance' => 35,
            'view_revenue_analytics' => 40,
        ];
        
        $allPermissions = array_merge(
            $userPermissions, $studioPermissions, $systemPermissions,
            $clinicalPermissions, $financialPermissions
        );
        
        foreach ($allPermissions as $permission => $probability) {
            $permissions[$permission] = $this->faker->boolean($probability);
        }
        
        return $permissions;
    }

    /**
     * Generate module access permissions.
     *
     * @return array<string, bool>
     */
    private function generateModuleAccess(): array
    {
        $modules = [
            'user_management' => 80,
            'patient_management' => 70,
            'doctor_management' => 60,
            'appointment_system' => 75,
            'billing_finance' => 50,
            'reports_analytics' => 60,
            'system_settings' => 40,
            'audit_logs' => 35,
            'integrations' => 30,
            'marketing_tools' => 45,
            'inventory_management' => 40,
            'quality_assurance' => 35,
        ];
        
        $access = [];
        foreach ($modules as $module => $probability) {
            $access[$module] = $this->faker->boolean($probability);
        }
        
        return $access;
    }

    /**
     * Generate work schedule.
     *
     * @return array<string, mixed>
     */
    private function generateWorkSchedule(): array
    {
        return [
            'monday' => $this->faker->boolean(90) ? '09:00-18:00' : null,
            'tuesday' => $this->faker->boolean(90) ? '09:00-18:00' : null,
            'wednesday' => $this->faker->boolean(90) ? '09:00-18:00' : null,
            'thursday' => $this->faker->boolean(90) ? '09:00-18:00' : null,
            'friday' => $this->faker->boolean(85) ? '09:00-17:00' : null,
            'saturday' => $this->faker->boolean(20) ? '09:00-13:00' : null,
            'sunday' => $this->faker->boolean(5) ? 'on_call' : null,
            'flexible_hours' => $this->faker->boolean(40),
            'core_hours' => '10:00-16:00',
        ];
    }

    /**
     * Generate notification preferences.
     *
     * @return array<string, bool>
     */
    private function generateNotificationPreferences(): array
    {
        return [
            'email_notifications' => $this->faker->boolean(85),
            'sms_notifications' => $this->faker->boolean(60),
            'push_notifications' => $this->faker->boolean(70),
            'security_alerts' => $this->faker->boolean(95),
            'system_maintenance' => $this->faker->boolean(90),
            'user_activities' => $this->faker->boolean(50),
            'financial_alerts' => $this->faker->boolean(60),
            'clinical_updates' => $this->faker->boolean(40),
        ];
    }

    /**
     * Generate compliance certificates.
     *
     * @return array<string, mixed>
     */
    private function generateComplianceCertificates(): array
    {
        $certificates = [];
        
        $available = [
            'gdpr_certification' => 80,
            'hipaa_equivalent' => 70,
            'data_protection' => 75,
            'security_awareness' => 85,
            'emergency_procedures' => 60,
            'quality_management' => 55,
            'anti_corruption' => 50,
        ];
        
        foreach ($available as $cert => $probability) {
            if ($this->faker->boolean($probability)) {
                $certificates[$cert] = [
                    'obtained_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
                    'expiry_date' => $this->faker->dateTimeBetween('now', '+2 years'),
                    'issuing_authority' => $this->faker->randomElement([
                        'Internal Training', 'Governo Italiano', 'Ente Certificatore',
                        'Associazione Professionale'
                    ])
                ];
            }
        }
        
        return $certificates;
    }

    /**
     * Create admin in active state (ready to work).
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state([
            'state' => Active::class,
            'two_factor_enabled' => true,
            'security_training_completed' => true,
            'gdpr_training_completed' => true,
        ]);
    }

    /**
     * Create admin in pending state (awaiting setup).
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state([
            'state' => Pending::class,
            'two_factor_enabled' => false,
            'last_password_change' => null,
            'permissions' => [], // No permissions until activated
        ]);
    }

    /**
     * Create system administrator with full access.
     *
     * @return static
     */
    public function systemAdmin(): static
    {
        return $this->state([
            'admin_level' => 'system',
            'security_clearance' => 'admin',
            'can_access_all_studios' => true,
            'department' => 'administration',
            'supervisor_level' => 4,
            'permissions' => [
                'create_users' => true,
                'edit_users' => true,
                'delete_users' => true,
                'view_users' => true,
                'manage_user_roles' => true,
                'manage_system_settings' => true,
                'view_system_logs' => true,
                'backup_database' => true,
            ],
            'module_access' => [
                'user_management' => true,
                'system_settings' => true,
                'audit_logs' => true,
                'reports_analytics' => true,
            ],
            'two_factor_enabled' => true,
            'session_timeout_minutes' => 60,
        ]);
    }

    /**
     * Create studio manager with studio-specific access.
     *
     * @return static
     */
    public function studioManager(): static
    {
        return $this->state([
            'admin_level' => 'studio',
            'security_clearance' => 'elevated',
            'can_access_all_studios' => false,
            'assigned_studios' => 1,
            'department' => 'administration',
            'supervisor_level' => 2,
            'admin_role' => 'studio_manager',
            'permissions' => [
                'view_users' => true,
                'edit_users' => true,
                'manage_studio_staff' => true,
                'view_studios' => true,
                'edit_studios' => true,
                'view_patient_records' => true,
                'manage_appointments' => true,
                'view_financial_reports' => true,
            ],
            'module_access' => [
                'patient_management' => true,
                'doctor_management' => true,
                'appointment_system' => true,
                'billing_finance' => true,
                'reports_analytics' => true,
            ],
        ]);
    }

    /**
     * Create regional manager with multi-studio access.
     *
     * @return static
     */
    public function regionalManager(): static
    {
        return $this->state([
            'admin_level' => 'regional',
            'security_clearance' => 'elevated',
            'can_access_all_studios' => false,
            'assigned_studios' => $this->faker->numberBetween(3, 8),
            'department' => 'administration',
            'supervisor_level' => 3,
            'admin_role' => 'studio_manager',
            'direct_reports_count' => $this->faker->numberBetween(5, 15),
            'permissions' => [
                'view_users' => true,
                'edit_users' => true,
                'create_users' => true,
                'manage_studio_staff' => true,
                'view_studios' => true,
                'edit_studios' => true,
                'studio_financial_reports' => true,
                'view_analytics' => true,
            ],
        ]);
    }

    /**
     * Create IT support admin with technical focus.
     *
     * @return static
     */
    public function itSupport(): static
    {
        return $this->state([
            'admin_level' => 'system',
            'security_clearance' => 'admin',
            'department' => 'it',
            'admin_role' => 'it_support',
            'can_access_all_studios' => true,
            'permissions' => [
                'view_system_logs' => true,
                'manage_system_settings' => true,
                'manage_integrations' => true,
                'backup_database' => true,
                'reset_user_passwords' => true,
            ],
            'module_access' => [
                'system_settings' => true,
                'audit_logs' => true,
                'integrations' => true,
                'user_management' => true,
            ],
            'two_factor_enabled' => true,
            'vpn_required' => true,
        ]);
    }

    /**
     * Create finance manager with financial focus.
     *
     * @return static
     */
    public function financeManager(): static
    {
        return $this->state([
            'admin_level' => 'regional',
            'security_clearance' => 'elevated',
            'department' => 'finance',
            'admin_role' => 'finance_manager',
            'permissions' => [
                'view_financial_reports' => true,
                'manage_billing' => true,
                'process_payments' => true,
                'manage_insurance' => true,
                'view_revenue_analytics' => true,
                'export_data' => true,
            ],
            'module_access' => [
                'billing_finance' => true,
                'reports_analytics' => true,
                'patient_management' => true,
            ],
            'two_factor_enabled' => true,
            'session_timeout_minutes' => 30, // Shorter for finance
        ]);
    }

    /**
     * Create junior admin with limited access.
     *
     * @return static
     */
    public function junior(): static
    {
        return $this->state([
            'admin_level' => 'studio',
            'security_clearance' => 'basic',
            'department' => 'administration',
            'supervisor_level' => 1,
            'salary_band' => 'junior',
            'can_access_all_studios' => false,
            'assigned_studios' => 1,
            'permissions' => [
                'view_users' => true,
                'view_patient_records' => true,
                'view_appointments' => true,
                'manage_appointments' => true,
            ],
            'module_access' => [
                'patient_management' => true,
                'appointment_system' => true,
            ],
            'session_timeout_minutes' => 30,
        ]);
    }

    /**
     * Create contractor admin with temporary access.
     *
     * @return static
     */
    public function contractor(): static
    {
        return $this->state([
            'contract_type' => 'contractor',
            'admin_level' => 'studio',
            'security_clearance' => 'basic',
            'can_access_all_studios' => false,
            'assigned_studios' => 1,
            'hire_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'session_timeout_minutes' => 30,
            'remote_work_allowed' => false,
            'two_factor_enabled' => true, // Required for contractors
            'permissions' => [
                'view_users' => false,
                'view_patient_records' => true,
                'view_appointments' => true,
            ],
        ]);
    }
}
