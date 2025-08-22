# Docs Naming Standards (Global)

## Rules
- Filenames MUST be English.
- Filenames MUST be kebab-case (hyphens), never underscores.
- Filenames MUST NOT include dates.
- All docs inside any `docs/` folder MUST be lowercase; only `README.md` may be uppercase.
- Apply across all modules and root docs.

## Rationale
- Predictable linking and stable URLs.
- Cross-platform consistency.
- Easier grepping, no locale mixing, cleaner diffs.

## Examples
- `optimizations.md` (not `optimizations-2025-08-22.md`)
- `phpstan-fixes.md` (not `phpstan_fixes_2025-01-06.md`)
- `whatsapp-provider-architecture.md` (not `whatsapp_provider_architecture.md`)

## Migration guidance
- Use `git mv` to preserve history.
- Update internal links in related docs after rename.
- Keep commit messages explicit: `chore(docs): standardize names to english-kebab no-dates`.
