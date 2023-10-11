import {User} from '/projet-final/projet-mairie/assets/js/classes/User.js';
import {Address} from '/projet-final/projet-mairie/assets/js/classes/Address.js';

export function validateUserRegisterForm () {
    let form = document.getElementById('userRegisterForm');

    form.addEventListener('submit', function(event) {
        
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirmPassword').value;

        let street = document.getElementById('address').value;
        let zipCode = document.getElementById('code-postal').value;
        let city = document.getElementById('ville').value;

        let user = new User (firstName, lastName, email, password, confirmPassword);
        let address = new Address (street, zipCode, city);

        user.validate();
        address.validate();

        if (!user.validate() || !address.validate()) {
            event.preventDefault();
            console.log('erreur');
            console.log(user.errors);
            console.log(address.errors);
        }

    });
}

export function validateUserLoginForm () {
    let form = document.getElementById('userLoginForm');

    form.addEventListener('submit', function (event) {
        // event.preventDefault();

        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        // email.validateEmail();
        // password.validatePassword();

    });
}