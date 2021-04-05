<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $administrator = new \App\Models\User;
        $administrator->username = "administrator";
        $administrator->name = "Site Administrator";
        $administrator->email = "admin@email.com";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("password");
        $administrator->avatar = "admin.png";
        $administrator->address = "Cipondoh, Tangerang";

        $administrator->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}
