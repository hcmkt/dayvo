@extends('layouts.layout-plus')

@php
    preg_match('/\d{4}-\d{2}-\d{2}/', url()->current(), $matches);
    $date = $matches[0];
@endphp

@section('title')
    投稿 - 
@endsection

@section('page-title')
    投稿
@endsection

@section('page-content')
    <div class="date-controller">
        <a href="{{ route('posts.edit', \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d')) }}"><svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"stroke-linejoin="round"stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></a>
        <span class="date-controller-date">{{ $date }}</span>
        <a href="{{ route('posts.edit', \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d')) }}"><svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
    </div>
    <form action="{{ isset($post) ? route('posts.update', $post->date) : route('posts.store') }}" method="post" class="post-edit-form">
        @csrf
        @method(isset($post) ? 'PATCH' : 'POST')
            @empty($post)
                <input type="hidden" name="date" value="{{ $date }}">
            @endempty
        <textarea class="post-edit-form-body" name="body" id="body" required>{{ isset($post) ? $post->body : '' }}</textarea>
        <p class="post-edit-form-length" id="body-length"></p>
        <div class="post-edit-form-tags">
            @foreach ($tags as $key => $tag)
                <div>
                    <input type="checkbox" class="post-edit-form-tags-tag" 
                    @isset($post)
                        {{ in_array($tag->name, $post->tags->pluck('name')->all()) ? 'checked' : '' }}
                    @endisset
                    name="tag_ids[]" id="t-{{ $key }}" value="{{ $tag->id }}"/>
                    <label for="t-{{ $key }}">#{{ $tag->name }}</label>
                </div>
            @endforeach
        </div>
        <button class="post-edit-form-btn" onclick="window.onbeforeunload = null;">保存</button>
    </form>
    @isset($post)
        <form action="{{ route('posts.destroy', $post->date) }}" method="post" id="delete-post" class="post-delete-form">
            @csrf
            @method('DELETE')
            <button class="post-delete-form-btn" type="submit">削除</button>
        </form>
    @endisset

    <script>
        const body = document.getElementById('body');
        const tags = document.getElementsByName('tag_ids[]');
        const default_body = body.value;
        const default_tags = new Array(tags.length);
        for (let i = 0; i < tags.length; i++) {
            const tag = tags[i];
            default_tags[i] = tag.checked;
        }
        const msg = "ページを離れようとしています。よろしいですか？";
        window.onbeforeunload = function(e) {
            let is_changed_body = default_body === body.value ? false : true;
            let is_changed_tags = new Array(tags.length);
            for (let i = 0; i < tags.length; i++) {
                const tag = tags[i];
                is_changed_tags[i] = tag.checked === default_tags[i] ? false : true;
            }
            let flag = is_changed_body || is_changed_tags.some(item => item);
            if (flag) {
                e.returnValue = msg;
                return msg;
            }
        }

        const body_length = document.getElementById('body-length');
        window.addEventListener('load', e => {
            body_length.innerHTML = body.value.length;
        });
        body.addEventListener('keyup', e => {
            body_length.innerHTML = body.value.length;
        })
        body.addEventListener('keydown', e => {
            body_length.innerHTML = body.value.length;
        })
    </script>

    @isset($post)
        <script>
            document.getElementById('delete-post').addEventListener('submit', e => {
                e.preventDefault();
                if (!confirm('削除しますか？')) return;
                e.target.submit();
                window.onbeforeunload = null;
            });
        </script>
    @endisset
@endsection
