@extends('layouts.auth')

@section('body')

<div class="d-flex justify-content-center fw-bold mt-3 sizefont">
   Total Biaya</div>
</div>

<div class="container text-center col-6 mt-3">
    <table class="table table-bordered border-primary">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Jenis Barang</th>
                <th>Harga</th>
            </tr>
        </thead>
         <tbody>
            <tr>
                <td>1</td>
                <td>LCD</td>
                <td>100.000</td>
            </tr>
             <tr>
                <td>1</td>
                <td>LCD</td>
                <td>100.000</td>
            </tr>
        </tbody>
</table>
</div>
<div class="text-center">*Keterangan :  Silahkan untuk memilih metode pembayaran</div>



@endsection


