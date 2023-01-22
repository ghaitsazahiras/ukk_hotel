<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTypeModel extends Model
{
    protected $table = 'room_type';
    public $timestamps = false;
    protected $primaryKey = 'room_type_id';
    protected $fillable = ['room_type_name', 'price', 'description', 'image'];
    
    use HasFactory;
}
