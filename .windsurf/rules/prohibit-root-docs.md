# prohibit root-level docs directory

## rule
- The directory `docs/` MUST NOT exist at the project root: `/var/www/html/_bases/base_saluteora/docs/`.
- Global documentation MUST live in `docs_project/`.
- Module-specific documentation MUST live in `laravel/Modules/<ModuleName>/docs/`.
- All docs paths and filenames must be lowercase, except `README.md`.

## rationale
- Prevents duplication and confusion with `docs_project/`.
- Aligns with Laraxot conventions and existing project structure.
- Simplifies navigation and CI rules that target `docs_project/` and module docs.

## enforcement
- Never create `/docs` at the root for any reason.
- When adding or moving documentation:
  - Use `docs_project/` for global docs.
  - Use `Modules/<ModuleName>/docs/` for module docs.
- Prefer relative links within docs.

## checklist
- [ ] No `/docs/` at repository root
- [ ] Global docs in `docs_project/`
- [ ] Module docs in `Modules/<ModuleName>/docs/`
- [ ] Lowercase files/folders in docs (except `README.md`)

## optional git ignore
Add this to the root `.gitignore` to prevent accidental commits:
```
/docs
```