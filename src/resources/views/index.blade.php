@extends('layouts.layout')

@section('body')
    <main class="main">
        <div class="intro">
            <div class="intro-top">
                <div class="intro-top-logo">
                    <img src="{{ url('img/logo.svg') }}" alt="Dayvo" class="intro-top-logo-child">
                </div>
                <div class="intro-top-descriptions">
                    <p class="intro-top-descriptions-description">シンプルな日記サービスです。</p>
                    {{-- <p class="intro-top-descriptions-description">Googleアカウントを使用して簡単に始めることができます。</p> --}}
                </div>
                <div class="intro-top-login">
                    <a href="{{ route('auth') }}" class="intro-top-login-button">ログイン</a>
                </div>
            </div>
        </div>
        <div class="intro">
            <h2 class="intro-title">主な機能</h2>
            <div class="intro-function">
                <div class="intro-function-uni">
                    <div class="intro-icon"><svg class="intro-icon-child" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></div>
                    <p class="intro-function-uni-description">日記を書く</p>
                </div>
                <div class="intro-function-uni">
                    <div class="intro-icon"><svg class="intro-icon-child" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg></div>
                    <p class="intro-function-uni-description">タグをつける</p>
                </div>
                <div class="intro-function-uni">
                    <div class="intro-icon"><svg class="intro-icon-child" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></div>
                    <p class="intro-function-uni-description">検索する</p>
                </div>
            </div>
        </div>
        {{-- <div class="intro">
            <h2 class="intro-title">アカウント</h2>
            <div class="intro-account">
                <div class="intro-account-uni">
                    <div class="intro-icon"><svg class="intro-icon-child" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>
                    <p class="intro-account-uni-description">Googleアカウントを使用して簡単に始めることができます。</p>
            </div>
        </div> --}}
        <div class="intro">
            <h2 class="intro-title">検索オプション</h2>
            <div class="intro-search">
                <p class="intro-search-description">オプションを使用して日記を検索できます。</p>
                <table class="intro-search-table">
                    <tr><th class="intro-search-table-cell">オプション</th> <th class="intro-search-table-cell">説明</th></tr>
                    <tr><td class="intro-search-table-cell">花見　風物詩</td> <td class="intro-search-table-cell">「花見」と「風物詩」を含む</td></tr>
                    <tr><td class="intro-search-table-cell">#サクラ</td> <td class="intro-search-table-cell">「サクラ」タグを含む</td></tr>
                    <tr><td class="intro-search-table-cell">y:2022</td> <td class="intro-search-table-cell">日付が「2022」年</td></tr>
                    <tr><td class="intro-search-table-cell">m:5</td> <td class="intro-search-table-cell">日付が「5」月</td></tr>
                    <tr><td class="intro-search-table-cell">d:24</td> <td class="intro-search-table-cell">日付が「24」日</td></tr>
                    <tr><td class="intro-search-table-cell">!</td> <td class="intro-search-table-cell">検索結果を日付の昇順にする</td></tr>
                </table>
            </div>
        </div>
    </main>
@endsection
