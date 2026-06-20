# Chronika App

A simple PHP 8 + MySQL journaling app designed for private browser access and file uploads.

## Features

- Password-protected login
- Create, edit, delete, and view journal entries
- Tag support and metadata fields
- File upload support for PDF, images, and videos
- Search across titles, body content, and tags
- Responsive HTML/CSS UI for desktop and mobile

## Directory Structure

- `public_html/` — public web root
- `app/` — application code and storage
- `sql/schema.sql` — database schema

## Setup

1. Import the schema into MySQL:
   - `mysql -u root -p < sql/schema.sql`

2. Update database settings in `app/config/db.php`. Copy `df.bphp.example` to `db.php` and edit the defines; DO NOT track the db.php in the repo, as it contains secrets

3. Place the `public_html/` folder as the web root on Hostinger.

4. If no user exists, the first login will automatically create an account from the credentials you enter.

## Notes

- Uploaded files are stored in `app/storage/uploads`.
- Access is handled through `public_html/index.php` with routes like `?route=login`.
- For Hostinger, make sure `public_html` is the served directory and PHP 8 is enabled.
