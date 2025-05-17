// Session handler for registration form
(() => {
    const STORAGE_KEY = "pendaftaran_session";
    let isLoaded = false;
    const debugMode = true; // Set to true to enable console logging

    function log(...args) {
        if (debugMode) {
            console.log("[SessionHandler]", ...args);
        }
    }

    function logError(...args) {
        if (debugMode) {
            console.error("[SessionHandler]", ...args);
        }
    }

    // Save form data to localStorage whenever it changes
    function saveFormData(formData) {
        try {
            if (typeof window !== "undefined") {
                // Always ensure the current step is saved
                formData.step = getCurrentStep();

                localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
                log("Data saved to localStorage", formData);

                // Also send to server for session storage
                const csrfToken =
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "";

                fetch("/pendaftaran/save-session", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify(formData),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `Server responded with ${response.status}`
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        log("Data saved to server session", data);
                    })
                    .catch((err) => {
                        logError("Failed to save session to server:", err);
                    });
            }
        } catch (error) {
            logError("Error in saveFormData:", error);
        }
    }

    // Load form data from localStorage on page load
    function loadFormData() {
        try {
            if (typeof window !== "undefined") {
                log("Loading form data...");

                // First check localStorage for immediate restoration
                // This helps prevent flashing of the initial step
                const localData = localStorage.getItem(STORAGE_KEY);
                if (localData) {
                    try {
                        const parsedData = JSON.parse(localData);
                        if (parsedData && parsedData.step) {
                            // Immediately restore the step to prevent flashing
                            showStep(parsedData.step);
                            log(
                                "Step immediately restored from localStorage:",
                                parsedData.step
                            );
                        }
                    } catch (e) {
                        logError("Error parsing localStorage data:", e);
                    }
                }

                const csrfToken =
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "";

                // Then try to get saved data from server session
                fetch("/pendaftaran/get-session", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `Server responded with ${response.status}`
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        log("Data retrieved from server session", data);

                        if (data && Object.keys(data).length > 0) {
                            restoreFormState(data);
                            isLoaded = true;
                            log("Form state restored from server session");
                        } else {
                            // Fall back to localStorage if server session is empty
                            const savedData = localStorage.getItem(STORAGE_KEY);
                            if (savedData) {
                                try {
                                    const parsedData = JSON.parse(savedData);
                                    restoreFormState(parsedData);
                                    log(
                                        "Form state restored from localStorage",
                                        parsedData
                                    );
                                    isLoaded = true;
                                } catch (e) {
                                    logError(
                                        "Error parsing localStorage data:",
                                        e
                                    );
                                }
                            } else {
                                log("No saved data found");
                            }
                            isLoaded = true;
                        }
                    })
                    .catch((err) => {
                        logError("Failed to get session from server:", err);

                        // Fall back to localStorage
                        const savedData = localStorage.getItem(STORAGE_KEY);
                        if (savedData) {
                            try {
                                const parsedData = JSON.parse(savedData);
                                restoreFormState(parsedData);
                                log(
                                    "Form state restored from localStorage (after server error)",
                                    parsedData
                                );
                            } catch (e) {
                                logError("Error parsing localStorage data:", e);
                            }
                        }
                        isLoaded = true;
                    })
                    .finally(() => {
                        // Set up form field change handlers
                        setupFormFieldListeners();

                        // Set up step change listeners
                        setupStepChangeListeners();

                        // Set up success step observer
                        setupSuccessStepObserver();

                        log("Event listeners set up");
                    });
            }
        } catch (error) {
            logError("Error in loadFormData:", error);
        }
    }

    // Restore form state from saved data
    function restoreFormState(formData) {
        try {
            log("Restoring form state with data:", formData);

            // First handle the step to ensure it's shown before filling in data
            if (formData.step) {
                showStep(formData.step);
                log(`Restored step: ${formData.step}`);
            }

            // Restore form field values
            Object.entries(formData).forEach(([key, value]) => {
                if (key === "step") {
                    // Already handled above
                    return;
                } else if (key === "calon_santri_id") {
                    // Store calonSantriId in a global variable
                    if (typeof window !== "undefined") {
                        window.calonSantriId = value;
                        log(`Set calonSantriId: ${value}`);
                    }
                } else {
                    // Restore field values
                    const element = document.getElementById(key);
                    if (element) {
                        if (element.type === "radio") {
                            const radioButton = document.querySelector(
                                `input[name="${key}"][value="${value}"]`
                            );
                            if (radioButton) {
                                radioButton.checked = true;
                                log(`Set radio ${key} to ${value}`);

                                // Handle payment type selection UI
                                if (key === "payment_type") {
                                    updatePaymentTypeUI(value);
                                }
                            } else {
                                log(
                                    `Radio button not found for ${key}=${value}`
                                );
                            }
                        } else {
                            element.value = value;
                            log(`Set field ${key} to ${value}`);
                        }
                    } else {
                        log(`Element not found for ${key}`);
                    }
                }
            });

            // Update checking step data if we have form data
            if (formData.nama) {
                updateCheckingStepData(formData);
                log("Updated checking step data");
            }
        } catch (error) {
            logError("Error in restoreFormState:", error);
        }
    }

    // Set up listeners for form field changes
    function setupFormFieldListeners() {
        try {
            const formFields = document.querySelectorAll(
                ".form-input, .form-textarea, input[type='radio'], input[type='checkbox']"
            );

            log(`Setting up listeners for ${formFields.length} form fields`);

            formFields.forEach((field) => {
                field.addEventListener("change", () => {
                    log(`Field changed: ${field.id || field.name}`);
                    const formData = collectFormData();
                    saveFormData(formData);
                });

                if (
                    field.type === "text" ||
                    field.type === "textarea" ||
                    field.tagName.toLowerCase() === "textarea"
                ) {
                    field.addEventListener("input", () => {
                        log(`Field input: ${field.id || field.name}`);
                        const formData = collectFormData();
                        saveFormData(formData);
                    });
                }
            });
        } catch (error) {
            logError("Error in setupFormFieldListeners:", error);
        }
    }

    // Set up listeners for step changes
    function setupStepChangeListeners() {
        try {
            // Listen for all buttons that might change steps
            const stepButtons = document.querySelectorAll(
                "[id^='submit-'], [id^='back-to-'], .step-button, .next-step, .prev-step"
            );

            log(`Setting up listeners for ${stepButtons.length} step buttons`);

            stepButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    log(
                        `Step button clicked: ${button.id || button.className}`
                    );

                    // Save immediately with current step
                    const currentFormData = collectFormData();
                    saveFormData(currentFormData);

                    // Then wait a bit and check if step changed
                    setTimeout(() => {
                        const newStep = getCurrentStep();
                        log(`Current step after click: ${newStep}`);

                        // If step changed, save again with new step
                        if (newStep !== currentFormData.step) {
                            const updatedFormData = collectFormData();
                            saveFormData(updatedFormData);
                            log(
                                `Step changed from ${currentFormData.step} to ${newStep}, saving updated data`
                            );
                        }
                    }, 300); // Longer timeout to ensure step transition completes
                });
            });

            // Also listen for form submissions that might change steps
            const forms = document.querySelectorAll("form");
            forms.forEach((form) => {
                form.addEventListener("submit", () => {
                    log("Form submitted, saving current state");
                    const formData = collectFormData();
                    saveFormData(formData);

                    // Also set up a check after submission
                    setTimeout(() => {
                        const newStep = getCurrentStep();
                        log(`Step after form submission: ${newStep}`);

                        // Save again with potentially new step
                        const updatedFormData = collectFormData();
                        saveFormData(updatedFormData);
                    }, 500); // Even longer timeout for form submission
                });
            });
        } catch (error) {
            logError("Error in setupStepChangeListeners:", error);
        }
    }

    // Set up observer for success step
    function setupSuccessStepObserver() {
        try {
            const successStep = document.getElementById("step-berhasil");
            if (successStep) {
                log("Setting up observer for success step");

                const observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (
                            mutation.type === "attributes" &&
                            mutation.attributeName === "class"
                        ) {
                            const element = mutation.target;
                            if (element.classList.contains("active")) {
                                log("Success step is active, clearing session");
                                clearSession();
                            }
                        }
                    });
                });

                observer.observe(successStep, { attributes: true });
            } else {
                log("Success step element not found");
            }
        } catch (error) {
            logError("Error in setupSuccessStepObserver:", error);
        }
    }

    // Get the current active step
    function getCurrentStep() {
        try {
            const activeStep = document.querySelector(".step-section.active");
            if (activeStep) {
                return activeStep.id.replace("step-", "");
            }

            // Alternative method to find active step
            const visibleStep = document.querySelector(
                ".step-section[style*='display: block']"
            );
            if (visibleStep) {
                return visibleStep.id.replace("step-", "");
            }

            // Another alternative - check which step has active class
            const activeStepIndicator = document.querySelector(".step.active");
            if (activeStepIndicator) {
                return (
                    activeStepIndicator.getAttribute("data-step") || "formulir"
                );
            }

            log('No active step found, defaulting to "formulir"');
            return "formulir"; // Default
        } catch (error) {
            logError("Error in getCurrentStep:", error);
            return "formulir";
        }
    }

    // Show a specific step
    function showStep(stepId) {
        try {
            log(`Showing step: ${stepId}`);

            // Hide all steps
            document.querySelectorAll(".step-section").forEach((section) => {
                section.classList.remove("active");
                // Also handle display style if that's how steps are shown/hidden
                section.style.display = "none";
            });

            // Show the requested step
            const stepElement = document.getElementById(`step-${stepId}`);
            if (stepElement) {
                stepElement.classList.add("active");
                // Also set display style
                stepElement.style.display = "block";
                log(`Step ${stepId} activated`);
            } else {
                log(`Step element not found for ${stepId}`);
            }

            // Update step indicators
            document.querySelectorAll(".step").forEach((step) => {
                step.classList.remove("active", "completed");
            });

            const steps = ["formulir", "checking", "pembayaran", "berhasil"];
            const currentIndex = steps.indexOf(stepId);

            steps.forEach((step, index) => {
                const stepElement = document.querySelector(
                    `.step[data-step="${step}"]`
                );
                if (stepElement) {
                    if (index < currentIndex) {
                        stepElement.classList.add("completed");
                        log(`Step ${step} marked as completed`);
                    } else if (index === currentIndex) {
                        stepElement.classList.add("active");
                        log(`Step ${step} marked as active`);
                    }
                } else {
                    log(`Step indicator not found for ${step}`);
                }
            });

            // Dispatch a custom event that step has changed
            window.dispatchEvent(
                new CustomEvent("stepChanged", { detail: { step: stepId } })
            );
        } catch (error) {
            logError("Error in showStep:", error);
        }
    }

    // Collect form data from all inputs
    function collectFormData() {
        try {
            const formData = {
                step: getCurrentStep(),
            };

            // Get form fields
            const nameField = document.getElementById("nama");
            if (nameField) formData.nama = nameField.value;

            const tempatLahirField = document.getElementById("tempat_lahir");
            if (tempatLahirField)
                formData.tempat_lahir = tempatLahirField.value;

            const tanggalLahirField = document.getElementById("tanggal_lahir");
            if (tanggalLahirField)
                formData.tanggal_lahir = tanggalLahirField.value;

            const alamatField = document.getElementById("alamat");
            if (alamatField) formData.alamat = alamatField.value;

            const namaAyahField = document.getElementById("nama_ayah");
            if (namaAyahField) formData.nama_ayah = namaAyahField.value;

            const namaIbuField = document.getElementById("nama_ibu");
            if (namaIbuField) formData.nama_ibu = namaIbuField.value;

            const noWhatsappField = document.getElementById("no_whatsapp");
            if (noWhatsappField) formData.no_whatsapp = noWhatsappField.value;

            const asalSekolahField = document.getElementById("asal_sekolah");
            if (asalSekolahField)
                formData.asal_sekolah = asalSekolahField.value;

            // Get radio button value
            const genderRadio = document.querySelector(
                'input[name="jenis_kelamin"]:checked'
            );
            if (genderRadio) formData.jenis_kelamin = genderRadio.value;

            // Get payment type value if on payment step
            const paymentRadio = document.querySelector(
                'input[name="payment_type"]:checked'
            );
            if (paymentRadio) {
                formData.payment_type = paymentRadio.value;
            }

            // Get calon santri ID if it exists
            if (typeof window !== "undefined" && window.calonSantriId) {
                formData.calon_santri_id = window.calonSantriId;
            }

            log("Collected form data:", formData);
            return formData;
        } catch (error) {
            logError("Error in collectFormData:", error);
            return { step: "formulir" };
        }
    }

    // Update checking step with collected form data
    function updateCheckingStepData(formData) {
        try {
            log("Updating checking step data");

            if (document.getElementById("checking-nama")) {
                document.getElementById("checking-nama").textContent =
                    formData.nama || "";
            }

            let ttl = "";
            if (formData.tempat_lahir && formData.tanggal_lahir) {
                const date = new Date(formData.tanggal_lahir);
                ttl = `${formData.tempat_lahir}, ${date.toLocaleDateString(
                    "id-ID"
                )}`;
            }

            if (document.getElementById("checking-ttl")) {
                document.getElementById("checking-ttl").textContent = ttl;
            }

            if (document.getElementById("checking-jenis-kelamin")) {
                document.getElementById("checking-jenis-kelamin").textContent =
                    formData.jenis_kelamin || "";
            }

            if (document.getElementById("checking-alamat")) {
                document.getElementById("checking-alamat").textContent =
                    formData.alamat || "";
            }

            if (document.getElementById("checking-nama-ayah")) {
                document.getElementById("checking-nama-ayah").textContent =
                    formData.nama_ayah || "";
            }

            if (document.getElementById("checking-nama-ibu")) {
                document.getElementById("checking-nama-ibu").textContent =
                    formData.nama_ibu || "";
            }

            if (document.getElementById("checking-no-whatsapp")) {
                document.getElementById("checking-no-whatsapp").textContent =
                    formData.no_whatsapp || "";
            }

            if (document.getElementById("checking-asal-sekolah")) {
                document.getElementById("checking-asal-sekolah").textContent =
                    formData.asal_sekolah || "";
            }
        } catch (error) {
            logError("Error in updateCheckingStepData:", error);
        }
    }

    // Update payment type UI based on selection
    function updatePaymentTypeUI(value) {
        try {
            log(`Updating payment type UI for: ${value}`);

            const paymentOptions = document.querySelectorAll(
                ".payment-type-option"
            );
            paymentOptions.forEach((option) => {
                option.classList.remove("selected");

                if (option.id === `payment-${value.toLowerCase()}`) {
                    option.classList.add("selected");
                    log(`Selected payment option: ${option.id}`);
                }
            });
        } catch (error) {
            logError("Error in updatePaymentTypeUI:", error);
        }
    }

    // Clear session when form is successfully submitted
    function clearSession() {
        try {
            log("Clearing session data");

            if (typeof window !== "undefined") {
                localStorage.removeItem(STORAGE_KEY);
                log("Cleared localStorage");

                // Clear server session too
                const csrfToken =
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "";

                fetch("/pendaftaran/clear-session", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `Server responded with ${response.status}`
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        log("Server session cleared", data);
                    })
                    .catch((err) => {
                        logError("Failed to clear server session:", err);
                    });
            }
        } catch (error) {
            logError("Error in clearSession:", error);
        }
    }

    // Initialize the session handler when the DOM is loaded
    document.addEventListener("DOMContentLoaded", () => {
        log("DOM loaded, initializing session handler");
        loadFormData();
    });

    // Also listen for page load event (in case DOMContentLoaded already fired)
    if (document.readyState === "complete") {
        log("Page already loaded, initializing session handler");
        loadFormData();
    } else {
        window.addEventListener("load", () => {
            log("Window loaded, initializing session handler");
            loadFormData();
        });
    }

    // Expose functions for debugging
    window.sessionHandler = {
        saveFormData,
        loadFormData,
        clearSession,
        collectFormData,
        getCurrentStep,
        showStep,
    };
})();
