# Calendar Implementation Rules

This directory contains implementation rules and best practices for the calendar module in SaluteOra.

## Rules Index

1. [Calendar Widgets](./calendar-widgets.mdc) - Rules for implementing calendar widgets
2. [FullCalendar Integration](./fullcalendar-integration.mdc) - Guidelines for FullCalendar implementation

## General Guidelines

### Code Organization
- Place all calendar-related code in the `Modules/SaluteOra/` directory
- Follow PSR-4 autoloading standards
- Use proper namespacing for all classes

### Naming Conventions
- Use `PascalCase` for class names
- Use `camelCase` for method and variable names
- Use `snake_case` for database columns and configuration keys
- Prefix interfaces with `I` (e.g., `ICalendarService`)

### Documentation
- Document all public and protected methods
- Include examples for complex functionality
- Keep documentation up-to-date with code changes

## Best Practices

### Performance
- Eager load relationships to prevent N+1 queries
- Cache expensive operations
- Use database indexes for frequently queried columns

### Security
- Always validate user input
- Implement proper authorization checks
- Protect against common vulnerabilities (XSS, CSRF, SQL injection)

### Testing
- Write unit tests for all calendar functionality
- Test edge cases and error conditions
- Include integration tests for API endpoints

## Related Documentation

- [Architecture](../architecture.md)
- [Widgets](../widgets/README.md)
- [FullCalendar Documentation](https://fullcalendar.io/docs)
- [Filament Documentation](https://filamentphp.com/docs)
