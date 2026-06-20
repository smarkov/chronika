<?php

class User
{
    public static function findByEmail(string $email): ?array
    {
        global $db;
        $statement = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->execute([':email' => $email]);
        $user = $statement->fetch();
        return $user ?: null;
    }

    public static function findById(int $id): ?array
    {
        global $db;
        $statement = $db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $statement->execute([':id' => $id]);
        $user = $statement->fetch();
        return $user ?: null;
    }

    public static function verifyPassword(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);
        if (!$user) {
            return null;
        }
        return password_verify($password, $user['password_hash']) ? $user : null;
    }

    public static function create(string $email, string $password, ?string $displayName = null): ?array
    {
        global $db;
        $statement = $db->prepare('INSERT INTO users (email, password_hash, display_name, created_at) VALUES (:email, :password_hash, :display_name, :created_at)');
        $success = $statement->execute([
            ':email' => $email,
            ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
            ':display_name' => $displayName,
            ':created_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$success) {
            return null;
        }

        return self::findByEmail($email);
    }

    public static function countAll(): int
    {
        global $db;
        $statement = $db->query('SELECT COUNT(*) FROM users');
        return (int) $statement->fetchColumn();
    }

    public static function updatePassword(int $id, string $password): bool
    {
        global $db;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $statement = $db->prepare('UPDATE users SET password_hash = :password_hash WHERE id = :id');
        return $statement->execute([':password_hash' => $passwordHash, ':id' => $id]);
    }
}
