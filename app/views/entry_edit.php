<?php
require_once __DIR__ . '/../models/Media.php';
$metadata = json_decode($entry['metadata'] ?? '{}', true) ?: [];
$mediaItems = !empty($entry['id']) ? Media::getByEntry($entry['id']) : [];
?>
<?php require __DIR__ . '/partials/header.php'; ?>
<section class="panel">
    <div class="panel-header">
        <h1><?= $entry['id'] ? 'Edit Entry' : 'New Entry' ?></h1>
    </div>
    <form action="?route=entry_save" method="post" enctype="multipart/form-data" class="form-grid">
        <?php if (!empty($entry['id'])): ?>
            <input type="hidden" name="id" value="<?= (int) $entry['id'] ?>">
        <?php endif; ?>

        <label>
            Title
            <input type="text" name="title" value="<?= htmlspecialchars($entry['title'] ?? '') ?>" placeholder="Reflective title">
        </label>

        <label>
            Tags (comma-separated)
            <input type="text" name="tags" value="<?= htmlspecialchars($entry['tags'] ?? '') ?>" placeholder="mood, travel, ideas">
        </label>

        <label>
            Mood
            <input type="text" name="mood" value="<?= htmlspecialchars($metadata['mood'] ?? '') ?>" placeholder="Focused, calm, excited">
        </label>

        <label>
            Location
            <input type="text" name="location" value="<?= htmlspecialchars($metadata['location'] ?? '') ?>" placeholder="Home, cafe, studio">
        </label>

        <label class="span-two">
            Body
            <textarea name="body" rows="10" placeholder="Write your journal entry..."><?= htmlspecialchars($entry['body'] ?? '') ?></textarea>
        </label>

        <label class="span-two file-upload">
            Upload files
            <input type="file" name="media_files[]" id="media_files" multiple>
            <span class="file-hint" id="file-hint">Choose PDF, image or video files</span>
        </label>

        <div class="form-actions span-two">
            <button type="submit" class="button button--primary">Save entry</button>
            <a href="?route=entries" class="button button--ghost">Cancel</a>
        </div>
    </form>

    <?php if (!empty($mediaItems)): ?>
        <div class="panel-block">
            <h2>Attached media</h2>
            <div class="media-grid">
                <?php foreach ($mediaItems as $item): ?>
                    <div class="media-card">
                        <strong><?= htmlspecialchars($item['file_name']) ?></strong>
                        <span><?= htmlspecialchars($item['file_type']) ?> · <?= round($item['file_size'] / 1024, 1) ?> KB</span>
                        <a href="?route=download_media&id=<?= $item['id'] ?>" class="button button--small">Download</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
