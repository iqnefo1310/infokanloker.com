document.getElementById('cekPass').addEventListener('change', function () {
    const passwordInput = document.querySelector('input[name="password"]');
    if (this.checked) {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
});

const passwordField = document.getElementById('password');
const showPasswordCheckbox = document.getElementById('cekPass');

showPasswordCheckbox.addEventListener('change', function () {
    if (showPasswordCheckbox.checked) {
        passwordField.type = 'text';
    } else {
        passwordField.type = 'password';
    }
});