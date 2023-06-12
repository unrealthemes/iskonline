<div class="blog-item col-lg-3 col-md-6">
    <a href="{{ route('blog.show.'.$blog->id) }}" class="blog-item__content">
        <div class="blog-item__cover">
            <img src="{{ $blog->preview }}" alt="Preview">
        </div>
        <div class="blog-item__title">{{ $blog->h1 }}</div>
        <div class="blog-item__date">{{ $date }}</div>        
    </a>
</div>