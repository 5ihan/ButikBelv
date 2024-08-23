@extends('komponen.index')
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="body-main col-md-8">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <img class="img" alt="Invoice Template" src="http://pngimg.com/uploads/shopping_cart/shopping_cart_PNG59.png" />
                </div>
                <div class="col-md-8 text-right">
                    <h4 style="color: #F81D2D;"><strong>Butik Belv</strong></h4>
                    <p>Pondok Serut Tangerang Selatan</p>
                    <p>+62-857-1768-2902</p>
                    <p>fajar@gmail.com</p>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>INVOICE</h2><br>
                    <h5> {{ $order->code_order }}</h5>
                </div>
            </div>
            <br />
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th><h5>Items</h5></th>
                            <th><h5>Amount</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-9">Product</td>
                            <td class="col-md-3"> Rp. {{ number_format($order->total_price, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <p><strong>Total Price + PPN 10% :</strong></p>
                                <p><strong>Shipment and Taxes :</strong></p>
                            </td>
                            <td>
                                <p><strong> Rp. {{ number_format($order->total_price, 2, ',', '.') }}</strong></p>
                                <p><strong>Rp. {{ number_format($order->shippingcost, 2, ',', '.') }}</strong></p>
                            </td>
                        </tr>
                        <tr style="color: #F81D2D;">
                            <td class="text-right"><h4><strong>Total:</strong></h4></td>
                            <td class="text-left"><h4><strong> Rp. {{ number_format($order->total, 2, ',', '.') }}</strong></h4></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <div class="col-md-12">
                    <p><b>Date :</b> {{ $order->created_at->format('d M Y') }}</p>
                    <br />
                    <p><b>Butik Belv</b></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .body-main {
        background: #ffffff;
        border-bottom: 15px solid #1E1F23;
        border-top: 15px solid #1E1F23;
        padding: 40px 30px;
        position: relative;
        box-shadow: 0 1px 21px #808080;
        font-size: 14px; /* Perbesar font size agar lebih proporsional */
    }

    .table thead {
        background: #1E1F23;
        color: #fff;
    }

    .table tbody tr td {
        border-bottom: 1px solid #ddd;
    }

    .img {
        height: 100px;
    }

    h1, h2 {
        text-align: center;
        font-family: Arial, sans-serif;
    }
</style>

@endsection
