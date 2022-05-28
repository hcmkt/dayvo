@extends('layouts.layout-plus')

@section('title')
    アカウントの削除 - 
@endsection

@section('page-title')
    アカウントの削除
@endsection

@section('page-content')
    <div class="account-delete">
        <p>アカウントを削除するとデータを復元することはできません。</p>
        <form action="{{ route('users.destroy', Auth::id()) }}" method="post" id="form">
            @csrf
            @method('DELETE')
        </form>
        <div class="account-delete-confirm">
            <input type="checkbox" name="confirm" id="confirm" form="form" required>
            <label for="confirm" class="account-delete-confirm-text">データを復元できないことに同意しました。</label>
        </div>
        <div class="account-delete-btns">
            <a href="{{ route('settings') }}" class="account-delete-btns-back">キャンセル</a>
            <button class="account-delete-btns-delete" form="form" id="btn">削除</button>
        </div>
    </div>

    <script>
        const checkbox = document.getElementById('confirm');
        const button = document.getElementById('btn');
        if (checkbox.checked) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }
        checkbox.addEventListener("change", function(event) {
            if (event.target.checked) {
                button.disabled = false;
            } else {
                button.disabled = true;
            }
        }, false);
    </script>
@endsection
