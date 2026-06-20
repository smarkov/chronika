<?php require __DIR__ . '/partials/header.php'; ?>
<section class="dashboard-grid">
    <div class="panel panel--hero">
        <?php
        $displayName = $user['display_name'] ?: strstr($user['email'], '@', true) ?: $user['email'];
        ?>
        <h1>Welcome back, <?= htmlspecialchars($displayName) ?></h1>
        <p>Now is best!</p>
    </div>
    <div class="panel panel--small">
        <h2>Total Entries</h2>
        <p class="stat-value"><?= $totalEntries ?></p>
    </div>
    <div class="panel panel--small">
        <h2>Recent Entries</h2>
        <ul class="compact-list">
            <?php foreach (array_slice($recentEntries, 0, 5) as $entry): ?>
                <li><a href="?route=entry_view&id=<?= $entry['id'] ?>"><?= htmlspecialchars($entry['title']) ?: 'Untitled entry' ?></a> — <small><?= htmlspecialchars(date('M j, Y', strtotime($entry['entry_date']))) ?></small></li>
            <?php endforeach; ?>
            <?php if (empty($recentEntries)): ?>
                <li>No entries yet.</li>
            <?php endif; ?>
        </ul>
    </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
