<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $admin = new Admin();
        $admin->name = 'Fares Alnaji';
        $admin->email = 'admin@app.com';
        $admin->balance = 1000.00;
        $admin->save();
    }
}
