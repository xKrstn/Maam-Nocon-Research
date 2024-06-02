const menubtn = document.getElementById("menu-btn");
const links = document.getElementById("links");
const icon = menubtn.querySelector("i");

menubtn.addEventListener("click", (e) => {
    links.classList.toggle("open");

    const isOpen = links.classList.contains("open");
    icon.setAttribute(
        "class", isOpen ? "ri-close-line" : "ri-menu-3-line"
    );
});