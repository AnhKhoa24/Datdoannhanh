@extends('layouts.clientlayout')
@section('content')

    @foreach (session('cart', []) as $item)
        <p>{{ $item['product_name'] }} - {{ $item['quantity'] }} - {{ $item['price'] }} -- {{ $item['photo_link'] }}</p>
    @endforeach
@endsection
