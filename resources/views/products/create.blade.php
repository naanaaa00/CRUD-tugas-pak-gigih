@extends('layouts.app')

@section('content')
    <h1>Create a Product</h1>
    <div>
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <form method="post" action="{{ route('product.store') }}">
        @csrf
        <div>
            <label>Name</label>
            <input type="text" name="name" placeholder="Name" required />
        </div>
        <div>
            <label>Qty</label>
            <input type="number" name="qty" placeholder="Qty" required />
        </div>
        <div>
            <label>Price</label>
            <input type="number" step="0.01" name="price" placeholder="Price" required />
        </div>
        <div>
            <label>Description</label>
            <input type="text" name="description" placeholder="Description" />
        </div>
        <div>
            <input type="submit" value="Save a New Product" />
        </div>
    </form>
@endsection
