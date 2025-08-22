# Laravel Boost Guidelines

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.10
- filament/filament (FILAMENT) - v3
- laravel/folio (FOLIO) - v1
- laravel/framework (LARAVEL) - v11
- laravel/pennant (PENNANT) - v1
- laravel/prompts (PROMPTS) - v0
- livewire/flux (FLUXUI_FREE) - v2
- livewire/livewire (LIVEWIRE) - v3
- livewire/volt (VOLT) - v1
- larastan/larastan (LARASTAN) - v3
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v3
- rector/rector (RECTOR) - v2
- tailwindcss (TAILWINDCSS) - v3

## Core Principles
- **DRY**: Don't Repeat Yourself - reuse existing components and patterns
- **KISS**: Keep It Simple, Stupid - prefer simple solutions over complex ones
- **SOLID**: Follow SOLID principles for clean architecture
- **ROBUST**: Write resilient code that handles edge cases gracefully
- **INTELLIGENT**: Use smart patterns and Laravel best practices
- **LARAXOT**: Follow Laraxot architectural patterns and conventions

## Conventions
- You must follow all existing code conventions used in this application
- Use descriptive names for variables and methods
- Check for existing components to reuse before writing new ones
- Stick to existing directory structure - don't create new base folders without approval

## Laravel Boost Tools
- Laravel Boost is an MCP server with powerful tools designed specifically for this application
- Use the `list-artisan-commands` tool when you need to call an Artisan command
- Use the `get-absolute-url` tool for project URLs
- Use the `tinker` tool for debugging and direct PHP execution
- Use the `search-docs` tool for Laravel ecosystem documentation

## Testing Philosophy
- **CRITICAL RULE**: Focus on business logic, NOT implementation details
- Models are "slim" - don't test fillable, hidden, or casts properties
- Test business logic, custom methods, relationships, accessors/mutators, and query scopes
- Use Pest for all tests - never PHPUnit
- **NEVER use RefreshDatabase** - use DatabaseTransactions instead
- **PRIORITY**: Make existing tests work before creating new ones

## Architecture Patterns
- Follow Laraxot modular architecture
- Use existing service providers and patterns
- Extend base classes (XotBaseResource, XotBaseServiceProvider)
- Maintain separation of concerns between modules
- Use Spatie packages for advanced functionality

## Code Quality
- Run `vendor/bin/pint --dirty` before finalizing changes
- Use PHP 8 constructor property promotion
- Always use explicit return type declarations
- Use PHPDoc blocks over inline comments
- Follow PSR-12 coding standards
- Aim for PHPStan level 10 compatibility

## Documentation
- Update module documentation in `Modules/<ModuleName>/docs/`
- Update root documentation in `/docs/`
- Create bidirectional links between related documentation
- Use lowercase for all files and folders (except README.md)
- Follow DRY principles in documentation

## Security & Best Practices
- Always validate form data
- Use Laravel's built-in authentication and authorization
- Implement proper middleware and policies
- Use environment variables only in configuration files
- Follow Laravel security best practices

## Performance & Optimization
- Use eager loading to prevent N+1 queries
- Implement queued jobs for time-consuming operations
- Use Laravel's query builder for complex operations
- Optimize database queries and relationships
- Use caching where appropriate

## Frontend & UI
- Use Tailwind CSS for styling
- Use Flux UI components when available
- Support dark mode if existing components do
- Use Livewire Volt for interactive pages
- Follow existing UI patterns and conventions

## Database & Models
- Use Eloquent relationships over raw queries
- Create useful factories and seeders for new models
- Use proper database naming conventions
- Implement database transactions in tests
- Follow Laravel Eloquent best practices

## API & Resources
- Use Eloquent API Resources for APIs
- Implement proper API versioning
- Use Form Request classes for validation
- Follow RESTful conventions
- Implement proper error handling

## Deployment & Environment
- Use proper environment configuration
- Follow deployment best practices
- Use configuration caching in production
- Implement proper logging and monitoring
- Follow Laravel deployment guidelines
