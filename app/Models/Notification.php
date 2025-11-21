<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'from_user_id',
        'text',
        'link',
        'title',
        'is_read',
        'to_user_id',
        'created_at',
        'updated_at',
    ];
    use HasFactory;
    public function User(){
        return $this->belongsTo(User::class , 'from_user_id');
    }
}
