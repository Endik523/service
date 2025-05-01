@extends('layouts.auth')

@section('body')
    <div class="form-container">
        <div class="card shadow-lg rounded-3" style="max-width: 800px;">
            <div class="card-header bg-primary text-white rounded-top-3 py-3">
                <h3 class="text-center mb-0">
                    <i class="fas fa-tools me-2"></i>Formulir Layanan Service
                </h3>
            </div>

            <div class="card-body p-4 p-md-5">
                <!-- Success Message -->
                <div id="successMessage" class="alert alert-success text-center p-4" style="display: none;">
                    <div class="success-icon mb-3">
                        <i class="fas fa-check-circle fa-4x text-success"></i>
                    </div>
                    <h4 class="alert-heading">Pesanan Berhasil Disimpan!</h4>
                    <p>Kami akan segera menghubungi Anda untuk konfirmasi lebih lanjut.</p>
                    <div class="mt-4">
                        <button id="whatsappButton" class="btn btn-success btn-lg mb-2">
                            <i class="fab fa-whatsapp me-2"></i> Lanjutkan ke WhatsApp
                        </button>
                        <button id="newOrderButton" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-plus me-2"></i> Pesan Baru
                        </button>
                    </div>
                </div>

                <!-- Main Form -->
                <form action="{{ route('isi.store') }}" method="POST" id="contactForm" class="needs-validation" novalidate>
                    @csrf

                    <div class="row g-3">
                        <!-- Personal Information Section -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Nama Lengkap" required>
                                <label for="username" class="fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                                </label>
                                <div class="invalid-feedback">
                                    Mohon isi nama Anda
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="no_telp" name="no_telp"
                                    placeholder="Nomor Telepon" required>
                                <label for="no_telp" class="fw-semibold">
                                    <i class="fas fa-phone me-2 text-primary"></i>Nomor Telepon
                                </label>
                                <div class="invalid-feedback">
                                    Mohon isi nomor telepon yang aktif
                                </div>
                            </div>
                        </div>

                        <!-- Product Information Section -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="barang" name="barang" required>
                                    <option value="" selected disabled>Pilih...</option>
                                    <option value="Handphone">Handphone</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Printer">Printer</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <label for="barang" class="fw-semibold">
                                    <i class="fas fa-laptop me-2 text-primary"></i>Jenis Barang
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="brand" name="brand" placeholder="Merek Barang">
                                <label for="brand" class="fw-semibold">
                                    <i class="fas fa-tag me-2 text-primary"></i>Merek Barang
                                </label>
                            </div>
                        </div>

                        <!-- Service Details Section -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" required>
                                <label for="tgl_pesan" class="fw-semibold">
                                    <i class="far fa-calendar-alt me-2 text-primary"></i>Tanggal Service
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="jemput_barang" name="jemput_barang" required>
                                    <option value="" selected disabled>Pilih...</option>
                                    <option value="yes">Ya, jemput ke alamat saya</option>
                                    <option value="no">Tidak, saya akan antar sendiri</option>
                                </select>
                                <label for="jemput_barang" class="fw-semibold">
                                    <i class="fas fa-truck me-2 text-primary"></i>Jemput Barang
                                </label>
                            </div>
                        </div>

                        <!-- Address Field (Conditional) -->
                        <div class="col-12" id="alamatContainer" style="display: none;">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat Lengkap"
                                    style="height: 100px"></textarea>
                                <label for="alamat" class="fw-semibold">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Alamat Lengkap
                                </label>
                                <small class="text-muted">Mohon sertakan detail alamat (jalan, RT/RW, kecamatan)</small>
                            </div>
                        </div>

                        <!-- Problem Description -->
                        <div class="col-12">
                            <div class="form-floating mb-4">
                                <textarea class="form-control" id="pesan" name="pesan" placeholder="Deskripsi Kerusakan"
                                    style="height: 120px" required></textarea>
                                <label for="pesan" class="fw-semibold">
                                    <i class="fas fa-exclamation-triangle me-2 text-primary"></i>Deskripsi Kerusakan
                                </label>
                                <small class="text-muted">Jelaskan gejala kerusakan sejelas mungkin</small>
                            </div>
                        </div>

                        <!-- Photo Upload -->
                        <div class="col-12 mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-camera me-2 text-primary"></i>Foto Kerusakan (Opsional)
                            </label>
                            <div class="dropzone border rounded-2 p-3 text-center" id="photoDropzone">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Seret & lepas foto disini atau klik untuk memilih</p>
                                <small class="text-muted">Format: JPG/PNG (Maks. 2MB per foto)</small>
                                <input type="file" id="damagePhotos" name="damagePhotos[]" multiple class="d-none"
                                    accept="image/*">
                            </div>
                            <div id="previewContainer" class="mt-2 d-flex flex-wrap gap-2"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan Service
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .form-container {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .form-floating label {
            color: #495057;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            padding: 1rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .dropzone {
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dropzone:hover {
            background-color: #e9ecef;
            border-color: #86b7fe;
        }

        .preview-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .btn-lg {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <script>
        // Form validation
        (function () {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Show/hide address field based on pickup selection
        document.getElementById('jemput_barang').addEventListener('change', function () {
            const addressContainer = document.getElementById('alamatContainer');
            addressContainer.style.display = this.value === 'yes' ? 'block' : 'none';

            if (this.value === 'yes') {
                document.getElementById('alamat').setAttribute('required', '');
            } else {
                document.getElementById('alamat').removeAttribute('required');
            }
        });

        // Photo upload preview
        const dropzone = document.getElementById('photoDropzone');
        const fileInput = document.getElementById('damagePhotos');
        const previewContainer = document.getElementById('previewContainer');

        dropzone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function () {
            previewContainer.innerHTML = '';

            if (this.files.length > 3) {
                alert('Maksimal 3 foto yang dapat diupload');
                this.value = '';
                return;
            }

            Array.from(this.files).forEach(file => {
                if (!file.type.match('image.*')) {
                    alert('Hanya file gambar yang diperbolehkan');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.className = 'preview-thumbnail';
                    previewContainer.appendChild(preview);
                }
                reader.readAsDataURL(file);
            });
        });

        // Drag and drop for photos
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropzone.classList.add('bg-light');
        }

        function unhighlight() {
            dropzone.classList.remove('bg-light');
        }

        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }

        // Form submission handling
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Simulate form submission
            setTimeout(() => {
                this.style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';

                // Scroll to success message
                document.getElementById('successMessage').scrollIntoView({
                    behavior: 'smooth'
                });
            }, 1500);
        });

        // New order button
        document.getElementById('newOrderButton')?.addEventListener('click', function () {
            document.getElementById('successMessage').style.display = 'none';
            document.getElementById('contactForm').style.display = 'block';
            document.getElementById('contactForm').reset();
            document.getElementById('contactForm').classList.remove('was-validated');
            previewContainer.innerHTML = '';
        });
    </script>
