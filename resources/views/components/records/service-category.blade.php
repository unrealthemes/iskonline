<x-blocks.block>
    <h3>{{ $serviceCategory->name }}</h3>
    <p>{{ $serviceCategory->description }}</p>
    @if($admin)
    <x-form.btn color='warning' link='{{ route("admin.categories.edit", ["category" => $serviceCategory->id]) }}'>Редактировать</x-form.btn>
    <x-form.btn color='danger' link='{{ route("admin.categories.delete", ["category" => $serviceCategory->id]) }}'>Удалить</x-form.btn>
    @else
    <x-form.btn color='outline-primary' link='/docsgen/category'>Услуги</x-form.btn>
    @endif

</x-blocks.block>