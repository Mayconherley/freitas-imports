@extends('layouts.admin', ['title' => 'Novo produto - Freitas Imports'])

@section('content')
<h1 class="text-3xl font-bold">Novo produto</h1>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="mt-5">
    @include('admin.products._form')
</form>
@endsection
