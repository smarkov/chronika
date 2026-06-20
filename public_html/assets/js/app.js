document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.querySelector('#media_files');
    const hint = document.querySelector('#file-hint');

    if (fileInput && hint) {
        fileInput.addEventListener('change', function () {
            const count = fileInput.files.length;
            hint.textContent = count === 0
                ? 'Choose PDF, image or video files'
                : `${count} file${count > 1 ? 's' : ''} selected`;
        });
    }

    const passwordInput = document.querySelector('#password');
    const toggle = document.querySelector('#togglePassword');

    if (passwordInput && toggle) {
        toggle.addEventListener('click', function () {
            const visible = passwordInput.type === 'text';
            passwordInput.type = visible ? 'password' : 'text';
            toggle.textContent = visible ? 'Show' : 'Hide';
        });
    }
});