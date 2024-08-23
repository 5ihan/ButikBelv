@extends('komponen.index')

@section('content')

    <body>
        <div class="mytabs">
            <div class="tab">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">No Resi</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status Paket</th>
                                <th scope="col">Actions</th> <!-- New Column for Actions -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $order)
                                <tr>
                                    <td>{{ $order->order->code_order }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        @if (!$order->resi)
                                            <span class="badge badge-warning">Resi Belum Muncul</span>
                                        @else
                                            {{ $order->resi }}
                                        @endif
                                    </td>
                                    <td>{{ 'Rp.' . number_format($order->order->total, 2, ',', '.') }}</td>
                                    <td>
                                        @if (!$order->status_paket)
                                            <span class="badge badge-danger">Belum Dikirim</span>
                                        @else
                                            <span class="badge badge-danger">{{ $order->status_paket }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Action Buttons -->
                                        <form action="{{ route('order.complete', $order->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Selesai Orderan</button>
                                        </form>

                                        <form action="{{ route('order.reject', $order->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Ajukan Pengembalian</button>
                                        </form>
                                        <form action="" method="POST" style="display:inline-block;">
                                            @csrf
                                            <a href="{{ route('invoice.show', $order->order_id) }}"
                                                class="btn btn-success btn-sm">Struk</a>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>

    <div class="spacer"></div>

    <style>
        h2 {
            padding: 10px;
        }

        .mytabs {
            display: flex;
            flex-wrap: wrap;
            max-width: 1400px;
            margin: 50px auto;
            padding: 10px;
        }

        .mytabs label {
            padding: 9px;
            color: #fff;
            background: #ff007f;
            font-weight: bold;
        }

        .mytabs .tab {
            width: 100%;
            padding: 4px;
            background: #fff;
            order: 1;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .thead-dark th {
            background-color: #343a40;
            color: #fff;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff;
        }

        .spacer {
            height: 250px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
@endsection
