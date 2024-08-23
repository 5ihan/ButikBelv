@extends('komponen.index')

@section('content')
    <!-- View: pelanggan/categories.blade.php -->
    <div class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container">
            <div class="row flex-row flex-start">
                @foreach ($categories as $category)
                    <div class="col-md-6 col-xl-4 p-b-30">
                        <!-- Block1 -->
                        <div class="block1 wrap-pic-w">
                            <img src="{{ asset('coza') }}/images/a.png" alt="IMG-BANNER">

                            <a href="{{ route('category', $category->id) }}"
                                class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                <div class="block1-txt-child1 flex-col-l">
                                    <span class="block1-name ltext-102 trans-04 p-b-8">
                                        {{ $category->name }}
                                    </span>
                                </div>
                                <div class="block1-txt-child2 p-b-4 trans-05">
                                    <div class="block1-link stext-101 cl0 trans-09">

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


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
@endsection
