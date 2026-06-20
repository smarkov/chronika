<?php

class Media
{
    public static function create(int $entryId, string $fileName, string $filePath, string $fileType, int $fileSize): bool
    {
        global $db;
        $statement = $db->prepare(
            'INSERT INTO media (entry_id, file_name, file_path, file_type, file_size, created_at) VALUES (:entry_id, :file_name, :file_path, :file_type, :file_size, :created_at)'
        );
        return $statement->execute([
            ':entry_id' => $entryId,
            ':file_name' => $fileName,
            ':file_path' => $filePath,
            ':file_type' => $fileType,
            ':file_size' => $fileSize,
            ':created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getByEntry(int $entryId): array
    {
        global $db;
        $statement = $db->prepare('SELECT * FROM media WHERE entry_id = :entry_id ORDER BY created_at DESC');
        $statement->execute([':entry_id' => $entryId]);
        return $statement->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        global $db;
        $statement = $db->prepare('SELECT * FROM media WHERE id = :id LIMIT 1');
        $statement->execute([':id' => $id]);
        $media = $statement->fetch();
        return $media ?: null;
    }

    public static function deleteByEntry(int $entryId): void
    {
        global $db;
        $statement = $db->prepare('DELETE FROM media WHERE entry_id = :entry_id');
        $statement->execute([':entry_id' => $entryId]);
    }
}
