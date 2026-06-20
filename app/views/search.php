<?php require __DIR__ . '/partials/header.php'; ?>
<section class="panel">
    <div class="panel-header">
        <div>
            <h1>Search Journal</h1>
            <p>Find entries by title, body, tags, or metadata.</p>
        </div>
    </div>

    <form action="?route=search" method="get" class="form-stack">
        <input type="hidden" name="route" value="search">
        <label>
            Search term
            <input type="search" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Search your journal">
        </label>
        <button type="submit" class="button button--primary">Search</button>
    </form>

    <?php if ($query !== ''): ?>
        <div class="panel-block">
            <h2>Results for "<?= htmlspecialchars($query) ?>"</h2>
            <?php if (empty($results)): ?>
                <p>No matching entries were found.</p>
            <?php else: ?>
                <div class="entry-list">
                    <?php foreach ($results as $entry): ?>
                        <article class="entry-card">
                            <div>
                                <h2><a href="?route=entry_view&id=<?= $entry['id'] ?>"><?= htmlspecialchars($entry['title'] ?: 'Untitled') ?></a></h2>
                                <p class="entry-meta">Updated <?= htmlspecialchars(date('M j, Y', strtotime($entry['updated_at']))) ?> · Tags: <?= htmlspecialchars($entry['tags']) ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
