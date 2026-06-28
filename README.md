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

- The project has two main folders, `private` (persistent) and `public_html` (auto-updated by the hosting platform via Github hooks; deletes anything that is not inside the repo).

This repo represents the _contents_ of the `public_html` folder.
It includes the `app` and and an `sql/schema.sql`, for setting up the DB on the server.

```bash
.
├── private
│   └── app
│       ├── config
│       │   └── db.php
│       └── storage
│           └── uploads
└── public_html
    ├── app
    │   ├── config
    │   │   └── db.php.example
    │   ├── controllers
    │   ├── models
    │   └── views
    │       ├── auth
    │       └── partials
    └── assets
        ├── css
        └── js
```
- `./` — public web root
- `index.php` -- entry point
- `app/` — application code and storage (MCV)
- `assets/` -- html stuff
- `sql/schema.sql` — database schema

## Setup

1. Create the layout of the website under `~/domains/website_name/`, to include `private` and  `public_html`.

2. Place the `./` (repository root) folder as the web root on Hostinger (under the website `public_html`).

3. Copy `public_html\app\config\db.php.example` to `private\app\config\db.php` and edit the defines starting with `DB_...`; **DO NOT track** the db.php in the repo, as it contains secrets!

4. Create the `private/app/storage/uploads` directory.

5. Import the schema into MySQL (substite with actual server values of DB_*):
   - `mysql -u DB_USER -h DB_HOST -p DB_NAME < sql/schema.sql`!

6. If no user exists, the first login will automatically create an account from the credentials you enter.

## Notes

- Uploaded files are stored in `private/app/storage/uploads`.
- Access is handled through `public_html/index.php` with routes like `?route=login`.
- For Hostinger, make sure `public_html` is the served directory and PHP 8 is enabled (current defaults).
