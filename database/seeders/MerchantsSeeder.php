<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $merchantsData = [
            [
                'name' => 'Ahmed',
                'account_number' => '158795',
            ],
            [
                'name' => 'amjad',
                'account_number' => '987654',
            ],
            [
                'name' => 'mohammed',
                'account_number' => '582637',
            ],
        ];

        foreach ($merchantsData as $data) {
            $merchant = new Merchant();
            $merchant->name = $data['name'];
            $merchant->account_number = $data['account_number'];
            $merchant->save();
        }
    }
}
