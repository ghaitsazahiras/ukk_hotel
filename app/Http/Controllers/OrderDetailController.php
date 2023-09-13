<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OrderDetailModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    // create order detail data
    public function add(Request $req){
        $validator = Validator::make($req->all(),[
            'order_id'      => 'required',
            'room_id'       => 'required',
            'access_date'   => 'required',
            'price'         => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $save = OrderDetailModel::create([
            'order_id'      => $req->order_id,
            'room_id'       => $req->room_id,
            'access_date'   => $req->access_date,
            'price'         => $req->price
        ]);

        $data = OrderDetailModel::where('order_id', '=', $req->order_id)-> get();
        
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

    // show all order detail data
    public function show(){
        return OrderDetailModel::all();
    }

    // show detail order detail data
    public function detail($id){
        if(OrderDetailModel::where('order_detail_id', $id)->exists()){
            $data = DB::table('order_detail')
            ->where('order_detail.order_detail_id', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    // update detail order data
    public function update(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'order_id'      => 'required',
            'room_id'       => 'required',
            'access_date'   => 'required',
            'price'         => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=OrderDetailModel::where('order_detail_id',$id)->update([
            'order_id'      => $req->order_id,
            'room_id'       => $req->room_id,
            'access_date'   => $req->access_date,
            'price'         => $req->price
        ]);
        
        $data=OrderDetailModel::where('order_detail_id', '=', $id)->get();
        
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

    // delete order detail data
    public function destroy($id){
        $del=OrderDetailModel::where('order_detail_id',$id)->delete();
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
