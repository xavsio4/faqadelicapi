<?php

namespace App\Http\Controllers\api\v1;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Group;
use App\Models\FaqGroup;

class FaqController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api',
        // ['except' => ['index']]
        );
        //$this->middleware('auth');
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $faqs = Auth::user()->faqs()->orderBy('orderby', 'asc')->paginate();
        return response()->json(['status' => 'success','result' => $faqs]);
    }

    public function addFaq(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'group_id' => 'required',
        ]);

        if ($validator->fails()) { 
             return response()->json(['error'=>$validator->errors()], 401);            
	    }
        
        $faq = new Faq();
        $faq->question = 'New question';
        $faq->answer = '';
        $faq->user_id = Auth::user()->id;
        $faq->save();
        $faqgroup = new FaqGroup();
        $faqgroup->group_id = $request->group_id;
        $faqgroup->faq_id = $faq->id;
        $faqgroup->save();

        return response()->json(['status' => 'success','result' => $faq]);
    }

    public function delFaq(Request $request)
    {
       /*  try {
            Group::where('id',$request->id)->delete();
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            //
        }*/
        
        if(Faq::destroy($request->id)){
            //now must delete the faqs themselves if not part of another faq group

            //now must delete the links with faqs
            FaqGroup::where('faq_id',$request->id)->delete();
            
            return response()->json(['status' => 'success']);
        }
    }

    public function editFaq(Request $request,$id)
    {
        $faq = Faq::find($id);

        if($faq->fill($request->all())->save()){
             return response()->json(['status' => 'success','result'=>$faq]);
        }
        else {
             return response()->json(['status' => 'failed']);
        }

    }

    public function faqgrouplist(Request $request) {
       $validator = Validator::make($request->all(), [ 
            'id' => 'required',
        ]);
        if ($validator->fails()) { 
             return response()->json(['error'=>$validator->errors()], 401);            
	    }

        $faqs = Group::find($request->id)->faqs;
        return response()->json(['status' => 'success','result' => $faqs]);

    }
}
