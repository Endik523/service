@extends('layouts.app')

@section('content')

<form action="{{ route('kerusakan.store') }}" method="POST">
    @csrf

    <input type="hidden" name="order_id" value="{{ session('admin_data.id_order') }}">

    <div class="form-group col-6">
        <label for="kerusakan" class="mb-1">Masukkan Kerusakan</label>
        <textarea id="kerusakan" name="kerusakan" class="form-control" required></textarea>
    </div>

    <div class="form-group mt-4">
        <select name="admin_id" class="mb-3 col-6" required>
            <option disabled value>Pilih User</option>
            @foreach ($admin as $item)
                <option value="{{ $item->id }}">{{ $item->username }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-1 mt-4">
        <h4>Tambah Barang</h4>
    </div>

    <div id="barang-container">
        <div class="barang-row">
            <input type="number" name="jumlah_item[]" class="form-control mb-2" placeholder="Jumlah Item" required>
            <input type="text" name="jenis_barang[]" class="form-control mb-2" placeholder="Jenis Barang" required>
            <input type="number" name="harga[]" class="form-control mb-2" placeholder="Harga" step="0.01" required>
        </div>
    </div>

    <button type="button" class="btn btn-success" onclick="addBarang()">Tambah Barang</button>
    <button type="submit" class="btn btn-primary mt-4">Submit</button>
</form>

@endsection



<script>
function addBarang() {
    let container = document.getElementById("barang-container");
    let newRow = document.createElement("div");
    newRow.classList.add("barang-row");
    newRow.innerHTML = `
        <input type="number" name="jumlah_item[]" class="form-control mb-2" placeholder="Jumlah Item" required>
        <input type="text" name="jenis_barang[]" class="form-control mb-2" placeholder="Jenis Barang" required>
        <input type="number" name="harga[]" class="form-control mb-2" placeholder="Harga" step="0.01" required>
        <button type="button" class="btn btn-danger" onclick="removeBarang(this)">Hapus</button>
    `;
    container.appendChild(newRow);
}

function removeBarang(button) {
    button.parentElement.remove();
}
</script>

