<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Subscription::create(
            [
                'name' => 'Basic',
                'price' => 0,
                'duration' => 'Unlimit',
                'total_user' => 5,
                'total_property' => 5,
                'total_tenant' => 5,
            ]
        );
    }
}
