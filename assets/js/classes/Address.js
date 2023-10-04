class Address {
    #street;
    #zipCode;
    #city;
    #errors;
    
    constructor(street, zipCode, city, errors = []) {
        this.#street = street;
        this.#zipCode = zipCode;
        this.#city = city;
        this.#errors = errors;
    }
    
    get street() {
        return this.#street;
    }

    set street(street) {
        this.#street = street;
    }

    get zipCode() {
        return this.#zipCode;
    }

    set zipCode(zipCode) {
        this.#zipCode = zipCode;
    }

    get city() {
        return this.#city;
    }

    set city(city) {
        this.#city = city;
    }
    
    get errors() {
        return this.#errors;
    }

    set errors(errors) {
        this.#errors = errors;
    }

    validateStreet () {
        if (this.#street.length !== 0) {
            return true;
        } else {
            let invalidateStreet = {
                field: 'street',
                message: 'The address must not be empty.'
            };
            this.addError(invalidateStreet);
            return false;
        }
    }

    validateZipCode () {
        let zipCodePattern = /^\d{5}$/;
        let zipCodeValid = zipCodePattern.test(this.#zipCode);

        if (zipCodeValid === true) {
            return true;
        } else {
            let invalidateZipCode = {
                field: 'zipCode',
                message: 'The zipCode must be 5 characters and only be numbers.'
            };
            this.addError(invalidateZipCode);
            return false;
        }
    }

    validateCity () {
        if (this.#city.length !== 0) {
            return true;
        } else {
            let invalidateCity = {
                field: 'city',
                message: 'The city must not be empty.'
            };
            this.addError(invalidateCity);
            return false;
        }
    }

    validate() {
        this.resetErrors();

        this.validateStreet();
        this.validateZipCode();
        this.validateCity();

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

export {Address};