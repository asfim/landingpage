<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'address',
        'phone',
        'note',
        'package_name',
        'product_price',
        'delivery_charge',
        'total_price',
        'status',
    ];

    /**
     * Status label in Bengali
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'   => 'অপেক্ষারত',
            'confirmed' => 'কনফার্ম',
            'delivered' => 'ডেলিভারি হয়েছে',
            'cancelled' => 'বাতিল',
            default     => $this->status,
        };
    }

    /**
     * Status badge color class
     */
    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'   => '#fbbf24',
            'confirmed' => '#6366f1',
            'delivered' => '#34d399',
            'cancelled' => '#f87171',
            default     => '#94a3b8',
        };
    }
}
