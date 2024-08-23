@extends('komponen.index')

@section('content')
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Cart Items Table -->
            <div class="col-lg-8">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $cartItem)
                                <tr>
                                    <td class="align-middle">
                                        <div class="cart-product">
                                            <img src="{{ asset('storage/' . $cartItem->product->img) }}" alt="Product Image" style="width: 50px;">
                                            <span class="cart-product-name">{{ $cartItem->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle" data-price="{{ $cartItem->product->price }}">
                                        {{ "Rp." . number_format($cartItem->product->price, 2, ",", ".") }}
                                    </td> <td class="align-middle" data-price="{{ $cartItem->product->size }}">
                                        {{ ($cartItem->product->size) }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <input type="number" class="form-control form-control-sm bg-secondary text-center quantity-input"
                                                value="{{ $cartItem->qty }}" min="1">
                                        </div>
                                    </td>
                                    <td class="align-middle total-price">
                                        {{ "Rp." . number_format($cartItem->product->price * $cartItem->qty, 2, ",", ".") }}
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('removecart', ['id' => $cartItem->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium" id="cart-subtotal">
                                {{ "Rp." . number_format($subtotal, 2, ",", ".") }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="cart-total">
                                {{ "Rp." . number_format($total, 2, ",", ".") }}
                            </h5>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="spacer"></div>

    <!-- Styles -->
    <style>
        .cart-table-wrap {
            overflow-x: auto;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table thead th {
            background-color: #f7f7f7;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-table tbody td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-product {
            display: flex;
            align-items: center;
        }

        .cart-product img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .cart-product-name {
            font-size: 16px;
            font-weight: bold;
        }

        .spacer {
            height: 200px;
        }
    </style>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateCartSummary = () => {
                let subtotal = 0;
                document.querySelectorAll('.quantity-input').forEach(input => {
                    const quantity = parseInt(input.value, 10);
                    const price = parseFloat(input.closest('tr').querySelector('td[data-price]').getAttribute('data-price'));
                    const totalCell = input.closest('tr').querySelector('.total-price');
                    const total = quantity * price;

                    totalCell.textContent = Rp.${total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')};
                    subtotal += total;
                });

                document.getElementById('cart-subtotal').textContent = Rp.${subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')};
                const shippingCost = 0; // Update this if you have shipping costs
                const total = subtotal + shippingCost;
                document.getElementById('cart-total').textContent = Rp.${total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')};
            };

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', updateCartSummary);
            });

            updateCartSummary(); // Initial call to set the correct values on load
        });
    </script>
@endsection
