# PHPStan Config Immutability Rule

- File: `/var/www/html/_bases/base_saluteora/laravel/phpstan.neon`
- Status: IMMUTABLE. Do not modify this file from tooling or automation.
- Ownership: Managed by the user. Any changes must be done manually by the user.

## Consequences
- Scoping, excludes, and experimental flags must be applied via CLI when running PHPStan.
- Example: limit analysis to selected modules or folders without touching phpstan.neon.

## Safe CLI Examples
```bash
# Run only selected modules
./vendor/bin/phpstan analyze Modules/User Modules/Geo --level=9 --no-progress --memory-limit=2G

# Run all module app/ folders except Activity (shell excludes)
find Modules -maxdepth 2 -type d -name app ! -path 'Modules/Activity/*' -print0 \
  | xargs -0 ./vendor/bin/phpstan analyze --level=9 --no-progress --memory-limit=2G
```

## Rationale
- Prevent unintentional, wide-impact configuration changes.
- Keep a single source of truth owned by the user for static analysis settings.

## Enforcement
- Tools and assistants must not patch `phpstan.neon`.
- If analysis requires different scope, use CLI-only flags and path lists.
