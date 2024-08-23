@extends('komponen.index')

@section('content')
    <div class="bg0 m-t-23 p-b-140">
        <div class="container">
            <div class="row isotope-grid">
                @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}">
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="{{ route('detail', $product->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $product->name }}
                                    </a>
                                    <span class="stext-105 cl3">
                                        {{"Rp." .number_format($product->price, 2, ",", ".") }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-12 pb-1">
        @if ($products->lastPage() > 1)
                        <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mb-3">
        <li class="page-item {{ $products->onFirstPage()? 'disabled' : '' }}">
            <a class="page-link btn btn-outline-secondary" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        @for ($i = 1; $i <= $products->lastPage(); $i++)
            <li class="page-item {{ $products->currentPage() == $i? 'active' : '' }}">
                <a class="page-link btn btn-outline-secondary {{ $products->currentPage() == $i? 'btn-primary' : '' }}" href="{{ $products->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="page-item {{ $products->onLastPage()? 'disabled' : '' }}">
            <a class="page-link btn btn-outline-secondary" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>
        @endif
    </div>
    <style>
        .block2 {
            height: 500px; /* Sesuaikan dengan ukuran yang diinginkan */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .block2:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            transform: translateY(-10px);
        }

        .block2-pic {
            width: 100%;
            height: 400px; /* Sesuaikan dengan ukuran yang diinginkan */
            overflow: hidden;
            margin-bottom: 20px;
            background-size: cover;
            background-position: center;
            border-radius: 10px 10px 0 0;
        }

        .block2-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .block2-txt {
            padding: 20px;
            text-align: center;
        }

        .block2-txt-child1 {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .block2-txt-child1 a, .block2-txt-child1 span {
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
        }

        .block2-txt-child1 a {
            font-weight: bold;
            text-decoration: none;
            color: #337ab7;
        }

        .block2-txt-child1 a:hover {
            color: #23527c;
        }
    </style>
@endsection
