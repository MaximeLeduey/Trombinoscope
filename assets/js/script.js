const burger = document.querySelector(".nav_burger");
const navMenu = document.querySelector(".nav_menu");
const lis = document.querySelectorAll(".nav_menu_li_link")

burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    navMenu.classList.toggle("active");
})

lis.forEach(n => n.addEventListener("click", () => 
    burger.classList.remove("active")
))

