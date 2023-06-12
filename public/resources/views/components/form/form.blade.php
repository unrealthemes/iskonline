<form action="{{ $action }}" method="{{ $method }}" class="{{ $class }}" enctype="multipart/form-data">
    @csrf
    {{ $slot }}
    <div class="errors">
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="mt-4 alert alert-danger">{{ $error }}</div>
        @endforeach
        @endif
    </div>
</form>