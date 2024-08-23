@extends('komponen.index')

@section('content')
    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                <div class="item-slick3" data-thumb="{{ asset('storage/' . $product->img) }}"
                                    alt="{{ $product->name }}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}">
                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">{{ $product->name }}</h4>

                        <span class="mtext-106 cl2">
                            {{ 'Rp.' . number_format($product->price, 2, ',', '.') }} </span>

                        <p class="stext-102 cl3 p-t-23">
                            {{ $product->desc }}
                        </p>

                        <!--  -->
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Size
                                </div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="time">
                                            <option>{{ $product->size }}</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Stok
                                </div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <option>{{ $product->stok }}</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-204 flex-w flex-m respon6-next">
                                <form action="{{ route('addcart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" type="button"
                                            onclick="decrementQuantity()">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" id="quantity"
                                            name="quantity" value="1" min="1" max="{{ $product->stok }}">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" type="button"
                                            onclick="incrementQuantity()">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>

                                    @if ($product->stok > 0)
                                        <button type="submit"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                            <i class="fa fa-shopping-cart mr-1"></i> Add to Cart
                                        </button>
                                    @else
                                        <button type="button"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04"
                                            disabled>
                                            <i class="fa fa-shopping-cart mr-1"></i> Out of Stock
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div><!--  -->

                </div>
            </div>
        </div>

        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-t-43">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6">
                                {{ $product->desc }}
                            </p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <div class="p-b-30 m-lr-15-sm">
                                    <!-- Review -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">


            <span class="stext-107 cl6 p-lr-25">
                {{ $product->category->name }}
            </span>
        </div>
    </section>

    <script>
        function incrementQuantity() {
            var quantityInput = document.getElementById('quantity');
            var quantity = parseInt(quantityInput.value);
            var maxQuantity = parseInt(quantityInput.max);

            if (quantity < maxQuantity) {
                quantity += 1;
                quantityInput.value = quantity;
            } else {
                // Disable the plus button if the quantity reaches the maxQuantity
                document.querySelector('.btn-num-product-up').classList.add('disabled');
            }
        }

        function decrementQuantity() {
            var quantityInput = document.getElementById('quantity');
            var quantity = parseInt(quantityInput.value);
            var maxQuantity = parseInt(quantityInput.max);

            if (quantity > 1) {
                quantity -= 1;
                quantityInput.value = quantity;
                // Re-enable the plus button when quantity is less than maxQuantity
                if (quantity < maxQuantity) {
                    document.querySelector('.btn-num-product-up').classList.remove('disabled');
                }
            }
        }
    </script>
@endsection
