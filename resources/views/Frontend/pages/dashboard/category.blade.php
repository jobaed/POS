@extends('Frontend.layout.sidenav-layout')
@section('content')
    @include('Frontend.component.category.category-list')
    @include('Frontend.component.category.category-delete')
    @include('Frontend.component.category.category-create')
    @include('Frontend.component.category.category-update')
@endsection