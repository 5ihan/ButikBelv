@extends('komponen.index')

@section('content')
    <!-- Checkout Start -->
    <div class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container">
            <div class="row flex-row flex-start">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Full Name</label>
                                <input class="form-control" type="text" placeholder="John"
                                    value="{{ $customer->name }}"readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" placeholder="example@email.com"
                                    value="{{ $customer->email }}" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" placeholder="+62 813 123"
                                    value="0{{ $customer->phone }}"readonly>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Full Address</label>
                                <input class="form-control" type="text" placeholder="123 Street"
                                    value="{{ $customer->address }}"readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <input class="form-control" type="text" value="Indonesia"readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" placeholder="123"readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header ">
                            <h4 class="mt-4 mtext-109 cl2 p-b-30">Cart Totals</h4>

                        </div>
                        <div class="card-body">
                            <!-- List of Products in the Cart -->
                            <h5 class="stext-110 cl2">Products</h5>
                            @foreach ($cartItems as $cartItem)
                                <div class="d-flex justify-content-between">
                                    <p class="stext-110 cl2">{{ $cartItem->product->name }}</p>
                                    <p class="stext-110 cl2">
                                        {{ 'Rp.' . number_format($cartItem->product->price * $cartItem->qty, 2, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach

                            <!-- Subtotal -->
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="stext-110 cl2">Subtotal</h6>
                                <h6 class="stext-110 cl2">{{ 'Rp.' . number_format($subtotal, 2, ',', '.') }}</h6>
                            </div>

                            <!-- Dropdown for Location Selection -->
                            <div class="form-group">
                                <label class="stext-110 cl2">Select Location</label>
                                <select class="form-control" name="location" id="location" required>
                                    <!-- Dynamic options should be loaded here -->
                                </select>
                                <button type="button" id="calculate-shipping"
                                    class="flex-c-m stext-10 mt-2 cl0 size-40 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Calculate
                                    Shipping</button>
                            </div>

                            <!-- Shipping Information -->
                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="stext-110 cl2">Shipping Cost</h6>
                                <h6 class="stext-110 cl2" id="shipping-cost">
                                    {{ 'Rp.' . number_format($shippingCost, 2, ',', '.') }}</h6>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="stext-110 cl2">PPN 10%</h6>
                                <h6 class="stext-110 cl2" id="shipping-cost">
                               {{ 'Rp.' . number_format($ppn, 2, ',', '.') }}</h6>
                            </div>

                            <!-- Total Amount -->
                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="stext-110 cl2">Total Amount</h6>
                                <h6 class="stext-110 cl2" id="total-amount">
                                    {{ 'Rp.' . number_format($subtotal + $ppn + $shippingCost, 2, ',', '.') }}</h6>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="card-footer border-secondary bg-transparent">
                            <form id="payment-form" action="{{ route('payment.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="location" id="hidden-location" value="{{ old('location') }}">
                                <button type="button" id="checkout-button"
                                    class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Checkout</button>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Checkout End -->

        <script>
            // Script untuk dropdown lokasi dan perhitungan biaya pengiriman
            const cities = [
                "Jakarta", "Bandung", "Surabaya", "Medan", "Makassar", "Bali", "Yogyakarta", "Semarang",
                "Palembang", "Balikpapan", "Batam", "Malang", "Manado", "Pontianak", "Padang", "Pekanbaru",
                "Samarinda", "Banda Aceh", "Lampung", "Mataram", "Kupang", "Bengkulu", "Gorontalo", "Ambon",
                "Jayapura", "Kendari", "Pangkal Pinang", "Palangkaraya", "Ternate", "Denpasar", "Tarakan",
                "Banjarmasin", "Bogor", "Sukabumi", "Cirebon", "Serang", "Depok", "Bekasi", "Tangerang",
                "Tasikmalaya", "Magelang", "Solo", "Sidoarjo", "Probolinggo", "Jember", "Purwokerto",
                "Tegal", "Pasuruan", "Kediri", "Madiun", "Blitar", "Cilacap"
            ];

            const locationSelect = document.getElementById('location');
            cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.toLowerCase().replace(/\s+/g, '_');
                option.textContent = city;
                locationSelect.appendChild(option);
            });

            document.getElementById('calculate-shipping').addEventListener('click', function() {
                const location = document.getElementById('location').value;



                let shippingCost = 0;

                // Hitung biaya pengiriman berdasarkan lokasi dan berat
                if (['jakarta', 'bogor', 'depok', 'tangerang', 'bekasi', 'cikarang', 'tangerang selatan', 'ciputat',
                        'bintaro'
                    ].includes(location)) {
                    shippingCost = 15000; // Sesuaikan tarif JNE
                } else if (['bandung', 'surabaya', 'semarang', 'solo', 'yogyakarta', 'malang', 'cirebon', 'tasikmalaya',
                        'purwokerto', 'magelang', 'kediri', 'madiun', 'tegal', 'pasuruan', 'blitar', 'probolinggo',
                        'jember'
                    ].includes(location)) {
                    shippingCost = 25000; // Sesuaikan tarif JNE
                } else if (['medan', 'palembang', 'padang', 'batam', 'bali', 'pekanbaru', 'lampung', 'jambi',
                        'bengkulu', 'palu', 'pangkal pinang', 'tanjung pinang', 'batu', 'denpasar'
                    ].includes(location)) {
                    shippingCost = 40000; // Sesuaikan tarif JNE
                } else if (['makassar', 'balikpapan', 'samarinda', 'pontianak', 'manado', 'mataram', 'kupang', 'ambon',
                        'ternate', 'kendari', 'palangkaraya', 'tarakan', 'banjarmasin', 'gorontalo'
                    ].includes(location)) {
                    shippingCost = 50000; // Sesuaikan tarif JNE
                } else if (['jayapura', 'biak', 'merauke', 'sorong', 'timika'].includes(location)) {
                    shippingCost = 80000; // Sesuaikan tarif JNE
                }


                // Update biaya pengiriman dan total amount
                document.getElementById('shipping-cost').textContent = "Rp." + shippingCost.toLocaleString("id-ID");

                // Hitung total amount
                const subtotal = {{ $subtotal }};
                const vat = subtotal * 0.1;
                const total = subtotal + vat + shippingCost;
                document.getElementById('total-amount').textContent = "Rp." + total.toLocaleString("id-ID");

                // Set nilai input tersembunyi untuk checkout
                document.getElementById('hidden-location').value = location;
            });

            document.getElementById('checkout-button').addEventListener('click', function() {
                const form = document.getElementById('payment-form');
                form.submit();
            });
        </script>

        @if (isset($snapToken))
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-iJt5elw9AGa2XL5h"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            console.log('Transaction succeeded:', result);
                            window.location.href = "{{ route('index') }}";
                        },
                        onPending: function(result) {
                            console.log('Transaction pending:', result);
                        },
                        onError: function(result) {
                            console.log('Transaction failed:', result);
                        }
                    });
                });
            </script>


            <style>
                .flex-row {
                    display: flex;
                    flex-wrap: wrap;
                }

                .d-flex {
                    display: flex;
                }

                .spacer {
                    height: 200px;
                }

                .flex-start {
                    justify-content: flex-start;
                }
            </style>
        @endif
    @endsection
