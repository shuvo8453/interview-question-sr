@extends('layouts.app')

@section('content')
    <h3>Products</h3>
    <a class="btn btn-info float-right mb-4" href="{{utl('/add-product')}}"> Add Product</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Variant</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <th scope="row">{{$product->id}}</th>
                <td>{{$product->title}}</td>
                <td>{{$product->description}}</td>
                <td>SM/ Red/ V-Nick</td>
                <td style="display: flex">
                    <div>
                        <a href="{{url('/edit-product/'.$product->id)}}" class="btn btn-primary mr-2">Edit</a>
                    </div>
                    <form action="{{url('/delete-product/'.$)product->id}}" method="post">
                        {{method_field('DELETE')}}
                        {{csrf_field}}
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection