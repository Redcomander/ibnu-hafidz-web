// Session handler for registration form
(() => {
    const STORAGE_KEY = "pendaftaran_session";
    let isLoaded = false;

    // Save form data to localStorage whenever it changes
    function saveFormData(formData) {
        if (typeof window !== "undefined") {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));

            // Also send to server for session storage
            fetch("/pendaftaran/save-session", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
                body: JSON.stringify(formData),
            }).catch((err) =>
                console.error("Failed to save session to server:", err)
            );
        }
    }

    // Load form data from localStorage on page load
    function loadFormData() {
        if (typeof window !== "undefined") {
            // First try to get saved data from server session
            fetch("/pendaftaran/get-session", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data && Object.keys(data).length > 0) {
                        restoreFormState(data);
                        isLoaded = true;
                    } else {
                        // Fall back to localStorage if server session is empty
                        const savedData = localStorage.getItem(STORAGE_KEY);
                        if (savedData) {
                            restoreFormState(JSON.parse(savedData));
                        }
                        isLoaded = true;
                    }
                })
                .catch((err) => {
                    console.error("Failed to get session from server:", err);

                    // Fall back to localStorage
                    const savedData = localStorage.getItem(STORAGE_KEY);
                    if (savedData) {
                        restoreFormState(JSON.parse(savedData));
                    }
                    isLoaded = true;
                });

            // Set up form field change handlers
            setupFormFieldListeners();

            // Set up step change listeners
            setupStepChangeListeners();

            // Set up success step observer
            setupSuccessStepObserver();
        }
    }

    // Restore form state from saved data
    function restoreFormState(formData) {
        // Restore form field values
        Object.entries(formData).forEach(([key, value]) => {
            if (key === "step") {
                // Handle step separately
                showStep(value);
            } else if (key === "calon_santri_id") {
                // Store calonSantriId in a global variable
                if (typeof window !== "undefined") {
                    window.calonSantriId = value;
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

                            // Handle payment type selection UI
                            if (key === "payment_type") {
                                updatePaymentTypeUI(value);
                            }
                        }
                    } else {
                        element.value = value;
                    }
                }
            }
        });

        // Update checking step data if we have form data
        if (formData.nama) {
            updateCheckingStepData(formData);
        }
    }

    // Set up listeners for form field changes
    function setupFormFieldListeners() {
        const formFields = document.querySelectorAll(
            ".form-input, .form-textarea, input[type='radio'], input[type='checkbox']"
        );

        formFields.forEach((field) => {
            field.addEventListener("change", () => {
                const formData = collectFormData();
                saveFormData(formData);
            });

            if (field.type === "text" || field.type === "textarea") {
                field.addEventListener("input", () => {
                    const formData = collectFormData();
                    saveFormData(formData);
                });
            }
        });
    }

    // Set up listeners for step changes
    function setupStepChangeListeners() {
        const stepButtons = document.querySelectorAll(
            "[id^='submit-'], [id^='back-to-']"
        );

        stepButtons.forEach((button) => {
            button.addEventListener("click", () => {
                setTimeout(() => {
                    const currentStep = getCurrentStep();

                    // Save the current step
                    const formData = collectFormData();
                    formData.step = currentStep;
                    saveFormData(formData);
                }, 100);
            });
        });
    }

    // Set up observer for success step
    function setupSuccessStepObserver() {
        const successStep = document.getElementById("step-berhasil");
        if (successStep) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (
                        mutation.type === "attributes" &&
                        mutation.attributeName === "class"
                    ) {
                        const element = mutation.target;
                        if (element.classList.contains("active")) {
                            clearSession();
                        }
                    }
                });
            });

            observer.observe(successStep, { attributes: true });
        }
    }

    // Get the current active step
    function getCurrentStep() {
        const activeStep = document.querySelector(".step-section.active");
        if (activeStep) {
            return activeStep.id.replace("step-", "");
        }
        return "formulir"; // Default
    }

    // Show a specific step
    function showStep(stepId) {
        // Hide all steps
        document.querySelectorAll(".step-section").forEach((section) => {
            section.classList.remove("active");
        });

        // Show the requested step
        const stepElement = document.getElementById(`step-${stepId}`);
        if (stepElement) {
            stepElement.classList.add("active");
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
                } else if (index === currentIndex) {
                    stepElement.classList.add("active");
                }
            }
        });
    }

    // Collect form data from all inputs
    function collectFormData() {
        const formData = {
            step: getCurrentStep(),
        };

        // Get form fields
        const nameField = document.getElementById("nama");
        if (nameField) formData.nama = nameField.value;

        const tempatLahirField = document.getElementById("tempat_lahir");
        if (tempatLahirField) formData.tempat_lahir = tempatLahirField.value;

        const tanggalLahirField = document.getElementById("tanggal_lahir");
        if (tanggalLahirField) formData.tanggal_lahir = tanggalLahirField.value;

        const alamatField = document.getElementById("alamat");
        if (alamatField) formData.alamat = alamatField.value;

        const namaAyahField = document.getElementById("nama_ayah");
        if (namaAyahField) formData.nama_ayah = namaAyahField.value;

        const namaIbuField = document.getElementById("nama_ibu");
        if (namaIbuField) formData.nama_ibu = namaIbuField.value;

        const noWhatsappField = document.getElementById("no_whatsapp");
        if (noWhatsappField) formData.no_whatsapp = noWhatsappField.value;

        const asalSekolahField = document.getElementById("asal_sekolah");
        if (asalSekolahField) formData.asal_sekolah = asalSekolahField.value;

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

        return formData;
    }

    // Update checking step with collected form data
    function updateCheckingStepData(formData) {
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
    }

    // Update payment type UI based on selection
    function updatePaymentTypeUI(value) {
        const paymentOptions = document.querySelectorAll(
            ".payment-type-option"
        );
        paymentOptions.forEach((option) => {
            option.classList.remove("selected");

            if (option.id === `payment-${value.toLowerCase()}`) {
                option.classList.add("selected");
            }
        });
    }

    // Clear session when form is successfully submitted
    function clearSession() {
        if (typeof window !== "undefined") {
            localStorage.removeItem(STORAGE_KEY);

            // Clear server session too
            fetch("/pendaftaran/clear-session", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
            }).catch((err) =>
                console.error("Failed to clear server session:", err)
            );
        }
    }

    // Initialize the session handler when the DOM is loaded
    document.addEventListener("DOMContentLoaded", loadFormData);
})();
