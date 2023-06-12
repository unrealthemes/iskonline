<x-layout.column6>
    <x-blocks.block>
        <h3>{{ $record->name }}</h3>
        <p>{{ $record->description }}</p>
        <x-form.btn color='warning' link='{{ route("admin.service_categories.edit", ["serviceCategory" => $record->id]) }}'>Редактировать</x-form.btn>
        <x-form.btn color='danger' link='{{ route("admin.service_categories.delete", ["serviceCategory" => $record->id]) }}'>Удалить</x-form.btn>
    </x-blocks.block>
</x-layout.column6>