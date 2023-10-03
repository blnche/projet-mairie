export function lightDarkMode () {
    
    let toggleThemeBtn = document.getElementById("themeBtn");
    let contrastIcon = toggleThemeBtn.children[0];

    let arrowUpParent = document.getElementById('ArrowUpBtn');
    let arrowUpIcon = arrowUpParent.children[0];

    let toggleBurgerMenuIcon = document.getElementById('toggleNavBtn');

    let isDark = localStorage.getItem('dark') === 'true';
    
    if (isDark) {
        document.documentElement.setAttribute('data-theme', 'dark');
    }

    toggleThemeBtn.addEventListener("click", function () {
        let currentTheme = document.documentElement.getAttribute('data-theme');

        let newTheme = currentTheme === 'dark' ? 'light' : currentTheme === 'light' ? 'dark' : currentTheme;

        if (newTheme === 'dark') {
            localStorage.setItem('dark', true);
            
            contrastIcon.setAttribute('src', 'https://img.icons8.com/000000/material-rounded/48/contrast.png');
            arrowUpIcon.setAttribute('src', 'https://img.icons8.com/000000/fluency-systems-regular/48/up--v1.png');
            toggleBurgerMenuIcon.setAttribute('src', 'https://img.icons8.com/000000/fluency-systems-filled/48/menu.png')
        } else if (newTheme === 'light') {
            localStorage.setItem('dark', false);
            
            contrastIcon.setAttribute('src', 'https://img.icons8.com/FFFFFF/material-rounded/48/contrast.png');
            arrowUpIcon.setAttribute('src', 'https://img.icons8.com/FFFFFF/fluency-systems-regular/48/up--v1.png');
            toggleBurgerMenuIcon.setAttribute('src', 'https://img.icons8.com/FFFFFF/fluency-systems-filled/48/menu.png')
        }

        document.documentElement.setAttribute('data-theme', newTheme);

    });
}