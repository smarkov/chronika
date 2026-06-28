<?php
if (User::countAll() >= 5) {
    setFlash('User limit reached. No more accounts can be created.', 'error');
    header('Location: ?route=register');
    exit;
}
?>
<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="page-panel page-panel--center">
    <div class="card card--login">
        <h1>Create account</h1>
        <form action="?route=register_submit" method="post" class="form-stack">
            <label>Email
                <input type="email" name="email" required>
            </label>
            <label>Display name
                <input type="text" name="display_name" placeholder="Anna" required>
            </label>
            <label class="password-field">
                Password
                <div class="password-input-group">
                    <input type="password" name="password" required>
                    <button type="button" id="togglePassword" class="button button--ghost">Show</button>
                </div>
            </label>
            <label class="password-field">
            Confirm password
                <div class="password-input-group">
                    <input type="password" name="confirm_password" required>
                    <button type="button" id="togglePassword" class="button button--ghost">Show</button>
                </div>
            </label>
            <button type="submit" class="button button--primary">Register</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>