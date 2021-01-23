// MOBILE NAVIGATION
const burgerButton = document.querySelector(".mobile-header__burger");
const closeButton = document.querySelector(".mobile-menu__cross");
const mobileMenu = document.querySelector(".mobile-menu");
let mobileMenuOpen = false;

burgerButton.addEventListener("click", (event) => {
    mobileMenuOpen = mobileMenuOpen ? false : true;
    if (mobileMenuOpen) {
        mobileMenu.style.display = "flex";
    }
});

closeButton.addEventListener("click", (event) => {
    mobileMenuOpen = mobileMenuOpen ? false : true;
    if (!mobileMenuOpen) {
        mobileMenu.style.display = "none";
    }
});