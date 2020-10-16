<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PhotoAlboms;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
class PhotoAlbomsController extends Controller
{
    //
    public function addAlbom(Request $request){

        $validator = validator($request->all(),
        [
            'name' => 'required',
            'description' => 'required',
        ]
        );
        $alboms = new PhotoAlboms();

        if(!$validator->fails() ){


            $alboms->name = $request->name;
            $alboms->description = $request->description;
            $alboms->public = $request->public;
            $alboms->user_id = $request->user_id;
            $alboms->save();

            if($alboms){
                return response()->json($alboms)
                    ->setStatusCode('200');
            }

        }
        return response()
            ->json($validator->errors())
            ->setStatusCode(400, 'Bad Request');

    }

    public function editAlbom(Request $request , $id){

        $validator = validator($request->all(),
            [
                'name' => 'required',
                'description' => 'required',
            ]
        );


        if(!$validator->fails() ){


            $albom = DB::table('photo_alboms')
                ->where('id', $id)
                ->update(['name' => $request->name , 'description' => $request->description]);



            if($albom){
                return response()->json($albom)
                    ->setStatusCode('200');
            }

        }
        return response()
            ->json($validator->errors())
            ->setStatusCode(400, 'Bad Request');

    }

    public function getAlbom($id)
    {

        $alboms = PhotoAlboms::where(['user_id' => $id])->get();

        return response()
            ->json($alboms)
            ->setStatusCode(200, 'Success');
    }
    public function removeAlbom($id)
    {

        //$alboms = PhotoAlboms::where(['id' => $id])->get();
        DB::delete('delete from photo_alboms where id = ?',[$id]);

        return response()
            ->json('deleted')
            ->setStatusCode(200, 'Success');
    }
}
