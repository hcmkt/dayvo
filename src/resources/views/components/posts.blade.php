<div class="posts">
    @foreach ($posts as $post)
        <div class="post">
            <div class="post-header">
                <h2 class="post-header-date">{{ $post->date }}</h2>
                <div class="post-header-link">
                    <a href="{{ route('posts.edit', $post->date) }}"><svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></span></a>
                </div>
            </div>
            <div class="content">
                <p class="post-content-body">{!! nl2br(e($post->body)) !!}</p>
                <div class="post-content-tags">
                    @foreach ($post->tags->sortBy('id') as $tag)
                        <a href="{{ route('search', ['q' => '#'.$tag->name]) }}" class="post-tag">#{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
