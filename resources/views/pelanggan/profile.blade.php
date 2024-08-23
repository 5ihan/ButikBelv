@extends('pelanggan.index')

@section('content')
    <div class="container mt-5">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ $customer->img ? asset('uploads/profile_pictures/' . $customer->img) : 'https://bootdey.com/img/Content/avatar/avatar7.png' }}"
                                    alt="Profile Picture" class=" profile-img" width="150">
                                <div class="mt-3">
                                    <h4>{{ $customer->name }}</h4>
                                    <p class="text-muted">{{ $customer->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <!-- Additional content or empty card if needed -->
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-muted">
                                    {{ $customer->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-muted">
                                    {{ $customer->email }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-muted">
                                    0{{ $customer->phone }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-muted">
                                    {{ $customer->address }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-info" href="{{ route('editprofile') }}">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spacer"></div>
    <style>
        .profile-img {
            border: 3px solid #007bff;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        .text-muted {
            color: #6c757d;
        }

        .btn-info {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-info:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .container {
            padding: 0 15px;
        }

        .main-body {
            margin-top: 2rem;
        }

        .row.gutters-sm {
            margin-right: -15px;
            margin-left: -15px;
        }

        .spacer {
            height: 200px;
        }
    </style>
@endsection
