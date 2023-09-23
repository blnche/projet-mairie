// IMPORT
import {validateUserLoginForm} from '/assets/js/functions/user-validate-forms.js';
import {validateUserRegisterForm} from '/assets/js/functions/user-validate-forms.js';
// END IMPORT

window.addEventListener("DOMContentLoaded", function () {
    console.log(window.location.pathname);
    let path = window.location.pathname;

    if (path === '/authentification/' + 'enregistrer-nouveau-compte') {
        validateUserRegisterForm();
    } else if (path === '/authentification/' + 'se-connecter') {
        validateUserLoginForm();
    }
})