<?php
// app/Models/UserTransaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'transaction_type',
        'transaction_number',
        'transaction_date',
        'expiry_date',
        'note',
        'created_by'
    ];
}
