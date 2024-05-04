const navLinkEls = document.querySelectorAll(".nav-link");
const windowPathname = window.location.pathname;

navLinkEls.forEach((navlink) => {
    const navLinkPathname = new URL(navlink.href).pathname;

    if (
        windowPathname === navLinkPathname ||
        (windowPathname === "/index.html" && navLinkPathname === "/")
    ) {
        navlink.classList.add("active");
    }
});
