<?php require __DIR__ . '/partials/header.php'; ?>
<section class="panel panel--small">
    <div class="panel-header">
        <h1>Account Settings</h1>
    </div>
    <form action="?route=settings_save" method="post" class="form-stack">
        <label>
            Current Password
            <input type="password" name="current_password" required placeholder="Current password">
        </label>
        <label>
            New Password
            <input type="password" name="new_password" required placeholder="New password">
        </label>
        <label>
            Confirm New Password
            <input type="password" name="confirm_password" required placeholder="Confirm new password">
        </label>
        <button type="submit" class="button button--primary">Update Password</button>
    </form>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
