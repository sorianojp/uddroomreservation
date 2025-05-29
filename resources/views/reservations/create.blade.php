<x-app-layout>
    <x-slot name="header">
        {{ $roomName }}
    </x-slot>
    <div class="max-w-full">
        <x-auth-validation-errors />
        <div class="grid grid-cols-2 gap-2">
            @include('reservations._includes.cReserve')
            @include('reservations._includes.cReservations')
        </div>
    </div>
</x-app-layout>
