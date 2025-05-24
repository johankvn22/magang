document.addEventListener("DOMContentLoaded", () => {
  const currentPath = window.location.pathname.replace(/\/$/, "");
  const navLinks = document.querySelectorAll(
    ".navbar-nav .nav-link, .navbar-nav .dropdown-item"
  );

  navLinks.forEach((link) => {
    try {
      const linkPath = new URL(link.href).pathname.replace(/\/$/, "");
      if (linkPath === currentPath) {
        link.classList.add("active");

        // Jika bagian dari dropdown, tandai juga parent-nya
        const dropdownMenu = link.closest(".dropdown-menu");
        if (dropdownMenu) {
          const toggle = dropdownMenu.previousElementSibling;
          if (toggle && toggle.classList.contains("nav-link")) {
            toggle.classList.add("active");
          }
        }
      }
    } catch (e) {
      // abaikan error untuk link seperti '#'
    }
  });
});
