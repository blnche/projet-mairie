window.addEventListener("DOMContentLoaded", function () {
    let toggleThemeBtn = document.getElementById("themeBtn");

    toggleThemeBtn.addEventListener("click", function () {
        let currentTheme = document.documentElement.getAttribute('data-theme');

        let newTheme = currentTheme === 'dark' ? 'light' : currentTheme === 'light' ? 'dark' : currentTheme;

        document.documentElement.setAttribute('data-theme', newTheme);
    })
})