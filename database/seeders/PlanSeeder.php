<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::defaultPlans();

        foreach ($plans as $p) {
            Plan::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'name' => $p['name'],
                    'duration_months' => $p['duration_months'],
                    'price' => $p['price'],
                    'gst_percent' => $p['gst_percent'],
                    'total_price' => $p['total_price'],
                    'description' => $p['description'],
                    'features' => $p['features'],
                    'is_active' => $p['is_active'],
                    'sort_order' => $p['id'],
                ]
            );
        }
    }
}
