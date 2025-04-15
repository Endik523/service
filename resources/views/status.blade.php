@extends('layouts.auth')

@section('body')

    <div style="margin-top: 120px;">
        <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Masalah Kerusakan</h3>
    </div>

    <table class="tablee" style="max-width: 800px; margin: 0 auto;">
        <tbody>
            <tr>

                <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas harum nesciunt qui ullam nisi
                    voluptatibus cumque dicta ea hic impedit, quibusdam minus iure optio, sint officiis voluptatum eligendi
                    pariatur. Consectetur.
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam, dicta aut ut modi est et, minima
                    dignissimos provident accusamus commodi, facilis dolorem similique ex nesciunt iste? Illum, similique
                    ab! Ipsam.
                </td>

            </tr>
        </tbody>
    </table>


    <div style="margin-top: 80px;">
        <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Total Biaya</h3>
    </div>

    <table class="tablee" style="width: 100%; max-width: 500px; margin: 0 auto;">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID Order</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold;">1</td>
                <td>1133</td>
                <td>Cassing</td>
                <td>Rp 60.000</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">2</td>
                <td>1213</td>
                <td>battery</td>
                <td>Rp 200.000</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">2</td>
                <td>1213</td>
                <td>Lorem ipsum dolor sit amet consectetur adipisicin</td>
                <td>Rp 400.000</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Total</td>
                <td colspan="3" style="text-align:right;">Rp 660.000</td>
            </tr>
        </tbody>


    </table>

    <div class="mb-4" style="text-align: center; margin-top: 20px;">
        <button type="button" class="btn btn-outline-primary" style="width: 250px;">Batalkan Pesanan</button>
        <button type="button" class="btn btn-outline-primary " style="width: 250px;">Lanjutkan Pembayaran</button>
    </div>


@endsection
