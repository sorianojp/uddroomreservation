<x-app-layout>
    <x-slot name="header">
        {{ __('Reserve Room') }}
    </x-slot>
    <div class="max-w-full mx-auto">
        <x-auth-session-status :status="session('status')" />
        <div class="grid grid-cols-3 gap-2">
            @foreach ($rooms as $room)
                <x-card>
                    <a href="{{ route('reservations.create', ['roomName' => $room['name']]) }}"
                        class="font-bold text-lg text-blue-600 dark:text-blue-500 hover:underline">
                        {{ $room['name'] }}
                    </a>
                    <div class="my-4">
                        @if (!empty($room['time_schedules']))
                            <x-heading3 class="uppercase">Regular Schedules</x-heading3>
                            <ul class="text-xs">
                                @foreach ($room['time_schedules'] as $sched)
                                    <li class="tracking-wide">
                                        {{ $sched['start'] }} - {{ $sched['end'] }}
                                        {{ $sched['time'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <x-note>No Regular Schedules</x-note>
                        @endif
                    </div>
                    <div>
                        @if ($reservations->has($room['name']))
                            <x-heading3 class="uppercase">Upcoming Reservations</x-heading3>
                            <ul class="text-xs">
                                @foreach ($reservations[$room['name']] as $res)
                                    <li class="tracking-wide border-b mb-2">
                                        {{ \Carbon\Carbon::parse($res->start_at)->format('M j, Y g:ia') }}
                                        to
                                        {{ \Carbon\Carbon::parse($res->end_at)->format('M j, Y g:ia') }}
                                        <br>
                                        <span class="font-semibold">{{ $res->user->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <x-note>No upcoming reservations.</x-note>
                        @endif
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
</x-app-layout>
