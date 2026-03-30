document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll(".tab");
  const forms = document.querySelectorAll(".form");

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      // Remove active class from all tabs
      tabs.forEach((tab) => tab.classList.remove("active"));
      // Add active class to clicked tab
      tab.classList.add("active");

      // Get the target form ID
      const target = tab.getAttribute("data-target");

      // Show the corresponding form and hide others
      forms.forEach((form) => {
        form.classList.remove("active");
        if (form.id === target) {
          form.classList.add("active");
        }
      });
    });
  });
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
  