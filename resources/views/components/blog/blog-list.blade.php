<div class="blog__list row">
    @if (count($blog) > 0)
    @foreach ($blog as $page)
    <x-blog.blog-preview :blog="$page"></x-blog.blog-preview>
    @endForeach
    @else
    <div class="text-muted">Статьи не найдены</div>
    @endIf
</div>