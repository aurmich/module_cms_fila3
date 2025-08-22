# NO RefreshDatabase Rule

- Do NOT use `RefreshDatabase` in any tests.
- Prefer unit tests with mocks/stubs or minimal explicit setup.
- If a DB is required, run specific migrations/seeders explicitly within the test setup.
- Apply across modules and CI.
