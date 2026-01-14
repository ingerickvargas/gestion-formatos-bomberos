<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Supply extends Model
{
    protected $fillable = [
        'name',
        'group',
        'quantity',
        'serial',
        'commercial_presentation',
        'batch',
        'expires_at',
        'manufacturer_lab',
		'invima_registration',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
	
	 public function getSemaphoreAttribute(): string
    {
        if (!$this->expires_at) {
            return 'gray';
        }

        $today = Carbon::today();
        $monthsDiff = $today->diffInMonths($this->expires_at, false);

        if ($monthsDiff > 12) {
            return 'green';
        }

        if ($monthsDiff >= 3) {
            return 'yellow';
        }

        return 'red';
    }
}
