<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewReservation;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct()
    {
    }

    public function create(Request $request)
    {
    }

    public function store(Request $request,
                          CreateNewReservation $creator)
    {
        $reservation = $creator->create($request->all());

        return $request->wantsJson()
            ? new JsonResponse(['data' => $reservation->toArray()], 201)
            : redirect()->intended(config('fortify.home'));
    }

    public function show(Request $request,
                          Reservation $reservation)
    {
        return $request->wantsJson()
            ? new JsonResponse(['data' => $reservation->toArray()], 200)
            : redirect()->intended(config('fortify.home'));
    }

    public function update(Request $request,
                          Reservation $reservation)
    {
        $reservation->update($request->all());

        return $request->wantsJson()
            ? new JsonResponse(['data' => $reservation->toArray()], 201)
            : redirect()->intended(config('fortify.home'));
    }

    public function delete(Request $request,
                          Reservation $reservation)
    {
        $reservation->delete();

        return $request->wantsJson()
            ? new JsonResponse(null, 204)
            : redirect()->intended(config('fortify.home'));
    }
}
