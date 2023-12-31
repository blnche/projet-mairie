// IMPORT
import {validateUserLoginForm} from '/projet-final/projet-mairie/assets/js/functions/user-validate-forms.js';
import {validateUserRegisterForm} from '/projet-final/projet-mairie/assets/js/functions/user-validate-forms.js';
import {burgerMenu, foldingMenu} from '/projet-final/projet-mairie/assets/js/functions/menus.js';
import {lightDarkMode} from '/projet-final/projet-mairie/assets/js/functions/theme-mode.js';
import {search} from '/projet-final/projet-mairie/assets/js/functions/search.js';
// END IMPORT

window.addEventListener("DOMContentLoaded", function () {
    burgerMenu();
    foldingMenu();
    lightDarkMode();

    console.log(window.location.pathname);
    let path = window.location.pathname;

    if (path === '/projet-final/projet-mairie/authentification/' + 'enregistrer-nouveau-compte') {
        validateUserRegisterForm();
    } else if (path === '/projet-final/projet-mairie/authentification/' + 'se-connecter') {
        validateUserLoginForm();
    }
    search();
})