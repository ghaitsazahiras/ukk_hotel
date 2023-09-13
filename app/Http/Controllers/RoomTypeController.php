<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RoomTypeModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoomTypeController extends Controller
{
    // create room type data
    public function add(Request $req){
        $validator = Validator::make($req->all(),[
            'room_type_name'    => 'required',
            'price'             => 'required',
            'description'       => 'required',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        //define nama file yang akan di upload
        $imageName = time() .'.'. $req->image->extension();

        //proses upload
        $req->image->move(public_path('images'), $imageName);

        $save = RoomTypeModel::create([
            'room_type_name'    => $req->room_type_name,
            'price'             => $req->price,
            'description'       => $req->description,
            'image'             => $imageName
        ]);

        $data = RoomTypeModel::where('room_type_name', '=', $req->room_type_name)-> get();
        
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

    // show all room type data
    public function show(){
        return RoomTypeModel::all();
    }

    // show detail room type data
    public function detail($id){
        if(RoomTypeModel::where('room_type_id', $id)->exists()){
            $data = DB::table('room_type')
            ->where('room_type.room_type_id', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    // update detail room type data
    public function update(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'room_type_name'    => 'required',
            'price'             => 'required',
            'description'       => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=RoomTypeModel::where('room_type_id',$id)->update([
            'room_type_name'    => $req->room_type_name,
            'price'             => $req->price,
            'description'       => $req->description
        ]);
        
        $data=RoomTypeModel::where('room_type_id', '=', $id)->get();
        
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

    // delete room type data
    public function destroy($id){
        $del=RoomTypeModel::where('room_type_id',$id)->delete();
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
