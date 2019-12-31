document.addEventListener('DOMContentLoaded', function (e) {
    const showAuthBtn = document.getElementById('ultimate-show-auth-form'),
          authContainer = document.getElementById('ultimate-auth-container'),
          close = document.getElementById('ultimate-auth-close'),
          authForm = document.getElementById('ultimate-auth-form'),
          status = authForm.querySelector('[data-message="status"]');

    showAuthBtn.addEventListener('click', () => {
        authContainer.classList.add('show');
        showAuthBtn.parentElement.classList.add('hide');
    });

    close.addEventListener('click', () => {
        authContainer.classList.remove('show');
        showAuthBtn.parentElement.classList.remove('hide');
    });

    authForm.addEventListener('submit', e => {
        e.preventDefault();

        // reset the form messages
        resetMessages();

        // collect all data
        let data = {
            name: authForm.querySelector('[name="username"]').value,
            password: authForm.querySelector('[name="password"]').value,
            nonce: authForm.querySelector('[name="ultimate_auth"]').value
        }

        // validate everything
        if(!data.name || !data.password) {
            status.innerHTML = "Missing Data";
            status.classList.add('error');
            return;
        }

        // ajax http post request
        let url = authForm.dataset.url;
        let params = new URLSearchParams(new FormData(authForm));

        authForm.querySelector('[name="submit"]').value = "Logging in...";
        authForm.querySelector('[name="submit"]').disabled = true;

        fetch(url, {
                method: "POST",
                body: params
        }).then(res => res.json())
        .catch(error => {
            resetMessages();
        })
        .then(response => {
            resetMessages();

            if (response === 0 || !response.status) {
                status.innerHTML = response.message;
                status.classList.add('error');
                return;
            }

            status.innerHTML = response.message;
            status.classList.add('success');

            authForm.reset();
            window.location.reload();
        });
    });
    
    function resetMessages() {
        status.innerHTML = '';
        status.classList.remove('success', 'error');

        authForm.querySelector('[name="submit"]').value = 'Login';
        authForm.querySelector('[name="submit"]').disabled = false;
    }
});