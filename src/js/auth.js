document.addEventListener('DOMContentLoaded', function (e) {
    const showAuthBtn = document.getElementById('ultimate-show-auth-form'),
          authContainer = document.getElementById('ultimate-auth-container'),
          close = document.getElementById('ultimate-auth-close');

    showAuthBtn.addEventListener('click', () => {
        authContainer.classList.add('show');
        showAuthBtn.parentElement.classList.add('hide');
    });

    close.addEventListener('click', () => {
        authContainer.classList.remove('show');
        showAuthBtn.parentElement.classList.remove('hide');
    });
});