<x-app-layout>
    <x-slot name="header">
        {{ __('My Reservations') }}
    </x-slot>

    <form action="{{ route('reservations.print.batch') }}" method="POST" target="_blank">
        @csrf

        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="px-6 py-3">Room</th>
                        <th class="px-6 py-3">Purpose</th>
                        <th class="px-6 py-3">Datetime</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="reservations[]" value="{{ $res->id }}">
                            </td>
                            <td class="px-6 py-4">{{ $res->room }}</td>
                            <td class="px-6 py-4">{{ $res->purpose }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($res->start_at)->format('M j, Y g:ia') }} -
                                {{ \Carbon\Carbon::parse($res->end_at)->format('M j, Y g:ia') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end my-2">
            <x-primary-button type="submit">
                Print Selected
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            document.querySelectorAll('input[name="reservations[]"]').forEach(cb => cb.checked = this.checked);
        });
    </script>
</x-app-layout>
