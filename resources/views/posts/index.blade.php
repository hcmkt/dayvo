@extends('layouts.layout-plus')

@section('page-title')
    ホーム
@endsection

@section('page-content')
    @include('components.posts', compact('posts'))
@endsection
