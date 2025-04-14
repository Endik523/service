@extends('layouts.app')

@section('content')
<div class="main-content">
    <h2>Masukan Pesanan Service Anda</h2>

    <form action="#" method="POST">
        @csrf
        <div class="form-group">
            <label>Masukan Nama</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Masukan Email</label>
            <input type="email" name="email" placeholder="name@example.com" required>
        </div>

        <div class="form-group">
            <label>Jenis Barang</label>
            <input type="text" name="service_type" required>
        </div>

        <div class="form-group">
            <label>Tanggal Pesan</label>
            <input type="date" name="date" required>
        </div>

        <div class="form-group">
            <label>Masalah Kerusakan</label>
            <textarea name="description" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn">Kirim</button>
    </form>

    <h3>Pesanan Anda</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Barang</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceRequests as $key => $request)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $request->name }}</td>
                <td>{{ $request->service_type }}</td>
                <td>{{ $request->date }}</td>
                <td>{{ $request->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
