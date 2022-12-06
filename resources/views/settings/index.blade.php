@extends('layouts.layout-plus')

@section('title')
    設定 - 
@endsection

@section('page-title')
    設定
@endsection

@section('page-content')
    <div class="tag-section">
        <div class="tag-section-header">
            <h2 class="tag-section-header-title">タグ</h2>
            <button class="tag-section-header-link" id="btn-0">追加</button>
        </div>
        <div class="tag-section-content">
            <div class="tag-section-content-tags">
                @foreach ($tags as $tag)
                    <div class="tag-section-content-tags-tag">
                        <p class="tag-section-content-tags-tag-name">{{ $tag->name }}</p>
                        <button class="tag-section-content-tags-tag-link" id="btn-{{ $tag->id }}">編集</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="account-section">
        <div class="account-section-header">
            <h2 class="account-section-header-title">アカウント</h2>
            <a href="{{ route('auth') }}" class="account-section-header-link setting-accounts-connect">追加連携</a>
        </div>
        <div class="account-section-content">
            <div class="account-section-content-accounts">
                @foreach ($social_accounts as $social_account)
                    <div class="account-section-content-accounts-account">
                        <p class="account-section-content-accounts-account-email">{{ $social_account->email }}</p>
                        @if ($social_accounts->count() > 1)                  
                            <form action="{{ route('socialAccounts.destroy', $social_account) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="account-section-content-accounts-account-link">連携解除</button>
                            </form>
                        @else
                            <button class="account-section-content-accounts-account-link-dummy">連携解除</button>
                        @endif
                    </div>
                @endforeach
                <p class="account-section-content-account-delete">
                    アカウントの削除は<a href="{{ route('userdelete') }}" class="account-section-content-account-delete-link">こちら</a>
                </p>
            </div>
        </div>
    </div>
    <div class="logout-section">
        <div class="logout-section-header">
            <h2 class="logout-section-header-title">ログアウト</h2>
            <a href="{{ route('logout') }}" class="logout-section-header-link">ログアウト</a>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="tag-modal" id="modal-0">
        <h3 class="tag-modal-title text-xl mb-2">タグの追加</h3>
        <button class="tag-modal-close-btn" id="close-0">&times;</button>
        <form action="{{ route('tags.store') }}" method="post" id="form-tags-update-0">
            @csrf
        </form>
        <input type="text" class="tag-modal-text" form="form-tags-update-0" name="name" id="input-0" required autocomplete="off">
        <div class="tag-modal-btn-area">
            <div class="tag-modal-btn-area-dummy"></div>
            <div class="tag-modal-btn-area-btns">
                <button class="tag-modal-btn-area-btns-create-btn" form="form-tags-update-0">保存</button>
            </div>
        </div>
    </div>

    @foreach ($tags as $tag) 
        <div class="tag-modal" id="modal-{{ $tag->id }}">
            <h3 class="tag-modal-title">タグの編集</h3>
            <button class="tag-modal-close-btn" id="close-{{ $tag->id }}">&times;</button>
            <form action="{{ route('tags.update', $tag) }}" method="post" id="form-tags-update-{{ $tag->id }}">
                @csrf
                @method('PATCH')
            </form>
            <form action="{{ route('tags.destroy', $tag) }}" method="post" id="form-tags-destroy-{{ $tag->id }}">
                @csrf
                @method('DELETE')
            </form>
            <input type="text" class="tag-modal-text" form="form-tags-update-{{ $tag->id }}" name="name" id="input-{{ $tag->id }}" value="{{ $tag->name }}" required autocomplete="off">
            <div class="tag-modal-btn-area">
                <div class="tag-modal-btn-area-dummy"></div>
                <div class="tag-modal-btn-area-btns">
                    <button class="tag-modal-btn-area-btns-delete-btn" form="form-tags-destroy-{{ $tag->id }}">削除</button>
                    <button class="tag-modal-btn-area-btns-update-btn" form="form-tags-update-{{ $tag->id }}">保存</button>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        const tagsId = {{ $tags->pluck('id') }};
        tagsId.unshift('0');
        const overlay = document.getElementById('overlay');
        const btn = new Array(tagsId.length);
        const modal = new Array(tagsId.length);
        const closeBtn = new Array(tagsId.length);
        const form = new Array(tagsId.length);
        const input = new Array(tagsId.length);
        for (let i = 0; i < tagsId.length; i++) {
            const tagId = tagsId[i];
            btn[i] = document.getElementById(`btn-${tagId}`);
            modal[i] = document.getElementById(`modal-${tagId}`);
            closeBtn[i] = document.getElementById(`close-${tagId}`);
            form[i] = document.getElementById(`form-tags-update-${tagId}`);
            input[i] = document.getElementById(`input-${tagId}`)
        }
        for (let i = 0; i < tagsId.length; i++) {            
            btn[i].addEventListener('click', function(e){
                e.preventDefault();
                modal[i].classList.add('active');
                overlay.classList.add('active');
                form[i].reset();
                setTimeout(() => {
                    input[i].focus();
                    input[i].setSelectionRange(300, 300);
                }, 50);
            });
            closeBtn[i].addEventListener('click', function(){
                modal[i].classList.remove('active');
                overlay.classList.remove('active');
            });
        }
        overlay.addEventListener('click', function() {
            for (let i = 0; i < tagsId.length; i++) {
                modal[i].classList.remove('active');
            }
            overlay.classList.remove('active');
        });

        const deleteForm = new Array(tagsId.length);
        for (let i = 0; i < tagsId.length; i++) {
            if (i === 0) continue;
            const tagId = tagsId[i];
            deleteForm[i] = document.getElementById(`form-tags-destroy-${tagId}`);
            deleteForm[i].addEventListener('submit', e => {
                e.preventDefault();
                if (!confirm('削除しますか？')) return;
                e.target.submit();
                window.onbeforeunload = null;
            });
        }

        const re = /^\S+$/u;
        for (let i = 0; i < tagsId.length; i++) {
            form[i].addEventListener('submit', e => {
                console.log(1);
                e.preventDefault();
                if (!re.test(input[i].value)) {
                    alert('タグ名に空白文字は使用できません。');
                    return;
                } else if (!(input[i].value.length <= 20)) {
                    alert('タグ名は20文字以内である必要があります。')
                }
                else {
                    e.target.submit();
                    window.onbeforeunload = null;
                }
            })
        }
    </script>
@endsection
