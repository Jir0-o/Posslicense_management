<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class License extends Model
{
    protected $fillable = [
        'name', 'notes', 'is_lifetime', 'expires_at', 'serial'
    ];

    protected $casts = [
        'is_lifetime' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function isValid(): bool
    {
        if ($this->is_lifetime) return true;
        if (!$this->expires_at) return false;
        return $this->expires_at->isFuture();
    }

    // return array for API
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'serial' => $this->serial,
            'name' => $this->name,
            'notes' => $this->notes,
            'is_lifetime' => $this->is_lifetime,
            'expires_at' => $this->expires_at ? $this->expires_at->toDateTimeString() : null,
            'valid' => $this->isValid(),
        ];
    }
}
