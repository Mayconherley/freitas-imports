@extends('layouts.admin', ['title' => 'Editar produto - Freitas Imports'])

@section('content')
<h1 class="text-3xl font-bold">Editar produto</h1>
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="mt-5">
    @method('PUT')
    @include('admin.products._form')
</form>
@endsection
