<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();

        $this->makeUser("admin", "admin@admin.com", "elliptic",["elliptic_admin"]);
        $this->makeUser("Eric Alan Eckstein", "eric.alan.eckstein@gmail.com", "elliptic", ["elliptic_admin", "elliptic_member"]);
        $this->makeUser("Tom Sowers", "tomsowers2@gmail.com", "bumblebee", ["elliptic_member"]);
        $this->makeUser("Eric Eckstein", "eeckstein@ellipticworks.com", "elliptic", ["elliptic_admin", "elliptic_member"]);
        $this->makeUser("Sean Walsh", "sean@ellipticworks.com", "elliptic", ["elliptic_member"]);
        $this->makeUser("Stefan Mangold", "smangold@ellipticworks.com", "elliptic", ["elliptic_member"]);
        $this->makeUser("John Tortorella", "jt@ellipticworks.com", "elliptic", ["elliptic_member"]);
        $this->makeUser("Barbara Rizzi", "barbara@ellipticworks.com", "elliptic", ["elliptic_member"]);
        $this->makeUser("John Bouvier", "jbouvier@ellipticworks.com", "elliptic", ["elliptic_member"]);
    }


    /**
     * Make a new User for the seeder with a team and roles
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $team
     * @param array $roles
     *
     * @return User
     */
    private function makeUser(string $name, string $email, string $password, array $roles): User
    {
        $user = new User ;
        $user->name = $name;
        $user->email = $email;
        $user->email_verified_at = now();
        $user->password = bcrypt($password);
        $user->remember_token = Str::uuid();

        $user->save();

        $user->attachRoles($roles);

        return $user;
    }
}
