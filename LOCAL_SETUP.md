## Local Development

Local development mimics web-hosting deployment, e.g. hostinger.
The objective is to test locally, commit to github and autodeploy via Hostinger's Git autodeployment.

During autodeployment Hostinger will dump the _contents_ of the repo under `public_html` _and_ delete anything that is not in the github repo.
Therefore, the actual git repo is the contents of our `public_html`.

The layout on Hostinger is (under `$HOME/domain/website_name/`):

```bash
> tree
.
├── DO_NOT_UPLOAD_HERE
├── private
│   ├── A_PERSISTENT_FOLDER
│   └── app
│       ├── config
│       │   └── db.php
│       └── storage
│           └── uploads
└── public_html
    ├── app
    │   ├── config
    │   │   ├── auth.php
    │   │   └── db.php.example
    │   ├── controllers
    │   │   ├── AuthController.php
    │   │   ├── EntryController.php
    │   │   ├── SearchController.php
    │   │   └── UploadController.php
    │   ├── models
    │   │   ├── Entry.php
    │   │   ├── Media.php
    │   │   └── User.php
    │   └── views
    │       ├── auth
    │       │   ├── login.php
    │       │   └── register.php
    │       ├── dashboard.php
    │       ├── entry_edit.php
    │       ├── entry_list.php
    │       ├── entry_view.php
    │       ├── partials
    │       │   ├── footer.php
    │       │   └── header.php
    │       ├── search.php
    │       └── settings.php
    ├── assets
    │   ├── css
    │   │   └── styles.css
    │   └── js
    │       └── app.js
    ├── index.php
    ├── LOCAL_SETUP.md
    └── README.md
```

  > **Note** The file contents may change over time, but the principle separation of `private` and `public_html` remains.

Therefore, we must structure our local layout appropriately:

1. Create the project root folder, e.g. `chronika`.
2. Create and populate the `private` folder underneath (including structure, and `db.php`).
3. Clone the `chronika` repo to `public_html`:

```bash
cd <path_to_root_of_project_chronika>
git clone git@github.com:smarkov/chronika.git public_html
```

Below, are the steps for local testing (assuming `Laragon` is installed and present for PHP and DB):

### 1. Start Laragon
- Open Laragon.
- Click `Start All` (or start `Apache` / `Nginx` and `MySQL`).

### 2. Serve the app through HTTP
Do not open `index.php` directly in the browser as a file. Use a web server URL.

#### Option A: Laragon web root
- Put the project under `C:\laragon\www\chronika`:
- Then open:
  `http://chronika.test` or `http://localhost/chronika/public_html`

#### Option B: Link Laragon web root to project root:
 - Make a link under Laragon web root (requires `admin` mode in `PowerShell`):

```ps
New-Item -ItemType Junction -Path "C:\laragon\www\chronika" -Target "C:\User\Name\PathTo\chronika"
```
- Then open:
  `http://chronika.test` or `http://localhost/chronika/public_html`

#### Option C: PHP built-in server
From PowerShell:
```powershell
cd C:\User\Name\PathTo\chronika
& "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" -S localhost:8000