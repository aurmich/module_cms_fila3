<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Services;

use Modules\SaluteOra\Models\User;
use Illuminate\Support\Facades\Config;

class UserModerationService
{
    /**
     * Validate user data against moderation rules for their type.
     *
     * @param User $user
     * @return array<string, string>
     */
    public function validateUserData(User $user): array
    {
        $userType = $user->type;
        $rules = Config::get("patient.moderation.user_types.$userType.validation_rules", []);
        $errors = [];

        foreach ($rules as $field => $rule) {
            $value = $user->$field;
            // Simple validation check (this should be expanded based on actual rules)
            if (is_string($rule) && strpos($rule, 'required') !== false && empty($value)) {
                $errors[$field] = "The $field field is required.";
            }
            // Add more complex validation logic as needed
        }

        return $errors;
    }

    /**
     * Update user moderation state.
     *
     * @param User $user
     * @param string $newState
     * @return bool
     */
    public function updateModerationState(User $user, string $newState): bool
    {
        $user->state = $newState;
        return $user->save();
    }

    /**
     * Get the next workflow step for a user type.
     *
     * @param string $userType
     * @param string $currentStep
     * @return string|null
     */
    public function getNextWorkflowStep(string $userType, string $currentStep): ?string
    {
        $workflowSteps = Config::get("patient.moderation.user_types.$userType.workflow.steps", []);
        $currentIndex = array_search($currentStep, $workflowSteps);

        if ($currentIndex !== false && isset($workflowSteps[$currentIndex + 1])) {
            return $workflowSteps[$currentIndex + 1];
        }

        return null;
    }
}
