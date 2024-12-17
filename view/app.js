const btn=document.querySelector('#toggleOpen');
const burgerMenu = document.getElementById("burger-menu");
const closeBtn = document.getElementById("close-btn");

// Ouvrir le menu
btn.addEventListener("click", () => {
    burgerMenu.classList.remove("hidden");
});

// Fermer le menu
closeBtn.addEventListener("click", () => {
    burgerMenu.classList.add("hidden");
});

// Fermer le menu si on clique en dehors
burgerMenu.addEventListener("click", (e) => {
    if (e.target === burgerMenu) {
        burgerMenu.classList.add("hidden");
    }
});