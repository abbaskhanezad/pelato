<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Point;
use App\PointItem;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
	public function index()
	{
		$Comment=Comment::orderby('id','DESC')->paginate(5);
		return View('comment.index',['Comment'=>$Comment]);
	}
	public function change_state(Request $request)
	{
		$id=$request->get('id');
		$value=$request->get('value');


		if(DB::table('comments')->where('id',$id)->update(['state'=>$value]))
		{
			if($value==0)
			{


                $user_id=Auth::user()->id;
                $point=Point::where([
                    ['point_user_id', '=', $user_id],
                    ['point_item_id', '=', '1'],
                ])->first();
                $newpoint=PointItem::find('1')->point_item_value;

                if($point){

                    $point_val=$point->point_count;
                    $point->update(['point_count'=>$point_val-$newpoint]);
                }else{

                }
                return 'ok';

			}
			else
			{

                $user_id=Auth::user()->id;
                $point=Point::where([
                    ['point_user_id', '=', $user_id],
                    ['point_item_id', '=', '1'],
                ])->first();
                $newpoint=PointItem::find('1')->point_item_value;

              if($point){

                    $point_val=$point->point_count;
                    $point->update(['point_count'=>$point_val+$newpoint]);
                }else{
                    $pnt=new Point();
                    $pnt->point_user_id=$user_id;
                    $pnt->point_item_id=1;
                    $pnt->point_count=$newpoint;
                    $pnt->save();
                }


                return 'no';

			}
		}
		else
		{
			return 'error';
		}
	}
	public function create(Request $request)
	{



	    $Comment=new Comment($request->all());
		$Comment->state=1;
		$Comment->name=Auth::user()->name;
        $Comment->user_id=Auth::user()->id;
		$Comment->time=time();
		$Comment->email=Auth::user()->email;
        dd($Comment);
		$Comment->save();

		return redirect()->back();
	}
	public function delete($id)
	{
		DB::table('comments')->where('id',$id)->delete();
		DB::table('comments')->where('parent_id',$id)->delete();
		return redirect()->back();
	}
}
