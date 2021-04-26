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
        $administrator->nip = "12345";

        $administrator->save();

        $this->command->info("User Admin berhasil diinsert");

        // stress test
        // for ($i = 0; $i <= 10000; $i++) {
        //     $administrator = new \App\Models\User;
        //     $administrator->username = "administrator" . $i;
        //     $administrator->id_department = 2;
        //     $administrator->name = "Site Administrator" . $i;
        //     $administrator->email = "admin@email.com" . $i;
        //     $administrator->roles = json_encode(["ADMIN"]);
        //     $administrator->password = \Hash::make("password");
        //     $administrator->avatar = "admin.png";
        //     $administrator->address = "Cipondoh, Tangerang";
        //     $administrator->nip = "1234" . $i;

        //     $administrator->save();
        // }
    }
}
