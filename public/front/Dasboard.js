const editButton = document.querySelector("#edit");
const changePasswordButton = document.querySelector("#change-password");

editButton.addEventListener("click", changeTab);

function changeTab() {
    const targetTab = "address";

    // Remove active class from all menu items
    document.querySelectorAll(".menu-item").forEach((el) => {
        el.classList.remove("active");
    });

    // Add active class to the clicked item
    document
        .querySelector(`[data-target=${targetTab}]`)
        .classList.add("active");

    // Hide all tabs
    document.querySelectorAll(".tab").forEach((tab) => {
        tab.classList.remove("active-tab");
    });

    // Show the targeted tab
    document.getElementById(targetTab).classList.add("active-tab");
}

document.querySelectorAll(".menu-item").forEach((item) => {
    item.addEventListener("click", function () {
        // Remove active class from all menu items
        document.querySelectorAll(".menu-item").forEach((el) => {
            el.classList.remove("active");
        });

        // Add active class to the clicked item
        this.classList.add("active");

        // Get the target tab from the data attribute
        const targetTab = this.getAttribute("data-target");

        // Hide all tabs
        document.querySelectorAll(".tab").forEach((tab) => {
            tab.classList.remove("active-tab");
        });

        // Show the targeted tab
        document.getElementById(targetTab).classList.add("active-tab");
    });
});

const addressButton = document.querySelector(".address-btn");
const addressForm = document.querySelector(".address-form");
const addressInfo = document.querySelector(".address-info");

addressButton.addEventListener("click", function () {
    addressInfo.classList.toggle("active-address");
    addressInfo.classList.toggle("deactive-address");

    addressForm.classList.toggle("active-address");
    addressForm.classList.toggle("deactive-address");
});

const paymentButton = document.querySelector("#payment-btn");
const paymentForm = document.querySelector(".payment-form");
const paymentInfo = document.querySelector(".payment-info");

paymentButton.addEventListener("click", function () {
    paymentInfo.classList.toggle("active-address");
    paymentInfo.classList.toggle("deactive-address");

    paymentForm.classList.toggle("active-address");
    paymentForm.classList.toggle("deactive-address");
});

const cardNumberInput = document.getElementById("card-number");

cardNumberInput.addEventListener("input", (e) => {
    let value = e.target.value.replace(/\D/g, ""); // Remove non-digits
    value = value.replace(/(.{4})/g, "$1 ").trim(); // Add spaces every 4 digits
    e.target.value = value;
});

document.addEventListener("DOMContentLoaded", () => {
    const dropdowns = document.querySelectorAll(".dropdown");

    dropdowns.forEach((dropdown) => {
        const dropdownBtn = dropdown.querySelector(".dropdown-btn");
        const dropdownMenu = dropdown.querySelector(".dropdown-menu");
        const dropdownItems = dropdown.querySelectorAll(".dropdown-item");

        // Toggle dropdown menu visibility
        dropdownBtn.addEventListener("click", (event) => {
            event.preventDefault();
            closeAllDropdowns(); // Close other dropdowns first
            dropdown.classList.toggle("open");
        });

        // Handle selection of dropdown items
        dropdownItems.forEach((item) => {
            item.addEventListener("click", (event) => {
                event.preventDefault();

                // Remove "selected" class from all items in this dropdown
                dropdownItems.forEach((el) => el.classList.remove("selected"));

                // Add "selected" class to the clicked item
                item.classList.add("selected");

                // Update the dropdown button text
                dropdownBtn.querySelector("span").textContent =
                    item.textContent;

                // Close the dropdown
                dropdown.classList.remove("open");
            });
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".dropdown")) {
            closeAllDropdowns();
        }
    });

    // Close all dropdowns
    function closeAllDropdowns() {
        dropdowns.forEach((dropdown) => dropdown.classList.remove("open"));
    }
});
