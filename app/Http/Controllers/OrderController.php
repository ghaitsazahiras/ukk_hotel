<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    // create order data
    public function add(Request $req){
        $validator = Validator::make($req->all(),[
            'order_number'  => 'required',
            'cust_name'    => 'required',
            'cust_email'   => 'required',
            // 'order_date'    => 'required',
            'checkin_date'  => 'required',
            'duration'      => 'required',
            // 'checkout_date' => 'required',
            'guest_name'    => 'required',
            'room_qty'      => 'required',
            'room_type_id'  => 'required',
            // 'order_status'  => 'required',
            'user_id'       => 'nullable'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        // menghitung durasi menginap
        $duration = $req->duration;
        $checkin = new Carbon ($req->checkin_date);
        $checkout = $checkin->addDays($duration);
        $now = Carbon::now();

        $save = OrderModel::create([
            'order_number'  => $req->order_number,
            'cust_name'    => $req->cust_name,
            'cust_email'   => $req->cust_email,
            'order_date'    => $now,
            'checkin_date'  => $req->checkin_date,
            'checkout_date' => $checkout,
            'guest_name'    => $req->guest_name,
            'room_qty'      => $req->room_qty,
            'room_type_id'  => $req->room_type_id,
            'order_status'  => "new",
        ]);

        $data = OrderModel::where('order_number', '=', $req->order_number)-> get();
        
        if($save){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes create new data!',
                'data' => $data
            ]);
        } else 
        {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed create data!'
            ]);
        }
    }

    // show all order data
    public function show(){
        return OrderModel::all();
    }

    // show detail order data
    public function detail($id){
        if(OrderModel::where('order_id', $id)->exists()){
            $data = DB::table('order')
            ->where('order.order_id', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    public function filterByCheckIn($date)
    {
        if(OrderModel::where('checkin_date', $date)->exists()){
            $data = OrderModel::where('checkin_date', $date)->get();

            return response()->json([
                'data' => $data
            ]);
        }
    }

    public function filterByName($name)
    {
        if(OrderModel::where('guest_name', $name)->exists()){
            $data = OrderModel::where('guest_name', $name)->get();

            return response()->json([
                'data' => $data
            ]);
        }
    }

    // update detail order data
    public function update(Request $req, $id){
        $validator = Validator::make($req->all(),[
            // 'order_number'  => 'required',
            // 'cust_name'    => 'required',
            // 'cust_email'   => 'required',
            // 'order_date'    => 'required',
            // 'checkin_date'  => 'required',
            // 'checkout_date' => 'required',
            // 'guest_name'    => 'required',
            // 'room_qty'      => 'required',
            // 'room_type_id'  => 'required',
            'order_status'  => 'required',
            'user_id'       => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=OrderModel::where('order_id',$id)->update([
            // 'order_number'  => $req->order_number,
            // 'cust_name'    => $req->cust_name,
            // 'cust_email'   => $req->cust_email,
            // 'order_date'    => $req->order_date,
            // 'checkin_date'  => $req->checkin_date,
            // 'checkout_date' => $req->checkout_date,
            // 'guest_name'    => $req->guest_name,
            // 'room_qty'      => $req->room_qty,
            // 'room_type_id'  => $req->room_type_id,
            'order_status'  => $req->order_status,
            'user_id'       => $req->user_id
        ]);
        
        $data=OrderModel::where('order_id', '=', $id)->get();
        
        if($update){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success updating data!',
                'data' => $data  
            ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed updating data!'
            ]);
        }
    }

    // delete order data
    public function destroy($id){
        $del=OrderModel::where('order_id',$id)->delete();
        if($del){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes delete data!'
            ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed delete data!'
            ]);
        }
    }
}
