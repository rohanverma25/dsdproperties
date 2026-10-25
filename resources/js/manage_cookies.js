document.addEventListener("DOMContentLoaded", function () {
    const banner = document.getElementById("cookie-banner");
    const acceptBtn = document.getElementById("accept-cookies");
    const rejectBtn = document.getElementById("reject-cookies");

    // The cookie banner only exists on the public site.
    if (!banner || !acceptBtn || !rejectBtn) {
        return;
    }

    // Helper functions
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
    }

    function getCookie(name) {
        return document.cookie.split('; ').find(row => row.startsWith(name + '='))?.split('=')[1];
    }

    // Show banner only if not accepted or rejected
    if (!getCookie("cookie_consent")) {
        banner.classList.remove("hidden");
    }

    // Accept cookies
    acceptBtn.addEventListener("click", () => {
        setCookie("cookie_consent", "accepted", 180);
        banner.classList.add("hidden");
    });

    // Reject cookies
    rejectBtn.addEventListener("click", () => {
        setCookie("cookie_consent", "rejected", 180);
        banner.classList.add("hidden");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const backToTopBtn = document.getElementById("backToTopBtn");

    // Not every layout has the button (the blog layout doesn't); without this check every page view
    // threw a TypeError, plus one more on each scroll.
    if (!backToTopBtn) {
        return;
    }

    // Show/hide button on scroll
    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.remove("hidden");
        } else {
            backToTopBtn.classList.add("hidden");
        }
    });

    // Scroll to top on click
    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});


const menuToggleBtn = document.getElementById('menu-toggle');
const mobileMenuEl = document.getElementById('mobile-menu');

if (menuToggleBtn && mobileMenuEl) {
    menuToggleBtn.addEventListener('click', function () {
        mobileMenuEl.classList.toggle('hidden');
    });
}
