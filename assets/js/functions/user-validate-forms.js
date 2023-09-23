import {User} from '/assets/js/classes/User.js';
import {Address} from '/assets/js/classes/Address.js';

export function validateUserRegisterForm () {
    let form = document.getElementById('userRegisterForm');

    form.addEventListener('submit', function(event) {
        // event.preventDefault();

        let firstName = document.getElementById('firstName');
        let lastName = document.getElementById('lastName');
        let email = document.getElementById('email');
        let password = document.getElementById('password');
        let confirmPassword = document.getElementById('confirmPassword');

        let street = document.getElementById('address');
        let zipCode = document.getElementById('code-postal');
        let city = document.getElementById('ville');

        let user = new User (firstName, lastName, email, password, confirmPassword);
        let address = new Address (street, zipCode, city);

        user.validate();
        address.validate();

    });
}

export function validateUserLoginForm () {
    let form = document.getElementById('userLoginForm');

    form.addEventListener('submit', function (event) {
        // event.preventDefault();

        let email = document.getElementById('email');
        let password = document.getElementById('password');

        // email.validateEmail();
        // password.validatePassword();

    });
}