<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    protected $table = 'room';
    public $timestamps = false;
    protected $primaryKey = 'room_id';
    protected $fillable = ['room_number', 'room_type_id'];

    public function room_type() {
        return $this->belongsTo('App\Models\RoomTypeModel','room_type_id','room_type_id');
    }
    
    use HasFactory;
}
