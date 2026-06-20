<?php

require_once __DIR__ . '/../models/User.php';

function isAuthenticated(): bool
{
    return !empty($_SESSION['user_id']);
}

function loginUser(array $user): void
{
    $_SESSION['user_id'] = $user['id'];
}

function logoutUser(): void
{
    unset($_SESSION['user_id']);
    session_regenerate_id(true);
}

function setFlash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function getFlash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function currentUser(): ?array
{
    if (!isAuthenticated()) {
        return null;
    }

    $user = User::findById($_SESSION['user_id']);
    if (!$user) {
        logoutUser();
        return null;
    }

    return $user;
}

function requireAuth(): void
{
    if (!isAuthenticated() || currentUser() === null) {
        header('Location: ?route=login');
        exit;
    }
}