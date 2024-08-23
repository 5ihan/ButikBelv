<!DOCTYPE html>
<html lang="en">

<head>
    @include("komponen.css")
</head>

<body>
    @include('komponen.header')

    @yield('content')
    @include('komponen.footer')
    @include('komponen.js')
</body>

</html>
