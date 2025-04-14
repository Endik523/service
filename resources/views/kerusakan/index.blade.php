@extends('layouts.app')

@section('content')
<a href="{{ route('kerusakan.create') }}" class="btn btn-primary mb-3">Tambah</a>


{{-- <table class="table table-bordered table-striped rounded">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>No</th>
                        <th>ID Order</th>
                        <th>User</th>
                        <th>Kerusakan</th>
                        <th>Jumlah Item</th>
                        <th>Jenis Barang</th>
                        <th>Harga</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $no=0;

                    @endphp
                     @foreach ($kerusakan as $item )
                     @php
                     $no++;
                     @endphp
            <tr>
                <td>{{ $no }}</td>
                <td>{{ optional($item->admin)->id_order ?? 'N/A' }}</td>
                <td>{{ optional($item->admin)->username ?? 'N/A' }}</td>
                <td>{{ $item->kerusakan }}</td>
                <td>{{ $item->jumlah_item }}</td>
                <td>{{ $item->jenis_barang }}</td>
                <td>{{ $item->harga }}</td>
                <td>

                                    <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="#" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger float" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i></button>
                                      </form>
                        </td>
            </tr>

            @endforeach

                </tbody>

            </table> --}}

            {{-- <table class="table table-bordered table-striped rounded">
    <thead class="bg-dark text-white">
        <tr>
            <th>No</th>
            <th>ID Order</th>
            <th>User</th>
            <th>Jenis Barang</th>
            <th>Jumlah Item</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no=0; @endphp
        @foreach ($kerusakan as $item)
            @php $no++; @endphp
            @foreach ($item->items as $barang)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ optional($item->admin)->id_order ?? 'N/A' }}</td>
                    <td>{{ optional($item->admin)->username ?? 'N/A' }}</td>
                    <td>{{ $barang->jenis_barang }}</td>
                    <td>{{ $barang->jumlah_item }}</td>
                    <td>{{ number_format($barang->harga, 2, ',', '.') }}</td>
                    <td>

                                    <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="#" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger float" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i></button>
                                      </form>
                        </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table> --}}

<table class="table table-bordered table-striped rounded">
    <thead class="bg-dark text-white">
        <tr>
            <th>No</th>
            <th>ID Order</th>
            <th>User</th>
            <th>Kerusakan</th>
            <th>Jenis Barang</th>
            <th>Jumlah Item</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 0; @endphp
        @foreach ($kerusakan as $item)
            @if ($item->items->count() > 0) {{-- Hanya tampilkan jika ada barang --}}
                @php $no++; @endphp
                @php $rowspan = $item->items->count(); @endphp

                <tr>
                    <td rowspan="{{ $rowspan }}">{{ $no }}</td>
                    <td rowspan="{{ $rowspan }}">{{ optional($item->admin)->id_order ?? 'N/A' }}</td>
                    <td rowspan="{{ $rowspan }}">{{ optional($item->admin)->username ?? 'N/A' }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $item->kerusakan }}</td>
                    <td>{{ $item->items[0]->jenis_barang }}</td>
                    <td>{{ $item->items[0]->jumlah_item }}</td>
                    <td>{{ number_format($item->items[0]->harga, 2, ',', '.') }}</td>
                    <td rowspan="{{ $rowspan }}">
                        <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="#" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger float" onclick="return confirm('Yakin?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                @for ($i = 1; $i < $rowspan; $i++)
                    <tr>
                        <td>{{ $item->items[$i]->jenis_barang }}</td>
                        <td>{{ $item->items[$i]->jumlah_item }}</td>
                        <td>{{ number_format($item->items[$i]->harga, 2, ',', '.') }}</td>
                    </tr>
                @endfor
            @endif
        @endforeach
    </tbody>
</table>




@endsection

@push('script')

@endpush
