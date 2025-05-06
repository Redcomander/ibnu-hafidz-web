<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Accordion functionality
        const accordionHeaders = document.querySelectorAll('.accordion-header');
        accordionHeaders.forEach(header => {
            header.addEventListener('click', function () {
                // Toggle active class on header
                this.classList.toggle('active');

                // Get the content element
                const content = this.nextElementSibling;

                // Toggle active class on content
                if (content.classList.contains('active')) {
                    content.classList.remove('active');
                    content.style.maxHeight = 0;
                } else {
                    content.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });
        });

        // File upload preview
        const paymentProofInput = document.getElementById('payment_proof');
        if (paymentProofInput) {
            paymentProofInput.addEventListener('change', function (e) {
                const previewContainer = document.getElementById('preview-container');
                const previewImage = document.getElementById('preview-image');
                const uploadIcon = document.getElementById('upload-icon');
                const uploadText = document.getElementById('upload-text');

                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        uploadIcon.classList.add('hidden');
                        uploadText.textContent = 'Ganti gambar';
                    }

                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }

        // Form submission handlers
        setupFormulirForm();
        setupVerifikasiForm();
        setupPembayaranForm();
    });

    // Global variable to store calon santri data
    let calonSantriData = {};

    function setupFormulirForm() {
        const formulirForm = document.getElementById('formulir-form');
        if (!formulirForm) return;

        formulirForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Show loading state
            const submitBtn = document.getElementById('submit-formulir');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');

            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            // Get form data
            const formData = new FormData(formulirForm);

            // AJAX request
            fetch('{{ route("pendaftaran.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Store data for next step
                        calonSantriData = data.calonSantri;

                        // Load verifikasi step
                        loadVerifikasiStep();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);

                        // Reset button state
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');

                    // Reset button state
                    btnText.classList.remove('hidden');
                    btnLoading.classList.add('hidden');
                });
        });
    }

    function setupVerifikasiForm() {
        const verifikasiBtn = document.getElementById('submit-verifikasi');
        if (!verifikasiBtn) return;

        verifikasiBtn.addEventListener('click', function () {
            // Show loading state
            const btnText = verifikasiBtn.querySelector('.btn-text');
            const btnLoading = verifikasiBtn.querySelector('.btn-loading');

            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            // AJAX request
            fetch('{{ route("pendaftaran.storeVerifikasi") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    calon_santri_id: calonSantriData.id
                }),
                credentials: 'same-origin'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update data for next step
                        calonSantriData = data.calonSantri;

                        // Load pembayaran step
                        loadPembayaranStep();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);

                        // Reset button state
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memverifikasi data. Silakan coba lagi.');

                    // Reset button state
                    btnText.classList.remove('hidden');
                    btnLoading.classList.add('hidden');
                });
        });
    }

    function setupPembayaranForm() {
        const pembayaranForm = document.getElementById('pembayaran-form');
        if (!pembayaranForm) return;

        pembayaranForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Show loading state
            const submitBtn = document.getElementById('submit-pembayaran');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');

            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            // Get form data
            const formData = new FormData(pembayaranForm);
            formData.append('calon_santri_id', calonSantriData.id);

            // AJAX request
            fetch('{{ route("pendaftaran.storePembayaran") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update data for next step
                        calonSantriData = data.calonSantri;

                        // Load selesai step
                        loadSelesaiStep();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);

                        // Reset button state
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengunggah bukti pembayaran. Silakan coba lagi.');

                    // Reset button state
                    btnText.classList.remove('hidden');
                    btnLoading.classList.add('hidden');
                });
        });
    }

    function loadVerifikasiStep() {
        fetch('{{ route("pendaftaran.verifikasi") }}')
            .then(response => response.text())
            .then(html => {
                document.getElementById('registration-container').innerHTML = html;

                // Initialize AOS for new content
                AOS.refresh();

                // Populate verification data
                document.getElementById('verifikasi-nama').textContent = calonSantriData.nama;
                document.getElementById('verifikasi-tempat-tanggal-lahir').textContent =
                    `${calonSantriData.tempat_lahir}, ${formatDate(calonSantriData.tanggal_lahir)}`;
                document.getElementById('verifikasi-jenis-kelamin').textContent = calonSantriData.jenis_kelamin;
                document.getElementById('verifikasi-alamat').textContent = calonSantriData.alamat;
                document.getElementById('verifikasi-nama-ayah').textContent = calonSantriData.nama_ayah;
                document.getElementById('verifikasi-nama-ibu').textContent = calonSantriData.nama_ibu;
                document.getElementById('verifikasi-no-whatsapp').textContent = calonSantriData.no_whatsapp;
                document.getElementById('verifikasi-asal-sekolah').textContent = calonSantriData.asal_sekolah;

                // Setup verifikasi form
                setupVerifikasiForm();

                // Scroll to top of the form
                document.getElementById('form-pendaftaran').scrollIntoView({ behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat halaman verifikasi. Silakan coba lagi.');
            });
    }

    function loadPembayaranStep() {
        fetch('{{ route("pendaftaran.pembayaran") }}')
            .then(response => response.text())
            .then(html => {
                document.getElementById('registration-container').innerHTML = html;

                // Initialize AOS for new content
                AOS.refresh();

                // Set calon santri ID
                document.getElementById('calon_santri_id').value = calonSantriData.id;

                // Setup pembayaran form
                setupPembayaranForm();

                // Scroll to top of the form
                document.getElementById('form-pendaftaran').scrollIntoView({ behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat halaman pembayaran. Silakan coba lagi.');
            });
    }

    function loadSelesaiStep() {
        fetch('{{ route("pendaftaran.selesai") }}')
            .then(response => response.text())
            .then(html => {
                document.getElementById('registration-container').innerHTML = html;

                // Initialize AOS for new content
                AOS.refresh();

                // Set nomor pendaftaran
                document.getElementById('nomor-pendaftaran').textContent =
                    `PSB-${String(calonSantriData.id).padStart(4, '0')}`;

                // Scroll to top of the form
                document.getElementById('form-pendaftaran').scrollIntoView({ behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat halaman selesai. Silakan coba lagi.');
            });
    }

    function formatDate(dateString) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }
</script>
