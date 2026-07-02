<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseDevice extends Model
{
    protected $fillable = [
        'license_id',
        'device_fingerprint',
        'processor_id',
        'device_name',
        'machine_user',
        'os',
        'app_version',
        'ip_address',
        'status',
        'requested_at',
        'approved_at',
        'rejected_at',
        'blocked_at',
        'last_seen_at',
        'approved_by',
        'note',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at'  => 'datetime',
        'rejected_at'  => 'datetime',
        'blocked_at'   => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}