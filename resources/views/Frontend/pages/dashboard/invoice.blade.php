@extends('Frontend.layout.sidenav-layout')
@section('content')
    @include('Frontend.component.invoice.invoice')
    @include('Frontend.component.invoice.invoice-details')
    @include('Frontend.component.invoice.invoice-delete')
@endsection