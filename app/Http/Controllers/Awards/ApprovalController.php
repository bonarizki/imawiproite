<?php

namespace App\Http\Controllers\Awards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Awards\ManagemenApprovalAwards as AMA;
use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;
use App\Model\Awards\ManagementQuestion;
use App\Helper\Helper;
use App\Model\Awards\AnswerL2;
use App\Model\Awards\AnswerL1;

class ApprovalController extends Controller
{
    public $HelperService;

    public function __construct(HelperService $HelperService)
    {
        $this->HelperService = $HelperService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $admin = \Helper::instance()->checkNIK();
            $user_nik = Auth::user()->user_nik;
            $data = AMA::with('User.Title','AnswerL1','AnswerL2');
                if (!in_array($user_nik, json_decode($admin))) {
                    $data->where('approve_by',Auth::user()->user_nik);
                }
                
            return $this->HelperService->DataTablesResponse($data->get());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->except('_token');
        for ($i=1; $i <= 20 ; $i++) { 
            $string1 = 'question_no_' . $i;
            $string2 = $string1 . '_id';
            $explode = explode('-',$credentials[$string1]); //array 0 jawaban, array 1 id soal
            $credentials[$string1] = $explode[0];
            $credentials = array_merge([$string2 => $explode[1]],$credentials);
        }
        $request = Helper::instance()->MakeRequest($credentials);
        $this->HelperService->addAuthInsert($request);
        AnswerL2::create($request->toArray());
        return \Response::success(["message"=>"Answer Saved"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_nik)
    {
        $data = [
            "l1" => AnswerL1::where('user_nik',$user_nik)->first(),
            "l2" => AnswerL2::where('user_nik',$user_nik)->first(),
        ];
        return response()->json(["status"=>"success","data"=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id is user_nik
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = in_array($id,$this->getASM()) ? 'asm' : 'non-asm';

        $data = ManagementQuestion::where('question_for',$type)->get();
        return response()->json(["status"=>"success","data"=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getASM()
    {
        return AMA::select('appraise_by')
            ->setEagerLoads([])
            ->groupBy('appraise_by')
            ->get()
            ->pluck(['appraise_by'])
            ->toArray();
        
    }
}
