// IMPORT
import {validateUserLoginForm} from '/projet-final/projet-mairie/assets/js/functions/user-validate-forms.js';
import {validateUserRegisterForm} from '/projet-final/projet-mairie/assets/js/functions/user-validate-forms.js';
import {burgerMenu, foldingMenu} from '/projet-final/projet-mairie/assets/js/functions/menus.js';
// END IMPORT

window.addEventListener("DOMContentLoaded", function () {
    burgerMenu();
    foldingMenu();

    console.log(window.location.pathname);
    let path = window.location.pathname;

    if (path === '/authentification/' + 'enregistrer-nouveau-compte') {
        validateUserRegisterForm();
    } else if (path === '/authentification/' + 'se-connecter') {
        validateUserLoginForm();
    }
})