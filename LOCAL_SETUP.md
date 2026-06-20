## Local Development

### 1. Start Laragon
- Open Laragon.
- Click `Start All` (or start `Apache` / `Nginx` and `MySQL`).

### 2. Serve the app through HTTP
Do not open `index.php` directly in the browser as a file. Use a web server URL.

#### Option A: Laragon web root
- Put the project under `C:\laragon\www\stanmarkov.com`
- Then open:
  `http://localhost/stanmarkov.com/public_html/`

#### Option B: PHP built-in server
From PowerShell:
```powershell
cd C:\Users\stani\Personal\stanmarkov.com\public_html
& "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" -S localhost:8000