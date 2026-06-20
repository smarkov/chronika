<?php require __DIR__ . '/partials/header.php'; ?>
<section class="panel">
    <div class="panel-header">
        <h1>Your Journal Entries</h1>
        <a href="?route=entry_new" class="button button--primary">New Entry</a>
    </div>

    <?php if (empty($entries)): ?>
        <div class="empty-state">
            <p>No entries yet. Start a private record with your first journal note.</p>
            <a href="?route=entry_new" class="button">Create entry</a>
        </div>
    <?php else: ?>
        <div class="entry-list">
            <?php foreach ($entries as $entry): ?>
                <article class="entry-card">
                    <div>
                        <h2><a href="?route=entry_view&id=<?= $entry['id'] ?>"><?= htmlspecialchars($entry['title']) ?: 'Untitled' ?></a></h2>
                        <p class="entry-meta">Date <?= htmlspecialchars(date('M j, Y', strtotime($entry['entry_date']))) ?> · Updated <?= htmlspecialchars(date('M j, Y', strtotime($entry['updated_at']))) ?> · Tags: <?= htmlspecialchars($entry['tags']) ?></p>
                    </div>
                    <div class="entry-actions">
                        <a href="?route=entry_edit&id=<?= $entry['id'] ?>" class="button button--ghost">Edit</a>
                        <a href="?route=entry_delete&id=<?= $entry['id'] ?>" class="button button--danger" onclick="return confirm('Delete this entry?');">Delete</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
