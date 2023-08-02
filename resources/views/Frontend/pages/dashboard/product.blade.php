@extends('Frontend.layout.sidenav-layout')
@section('content')
    @include('Frontend.component.product.product-create')
    @include('Frontend.component.product.product-delete')
    @include('Frontend.component.product.product-list')
    @include('Frontend.component.product.product-update')
@endsection