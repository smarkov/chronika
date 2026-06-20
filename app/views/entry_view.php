<?php
require_once __DIR__ . '/../models/Media.php';
$metadata = json_decode($entry['metadata'] ?? '{}', true) ?: [];
$mediaItems = Media::getByEntry($entry['id']);
?>
<?php require __DIR__ . '/partials/header.php'; ?>
<section class="panel panel--content">
    <div class="panel-header">
        <div>
            <h1><?= htmlspecialchars($entry['title'] ?: 'Untitled entry') ?></h1>
            <p class="entry-meta">Entry Date <?= htmlspecialchars(date('M j, Y', strtotime($entry['entry_date']))) ?> · Created <?= htmlspecialchars(date('M j, Y', strtotime($entry['created_at']))) ?> · Updated <?= htmlspecialchars(date('M j, Y', strtotime($entry['updated_at']))) ?></p>
            <p class="entry-meta">Tags: <?= htmlspecialchars($entry['tags']) ?></p>
            <?php if (!empty($metadata['mood']) || !empty($metadata['location'])): ?>
                <p class="entry-meta">Mood: <?= htmlspecialchars($metadata['mood']) ?> · Location: <?= htmlspecialchars($metadata['location']) ?></p>
            <?php endif; ?>
        </div>
        <div class="entry-actions">
            <a href="?route=entry_edit&id=<?= $entry['id'] ?>" class="button">Edit</a>
            <a href="?route=entry_delete&id=<?= $entry['id'] ?>" class="button button--danger" onclick="return confirm('Delete this entry?');">Delete</a>
        </div>
    </div>

    <article class="entry-body">
        <?= nl2br(htmlspecialchars($entry['body'])) ?>
    </article>

    <?php if (!empty($mediaItems)): ?>
        <div class="panel-block">
            <h2>Attachments</h2>
            <div class="media-grid">
                <?php foreach ($mediaItems as $item): ?>
                    <div class="media-card media-card--preview">
                        <?php if (str_starts_with($item['file_type'], 'image/')): ?>
                            <img src="?route=download_media&id=<?= $item['id'] ?>" alt="<?= htmlspecialchars($item['file_name']) ?>">
                        <?php elseif (str_starts_with($item['file_type'], 'video/')): ?>
                            <video controls>
                                <source src="?route=download_media&id=<?= $item['id'] ?>" type="<?= htmlspecialchars($item['file_type']) ?>">
                                Your browser does not support video playback.
                            </video>
                        <?php else: ?>
                            <div class="media-file-icon">File</div>
                        <?php endif; ?>
                        <div>
                            <strong><?= htmlspecialchars($item['file_name']) ?></strong>
                            <a href="?route=download_media&id=<?= $item['id'] ?>" class="button button--small">Download</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
