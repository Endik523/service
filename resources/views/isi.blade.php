@extends('layouts.auth')

@section('body')
    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; margin-top: 70px;">
        <div class="card shadow-sm rounded-4" style="width: 700px;">
            <div class="card-body">
                <h3 class="text-center mb-4">Isi Formulir</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
@endsection

<script>
    document.getElementById('contactForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Mengambil nilai dari form
        var username = document.getElementById('username').value;
        var barang = document.getElementById('barang').value;
        var alamat = document.getElementById('alamat').value;
        var tgl_pesan = document.getElementById('tgl_pesan').value;
        var pesan = document.getElementById('pesan').value;

        var formData = new FormData(this);

        // Simpan URL WhatsApp dalam variabel
        var whatsapp_url = "https://web.whatsapp.com/send?phone=6285755060739&text=Hai%20Admin.%0ANama%20Saya%20%3A%20*" +
            encodeURIComponent(username) + "*%0ABarang%20Saya%20%3A%20*" +
            encodeURIComponent(barang) + "*%0AAlamat%20%3A%20*" +
            encodeURIComponent(alamat) + "*%0ATanggal%20Service%20%3A%20*" +
            encodeURIComponent(tgl_pesan) + "*%0A%0A*Keluhan*%3A%0A" +
            encodeURIComponent(pesan);


        console.log('Mengirim data ke server...');

        // Kirim data ke server
        fetch("{{ route('isi.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json()) // Langsung ambil response sebagai JSON
            .then(data => {
                console.log('Sukses:', data);

                // Menambahkan delay sebelum redirect untuk menghindari pemblokiran browser
                setTimeout(function () {
                    // Coba buka WhatsApp di tab baru
                    var newWindow = window.open(whatsapp_url, '_blank');

                    // Jika tab baru tidak bisa dibuka (popup blocker), fallback menggunakan window.location.href
                    if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                        console.log("Tab baru diblokir, mengalihkan menggunakan window.location.href");
                        window.location.href = whatsapp_url; // Pengalihan menggunakan URL langsung
                    }
                }, 500); // Delay 500ms untuk menghindari pemblokiran oleh browser

                // Reset form setelah berhasil
                document.getElementById('contactForm').reset();
            })

            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan dalam pengiriman data.');
            });
    });
</script>
