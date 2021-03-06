<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::firstOrCreate([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'is_admin' => true
        ]);

        if ($user->email_verified_at == null) {
            $user->update([
                'password' => password_hash('admin', PASSWORD_BCRYPT),
                'email_verified_at' => Carbon::now(),
            ]);
        }
    }
}
