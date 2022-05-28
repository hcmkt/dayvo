@extends('layouts.layout-plus')

@php
    $date = 'm:'.date('m').' d:'.date('d');
@endphp


@section('title')
    検索 - 
@endsection

@section('page-title')
    検索
@endsection

@section('page-content')
    <div class="search-box">
        <form class="search-box-form" action="" method="get">
            <input class="search-box-form-text" type="text" name="q" id="q" placeholder="キーワードを入力..." value="{{ request('q') }}" autocomplete="off">
            <button class="search-box-form-btn" type="submit"><svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
        </form>
    </div>
    @include('components.posts', $posts)
    @if ($posts->isEmpty())
        @if (request('q')===null)
            <div class="search-candidates">
                <a href="{{ route('search', ['q' => $date ]) }}" class="search-candidates-candidate">{{ $date }}</a>
                @foreach ($tags as $tag)
                    <a href="{{ route('search', ['q' => '#'.$tag->name]) }}" class="search-candidates-candidate">#{{ $tag->name }}</a>
                @endforeach
            </div>
        @else    
            <p class="search-not-found">検索結果が見つかりませんでした</p> 
        @endif    
    @endif
@endsection
