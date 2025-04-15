@extends('layouts.auth')

@section('body')

    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; margin-top: 70px;">
        <div class="card shadow-sm rounded-4" style="width: 700px;">
            <div class="card-body">
                <h3 class="text-center mb-4">Isi Formulir</h3>

                <!-- Pesan sukses - awalnya tersembunyi -->
                <div id="successMessage" class="alert alert-success text-center" style="display: none;">
                    Data pesanan berhasil disimpan!
                    <div class="mt-3">
                        <button id="whatsappButton" class="btn btn-success">
                            <i class="fab fa-whatsapp"></i> Lanjutkan ke WhatsApp
                        </button>
                    </div>
                </div>

                <form action="{{ route('isi.store') }}" method="POST" id="contactForm">
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Nama</label>
                        <input type="text" id="username" name="username" class="form-control w-100" required />
                    </div>

                    <div class="mb-3">
                        <label for="barang" class="form-label fw-bold">Jenis Barang</label>
                        <select id="barang" name="barang" class="form-select w-100" required>
                            <option value="" selected disabled>Masukkan Jenis Barang...</option>
                            <option value="Handphone">Handphone</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Printer">Printer</option>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="tgl_pesan" class="form-label fw-bold">Tanggal Service</label>
                        <input type="date" id="tgl_pesan" name="tgl_pesan" class="form-control w-100" required />
                    </div>

                    <div class="mb-3">
                        <label for="jemput_barang" class="form-label fw-bold">Jemput Barang</label>
                        <select id="jemput_barang" name="jemput_barang" class="form-select w-100" required>
                            <option value="" selected disabled>Jemput Barang di Rumah...</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div class="mb-3" id="alamatContainer" style="display: none;">
                        <label for="alamat" class="form-label fw-bold">Alamat Tempat Tinggal</label>
                        <input type="text" id="alamat" name="alamat" class="form-control w-100" />
                    </div>

                    <div class="mb-3">
                        <label for="pesan" class="form-label fw-bold">Masalah Kerusakan</label>
                        <textarea id="pesan" name="pesan" rows="4" class="form-control w-100" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Kirim Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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
                encodeURIComponent(formValues.username) + "*%0ABarang%20Saya%20%3A%20*" +
                encodeURIComponent(formValues.barang) + "*%0AAlamat%20%3A%20*" +
                encodeURIComponent(formValues.alamat) + "*%0ATanggal%20Service%20%3A%20*" +
                encodeURIComponent(formValues.tgl_pesan) + "*%0A%0A*Jemput%20Barang%20Di%20Rumah*%3A%0A" +
                encodeURIComponent(formValues.jemput_barang) + "*%0A%0A*Keluhan*%3A%0A" +
                encodeURIComponent(formValues.pesan);

            // Buka WhatsApp di tab baru - ini akan berhasil karena dipicu oleh klik pengguna
            window.open(whatsappUrl, '_blank');
        });
    });
</script>
