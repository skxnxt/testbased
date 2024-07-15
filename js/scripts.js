function showInvalidFeedback(input, message) {
    input.classList.add('is-invalid');
    input.parentElement.querySelector('.invalid-feedback').textContent = message;
}

function clearInvalidFeedback(input) {
    input.classList.remove('is-invalid');
}

document.getElementById('showRegisterForm').addEventListener('click', function() {
    document.getElementById('loginFormContainer').classList.add('d-none');
    document.getElementById('registerFormContainer').classList.remove('d-none');
});

document.getElementById('showLoginForm').addEventListener('click', function() {
    document.getElementById('loginFormContainer').classList.remove('d-none');
    document.getElementById('registerFormContainer').classList.add('d-none');
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('regUsername');
    const email = document.getElementById('regEmail');
    const password = document.getElementById('regPassword');

    let isValid = true;

    if (username.value.trim() === '') {
        showInvalidFeedback(username, 'Please enter a valid username.');
        isValid = false;
    } else {
        clearInvalidFeedback(username);
    }

    if (email.value.trim() === '' || !email.value.includes('@')) {
        showInvalidFeedback(email, 'Please enter a valid email address.');
        isValid = false;
    } else {
        clearInvalidFeedback(email);
    }

    if (password.value.trim() === '') {
        showInvalidFeedback(password, 'Please enter a valid password.');
        isValid = false;
    } else {
        clearInvalidFeedback(password);
    }

    if (isValid) {
        fetch('php/register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username: username.value, email: email.value, password: password.value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Success', data.message, 'success');
                document.getElementById('showLoginForm').click();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    }
});

document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const username = document.getElementById('loginUsername');
    const password = document.getElementById('loginPassword');
    const rememberMe = document.getElementById('rememberMe').checked;

    let isValid = true;

    if (username.value.trim() === '') {
        showInvalidFeedback(username, 'Please enter a valid username.');
        isValid = false;
    } else {
        clearInvalidFeedback(username);
    }

    if (password.value.trim() === '') {
        showInvalidFeedback(password, 'Please enter a valid password.');
        isValid = false;
    } else {
        clearInvalidFeedback(password);
    }

    if (isValid) {
        fetch('php/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username: username.value, password: password.value, rememberMe: rememberMe })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Success', data.message, 'success').then(() => {
                    fetch('php/check_character.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.hasCharacter) {
                                window.location.href = 'game.php';
                            } else {
                                window.location.href = 'create_character.php';
                            }
                        });
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('characterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('charName');
        const avatar = document.querySelector('input[name="charAvatar"]:checked');

        let isValid = true;

        if (name.value.trim() === '') {
            showInvalidFeedback(name, 'Please enter a character name.');
            isValid = false;
        } else {
            clearInvalidFeedback(name);
        }

        if (!avatar) {
            showInvalidFeedback(document.querySelector('input[name="charAvatar"]'), 'Please select an avatar.');
            isValid = false;
        } else {
            clearInvalidFeedback(document.querySelector('input[name="charAvatar"]'));
        }

        if (isValid) {
            fetch('php/create_character.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: name.value, avatar: avatar.value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', data.message, 'success').then(() => {
                        window.location.href = 'game.php';
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            });
        }
    });
});

function showInvalidFeedback(input, message) {
    input.classList.add('is-invalid');
    input.parentElement.querySelector('.invalid-feedback').textContent = message;
}

function clearInvalidFeedback(input) {
    input.classList.remove('is-invalid');
}

document.getElementById('exploreBtn').addEventListener('click', function() {
    performAction('explore');
});

document.getElementById('fightBtn').addEventListener('click', function() {
    performAction('fight');
});

function performAction(action) {
    fetch('php/game_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ action: action })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success', data.message, 'success');
            document.getElementById('actionResult').innerHTML = `Experience: ${data.new_experience}`;
            // Update character info (e.g., level) if necessary
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    });
}