export function burgerMenu () {

    let burgerMenuButton = document.getElementById('toggleNavBtn');
    let menu = document.getElementById('mainNav');
    let body = document.querySelector('body');
    let liWithSubMenu = document.querySelectorAll('.menu-item-has-children');

    for(let i = 0; i < liWithSubMenu.length; i++) {
        let parent = liWithSubMenu[i].parentNode;
        let divMenu = liWithSubMenu[i].parentNode.parentNode;

        if (parent.classList.contains('sub-menu')) {
            // We don't append a span element to submenu item with submenu
        } else if (divMenu.classList.contains('menu-menu-principal-container')) {
            let span = document.createElement("span");
            let arrow = document.createTextNode('⬇︎');
            span.appendChild(arrow);
            liWithSubMenu[i].appendChild(span);
        }
    }

    burgerMenuButton.addEventListener('click', function () {
        console.log('clicked');
        menu.classList.toggle('mainNavActive');

        if (menu.getAttribute('class') === 'mainNavActive') {
            body.style.overflow ='hidden';
        } else {
            body.style.overflow ='auto';
        }
    });
}
export function foldingMenu () {

    let menu = document.querySelectorAll('.sub-menu');

    for (let i = 0; i < menu.length; i++) {
        let foldingMenuParent = menu[i].parentNode;

        foldingMenuParent.addEventListener('click', function () {
            menu[i].classList.toggle('active');
        })

        for (let j = 0; j < menu[i].children.length; j++) {
            if (menu[i].children[j].classList.contains('menu-item-has-children')) {
                let subSubMenu = menu[i].children[j].children[1];
                subSubMenu.style.display = 'none';
            }
        }
    }
}