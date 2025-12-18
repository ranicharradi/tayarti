ADMIN:
Credentials are defined in `database/tayarti.sql` (avoid committing real passwords to public repos).

DEPLOY (Render):
- This app needs a MySQL database. Render does not provide managed MySQL, so use an external MySQL provider (or run your own MySQL elsewhere).
- Configure these environment variables in Render:
  - DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
- Import `database/tayarti.sql` into your MySQL database.
