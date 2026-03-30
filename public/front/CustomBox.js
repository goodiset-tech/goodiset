const quantity_btn = document.querySelectorAll("#quantity_btn_box");
const mbl_box_menu = document.querySelector(".mbl_box_customization");
const mbl_box_menu_controler = document.querySelector(".fa-grip-lines");
const overlay = document.createElement("div");
overlay.className = "overlay";
document.body.appendChild(overlay);
const overlay_container = document.querySelector(".overlay");
// quantity_btn.forEach((e) => {
//     e.addEventListener("click", () => {
//         const minus = e.querySelector(".minus_quantity");
//         const add = e.querySelector(".add_quantity");
//         const quantity = e.querySelector(".box_product_quantity");
//         const value = quantity.innerHTML;
//         const match = value.match(/\d+(\.\d+)?/); // Matches integers or decimals
//         const amount = match ? parseFloat(match[0]) : null;
//         minus.addEventListener("click", () => {
//             if (amount != 100) quantity.innerHTML = `${amount - 100} g`;
//         });

//         add.addEventListener("click", () => {
//             quantity.innerHTML = `${amount + 100} g`;
//         });
//     });
// });
mbl_box_menu.addEventListener("wheel", (e) => {
    e.preventDefault();
});

function menuHandler() {
    const currentHeight = mbl_box_menu.offsetHeight;
    // Temporarily disable transition to measure new content height
    mbl_box_menu.style.transition = "none";
    mbl_box_menu.style.height = "auto";

    if (mbl_box_menu.classList.contains("down_menu_box")) {
        mbl_box_menu.classList.remove("down_menu_box");
        overlay.classList.add("active");
    } else {
        overlay.classList.remove("active");
        mbl_box_menu.classList.add("down_menu_box");
    }

    // Measure new height after content change
    const newHeight = mbl_box_menu.offsetHeight;

    // Apply smooth transition to new height
    mbl_box_menu.style.height = `${currentHeight}px`;
    mbl_box_menu.offsetHeight; // Trigger reflow
    mbl_box_menu.style.transition = "height 0.3s ease";
    mbl_box_menu.style.height = `${newHeight}px`;
}
mbl_box_menu_controler.addEventListener("click", () => {
    menuHandler();
});
overlay_container.addEventListener("wheel", (e) => {
    e.preventDefault();
});

overlay_container.addEventListener("click", () => {
    menuHandler();
});