@endsection



{{--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contactForm = document.getElementById('contactForm');
        const successMessage = document.getElementById('successMessage');
        const whatsappButton = document.getElementById('whatsappButton');

        contactForm.addEventListener('submit', function (event) {
            event.preventDefault();

            // Validasi form sebelum submit
            if (!contactForm.checkValidity()) {
                event.stopPropagation();
                contactForm.classList.add('was-validated');
                return;
            }

            // Ambil semua nilai form dengan benar
            const formValues = {
                username: document.getElementById('username').value,
                no_telp: document.getElementById('no_telp').value,
                // damage_photos: document.getElementById('damage_photos').value,
                barang: document.getElementById('barang').value,
                alamat: document.getElementById('alamat').value || '-', // default jika kosong
                tgl_pesan: document.getElementById('tgl_pesan').value,
                jemput_barang: document.getElementById('jemput_barang').value,
                pesan: document.getElementById('pesan').value,
                user_id: {{ auth() -> id() ?? 'null'
        }} // Pastikan user sudah login
        };


    // Kirim data via Fetch API
    const formData = new FormData(contactForm);

    fetch(contactForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            contactForm.style.display = 'none';
            successMessage.style.display = 'block';

            // Buat pesan WhatsApp
            const whatsappUrl = `https://wa.me/6285755060739?text=${encodeURIComponent(`Hai Admin.
                                            Nama Saya : *${formValues.username}*
                                            Nomor Saya : *${formValues.no_telp}*
                                            Barang Saya : *${formValues.barang}*
                                            Alamat Saya : *${formValues.alamat}*
                                            Tanggal Service : *${formValues.tgl_pesan}*

                                            Jemput Barang Di Rumah:
                                            *${formValues.jemput_barang}*

                                            *Keluhan*:
                                            ${formValues.pesan}`)
                }`;

            whatsappButton.onclick = () => window.open(whatsappUrl, '_blank');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        });
        });
    });
