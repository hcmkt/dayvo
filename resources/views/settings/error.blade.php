@extends('layouts.layout-plus')

@section('title')
    エラー - 
@endsection

@section('page-title')
    エラー
@endsection

@section('page-content')
    <div class="account-error">
        <p>このGoogleアカウントはすでにDayvoに登録されているため連携できません。Googleアカウントのメールアドレスを変更した場合は、一度連携を解除して、再度連携をすると変更が反映されます。</p>
        <a href="{{ route('settings') }}" class="account-error-back">戻る</a>
    </div>
@endsection
