<?php

namespace Database\Seeders;

use App\Models\Bumblebee;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(UserSeeder::class);

        // \App\Models\User::factory(10)->create();
        $tomSowers = User::where('name','Tom Sowers')->firstOrFail();

        if (!$tomSowers){
            $this->command->info('User Tom Sowers not found');
        } else {
            $this->command->info('User Tom found');
        }

        $bumblebee = $this->makeBumblebee(
            $tomSowers,
            'bb_1',
            '0de3cd6c-611c-4898-a149-a9288fe677c5');

        $this->call(MeasurementSeeder::class);
    }

    /**
     * Make a Reference Bumblebee
     * @param User $user
     * @param string $bbID
     * @param string $UUID
     * @return Bumblebee|Bumblebee[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|LaravelIdea\Helper\App\Models\_IH_Bumblebee_C
     */
    public function makeBumblebee(User $user, string $bbID, string $UUID){
        return Bumblebee::factory()->create([
            'serial_number' => $bbID,
            'owner_id' => $user->id,
            'remember_token' => $UUID
        ]);
    }

}
