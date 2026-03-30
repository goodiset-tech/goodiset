document.addEventListener("DOMContentLoaded", () => {
    const steps = document.querySelectorAll(".step");
    const step_label = document.querySelectorAll(".step_label");
    const active_step_label = document.querySelectorAll(".active_step_label");
    const contents = document.querySelectorAll(".content");
    const nextBtn = document.getElementById("next-step");

    // Retrieve current step from localStorage or default to 1
    let currentStep = Number(localStorage.getItem("currentStep")) === 3
    ? 3
    :  3;

    const updateStepper = () => {
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            if (stepNumber < currentStep) {
                step.classList.add("completed");
                step.classList.remove("active");
            } else if (stepNumber === currentStep) {
                step.classList.add("active");
                step.classList.remove("completed");
            } else {
                step.classList.remove("active", "completed");
            }
        });

        document.querySelector(".body-container").scrollTo({
            top: 0,
            behavior: "smooth",
        });

        contents.forEach((content) => {
            content.style.display =
                Number(content.dataset.step) === currentStep ? "block" : "none";
        });

        step_label.forEach((content) => {
            content.style.display =
                Number(content.dataset.step) === currentStep ? "block" : "none";
        });

        active_step_label.forEach((content) => {
            content.style.display =
                Number(content.dataset.step) === currentStep ? "block" : "none";
        });

        nextBtn.disabled = currentStep === steps.length;

        // Save the current step to localStorage
        localStorage.setItem("currentStep", currentStep);
    };

    const validateStepFields = () => {
        const currentContent = document.querySelector(
            `.content[data-step="${currentStep}"]`
        );
        const requiredFields = currentContent.querySelectorAll(
            "input[required], select[required]"
        );
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach((field) => {
            const value = field.value.trim();

            if (!value) {
                isValid = false;
                field.style.border = "2px solid red";
                showError(field, "This field is required.");

                if (!firstInvalidField) {
                    firstInvalidField = field; // Capture the first invalid field
                }
            } else if (field.type === "email" && !isValidEmail(value)) {
                isValid = false;
                field.style.border = "2px solid red";
                showError(field, "Please enter a valid email address.");

                if (!firstInvalidField) {
                    firstInvalidField = field; // Capture the first invalid field
                }
            } else {
                field.style.border = "";
                hideError(field);
            }
        });

        // Scroll to the first invalid field and focus on it
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: "smooth", block: "center" });
            firstInvalidField.focus();
        }

        return isValid;
    };


    const isValidEmail = (email) => {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
        return emailRegex.test(email);
    };

    const showError = (field, message) => {
        let error = field.nextElementSibling;
        if (!error || !error.classList.contains("error-message")) {
            error = document.createElement("span");
            error.classList.add("error-message");
            error.style.color = "red";
            field.parentNode.appendChild(error);
        }
        error.textContent = message;
    };

    const hideError = (field) => {
        const error = field.nextElementSibling;
        if (error && error.classList.contains("error-message")) {
            error.remove();
        }
    };

    nextBtn.addEventListener("click", () => {
        if (validateStepFields()) {
            if (currentStep < steps.length) {
                currentStep++;
                updateStepper();
            }
        }
    });

    document.getElementById("next_btn").addEventListener("click", () => {
        if (validateStepFields()) {
            if (currentStep < steps.length) {
                currentStep++;
                updateStepper();
            }
        }
    });

    updateStepper();

    // Phone field auto format
    // const phoneField = document.getElementById("phoneField");

    // phoneField.addEventListener("input", (e) => {
    //     let value = e.target.value.replace(/\D/g, "");

    //     if (value.length > 3) {
    //         value = value.slice(0, 3) + "" + value.slice(3);
    //     }
    //     if (value.length > 7) {
    //         value = value.slice(0, 7) + "" + value.slice(7);
    //     }

    //     if (value.length > 10) {
    //         value = value.slice(0, 10);
    //     }

    //     e.target.value = value;
    // });

    // phoneField.addEventListener("blur", () => {
    //     const value = phoneField.value.trim();
    //     if (!value.match(/^\d{3}[-\s]?\d{3}[-\s]?\d{4}$/)) {
    //         phoneField.style.border = "2px solid red";
    //         showError(
    //             phoneField,
    //             "Please enter a valid phone number in the format: 123 456 7890"
    //         );
    //     } else {
    //         phoneField.style.border = "";
    //         hideError(phoneField);
    //     }
    // });
});
