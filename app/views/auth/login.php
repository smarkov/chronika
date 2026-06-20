<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="page-panel page-panel--center">
    <div class="card card--login">
        <h1>Private Journal Access</h1>
        <p>Enter your credentials to continue.</p>
        <form action="?route=authenticate" method="post" class="form-stack">
            <label>
                Email
                <input type="email" name="email" required placeholder="you@example.com">
            </label>
            <label class="password-field">
                Password
                <div class="password-input-group">
                    <input id="password" type="password" name="password" required placeholder="••••••••">
                    <button type="button" id="togglePassword" class="button button--ghost">Show</button>
                </div>
            </label>            
            <button type="submit" class="button button--primary">Sign in</button>
        </form>
        <p class="form-note">
            <a href="?route=register">Create a new account</a>
        </p>
    </div>
</div>


<?php require __DIR__ . '/../partials/footer.php'; ?>
