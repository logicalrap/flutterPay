<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'tx_ref',
        'amount',
        'currency',
        'status',
        'customer_id',      // Add customer_id to the fillable list
        'customer_email',   // Add customer_email to the fillable list
        // ... other fields
    ];

    // Define the relationship with the Customer model (if applicable)
    /*public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }*/
}
