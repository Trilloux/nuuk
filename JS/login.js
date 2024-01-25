
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

        // Clear previous error messages
        username_error_1.style.display = 'none';
        username_error_2.style.display = 'none';
        password_error_1.style.display = 'none';
        password_error_2.style.display = 'none';

        // Validate username
        if (user == '') {
            username_error_1.style.display = 'inline-block';
            user_input.style.border = '2px solid red';
        } else if (user.length < 6) {
            username_error_2.style.display = 'inline-block';
            user_input.style.border = '2px solid red';
        }

        // Validate password
        if (pass == '') {
            password_error_1.style.display = 'inline-block';
            pass_input.style.border = '2px solid red';
        } else if (pass.length < 8) {
            password_error_2.style.display = 'inline-block';
            pass_input.style.border = '2px solid red';
        }

        // Check if there are any error messages displayed
        let hasErrors = username_error_1.style.display === 'inline-block' ||
                        username_error_2.style.display === 'inline-block' ||
                        password_error_1.style.display === 'inline-block' ||
                        password_error_2.style.display === 'inline-block';

        // If no errors, proceed with login
        if (!hasErrors) {
            // Submit the form
            form.submit();
        }
    });
};
