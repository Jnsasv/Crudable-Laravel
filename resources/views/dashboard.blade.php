<x-app-layout>
    <x-slot name="header">
            {{ __('Dashboard') }}
    </x-slot>
</x-app-layout>

@php
    // dump(get_declared_classes())

    $composer = require app_path() . '/vendor/autoload.php';
    if (false === empty($composer)) {
            $classes  = array_keys($composer->getClassMap());
        }
        dump($classes);
@endphp
