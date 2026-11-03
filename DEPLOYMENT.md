# Production deployment

This project requires a PHP web server and MySQL. Live Server and static-only hosts cannot run the PHP API.

## Recommended hosting

Choose a reputable PHP hosting provider with:

- PHP 8.1 or newer, with PDO MySQL enabled
- MySQL 8.0 or a compatible managed MySQL server
- Apache with `.htaccess` support, or equivalent web-server access rules
- HTTPS certificates and automatic renewal
- Private database credentials and regular backups

A cPanel PHP/MySQL plan is usually the simplest first deployment. Ask your school or organization whether it already provides approved web hosting before purchasing a service. Do not publish real student or guest records until the school approves the host and its privacy/security arrangements.

## Deployment checklist

1. Create a production website and a dedicated MySQL database and user in the hosting control panel. Grant that database user access only to this application database.
2. Set the website document root to this project directory. Keep the included `.htaccess` files in place; they block access to configuration, SQL, and development files. If the host does not support Apache `.htaccess`, configure equivalent deny rules before publishing.
3. Upload the application files over SFTP or the host's secure file manager. Do not upload a developer's existing `backend/.env`; create the production file directly on the host.
4. Copy `backend/.env.example` to `backend/.env` and set `APP_ENV=production`, the host-provided database host/name/user/password, and the correct database port. Use a unique, strong database password; never use the local XAMPP `root` account.
5. Import `database/cihrm_database.sql` into the production database, then run `database/workflow_migration.php` from the hosting shell if available. Otherwise, apply the migration's additive `ALTER TABLE` through the database control panel.
6. If the hosting shell supports PHP, run `php backend/test-db.php`. It should confirm the database, nine ERD tables, eight foreign keys, and no orphaned rows.
7. Do not run `backend/seed.php` on a public installation. It resets the local demo accounts to a known shared password. Create administrator accounts with unique credentials using a secure, private setup process instead.
8. Enable HTTPS and force all traffic to HTTPS in the hosting control panel. Test registration, sign-in/sign-out, role access, reports, and database workflows over HTTPS.
9. Keep production backups private, update PHP regularly, and configure database backups before entering real data.

## Before launch

- Replace all demo or test accounts and remove any data that should not be public.
- Confirm with your institution that it approves the provider, data location, retention, access, and backup policies.
- The project is an educational simulator. Folio payment actions are simulated and do not process real payments.

Publishing requires a hosting account, domain/DNS, and credentials that only the site owner should enter into the hosting provider. Never send database or hosting passwords in chat.
