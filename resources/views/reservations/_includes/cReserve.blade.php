<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <x-heading>Reserve</x-heading>
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="room" value="{{ $roomName }}">
            <div class="grid grid-cols-2 gap-2">
                <div class="col-span-2">
                    <x-input-label for="purpose" value="Purpose" />
                    <x-text-input class="w-full" type="text" id="purpose" name="purpose"
                        value="{{ old('purpose') }}" />
                </div>
                <div>
                    <x-input-label for="start_at" value="Start" />
                    <x-text-input class="w-full" type="datetime-local" id="start_at" name="start_at"
                        value="{{ old('start_at') }}" />
                </div>
                <div>
                    <x-input-label for="end_at" value="End" />
                    <x-text-input class="w-full" type="datetime-local" id="end_at" name="end_at"
                        value="{{ old('end_at') }}" />
                </div>
            </div>
            <div class="justify-end flex gap-2 mt-4">
                <x-primary-button class="btn btn-primary">Reserve</x-primary-button>
                <a href="{{ route('reservations.index') }}">
                    <x-secondary-button type="button"> Cancel </x-secondary-button>
                </a>
            </div>
        </form>
    </div>
</div>
