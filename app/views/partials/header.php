<?php
$loggedInUser = currentUser();
$brandText = SITE_NAME;

if ($loggedInUser) {
    $displayName = trim($loggedInUser['display_name'] ?? '');
    if ($displayName === '') {
        $displayName = strtok($loggedInUser['email'], '@');
    }
    $brandText = $displayName . "'s Chronika";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($brandText) ?> — Chronika</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="layout">
    <header class="topbar">
        <div class="brand">
            <a href="?route=dashboard"><?= htmlspecialchars($brandText) ?></a>
        </div>
        <?php if (isAuthenticated()): ?>
            <nav class="nav-links">
                <a href="?route=dashboard">Dashboard</a>
                <a href="?route=entries">Entries</a>
                <a href="?route=entry_new" class="button">New Entry</a>
                <a href="?route=search">Search</a>
                <a href="?route=settings">Settings</a>
                <a href="?route=logout" class="button button--ghost">Logout</a>
            </nav>
        <?php endif; ?>
    </header>

    <main class="content">
        <?php $flash = getFlash(); ?>
        <?php if ($flash): ?>
            <div class="alert alert--<?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
