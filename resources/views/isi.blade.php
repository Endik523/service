@extends('layouts.auth')

<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; margin-top: 70px;">
    <div class="card shadow-sm rounded-4" style="width: 700px;">
        <div class="card-body">
            <h3 class="text-center mb-4">Isi Formulir</h3>
            <form action="{{ route('isi.store') }}" method="POST" id="contactForm">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Nama</label>
                    <input type="text" id="username" name="username" class="form-control w-100" required />
                </div>

                <div class="mb-3">
                    <label for="barang" class="form-label fw-bold">Jenis Barang</label>
                    <select id="barang" name="barang" class="form-select w-100" required>
                        <option selected disabled>Masukkan Jenis Barang...</option>
                        <option value="hp">Handphone</option>
                        <option value="laptop">Laptop</option>
                        <option value="printer">Printer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label fw-bold">Alamat Tempat Tinggal</label>
                    <input type="text" id="alamat" name="alamat" class="form-control w-100" required />
                </div>

                <div class="mb-3">
                    <label for="tgl_pesan" class="form-label fw-bold">Tanggal Service</label>
                    <input type="date" id="tgl_pesan" name="tgl_pesan" class="form-control w-100" required />
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

{{-- Script kirim form --}}
<script>
    document.getElementById('contactForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch("{{ route('isi.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server error: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Sukses:', data);

                if (data.success) {
                    // Kode WhatsApp redirect
                    var username = document.getElementById('username').value;
                    var barang = document.getElementById('barang').value;
                    var alamat = document.getElementById('alamat').value;
                    var tgl_pesan = document.getElementById('tgl_pesan').value;
                    var pesan = document.getElementById('pesan').value;

                    var whatsapp_url = "https://api.whatsapp.com/send?phone=6285755060739&text=Hai%20Admin.%0ANama%20Saya%20%3A%20*" +
                        encodeURIComponent(username) + "*%0ABarang%20Saya%20%3A%20*" +
                        encodeURIComponent(barang) + "*%0AAlamat%20%3A%20*" +
                        encodeURIComponent(alamat) + "*%0ATanggal%20Service%20%3A%20*" +
                        encodeURIComponent(tgl_pesan) + "*%0A%0A*Keluhan*%3A%0A" +
                        encodeURIComponent(pesan);

                    window.open(whatsapp_url, '_blank');
                } else {
                    alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
    });
    event.preventDefault();

    var formData = new FormData(this);
    formData.append('_token', '{{ csrf_token() }}');

    console.log('Mengirim permintaan ke:', "{{ route('isi.store') }}");
    console.log('Data yang dikirim:', Object.fromEntries(formData));

    fetch("{{ route('isi.store') }}", {
        method: "POST",
        body: formData
    })
        .then(response => {
            console.log('Status respons:', response.status);
            console.log('Headers respons:', Object.fromEntries(response.headers.entries()));

            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Respons error:', text);
                    throw new Error('Server mengembalikan status ' + response.status + ': ' + response.statusText);
                });
            }
            return response.text();
        })
        .then(text => {
            console.log('Respons mentah:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON tidak valid:', e);
                throw new Error('Server tidak mengembalikan JSON yang valid');
            }
        })
        .then(data => {
            console.log('Data berhasil diproses:', data);
            if (data.success) {
                // Kode untuk WhatsApp tetap sama
                var username = document.getElementById('username').value;
                var barang = document.getElementById('barang').value;
                var alamat = document.getElementById('alamat').value;
                var tgl_pesan = document.getElementById('tgl_pesan').value;
                var pesan = document.getElementById('pesan').value;

                var whatsapp_url = "https://api.whatsapp.com/send?phone=6285755060739&text=Hai%20Admin.%0ANama%20Saya%20%3A%20*" +
                    encodeURIComponent(username) + "*%0ABarang%20Saya%20%3A%20*" +
                    encodeURIComponent(barang) + "*%0AAlamat%20%3A%20*" +
                    encodeURIComponent(alamat) + "*%0ATanggal%20Service%20%3A%20*" +
                    encodeURIComponent(tgl_pesan) + "*%0A%0A*Keluhan*%3A%0A" +
                    encodeURIComponent(pesan);

                var newWindow = window.open(whatsapp_url, '_blank');
                if (newWindow) {
                    newWindow.focus();
                } else {
                    alert("Popup diblokir, harap izinkan popup untuk melanjutkan.");
                }
            } else {
                alert("Terjadi kesalahan: " + (data.message || "Tidak ada detail error"));
            }
        })
        .catch(error => {
            console.error('Error lengkap:', error);
            alert("Terjadi kesalahan: " + error.message);
        });
    });
</script>

{{-- <style>
    body {
        background-color: $secondary-color;
        display: flex;
        justify-content: center;
        min-height: 100vh;
        padding: 10px;
    }
</style> --}}
