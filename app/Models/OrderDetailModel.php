<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailModel extends Model
{
    protected $table = 'order_detail';
    public $timestamps = false;
    protected $primaryKey = 'order_detail_id';
    protected $fillable = ['order_id', 'room_id', 'access_date', 'price'];

    public function order() {
        return $this->belongsTo('App\Models\OrderModel','order_id','order_id');
    }

    public function room() {
        return $this->belongsTo('App\Models\RoomModel','room_id','room_id');
    }
    
    use HasFactory;
}
