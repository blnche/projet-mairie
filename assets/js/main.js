window.addEventListener("DOMContentLoaded", function () {

    /*  =======================
        THEME BUTTON
        ======================= */

    let toggleThemeBtn = document.getElementById("themeBtn");
    // let themeBtnSymbol = document.querySelector('#themeBtn i');
    // console.log(themeBtnSymbol);

    toggleThemeBtn.addEventListener("click", function () {
        let currentTheme = document.documentElement.getAttribute('data-theme');

        let newTheme = currentTheme === 'dark' ? 'light' : currentTheme === 'light' ? 'dark' : currentTheme;

        document.documentElement.setAttribute('data-theme', newTheme);
        
        // if (currentTheme === 'dark')
        // {
        //     themeBtnSymbol.classList.remove('fa-sharp fa-solid fa-moon');
        //     themeBtnSymbol.classList.add('fa-solid fa-sun-bright');
        // }
        // else if (currentTheme === 'light')
        // {
        //     themeBtnSymbol.classList.remove('fa-solid fa-sun-bright');
        //     themeBtnSymbol.classList.add('fa-sharp fa-solid fa-moon');
        // }
    });
})