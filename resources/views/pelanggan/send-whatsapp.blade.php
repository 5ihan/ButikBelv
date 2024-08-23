@extends('komponen.index')

@section('content')
<form method="POST" action="{{ route('send-whatsapp') }}">
    @csrf
    <input type="text" name="name" placeholder="Name">
    <input type="email" name="phone" placeholder="Phone">
    <textarea name="message" placeholder="Message"></textarea>
    <button type="submit">Send</button>
</form>



@endsection
12