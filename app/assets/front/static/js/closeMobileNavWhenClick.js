const mobileNav = document.getElementById("mobile_nav-menu-items");
const mobileNavElements = mobileNav.children;

Array.from(mobileNavElements).forEach((element) => {
    element.addEventListener("click", () => {
        location.reload();
    })
})