@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'my-2 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg']) }}>
        {{ $status }}
    </div>
@endif
