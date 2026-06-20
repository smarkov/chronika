<?php

require_once __DIR__ . '/../models/Entry.php';
require_once __DIR__ . '/../models/Media.php';

class EntryController
{
    public static function dashboard(): void
    {
        requireAuth();
        $user = currentUser();
        $totalEntries = Entry::countByUser($user['id']);
        $recentEntries = Entry::listByUser($user['id']);
        require __DIR__ . '/../views/dashboard.php';
    }

    public static function index(): void
    {
        requireAuth();
        $user = currentUser();
        $entries = Entry::listByUser($user['id']);
        require __DIR__ . '/../views/entry_list.php';
    }

    public static function create(): void
    {
        requireAuth();
        $entry = [ 'id' => '', 'title' => '', 'body' => '', 'tags' => '', 'metadata' => json_encode(['mood' => '', 'location' => '']) ];
        require __DIR__ . '/../views/entry_edit.php';
    }

    public static function edit(): void
    {
        requireAuth();
        $user = currentUser();
        $id = (int) ($_GET['id'] ?? 0);
        $entry = Entry::findById($id, $user['id']);
        if (!$entry) {
            setFlash('Entry not found.', 'error');
            header('Location: ?route=entries');
            exit;
        }
        require __DIR__ . '/../views/entry_edit.php';
    }

    public static function save(): void
    {
        requireAuth();
        $user = currentUser();

        $entryId = Entry::save($_POST, $user['id']);
        self::processUploads($entryId);
        setFlash('Journal entry saved successfully.');
        header('Location: ?route=entry_view&id=' . $entryId);
    }

    private static function processUploads(int $entryId): void
    {
        if (empty($_FILES['media_files']) || !is_array($_FILES['media_files']['name'])) {
            return;
        }
        UploadController::handleUpload($entryId, $_FILES['media_files']);
    }

    public static function delete(): void
    {
        requireAuth();
        $user = currentUser();
        $id = (int) ($_GET['id'] ?? 0);
        $entry = Entry::findById($id, $user['id']);
        if ($entry) {
            $mediaItems = Media::getByEntry($id);
            foreach ($mediaItems as $item) {
                $filePath = UPLOAD_DIR . '/' . $item['file_path'];
                if (is_file($filePath)) {
                    @unlink($filePath);
                }
            }
            Media::deleteByEntry($id);
            Entry::delete($id, $user['id']);
            setFlash('Entry deleted successfully.');
        }
        header('Location: ?route=entries');
    }

    public static function view(): void
    {
        requireAuth();
        $user = currentUser();
        $id = (int) ($_GET['id'] ?? 0);
        $entry = Entry::findById($id, $user['id']);
        if (!$entry) {
            setFlash('Entry not found.', 'error');
            header('Location: ?route=entries');
            exit;
        }
        $mediaItems = Media::getByEntry($entry['id']);
        require __DIR__ . '/../views/entry_view.php';
    }
}
