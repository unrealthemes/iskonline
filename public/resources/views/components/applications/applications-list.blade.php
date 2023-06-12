<x-layout.row>
    @foreach ($records as $record)
    <x-layout.column12>
        <x-applications.applications-component :application="$record" :statuses="$statuses" :services="$services"></x-applications.applications-component>
    </x-layout.column12>
    @endForeach
</x-layout.row>