<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
        'slots_available',
        'created_by_user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }
}
