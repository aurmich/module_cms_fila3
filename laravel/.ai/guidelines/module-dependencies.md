# Module Dependency Guidelines

## Core Rule: Base modules must not depend on feature modules

- `Modules/User` is a base module. It MUST NOT depend on `Modules/SaluteOra` (or any feature-specific module).
- Allowed directions: `SaluteOra` → `User`, never the opposite.
- If interaction is needed, use:
  - Interfaces in the base module + bindings in the feature module
  - Domain events (feature listens to base events)
  - Optional integration guarded with `class_exists()` and service discovery

## Enforcement
- Add CI checks to detect forbidden imports in base modules.
- Prefer inversion via contracts and events.

## Quick Check
- Search for `use Modules\SaluteOra\` inside `Modules/User/**` → Must be empty.

## Related
- `.windsurf/rules/module-dependency-user.mdc`
- `.ai/guidelines/filament-resource-rules.md` (respect base abstractions)
- `.ai/guidelines/testing-business-behavior.md` (business-first tests)
