@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-sm text-red-600 m-0']) }}>{{ $message }}</p>
@enderror
