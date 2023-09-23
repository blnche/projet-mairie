class User {
    #firstName;
    #lastName;
    #email;
    #password;
    #confirmPassword;
    #errors;

    constructor(firstName, lastName, email, password, confirmPassword, errors = []) {
        this.#firstName = firstName;
        this.#lastName = lastName;
        this.#email = email;
        this.#password = password;
        this.#confirmPassword = confirmPassword;
        this.#errors = errors;
    }

    get firstName() {
        return this.#firstName;
    }

    set firstName(firstName) {
        this.#firstName = firstName;
    }

    get lastName() {
        return this.#lastName;
    }

    set lastName(lastName) {
        this.#lastName = lastName;
    }

    get email() {
        return this.#email;
    }

    set email(email) {
        this.#email = email;
    }

    get password() {
        return this.#password;
    }

    set password(password) {
        this.#password = password;
    }

    get confirmPassword() {
        return this.#confirmPassword;
    }

    set confirmPassword(confirmPassword) {
        this.#confirmPassword = confirmPassword;
    }


    get errors() {
        return this.#errors;
    }

    set errors(errors) {
        this.#errors = errors;
    }

    validateFirstName () {
        if (this.#firstName.length > 2 && this.#firstName.length < 64) {
            return true;
        } else {
            let invalidFirstName = {
                field: "firstName",
                message: "The first name must be between 2 and 64 characters"
            };
            this.addError(invalidFirstName);
            return false;
        }
    }

    validateLastName () {
        if (this.lastName.length > 2 && this.lastName.length < 64) {
            return true;
        } else {
            let invalidLastName = {
                field: "lastName",
                message: "The last name must be between 2 and 64 characters"
            };
            this.addError(invalidLastName);
            return false;
        }
    }

    validateEmail () {
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let emailValid = emailPattern.test(this.#email);

        if (emailValid === true) {
            return true;
        } else {
            let invalidEmail = {
                field : "email",
                message : "Your email is invalid"
            };
            this.addError(invalidEmail);
            return false;
        }
    }

    validatePassword () {
        let passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{12,}$/;
        let passwordValid = passwordPattern.test(this.#password);

        if (passwordValid === true) {
            return true;
        } else {
            let invalidPassword = {
                field : "password",
                message : "Your password must contain at least 12 characters with 1 number, 1 capital letter, 1 special character."
            };
            this.addError(invalidPassword);
            return false;
        }
    }

    validateConfirmPassword () {
        if (this.#confirmPassword === this.#password) {
            return true;
        } else {
            let invalidateConfirmPassword = {
                field: 'confirmPassword',
                message: 'Confirm password must be the same as the password.'
            };
            this.addError(invalidateConfirmPassword);
            return false;
        }
    }

    validate() {
        this.resetErrors();

        this.validateFirstName();
        this.validateLastName();
        this.validateEmail();
        this.validatePassword();
        this.validateConfirmPassword();

        if (this.errors.length === 0) {
            return true;
        } else {
            return false;
        }
    }

    addError(error) {
        this.#errors.push(error);
    }

    resetErrors() {
        this.#errors.length = 0;
    }
}

export {User};