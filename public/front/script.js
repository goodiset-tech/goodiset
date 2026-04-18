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
document.querySelectorAll(".mega-dropdown").forEach((navbarContainer) => {
    const menuToggle = navbarContainer.querySelector(".mega-dropdown-toggle");
    const dropdownMenu = navbarContainer.querySelector(".mega-dropdown-menu");
    if (!menuToggle || !dropdownMenu) {
        return;
    }
    const categoriesItems = navbarContainer.querySelectorAll(".category_item");
    const menuRightItems = navbarContainer.querySelectorAll(".menu-right");

    menuToggle.addEventListener("mouseenter", () => {
        dropdownMenu.style.display = "flex";
        menuRightItems.forEach((menu) => menu.classList.remove("active"));
        categoriesItems.forEach((el) => el.classList.remove("active"));
        const zeroCat = navbarContainer.querySelector(".zero_category");
        if (zeroCat) {
            zeroCat.classList.add("active");
        }
    });

    categoriesItems.forEach((item) => {
        item.addEventListener("mouseenter", (e) => {
            const element = e.currentTarget;
            const elementId = (element.id || "").trim();
            if (!elementId) {
                return;
            }
            navbarContainer.querySelectorAll(".menu-right").forEach((menu) => {
                menu.classList.remove("active");
            });
            categoriesItems.forEach((el) => {
                el.classList.remove("active");
            });
            const safeId = typeof CSS !== "undefined" && CSS.escape ? CSS.escape(elementId) : elementId;
            const correspondingMenu = navbarContainer.querySelector(`.menu-right.${safeId}`);
            if (correspondingMenu) {
                correspondingMenu.classList.add("active");
                element.classList.add("active");
            }
        });
    });

    navbarContainer.addEventListener("mouseleave", () => {
        dropdownMenu.style.display = "none";
        menuRightItems.forEach((menu) => menu.classList.remove("active"));
        categoriesItems.forEach((el) => el.classList.remove("active"));
    });
});
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
document.querySelectorAll(".mbl_shop_toggle").forEach((toggle) => {
    toggle.addEventListener("click", () => {
        const dd = toggle.nextElementSibling;
        if (!dd || !dd.classList.contains("mbl_dropdown")) {
            return;
        }
        dd.style.display = dd.style.display === "block" ? "none" : "block";
    });
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
    if (!minusBtn || !delBtn || !plusBtn || !quantityDisplay) {
        return;
    }
    const isGram = controller.dataset.qtyGrams === "1";
    const readQty = () => {
        const raw =
            quantityDisplay.tagName === "INPUT"
                ? quantityDisplay.value
                : quantityDisplay.textContent.trim().replace(/\s*g\s*$/i, "");
        let n = parseInt(raw, 10);
        if (Number.isNaN(n)) {
            n = isGram ? 100 : 1;
        }
        return n;
    };
    const writeQty = (n) => {
        if (quantityDisplay.tagName === "INPUT") {
            quantityDisplay.value = String(n);
        } else if (isGram) {
            quantityDisplay.textContent = `${n} g`;
        } else {
            quantityDisplay.textContent = String(n);
        }
    };
    const updateVisibility = () => {
        const quantity = readQty();
        if (isGram) {
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
        let quantity = readQty();
        if (isGram) {
            if (quantity > 100) {
                quantity -= 100;
                writeQty(quantity);
            }
        } else if (quantity > 1) {
            quantity -= 1;
            writeQty(quantity);
        }
        updateVisibility();
    });
    plusBtn.addEventListener("click", () => {
        let quantity = readQty();
        if (isGram) {
            quantity += 100;
        } else {
            quantity += 1;
        }
        const maxAttr = quantityDisplay.getAttribute("max");
        const maxVal = maxAttr !== null ? parseInt(maxAttr, 10) : NaN;
        if (!Number.isNaN(maxVal) && quantity > maxVal) {
            quantity = maxVal;
        }
        writeQty(quantity);
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

