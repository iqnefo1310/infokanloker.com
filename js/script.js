document.getElementById('cekPass').addEventListener('change', function () {
    const passwordInput = document.querySelector('input[name="password"]');
    if (this.checked) {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
});