<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\RoomMedia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CreateApartmentType::class,
            CreateRoomType::class,
        ]);

        \App\Models\User::factory()->create();

        \App\Models\Apartment::factory(10)->create();

        \App\Models\Room::factory(100)->create();

        $room_ids = \App\Models\Room::pluck('id');

        foreach ($room_ids as $room_id) {
            RoomMedia::create([
                'room_id' => $room_id,
                'url' => 'https://www.thespruce.com/thmb/9lEUgCeIJwiY-7PfZrL3AO7tWCY=/750x0/filters:no_upscale():max_bytes(150000):strip_icc():format(webp)/EleanorEmail-5aaf1c6ec5cf45eea0a4cd70ddbd4b21.png',
            ]);
            RoomMedia::create([
                'room_id' => $room_id,
                'url' => 'https://www.thespruce.com/thmb/h14GBjBDC4lSx26Ncpa7ahwWxtc=/750x0/filters:no_upscale():max_bytes(150000):strip_icc():format(webp)/AgnesArtandPhotoforMackenzieCollierInteriors.jpg-096098e38406478894a7ec9f40fbdfc4.jpg',
            ]);
            RoomMedia::create([
                'room_id' => $room_id,
                'url' => 'https://www.thespruce.com/thmb/8UU1FaU16IeUimv4VLjr3mrJIRs=/750x0/filters:no_upscale():max_bytes(150000):strip_icc():format(webp)/MaryPattonDesignlRiverOaksResidencelCreditslMollyCulver-a1d6f86382674828b9e9fa28e4aa47b2.jpg',
            ]);
        }

        \App\Models\Payment::factory(100)->create();

        for ($x = 0; $x <= 49; $x++) {
            $gender = ['Male', 'Other', 'Female'];
            \App\Models\Tenant::create([
                'name' => fake()->name(),
                'phone_number' => fake()->unique()->phoneNumber(),
                'citizen_number' => fake()->unique()->uuid(),
                'gender' => $gender[array_rand($gender)],
                'email' => fake()->unique()->safeEmail(),
            ]);
        }

        $tenant_ids = \App\Models\Tenant::pluck('id');

        foreach ($tenant_ids as $tenant_id) {
            $tenant = \App\Models\Tenant::where('id', $tenant_id)->first();
            $room_id = \App\Models\Room::inRandomOrder()->first();
            $bool = [true, false];
            $rent_type = ['Rented', 'Owned'];
            $tenant->rooms()->attach($room_id, [
                'room_host' => $bool[array_rand($bool)],
                'rent_type' => $rent_type[array_rand($rent_type)],
                'living_status' => $bool[array_rand($bool)],
            ]);
        }
    }
}
