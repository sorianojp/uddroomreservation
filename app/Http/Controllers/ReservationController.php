<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        // fetch all rooms from the API
        $allRooms = $this->fetchRooms();

        // filter rooms
        $rooms = collect($allRooms)
            ->reject(fn(array $room) => Str::startsWith($room['name'], '#') || $room['is_room'] === 0)
            ->sortBy('name')
            ->values()
            ->all();

        // get upcoming reservations for all displayed rooms
        $now = Carbon::now();
        $roomNames = collect($rooms)->pluck('name');

        $reservations = Reservation::whereIn('room', $roomNames)
            ->where('end_at', '>=', $now)
            ->orderBy('start_at')
            ->get()
            ->groupBy('room');

        return view('reservations.index', compact('rooms', 'reservations'));
    }

    protected function fetchRooms(): array
    {
        $baseUrl = config('services.rooms.base_url');
        $token   = config('services.rooms.token');

        $response = Http::withToken($token)->accept('application/json')->get("{$baseUrl}/get-rooms");

        if (! $response->successful()) {
            abort($response->status(), 'Could not retrieve rooms.');
        }

        return $response->json();
    }
    public function create(string $roomName)
    {
        $now = Carbon::now();
        // dd($now);

        $existing = Reservation::where('room', $roomName)
        ->where('end_at', '>=', $now)
        ->orderBy('start_at')
        ->get();

        return view('reservations.create', [
            'roomName' => $roomName,
            'existingReservations' => $existing,
        ]);
    }
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'room'     => ['required', 'string'],
            'purpose'  => ['required', 'string', 'max:255'],
            'start_at' => ['required', 'date', 'before:end_at'],
            'end_at'   => ['required', 'date', 'after:start_at'],
        ]);

        $conflict = Reservation::where('room', $attrs['room'])
            ->where('start_at', '<',  $attrs['end_at'])
            ->where('end_at',   '>',  $attrs['start_at'])
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['start_at' => 'This time slot is already taken. Please choose another.'])
                ->withInput();
        }

        Auth::user()->reservations()->create($attrs);


        return redirect()->route('reservations.index')->with('status', "Reserved {$attrs['room']} successfully!");
    }

    public function myReservations()
    {
        $reservations = Auth::user()->reservations()
            ->orderBy('start_at', 'desc')
            ->get();
        return view('reservations.my-reservations', compact('reservations'));
    }

    public function printBatch(Request $request)
    {
        $reservationIds = $request->input('reservations', []);
        $reservations = Reservation::with('user')->whereIn('id', $reservationIds)->get();

        if ($reservations->isEmpty()) {
            return redirect()->back()->with('error', 'No reservations selected.');
        }

        return view('reservations.print_batch', compact('reservations'));
    }


}
