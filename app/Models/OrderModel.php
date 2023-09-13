<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    public $timestamps = false;
    protected $primaryKey = 'order_id';
    protected $fillable = ['order_number', 'cust_name', 'cust_email', 'order_date', 'checkin_date', 'checkout_date', 'guest_name', 'room_qty', 'room_type_id', 'order_status', 'user_id'];

    public function room_type() {
        return $this->belongsTo('App\Models\RoomTypeModel','room_type_id','room_type_id');
    }

    public function users() {
        return $this->belongsTo('App\Models\User','user_id','user_id');
    }
    
    use HasFactory;
}
