<?php

namespace App\Actions\Fortify;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateNewReservation
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\Reservation
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'libelle' => ['required', 'string', 'max:255'],
            'day' => ['required'],
            'startHour' => ['required'],
            'endHour' => ['required'],
            'description' => ['min:2'],
        ])->validate();

        return Reservation::create([
            'libelle' => $input['libelle'],
            'day' => $input['day'],
            'startHour' => $input['startHour'],
            'endHour' => $input['endHour'],
            'description' => $input['description'],
            'user_id' => Auth::user()->id,
        ]);
    }
}
