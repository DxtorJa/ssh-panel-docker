<?php

use Illuminate\Database\Seeder;

use App\TicketCategory;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketCategory::create([
            'name' => 'Technical'
        ]);

        TicketCategory::create([
            'name' => 'Support'
        ]);

        TicketCategory::create([
            'name' => 'Services',
        ]);

    }
}
