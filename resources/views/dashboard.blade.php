<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>


    <div class="max-w-full mx-auto">
        <x-card>
            Welcome {{ auth()->user()->name }}
        </x-card>
    </div>

</x-app-layout>