</script> --}}



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contactForm = document.getElementById('contactForm');
        const successMessage = document.getElementById('successMessage');
        const whatsappButton = document.getElementById('whatsappButton');
        const jemputBarangSelect = document.getElementById('jemput_barang');
        const alamatContainer = document.getElementById('alamatContainer');

        // Menyembunyikan alamat container saat halaman pertama kali dimuat
        alamatContainer.style.display = 'none';

        // Fungsi untuk mengontrol visibilitas input alamat
        jemputBarangSelect.addEventListener('change', function () {
            if (this.value === 'yes') {
                alamatContainer.style.display = 'block';  // Menampilkan alamat
            } else {
                alamatContainer.style.display = 'none';   // Menyembunyikan alamat
            }
        });

        // Menyimpan referensi data form
        let formValues = {};

        contactForm.addEventListener('submit', function (event) {
            event.preventDefault();

            // Simpan semua nilai form
            formValues = {
                username: document.getElementById('username').value,
                barang: document.getElementById('barang').value,
                alamat: document.getElementById('alamat').value,
                tgl_pesan: document.getElementById('tgl_pesan').value,
                jemput_barang: document.getElementById('jemput_barang').value,
                no_telp: document.getElementById('no_telp').value,
                pesan: document.getElementById('pesan').value
            };

            // Kirim data ke server menggunakan fetch
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Sukses:', data);

                    // Sembunyikan form
                    contactForm.style.display = 'none';

                    // Tampilkan pesan sukses dan tombol WhatsApp
                    successMessage.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                });
        });

        // Event listener untuk tombol WhatsApp
        whatsappButton.addEventListener('click', function () {
            // Buat URL WhatsApp dengan data form yang tersimpan
            const whatsappUrl = "https://web.whatsapp.com/send?phone=6285755060739&text=Hai%20Admin.%0ANama%20Saya%20%3A%20*" +
                encodeURIComponent(formValues.username) + "*%0ANomor%20Saya%20%3A%20*" +
                encodeURIComponent(formValues.no_telp) + "*%0ABarang%20Saya%20%3A%20*" +
                encodeURIComponent(formValues.barang) + "*%0AAlamat%20Saya%20%3A%20*" +
                encodeURIComponent(formValues.alamat) + "*%0ATanggal%20Service%20%3A%20*" +
                encodeURIComponent(formValues.tgl_pesan) + "*%0A%0AJemput%20Barang%20Di%20Rumah%3A%0A*" +
                encodeURIComponent(formValues.jemput_barang) + "*%0A%0A*Keluhan*%3A%0A" +
                encodeURIComponent(formValues.pesan);

            // Buka WhatsApp di tab baru - ini akan berhasil karena dipicu oleh klik pengguna
            window.open(whatsappUrl, '_blank');
        });
    });
</script>
