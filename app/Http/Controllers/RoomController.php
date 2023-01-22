<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RoomModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    // create room data
    public function add(Request $req){
        $validator = Validator::make($req->all(),[
            'room_number'   => 'required',
            'room_type_id'  => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $save = RoomModel::create([
            'room_number'   => $req->room_number,
            'room_type_id'  => $req->room_type_id
        ]);

        $data = RoomModel::where('room_number', '=', $req->room_number)-> get();
        
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

    // show all room data
    public function show(){
        return RoomModel::all();
    }

    // show detail room data
    public function detail($id){
        if(RoomModel::where('room_id', $id)->exists()){
            $data = DB::table('room')
            ->where('room.room_id', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    // update room data
    public function update(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'room_number'   => 'required',
            'room_type_id'  => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=RoomModel::where('room_id',$id)->update([
            'room_number'   => $req->room_number,
            'room_type_id'  => $req->room_type_id
        ]);
        
        $data=RoomModel::where('room_id', '=', $id)->get();
        
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

    // delete room data
    public function destroy($id){
        $del=RoomModel::where('room_id',$id)->delete();
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
