<?php

class UploadController
{
    public static function upload(): void
    {
        requireAuth();
        $entryId = (int) ($_POST['entry_id'] ?? 0);
        self::handleUpload($entryId, $_FILES['media_files'] ?? []);
        setFlash('Files uploaded successfully.');
        header('Location: ?route=entry_edit&id=' . $entryId);
    }

    public static function handleUpload(int $entryId, array $files): void
    {
        if (empty($files['name']) || !is_array($files['name'])) {
            return;
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $tmpName = $files['tmp_name'][$i];
            $originalName = basename($files['name'][$i]);
            $mimeType = mime_content_type($tmpName) ?: 'application/octet-stream';
            $fileSize = (int) $files['size'][$i];
            $allowed = self::isValidUpload($mimeType, $originalName, $fileSize);

            if (!$allowed) {
                continue;
            }

            $safeName = uniqid() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $originalName);
            $target = UPLOAD_DIR . '/' . $safeName;
            if (!is_dir(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0755, true);
            }

            if (move_uploaded_file($tmpName, $target)) {
                Media::create($entryId, $originalName, $safeName, $mimeType, $fileSize);
            }
        }
    }

    private static function isValidUpload(string $mimeType, string $fileName, int $fileSize): bool
    {
        $allowedTypes = [
            'application/pdf',
            'image/jpeg',
            'image/png',
            'image/gif',
            'video/mp4',
            'video/webm',
            'video/quicktime',
            'text/plain',
        ];
        if ($fileSize > 30 * 1024 * 1024) {
            return false;
        }

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'mov', 'txt'];

        return in_array($mimeType, $allowedTypes, true) && in_array($ext, $allowedExtensions, true);
    }

    public static function download(): void
    {
        requireAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $media = Media::findById($id);
        if (!$media) {
            http_response_code(404);
            echo 'File not found.';
            exit;
        }

        $filePath = UPLOAD_DIR . '/' . $media['file_path'];
        if (!is_file($filePath)) {
            http_response_code(404);
            echo 'File not found.';
            exit;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $media['file_type']);
        header('Content-Disposition: attachment; filename="' . basename($media['file_name']) . '"');
        header('Content-Length: ' . $media['file_size']);
        readfile($filePath);
        exit;
    }
}
