<?php

namespace Database\Seeders;

use App\Models\TourBooking;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Set admin role for existing admin accounts
        User::whereIn('email', ['admin@gmail.com', 'admin@chestnuttravel.net'])->update(['role' => 'admin']);

        // 2. Link every booking that has no user_id to a customer account
        $bookings = TourBooking::whereNull('user_id')->get();
        foreach ($bookings as $booking) {
            $email = trim(strtolower($booking->customer_email));
            if (empty($email)) {
                continue;
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $booking->customer_name ?: 'Khách hàng',
                    'email' => $email,
                    'phone' => $booking->customer_phone,
                    'role' => 'customer',
                    'nationality' => $booking->hotel_pickup ?? 'Vietnam',
                    'password' => bcrypt('travel123456'),
                ]);
            }

            $booking->user_id = $user->id;
            $booking->save();
        }
    }
}
