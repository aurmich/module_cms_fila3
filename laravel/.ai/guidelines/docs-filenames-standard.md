# Documentation Filenames Standard (Project-wide)

## Rules
- No dates in documentation filenames inside any `docs/` directory.
- English-only filenames (US English), except `README.md`.
- Use hyphen-case for filenames and folders (e.g., `naming-conventions.md`).
- Lowercase for all docs filenames/folders; only `README.md` may use uppercase.
- Prefer concise, descriptive names; avoid ambiguity and duplicates.

## Rationale
- Predictable links, fewer diffs due to timestamped filenames.
- Cross-platform compatibility and consistency.
- Easier search and tooling across modules.

## Examples
- ❌ `phpstan-analysis-2025-08-18.md` → ✅ `phpstan-analysis.md`
- ❌ `ottimizzazioni-e-miglioramenti.md` → ✅ `optimizations-and-improvements.md`
- ❌ `event_sourcing.md` → ✅ `event-sourcing.md`

## Enforcement
- During reviews, reject PRs with date-stamped or non-English or underscore-named docs in `docs/`.
- When renaming, update internal links in the same PR.
- Keep a single authoritative document when duplicates exist (mark others as `-duplicate.md` until merged).
