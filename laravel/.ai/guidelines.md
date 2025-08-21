# AI Development Guidelines - SaluteOra Project

## Error Fixing Philosophy

### Core Principle: Fix, Don't Hide

**NEVER** use `@phpstan-ignore` or similar suppression comments unless absolutely necessary. Always prefer fixing the root cause of the error.

### Common Error Patterns and Solutions

#### 1. Type Safety Issues
- Use `instanceof` checks for type validation
- Add proper null checks before property/method access
- Throw meaningful exceptions for invalid types

#### 2. Eloquent Relationship Issues
- Use `$this` instead of concrete class names in generic type annotations
- Remove unnecessary method overrides when parent implementation suffices
- Ensure proper return type compatibility between parent and child classes

#### 3. Filament Resource Errors
- `getRelations()` must return RelationManager class names, not field names
- Use `getXlsFields()` for field configurations
- Verify proper resource inheritance and model assignment

## Code Quality Standards

### PHPStan Compliance
- Run PHPStan analysis before committing changes
- Address all errors with proper fixes, not suppressions
- Document any necessary suppressions with detailed comments

### Testing Requirements
- Write tests for all new functionality
- Ensure PHPStan fixes don't break existing functionality
- Use proper type hints and assertions in tests

### Documentation Standards
- Update CLAUDE.md when adding new patterns or rules
- Document architectural decisions in appropriate docs/ files
- Keep inline documentation concise but informative

## Module-Specific Guidelines

### SaluteOra Module
- Follow existing inheritance patterns (User -> Doctor/Patient/Admin)
- Use proper database connections (`salute_ora` vs `user`)
- Maintain cross-database relationship conventions

### Filament Integration
- Resources should extend appropriate base classes
- RelationManagers must be properly implemented
- Form schemas should follow existing patterns

## Common Pitfalls to Avoid

1. **Template Type Covariance**: Don't fight PHPStan's template system, use `$this` appropriately
2. **Null Property Access**: Always check for null before accessing properties
3. **Mixed Type Parameters**: Use proper type checking instead of assuming types
4. **Unnecessary Overrides**: Remove method overrides when parent implementation is sufficient

## When Suppressions Are Acceptable

Only use `@phpstan-ignore` in these specific cases:
- Known framework limitations (documented in Laravel/Filament)
- Legacy code that cannot be immediately refactored
- Complex template scenarios with no viable alternative

Always include a detailed comment explaining why the suppression is necessary.

## Review Checklist

Before considering code complete:
- [ ] All PHPStan errors resolved properly (not suppressed)
- [ ] Null safety checks added where needed
- [ ] Type checking implemented correctly
- [ ] Tests pass and cover new functionality
- [ ] Documentation updated appropriately
- [ ] No unnecessary method overrides
- [ ] Proper exception handling in place

## References

- Main guidelines: `/CLAUDE.md`
- Error fixing patterns: `/docs/phpstan-error-fixes.md`
- Module documentation: `/Modules/*/docs/README.md`