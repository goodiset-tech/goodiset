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
          dropdownBtn.querySelector("span").textContent = item.textContent;

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


document.addEventListener("DOMContentLoaded", () => {
    const checkboxes = document.querySelectorAll('input[name="form-toggle"]');
    const fields = document.querySelectorAll(".fields");

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", (e) => {
        // Uncheck other checkboxes
        
        checkboxes.forEach((box) => {
          if (box !== checkbox) {
            box.checked = false;
          }
        });

        // Show the corresponding field set and hide others
        fields.forEach((field) => {
          if (field.id === e.target.value) {
            field.classList.add("active");
          } else {
            field.classList.remove("active");
          }
        });
      });
    });
  });
