<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $fillable = [
        'name',
        'slug',
        'duration_months',
        'price',
        'gst_percent',
        'total_price',
        'description',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'gst_percent' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    /**
     * Default fallback plans if table is empty
     */
    public static function defaultPlans()
    {
        return [
            [
                'id' => 1,
                'name' => 'Monthly Plan',
                'slug' => 'monthly',
                'duration_months' => 1,
                'price' => 5900.00,
                'gst_percent' => 18.00,
                'total_price' => 6962.00,
                'description' => 'Ideal for short-term projects and initial operational trial.',
                'features' => [
                    'Full Access to Project Management',
                    'Bill of Quantity (BOQ) & Measurements',
                    'Basic Rates & Schedule Maker',
                    'Billing & Recoveries Tracking',
                    '1 Month Validity',
                    'Standard Email & Phone Support',
                ],
                'is_active' => true,
                'badge' => 'Flexible',
            ],
            [
                'id' => 2,
                'name' => 'Half-Yearly Plan',
                'slug' => 'half_yearly',
                'duration_months' => 6,
                'price' => 32000.00,
                'gst_percent' => 18.00,
                'total_price' => 37760.00,
                'description' => 'Popular choice for ongoing civil construction cycles.',
                'features' => [
                    'Full Access to Project Management',
                    'Bill of Quantity (BOQ) & Measurements',
                    'Basic Rates & Schedule Maker',
                    'Billing, T&P & Inventories',
                    '6 Months Validity',
                    'Priority Technical Support',
                ],
                'is_active' => true,
                'badge' => 'Most Popular',
            ],
            [
                'id' => 3,
                'name' => 'Yearly Plan',
                'slug' => 'yearly',
                'duration_months' => 12,
                'price' => 60000.00,
                'gst_percent' => 18.00,
                'total_price' => 70800.00,
                'description' => 'Best value for full enterprise management and complete fiscal year coverage.',
                'features' => [
                    'Complete DigiProject Enterprise Suite',
                    'All Modules & Advanced Rate Analysis',
                    'Multi-User Staff & Vendor Accounts',
                    '12 Months Full Access',
                    'Dedicated Account Manager',
                    '24/7 Priority Support',
                ],
                'is_active' => true,
                'badge' => 'Best Value',
            ],
        ];
    }
}
