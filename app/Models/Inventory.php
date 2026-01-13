<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $fillable = [
        'project_id',
        'vendor_id',
        'item_name',
        'sku',
        'remarks',
        'date',
                'category',
                'description',
                'paid_to',
                'voucher',
                'quantity',
                'amount',
                'deduction',
                'net_payable',
                'upload',
                'user_id',
                'dismantals',
                'dismantal_amount',
                'dismantal_rate',
                'schedule_work_id',
                'staff_id',
                'isApproved',
                'description2',
                'paid_through',
                'paid_date',
                'bank_ref',
                'upi_ref',



    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

   public function scheduleOfWorks()
   {
     return $this->hasMany(ScheduleWork::class);
   }

   public function schedule()
   {
     return $this->belongsTo(ScheduleWork::class, 'schedule_work_id', 'id');

   }
    public function user()
    {
      return $this->belongsTo(User::class, 'staff_id', 'id');

    }
}
