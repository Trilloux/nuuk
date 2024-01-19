
window.onload = function () {
    let form = document.getElementById('login_form');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        let user = document.getElementById('username').value;
        let username_error_1 = document.getElementById('username_error_1');
        let username_error_2 = document.getElementById('username_error_2');
        let user_input = document.getElementById('username');

        let pass = document.getElementById('password').value;
        let password_error_1 = document.getElementById('password_error_1');
        let password_error_2 = document.getElementById('password_error_2');
        let pass_input = document.getElementById('password');

        // Set default border style
        user_input.style.border = '1px solid black';
        pass_input.style.border = '1px solid black';

        if (user == '') {
            username_error_1.style.display = 'inline-block';
            user_input.style.border = '2px solid red';
        } else {
            username_error_1.style.display = 'none';
        }

        if (user.length < 6 && user != '') {
            username_error_2.style.display = 'inline-block';
            user_input.style.border = '2px solid red';
        } else {
            username_error_2.style.display = 'none';
        }

        if (pass == '') {
            password_error_1.style.display = 'inline-block';
            pass_input.style.border = '2px solid red';
        } else {
            password_error_1.style.display = 'none';
        }

        if (pass.length < 8 && pass != '') {
            password_error_2.style.display = 'inline-block';
            pass_input.style.border = '2px solid red';
        } else {
            password_error_2.style.display = 'none';
        }
    });
};
