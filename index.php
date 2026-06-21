<?php
session_start();

require_once __DIR__ . '/app/config/db.php';
require_once __DIR__ . '/app/config/auth.php';
require_once __DIR__ . '/app/models/Entry.php';
require_once __DIR__ . '/app/models/Media.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/EntryController.php';
require_once __DIR__ . '/app/controllers/UploadController.php';
require_once __DIR__ . '/app/controllers/SearchController.php';

$route = $_GET['route'] ?? 'dashboard';

if (!isAuthenticated() && !in_array($route, ['login','authenticate','register','register_submit'], true)) {
    header('Location: ?route=login');
    exit;
}

switch ($route) {
    case 'register':
        AuthController::showRegister();
        break;
    case 'register_submit':
        AuthController::register();
        break;
    case 'login':
        AuthController::showLogin();
        break;
    case 'authenticate':
        AuthController::authenticate();
        break;
    case 'logout':
        AuthController::logout();
        break;
    case 'dashboard':
        EntryController::dashboard();
        break;
    case 'entries':
        EntryController::index();
        break;
    case 'entry_new':
        EntryController::create();
        break;
    case 'entry_save':
        EntryController::save();
        break;
    case 'entry_edit':
        EntryController::edit();
        break;
    case 'entry_delete':
        EntryController::delete();
        break;
    case 'entry_view':
        EntryController::view();
        break;
    case 'upload_media':
        UploadController::upload();
        break;
    case 'download_media':
        UploadController::download();
        break;
    case 'search':
        SearchController::search();
        break;
    case 'settings':
        AuthController::settings();
        break;
    case 'settings_save':
        AuthController::saveSettings();
        break;
    default:
        EntryController::dashboard();
        break;
}
