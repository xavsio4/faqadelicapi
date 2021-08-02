<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\FaqGroup;
use Keygen\Keygen;

class GroupController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api',
         ['except' => ['faqByKey']]
        );
        //$this->middleware('auth');
    }

    public function faqByKey($key)
    {
        $faqs = Group::where('key',$key)->with('faqs')->get();

        $group = Group::where('key',$key)->first();
       $group->counter++;
      $group->save();

        return response()->json($faqs);
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $faqs = Auth::user()->groups()->orderBy('orderby', 'asc')->paginate();
        return response()->json(['status' => 'success','result' => $faqs]);
    }

    public function faqlist(Request $request)
    {
        $faqs = Auth::user()->groups()->where('id',$request->id)->faqs;
        return response()->json(['status' => 'success','result' => $faqs]);
    }

    public function addGroup()
    {
        $group = new Group();
        $group->title = 'untitled';
        $group->key = Keygen::numeric(27)->generate();
        $group->user_id = Auth::user()->id;
        $group->save();
        return response()->json(['status' => 'success','result' => $group]);
    }

    public function delGroup(Request $request)
    {
       /*  try {
            Group::where('id',$request->id)->delete();
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            //
        }*/
        
        if(Group::destroy($request->id)){
            //now must delete the faqs themselves if not part of another faq group

            //now must delete the links with faqs
            FaqGroup::where('group_id',$request->id)->delete();
            
            return response()->json(['status' => 'success']);
        }
    }

    public function editGroup(Request $request,$id)
    {
        $group = Group::find($id);

        if($group->fill($request->all())->save()){
             return response()->json(['status' => 'success','result'=>$group]);
        }
        else {
             return response()->json(['status' => 'failed']);
        }

    }
}
