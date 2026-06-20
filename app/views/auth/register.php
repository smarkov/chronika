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
                <input type="text" name="display_name" placeholder="Anna">
            </label>
            <label>Password
                <input type="password" name="password" required>
            </label>
            <label>Confirm password
                <input type="password" name="confirm_password" required>
            </label>
            <button type="submit" class="button button--primary">Register</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>