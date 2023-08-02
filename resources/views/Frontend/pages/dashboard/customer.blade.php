@extends('Frontend.layout.sidenav-layout')
@section('content')
    @include('Frontend.component.customer.customer-list')
    @include('Frontend.component.customer.customer-create')
    @include('Frontend.component.customer.customer-delete')
    @include('Frontend.component.customer.customer-update')
@endsection