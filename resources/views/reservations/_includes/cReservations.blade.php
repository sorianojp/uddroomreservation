<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <x-heading>Reservations</x-heading>
        @if ($existingReservations->isNotEmpty())
            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Start</th>
                            <th scope="col" class="px-6 py-3">End</>
                            <th scope="col" class="px-6 py-3">Reserved By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($existingReservations as $res)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($res->start_at)->format('M j, Y g:ia') }}
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($res->end_at)->format('M j, Y g:ia') }}
                                </td>
                                <td class="px-6 py-4">{{ $res->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-note>No current reservations for this room.</x-note>
        @endif
    </div>
