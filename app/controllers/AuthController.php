<?php

class AuthController
{
    public static function showRegister(): void
    {
        require __DIR__ . '/../views/auth/register.php';
    }

    public static function register(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');
        $displayName = trim($_POST['display_name'] ?? '');

        if (empty($email) || empty($password) || empty($confirm)) {
            setFlash('Email and passwords are required.', 'error');
            header('Location: ?route=register');
            exit;
        }

        if ($password !== $confirm) {
            setFlash('Passwords do not match.', 'error');
            header('Location: ?route=register');
            exit;
        }

        if (User::findByEmail($email)) {
            setFlash('That email is already registered.', 'error');
            header('Location: ?route=register');
            exit;
        }

        $user = User::create($email, $password, $displayName);
        if (!$user) {
            setFlash('Registration failed. Please try again.', 'error');
            header('Location: ?route=register');
            exit;
        }

        loginUser($user);
        setFlash('Welcome! Your account is ready.');
        header('Location: ?route=dashboard');
    }

    public static function showLogin(): void
    {
        require __DIR__ . '/../views/auth/login.php';
    }

    public static function authenticate(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            setFlash('Please enter both email and password.', 'error');
            header('Location: ?route=login');
            exit;
        }

        $user = User::verifyPassword($email, $password);

        if (!$user) {
            if (User::countAll() === 0) {
                $user = User::create($email, $password);
                if (!$user) {
                    setFlash('Failed to create account. Please try again.', 'error');
                    header('Location: ?route=login');
                    exit;
                }
                setFlash('First user account created automatically.', 'success');
            } else {
                setFlash('Invalid email or password.', 'error');
                header('Location: ?route=login');
                exit;
            }
        }

        loginUser($user);
        setFlash('Welcome back!');
        header('Location: ?route=dashboard');
    }

    public static function logout(): void
    {
        logoutUser();
        setFlash('You have been logged out.', 'success');
        header('Location: ?route=login');
    }

    public static function settings(): void
    {
        requireAuth();
        require __DIR__ . '/../views/settings.php';
    }

    public static function saveSettings(): void
    {
        requireAuth();
        $currentPassword = trim($_POST['current_password'] ?? '');
        $newPassword = trim($_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            setFlash('All password fields are required.', 'error');
            header('Location: ?route=settings');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            setFlash('The new passwords do not match.', 'error');
            header('Location: ?route=settings');
            exit;
        }

        $user = currentUser();
        if (!User::verifyPassword($user['email'], $currentPassword)) {
            setFlash('Current password is incorrect.', 'error');
            header('Location: ?route=settings');
            exit;
        }

        User::updatePassword($user['id'], $newPassword);
        setFlash('Password updated successfully.');
        header('Location: ?route=settings');
    }
}
