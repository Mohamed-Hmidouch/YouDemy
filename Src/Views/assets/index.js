document.addEventListener("DOMContentLoaded", () => {
    // Dropdown Desktop
    const desktopDropdowns = document.querySelectorAll(".group");
    desktopDropdowns.forEach((dropdown) => {
        const button = dropdown.querySelector("button");
        const menu = dropdown.querySelector("div");

        button.addEventListener("click", (event) => {
            event.stopPropagation();
            menu.classList.toggle("hidden");
        });

        document.addEventListener("click", (event) => {
            if (!dropdown.contains(event.target)) {
                menu.classList.add("hidden");
            }
        });
    });

    // Menu Hamburger
    const hamburgerButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.createElement("div");
    mobileMenu.innerHTML = `
        <div id="mobile-menu" class="fixed top-16 left-0 w-full bg-base-100 shadow-lg z-40 hidden">
            <div class="flex flex-col space-y-4 p-4">
                <a href="#" class="text-neutral hover:text-primary transition-colors">Catégories</a>
                <a href="#" class="text-neutral hover:text-primary transition-colors">Développement Web</a>
                <a href="#" class="text-neutral hover:text-primary transition-colors">Design</a>
                <a href="#" class="text-neutral hover:text-primary transition-colors">Marketing</a>
                <div class="flex flex-col space-y-2">
                    <button class="px-4 py-2 text-neutral hover:text-primary transition-colors hover:bg-base-200 rounded-md">Connexion</button>
                    <button class="px-6 py-2 bg-primary text-white rounded-full hover:bg-primary/90 transition-colors shadow-md hover:shadow-lg">S'inscrire</button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(mobileMenu);

    hamburgerButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });

    document.addEventListener("click", (event) => {
        if (!hamburgerButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add("hidden");
        }
    });
});
