<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanySetup;

class CompanySetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySetup::create([
          'email'=>'batian@gmail.com',
          'company_name'=>'Batian Optical Centre',
          'postal_address'=>'2066-10100 Nyeri',
          'pin'=>'P00012834J',
          'bank_name'=>'Coop',
          'account_no'=>'011000003242',
          'branch_name'=>'Nyeri'

        ]);

    }
}
