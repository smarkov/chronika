<?php

class Entry
{
    public static function listByUser(int $userId): array
    {
        global $db;
        $statement = $db->prepare('SELECT * FROM entries WHERE user_id = :user_id ORDER BY entry_date DESC, updated_at DESC');
        $statement->execute([':user_id' => $userId]);
        return $statement->fetchAll();
    }

    public static function countByUser(int $userId): int
    {
        global $db;
        $statement = $db->prepare('SELECT COUNT(*) FROM entries WHERE user_id = :user_id');
        $statement->execute([':user_id' => $userId]);
        return (int) $statement->fetchColumn();
    }

    public static function timelineByUser(int $userId): array
    {
        global $db;
        $statement = $db->prepare('SELECT * FROM entries WHERE user_id = :user_id ORDER BY entry_date DESC, updated_at DESC');
        $statement->execute([':user_id' => $userId]);
        return $statement->fetchAll();
    }

    public static function findById(int $id, int $userId): ?array
    {
        global $db;
        $statement = $db->prepare('SELECT * FROM entries WHERE id = :id AND user_id = :user_id LIMIT 1');
        $statement->execute([':id' => $id, ':user_id' => $userId]);
        $entry = $statement->fetch();
        return $entry ?: null;
    }

    public static function search(int $userId, string $query): array
    {
        global $db;
        $search = trim($query);
        $like = '%' . $search . '%';
        $statement = $db->prepare(
            'SELECT * FROM entries WHERE user_id = :user_id AND (MATCH(title, body, tags) AGAINST(:search IN NATURAL LANGUAGE MODE) OR title LIKE :like_title OR body LIKE :like_body OR tags LIKE :like_tags) ORDER BY entry_date DESC, updated_at DESC'
        );
        $statement->execute([
            ':user_id' => $userId,
            ':search' => $search,
            ':like_title' => $like,
            ':like_body' => $like,
            ':like_tags' => $like,
        ]);
        return $statement->fetchAll();
    }

    public static function save(array $data, int $userId): int
    {
        global $db;
        $now = date('Y-m-d H:i:s');
        $entryDate = trim($data['entry_date'] ?? date('Y-m-d'));
        $tags = self::normalizeTags($data['tags'] ?? '');
        $metadata = json_encode([ 'mood' => trim($data['mood'] ?? ''), 'location' => trim($data['location'] ?? '') ]);

        if (!empty($data['id'])) {
            $statement = $db->prepare(
                'UPDATE entries SET title = :title, body = :body, tags = :tags, metadata = :metadata, updated_at = :updated_at WHERE id = :id AND user_id = :user_id'
            );
            $statement->execute([
                ':title' => trim($data['title']),
                ':body' => trim($data['body']),
                ':tags' => $tags,
                ':metadata' => $metadata,
                ':updated_at' => $now,
                ':id' => $data['id'],
                ':user_id' => $userId,
            ]);
            return (int) $data['id'];
        }

        $statement = $db->prepare(
            'INSERT INTO entries (user_id, title, body, tags, metadata, entry_date, created_at, updated_at) VALUES (:user_id, :title, :body, :tags, :metadata, :entry_date, :created_at, :updated_at)'
        );
        $statement->execute([
            ':user_id' => $userId,
            ':title' => trim($data['title']),
            ':body' => trim($data['body']),
            ':tags' => $tags,
            ':metadata' => $metadata,
            ':entry_date' => $entryDate,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        return (int) $db->lastInsertId();
    }

    public static function delete(int $id, int $userId): bool
    {
        global $db;
        $statement = $db->prepare('DELETE FROM entries WHERE id = :id AND user_id = :user_id');
        return $statement->execute([':id' => $id, ':user_id' => $userId]);
    }

    private static function normalizeTags(string $tags): string
    {
        $parts = array_filter(array_map('trim', explode(',', $tags)));
        $parts = array_unique($parts);
        return implode(', ', $parts);
    }
}
