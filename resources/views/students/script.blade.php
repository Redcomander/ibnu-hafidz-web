<script>
    function confirmDelete(id) {
        document.getElementById('deleteForm').action = `/admin/student/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Mass selection and deletion
    function toggleAllCheckboxes() {
        const masterCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.student-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.checked = masterCheckbox.checked;
        });

        updateSelectedCount();
    }

    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.student-checkbox:checked').length;
        const countElement = document.getElementById('selected-count');
        const actionBar = document.getElementById('mass-action-bar');

        if (selectedCount > 0) {
            countElement.textContent = selectedCount;
            actionBar.classList.remove('hidden');
        } else {
            actionBar.classList.add('hidden');
        }
    }

    function confirmMassDelete() {
        const selectedIds = Array.from(document.querySelectorAll('.student-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            return;
        }

        document.getElementById('mass-delete-ids').value = JSON.stringify(selectedIds);
        document.getElementById('massDeleteModal').classList.remove('hidden');
    }

    function closeMassDeleteModal() {
        document.getElementById('massDeleteModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function (event) {
        const deleteModal = document.getElementById('deleteModal');
        const massDeleteModal = document.getElementById('massDeleteModal');
        const studentDetailModal = document.getElementById('studentDetailModal');

        if (event.target == deleteModal) {
            closeModal();
        }
        if (event.target == massDeleteModal) {
            closeMassDeleteModal();
        }
        if (studentDetailModal && event.target == studentDetailModal) {
            closeStudentModal();
        }
    }

    // Close modal with escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
            closeMassDeleteModal();
            if (typeof closeStudentModal === 'function') {
                closeStudentModal();
            }
        }
    });

    // Toggle additional filters
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFiltersBtn = document.getElementById('toggleFilters');
        if (toggleFiltersBtn) {
            toggleFiltersBtn.addEventListener('click', function () {
                const filtersSection = document.getElementById('additionalFilters');
                const isHidden = filtersSection.classList.contains('hidden');

                if (isHidden) {
                    filtersSection.classList.remove('hidden');
                    this.querySelector('svg').classList.add('rotate-180');
                } else {
                    filtersSection.classList.add('hidden');
                    this.querySelector('svg').classList.remove('rotate-180');
                }
            });
        }

        // Clear filters
        const clearFiltersBtn = document.getElementById('clearFilters');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function () {
                const form = this.closest('form');
                const inputs = form.querySelectorAll('input:not([type="submit"]), select');

                inputs.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });

                // Clear active filters
                document.getElementById('activeFilters').innerHTML = '';
            });
        }

        // Refresh stats
        const refreshStatsBtn = document.getElementById('refreshStats');
        if (refreshStatsBtn) {
            refreshStatsBtn.addEventListener('click', function() {
                // Add loading state
                this.disabled = true;
                this.innerHTML = `
                    <svg class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Refreshing...
                `;

                // Reload the page to refresh stats
                window.location.reload();
            });
        }

        // Initialize checkboxes
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
    });

    // Remove filter chip
    function removeFilter(filterName) {
        document.querySelector(`[name="${filterName}"]`).value = '';
        document.querySelector('form').submit();
    }

    // Student Detail Modal Functions
    function showStudentDetails(id) {
        const modal = document.getElementById('studentDetailModal');
        const content = document.getElementById('studentDetailContent');
        const editLink = document.getElementById('editStudentLink');

        // Show modal
        modal.classList.add('show');

        // Set edit link
        editLink.href = `/admin/student/${id}/edit`;

        // Fetch student details with modal parameter
        fetch(`/admin/student/${id}?modal=true`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Render student details
                renderStudentDetails(data.student);
            })
            .catch(error => {
                content.innerHTML = `
                    <div class="p-4 bg-red-50 dark:bg-red-900/30 rounded-lg">
                        <p class="text-red-600 dark:text-red-400">Error loading student details: ${error.message}</p>
                        <p class="mt-2 text-sm">Please check your browser console for more details.</p>
                    </div>
                `;
                console.error('Error fetching student details:', error);
            });
    }

    function closeStudentModal() {
        const modal = document.getElementById('studentDetailModal');
        modal.classList.remove('show');
    }

    function renderStudentDetails(student) {
        const content = document.getElementById('studentDetailContent');

        // Format dates
        const formatDate = (dateString) => {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        };

        // Get student status class
        const getStatusClass = (status) => {
            if (!status) return 'active';
            return status.toLowerCase();
        };

        // Create HTML content
        let html = `
                    <div class="student-profile-header">
                        <div class="student-profile-photo">
                            ${student.profile_photo
                ? `<img src="/storage/${student.profile_photo}" alt="${student.nama_lengkap}" class="w-full h-full object-cover">`
                : student.nama_lengkap.charAt(0)
            }
                        </div>
                        <div class="student-profile-info">
                            <h2 class="student-profile-name">${student.nama_lengkap}</h2>
                            <p class="student-profile-meta">
                                ${student.tempat_lahir || ''} ${student.tanggal_lahir ? ', ' + formatDate(student.tanggal_lahir) : ''}
                            </p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="student-profile-badge ${getStatusClass(student.status)}">
                                    ${student.status ? student.status.charAt(0).toUpperCase() + student.status.slice(1) : 'Active'}
                                </span>
                                <span class="student-profile-badge ${student.jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-pink-100 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400'}">
                                    ${student.jenis_kelamin === 'Laki-laki' ? 'Male' : 'Female'}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="tab-container">
                        <div class="tab-buttons">
                            <button type="button" class="tab-button active" onclick="switchTab(event, 'personal-info')">Personal Info</button>
                            <button type="button" class="tab-button" onclick="switchTab(event, 'academic-info')">Academic Info</button>
                            <button type="button" class="tab-button" onclick="switchTab(event, 'family-info')">Family Info</button>
                            <button type="button" class="tab-button" onclick="switchTab(event, 'address-info')">Address</button>
                            <button type="button" class="tab-button" onclick="switchTab(event, 'other-info')">Other Info</button>
                        </div>

                        <div id="personal-info" class="tab-content active">
                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Personal Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Full Name</div>
                                        <div class="student-detail-value">${student.nama_lengkap || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">NIS</div>
                                        <div class="student-detail-value">${student.nis || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">NISN</div>
                                        <div class="student-detail-value">${student.nisn || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Gender</div>
                                        <div class="student-detail-value">${student.jenis_kelamin || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Birth Place</div>
                                        <div class="student-detail-value">${student.tempat_lahir || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Birth Date</div>
                                        <div class="student-detail-value">${formatDate(student.tanggal_lahir)}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Religion</div>
                                        <div class="student-detail-value">${student.agama || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Nationality</div>
                                        <div class="student-detail-value">${student.kewarganegaraan || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">NIK</div>
                                        <div class="student-detail-value">${student.nik || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">No. KK</div>
                                        <div class="student-detail-value">${student.no_kk || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">No. Akte</div>
                                        <div class="student-detail-value">${student.no_akte || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Height</div>
                                        <div class="student-detail-value">${student.tinggi_badan ? student.tinggi_badan + ' cm' : '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Weight</div>
                                        <div class="student-detail-value">${student.berat_badan ? student.berat_badan + ' kg' : '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Child Number</div>
                                        <div class="student-detail-value">${student.anak_ke || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Number of Siblings</div>
                                        <div class="student-detail-value">${student.jumlah_anak || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Child Status</div>
                                        <div class="student-detail-value">${student.status_anak || '-'}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="academic-info" class="tab-content">
                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Academic Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Major</div>
                                        <div class="student-detail-value">${student.jurusan || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Previous School</div>
                                        <div class="student-detail-value">${student.sekolah_asal || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Graduation Year</div>
                                        <div class="student-detail-value">${student.tahun_kelulusan || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">UN Participant Number</div>
                                        <div class="student-detail-value">${student.no_peserta_un || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Diploma Serial Number</div>
                                        <div class="student-detail-value">${student.no_seri_ijazah || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">SKHUN Number</div>
                                        <div class="student-detail-value">${student.no_skhun || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Student Status</div>
                                        <div class="student-detail-value">${student.status_santri || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Other Status</div>
                                        <div class="student-detail-value">${student.status_santri_other || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Entry Date</div>
                                        <div class="student-detail-value">${formatDate(student.tanggal_masuk_pondok)}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Registration Type</div>
                                        <div class="student-detail-value">${student.jenis_pendaftaran || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">ANBK</div>
                                        <div class="student-detail-value">${student.anbk || '-'}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="family-info" class="tab-content">
                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Father's Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Father's Name</div>
                                        <div class="student-detail-value">${student.nama_ayah || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Father's NIK</div>
                                        <div class="student-detail-value">${student.nik_ayah || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Father's Birth Year</div>
                                        <div class="student-detail-value">${student.tahun_lahir_ayah || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Father's Education</div>
                                        <div class="student-detail-value">${student.pendidikan_ayah || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Father's Graduation Year</div>
                                        <div class="student-detail-value">${student.tahun_lulus_ayah || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Father's Occupation</div>
                                        <div class="student-detail-value">${student.pekerjaan_ayah || '-'}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Mother's Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Mother's Name</div>
                                        <div class="student-detail-value">${student.nama_ibu || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Mother's NIK</div>
                                        <div class="student-detail-value">${student.nik_ibu || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Mother's Birth Year</div>
                                        <div class="student-detail-value">${student.tahun_lahir_ibu || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Mother's Education</div>
                                        <div class="student-detail-value">${student.pendidikan_ibu || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Mother's Graduation Year</div>
                                        <div class="student-detail-value">${student.tahun_lulus_ibu || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Mother's Occupation</div>
                                        <div class="student-detail-value">${student.pekerjaan_ibu || '-'}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="address-info" class="tab-content">
                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Address Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item col-span-full">
                                        <div class="student-detail-label">Address</div>
                                        <div class="student-detail-value">${student.alamat || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">RT</div>
                                        <div class="student-detail-value">${student.rt || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">RW</div>
                                        <div class="student-detail-value">${student.rw || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Village/Kelurahan</div>
                                        <div class="student-detail-value">${student.desa_kelurahan || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">District/Kecamatan</div>
                                        <div class="student-detail-value">${student.kecamatan || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">City/Regency</div>
                                        <div class="student-detail-value">${student.kabupaten_kota || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Province</div>
                                        <div class="student-detail-value">${student.provinsi || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Postal Code</div>
                                        <div class="student-detail-value">${student.kode_pos || '-'}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Contact Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Phone Number</div>
                                        <div class="student-detail-value">
                                            ${student.no_hp_telpon
                ? `<a href="tel:${student.no_hp_telpon}" class="text-indigo-600 dark:text-indigo-400 hover:underline">${student.no_hp_telpon}</a>`
                : '-'
            }
                                        </div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Email</div>
                                        <div class="student-detail-value">
                                            ${student.email
                ? `<a href="mailto:${student.email}" class="text-indigo-600 dark:text-indigo-400 hover:underline">${student.email}</a>`
                : '-'
            }
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="other-info" class="tab-content">
                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Social Assistance Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">KKS Number</div>
                                        <div class="student-detail-value">${student.no_kks || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">KPS Recipient</div>
                                        <div class="student-detail-value">${student.penerima_kps || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">KPS Number</div>
                                        <div class="student-detail-value">${student.no_kps || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">KIP Number</div>
                                        <div class="student-detail-value">${student.no_kip || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Name on KIP</div>
                                        <div class="student-detail-value">${student.nama_di_kip || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Received Physical Card</div>
                                        <div class="student-detail-value">${student.terima_fisik || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Insurance Card</div>
                                        <div class="student-detail-value">${student.kartu_jaminan || '-'}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="student-detail-section">
                                <h3 class="text-lg font-medium text-slate-800 dark:text-white mb-4">Additional Information</h3>
                                <div class="student-detail-grid">
                                    <div class="student-detail-item col-span-full">
                                        <div class="student-detail-label">Notes</div>
                                        <div class="student-detail-value">${student.ket || '-'}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Created At</div>
                                        <div class="student-detail-value">${formatDate(student.created_at)}</div>
                                    </div>
                                    <div class="student-detail-item">
                                        <div class="student-detail-label">Last Updated</div>
                                        <div class="student-detail-value">${formatDate(student.updated_at)}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

        content.innerHTML = html;
    }

    function switchTab(event, tabId) {
        // Hide all tab contents
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(tab => tab.classList.remove('active'));

        // Remove active class from all tab buttons
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => button.classList.remove('active'));

        // Show the selected tab content
        document.getElementById(tabId).classList.add('active');

        // Add active class to the clicked button
        event.currentTarget.classList.add('active');
    }
</script>
