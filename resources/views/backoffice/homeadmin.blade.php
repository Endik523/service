
@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-center text-center">
        <h1>Isi Formulir</h1>
    </div>

<table class="table table-bordered table-striped rounded">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>No</th>
                        <th>ID Order</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jenis Barang</th>
                        <th>Masalah Kerusakan</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $no=0;

                    @endphp
                     @foreach ($data_admin as $item )
                     @php
                     $no++;
                    //    // ID Order yang ada di database
                    //  $id_order = $item->id_order ?? rand(1000, 9999);
                     $status = 'pending';
                     @endphp
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $item->id_order }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->barang }}</td>
                <td>{{ $item->pesan }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->tgl_pesan }}</td>
                <td>{{ $status }}</td>

                <td>
                            <a href="{{ route('kerusakan') }}" class="btn btn-sm btn-primary"><i class="fas fa-code-branch"></i></a>
                                    <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="#" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger float" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i></button>
                                      </form>
                        </td>
            </tr>

            @endforeach
                    {{-- <tr>
                        <td>{{ session('admin_data.id', 'N/A') }}</td>
                        <td>{{ session('admin_data.username', 'N/A') }}</td>
                        <td>{{ session('admin_data.barang', 'N/A') }}</td>
                        <td>{{ session('admin_data.pesan', 'N/A') }}</td>
                        <td>{{ session('admin_data.tgl_pesan', 'N/A') }}</td>
                        <td>{{ session('admin_data.status', 'N/A') }}</td>
                        <td>
                            <a href="{{ route('kerusakan') }}" class="btn btn-sm btn-primary"><i class="fas fa-code-branch"></i></a>
                                    <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="#" method="post" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger float" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i></button>
                                      </form>
                        </td>

                    </tr> --}}

                </tbody>

            </table>

@endsection
