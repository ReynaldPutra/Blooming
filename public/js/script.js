document.addEventListener("DOMContentLoaded", function () {
    const navLinkEls = document.querySelectorAll(".nav-link");
    const windowPathname = window.location.pathname; // Decode URI component
    console.log("windowPathname:", windowPathname);

    navLinkEls.forEach((navlink) => {
        const navLinkPathname = new URL(navlink.href).pathname;

        console.log("navLinkPathname:", navLinkPathname);
        // Check if windowPathname exactly matches navLinkPathname or starts with navLinkPathname followed by '/'
        if (
            windowPathname === navLinkPathname ||
            windowPathname.startsWith(navLinkPathname + "/")
        ) {
            navlink.classList.add("active");
        } else {
            navlink.classList.remove("active"); // Remove active class if not matching
        }
    });
});
