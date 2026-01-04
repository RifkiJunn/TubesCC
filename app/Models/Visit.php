<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Visit extends Model
{
    use Prunable;

    protected $fillable = [
        'ip_hash',
        'url',
        'user_id',
    ];

    /**
     * Get the prunable model query.
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subYear());
    }
}
