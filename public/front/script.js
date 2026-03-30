document.addEventListener("DOMContentLoaded", () => {
    const closeButton = document.querySelector(".close_annoucement_btn");
    const announcementBar = document.querySelector(".announcement-bar");
    if (closeButton && announcementBar) {
        closeButton.addEventListener("click", () => {
            announcementBar.style.display = "none";
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const closeButtonsearch = document.querySelector(".close_search");
    if (closeButtonsearch) {
        closeButtonsearch.addEventListener("click", () => {
            document.getElementsByClassName("search_bar_overlay")[0].style.display = "none";
            document.querySelector(".body-container").style.overflowY = " auto";
            document.querySelector(".body-container").style.height = "100vh";
        });
    }
});
const menuToggle = document.querySelector(".mega-dropdown-toggle");
const dropdownMenu = document.querySelector(".mega-dropdown-menu");
const categoriesItems = document.querySelectorAll(".category_item");
const menuRightItems = document.querySelectorAll(".menu-right");

if (menuToggle && dropdownMenu) {
    menuToggle.addEventListener("mouseenter", () => {
        dropdownMenu.style.display = "flex";
        menuRightItems.forEach((menu) => menu.classList.remove("active"));
        categoriesItems.forEach((e) => e.classList.remove("active"));
        const zeroCat = document.querySelector(".zero_category");
        if (zeroCat) zeroCat.classList.add("active");
    });
}

categoriesItems.forEach((item) => {
    item.addEventListener("mouseenter", (e) => {
        const element = e.target;
        const elementId = element.id.trim();
        document.querySelectorAll(".menu-right").forEach((menu) => {
            menu.classList.remove("active");
        });
        categoriesItems.forEach((e) => {
            e.classList.remove("active");
        });
        const correspondingMenu = document.querySelector(`.menu-right.${elementId}`);
        if (correspondingMenu) {
            correspondingMenu.classList.add("active");
            element.classList.add("active");
        }
    });
});
// Replace global mouseover with mouseleave on navigation container if exists
const navbarContainer = document.querySelector(".mega-dropdown"); // Assuming this wraps the toggle and menu
if (navbarContainer && dropdownMenu) {
    navbarContainer.addEventListener("mouseleave", () => {
        dropdownMenu.style.display = "none";
        menuRightItems.forEach((menu) => menu.classList.remove("active"));
        categoriesItems.forEach((e) => e.classList.remove("active"));
    });
}
document.getElementById("open_search").addEventListener("click", () => {
    document.getElementsByClassName("search_bar_overlay")[0].style.display = "flex";
    document.querySelector(".body-container").style.overflowY = "hidden";
    document.querySelector(".body-container").style.height = "calc(100vh - 90px)";
});
document.addEventListener("click", (event) => {
    if (event.target.classList.contains("search_bar_overlay")) {
        document.getElementsByClassName("search_bar_overlay")[0].style.display = "none";
        document.querySelector(".body-container").style.overflowY = " auto";
        document.querySelector(".body-container").style.height = "100vh";
    }
});
document.getElementsByClassName("menu_icon")[0].addEventListener("click", () => {
    document.getElementById("mbl_nav_container").style.display = "block";
    document.getElementsByTagName("body")[0].style.overflowY = "hidden";
});
document.getElementById("close_mbl_menu").addEventListener("click", () => {
    document.getElementById("mbl_nav_container").style.display = "none";
    document.getElementsByTagName("body")[0].style.overflowY = "unset";
});
document.getElementsByClassName("mbl_shop_toggle")[0].addEventListener("click", () => {
    document.getElementsByClassName("mbl_dropdown")[0].style.display =
        document.getElementsByClassName("mbl_dropdown")[0].style.display === "block" ? "none" : "block";
});
const sliderState = { currentIndex: 0 };
function showNextImage() {
    const visibleContainer =
        window.innerWidth > 786 ? document.querySelector(".background_slider") : document.querySelector(".mob-slider");
    if (!visibleContainer) return;
    const images = visibleContainer.querySelectorAll(".slider_image");
    if (images.length === 0) return;
    if (images[sliderState.currentIndex]) images[sliderState.currentIndex].classList.remove("active");
    sliderState.currentIndex = (sliderState.currentIndex + 1) % images.length;
    if (images[sliderState.currentIndex]) images[sliderState.currentIndex].classList.add("active");
}
setInterval(showNextImage, 3000);
const slider = document.querySelector(".slider");
function slideLeft() {
    slider.scrollBy({ left: -238, behavior: "smooth" });
}
function slideRight() {
    slider.scrollBy({ left: 238, behavior: "smooth" });
}
const quantityControls = document.querySelectorAll(".quantity-controls");
quantityControls.forEach((controller) => {
    const minusBtn = controller.querySelector("#minus");
    const delBtn = controller.querySelector(".del_btn");
    const plusBtn = controller.querySelector("#plus");
    const quantityDisplay = controller.querySelector(".quantity_cart");
    const orignalQuantity = quantityDisplay.innerHTML.trim();
    const updateVisibility = () => {
        let quantity = parseInt(quantityDisplay.innerHTML);
        if (orignalQuantity.endsWith("g")) {
            if (quantity > 100) {
                delBtn.style.display = "none";
                minusBtn.style.display = "inline";
            } else {
                delBtn.style.display = "inline";
                minusBtn.style.display = "none";
            }
        } else {
            if (quantity > 1) {
                delBtn.style.display = "none";
                minusBtn.style.display = "inline";
            } else {
                delBtn.style.display = "inline";
                minusBtn.style.display = "none";
            }
        }
    };
    updateVisibility();
    minusBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityDisplay.innerHTML);
        if (orignalQuantity.endsWith("g")) {
            if (quantity > 100) {
                quantity -= 100;
                quantityDisplay.textContent = `${quantity} g`;
                updateVisibility();
            }
        } else {
            quantity--;
            quantityDisplay.textContent = quantity;
        }
        updateVisibility();
    });
    plusBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityDisplay.innerHTML);
        console.log(orignalQuantity, orignalQuantity.endsWith("g"), ">>>original quantity");
        if (orignalQuantity.endsWith("g")) {
            console.log(">>> ****", quantity);
            quantity += 100;
            quantityDisplay.textContent = `${quantity} g`;
        } else {
            quantity++;
            quantityDisplay.textContent = quantity;
        }
        updateVisibility();
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const fullscreenMenu = document.querySelector(".fullscreen-menu");
    document.body.addEventListener("click", function (event) {
        if (event.target.matches(".account_menu")) {
            if (fullscreenMenu) {
                fullscreenMenu.classList.toggle("active");
            }
        }
        if (event.target.matches(".menu-item, .menu-item a")) {
            if (fullscreenMenu) {
                fullscreenMenu.classList.remove("active");
            }
        }
        if (fullscreenMenu && !fullscreenMenu.contains(event.target) && !event.target.matches(".account_menu")) {
            fullscreenMenu.classList.remove("active");
        }
    });
});

// Handle select element color change for placeholder vs selected option
document.addEventListener("DOMContentLoaded", function () {
    const selectElements = document.querySelectorAll("select");

    selectElements.forEach((select) => {
        // Check initial state
        if (select.value !== "" && select.selectedIndex !== 0) {
            select.classList.add("selected");
        }

        // Add change event listener
        select.addEventListener("change", function () {
            if (this.value !== "" && this.selectedIndex !== 0) {
                this.classList.add("selected");
            } else {
                this.classList.remove("selected");
            }
        });
    });
});

