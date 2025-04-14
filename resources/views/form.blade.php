@extends('layouts.auth')

@section('body')
    <div class="py-5">
        <div class="row justify-content-center">
            <div style="width: 100%"> {{-- Lebar card bisa disesuaikan --}}
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Isi Formulir</h3>
                        <form action="{{ route('admin') }}" method="POST" id="contactForm">
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold">Nama</label>
                                <input type="text" id="username" name="username" class="form-control w-100" required />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" id="email" name="email" class="form-control w-100" required />
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
        </div>
    </div>

    {{-- Script kirim form --}}
    <script>
        document.getElementById('contactForm').addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('admin') }}", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var username = document.getElementById('username').value;
                        var email = document.getElementById('email').value;
                        var barang = document.getElementById('barang').value;
                        var alamat = document.getElementById('alamat').value;
                        var tgl_pesan = document.getElementById('tgl_pesan').value;
                        var pesan = document.getElementById('pesan').value;

                        var whatsapp_url = "https://web.whatsapp.com/send?phone=6285755060739&text=Haii..%20Admin.%0ANama%20Saya%20%3A%20*" +
                            encodeURIComponent(username) + "*%0AEmail%20Saya%20%3A%20*" +
                            encodeURIComponent(email) + "*%0AJenis%20Barang%20%3A%20*" +
                            encodeURIComponent(barang) + "*%0AAlamat%20%3A%20*" +
                            encodeURIComponent(alamat) + "*%0ATanggal%20Service%20%3A%20*" +
                            encodeURIComponent(tgl_pesan) + "*%0A%0A*Keluhan*%3A%0A" +
                            encodeURIComponent(pesan);

                        window.open(whatsapp_url, '_blank');
                        window.location.href = data.redirect_url;
                    } else {
                        alert("Terjadi kesalahan saat mengirim data. Silakan coba lagi.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
