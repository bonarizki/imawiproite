<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\ApprovalMatrix;
use App\Model\Departement;
use App\Model\Grade;
use App\Model\GradeGroup;
use App\Model\Title;
use App\Model\User;
use App\Model\Appraisal\AppraisalCompetency;
use App\Model\Appraisal\AppraisalCompetencyNew;
use App\Model\Appraisal\AppraisalMain;
use App\Model\Appraisal\AppraisalMilestone;
use App\Model\Appraisal\AppraisalMilestoneDetail;
use App\Model\Appraisal\AppraisalMilestoneNext;
use App\Model\Appraisal\AppraisalMilestoneNextDetail;
use App\Model\Appraisal\AppraisalPeriod;
use App\Model\Appraisal\AppraisalStaffCompetency;
use App\Model\Appraisal\AppraisalStaffMain;
use App\Model\Appraisal\AppraisalStaffObjective;
use App\Model\Appraisal\AppraisalStaffObjectiveNext;
use App\Model\Appraisal\Competency;
use App\Model\Appraisal\Milestone;
use App\Model\Plugin\PluginPeriod;

use App\Mail\MailAppraisal\AppraisalApprovedMail;
use App\Mail\MailAppraisal\AppraisalRejectMail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB, Exception;

class AppraisalApprovalController extends Controller
{
    protected $gg_access;
    protected $gg_spv_above;
    protected $gg_staff;

    protected $cc_email;

    public function __construct()
    {
        $this->gg_access = array(3,4,5,6,7);
        $this->gg_spv_above = array(4,5,6,7);
        $this->gg_staff = array(3);

        // CC EMAIL : SYSTEM IMAWIPROITE
        $this->cc_email = array(
            'system.imawiproite@wipro-unza.co.id'
        );
    }

    public function index()
    {
        return view('appraisal.approval');
    }

    public function approvalForm(Request $request)
    {
        if($request->type == 'staff') {
            $appraisal = AppraisalStaffMain::query()
                ->selectRaw('trans_appraisal_staff_main.*, dept.department_name')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'trans_appraisal_staff_main.department_id')
                ->where('trans_appraisal_staff_main.appraisal_staff_id', $request->id)
            ->first();

            $period = PluginPeriod::where('period_id', $appraisal->period_id)->first();

            $objective = AppraisalStaffObjective::where('appraisal_staff_id', $request->id)->get();

            $competency = AppraisalStaffCompetency::query()
                ->selectRaw('trans_appraisal_staff_competency.*,
                    acs.*')
                ->leftJoin('mst_appraisal_competency_staff AS acs', 'acs.competency_staff_id', 'trans_appraisal_staff_competency.competency_staff_id')
                ->where('trans_appraisal_staff_competency.appraisal_staff_id', $request->id)
                ->groupBy('trans_appraisal_staff_competency.appraisal_staff_competency_id')
            ->get();

            $objective_next = AppraisalStaffObjectiveNext::where('appraisal_staff_id', $request->id)->get();

            return view('appraisal.approval_form_staff', compact('appraisal', 'period', 'objective', 'competency', 'objective_next'));
        } else {
            $appraisal = AppraisalMain::query()
                ->selectRaw('trans_appraisal_main.*,
                    user.user_nik,
                    user.user_name,
                    dept.department_name,
                    ugg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS ugg', 'ugg.grade_group_id', 'ug.grade_group_id')
                ->where('trans_appraisal_main.appraisal_id', $request->id)
            ->first();

            $period = PluginPeriod::where('period_id', $appraisal->period_id)->first();

            $period_name_arr = explode('-', $period->period_name);
            $period_next_name = ((int) $period_name_arr[0] + 1).'-'.((int) $period_name_arr[1] + 1);
            $period_next = PluginPeriod::where('period_name', $period_next_name)->first();

            $milestone_template = Milestone::where('milestone_status', '1')->get();

            if($appraisal->appraisal_milestone_status == 'PENDING') {
                $milestone = AppraisalMain::query()
                    ->selectRaw('trans_appraisal_main.appraisal_id,
                        am.appraisal_milestone_id,
                        am.milestone_id,
                        amd.appraisal_milestone_detail_id,
                        amd.milestone_description,
                        amd.milestone_measurement,
                        amd.employee_assessment')
                    ->leftJoin('trans_appraisal_milestone AS am', 'am.appraisal_id', 'trans_appraisal_main.appraisal_id')
                    ->leftJoin('trans_appraisal_milestone_detail AS amd', 'amd.appraisal_milestone_id', 'am.appraisal_milestone_id')
                    ->where('trans_appraisal_main.appraisal_id', $appraisal->appraisal_id)
                ->get();

                return view('appraisal.approval_milestone', compact('appraisal', 'period', 'milestone_template', 'milestone'));
            } else {
                $milestone = AppraisalMilestoneDetail::query()
                    ->selectRaw('trans_appraisal_milestone_detail.appraisal_milestone_detail_id,
                        trans_appraisal_milestone_detail.milestone_description,
                        trans_appraisal_milestone_detail.milestone_measurement,
                        trans_appraisal_milestone_detail.employee_assessment,
                        trans_appraisal_milestone_detail.superior_assessment,
                        trans_appraisal_milestone_detail.superior_score,
                        trans_appraisal_milestone_detail.appraisal_milestone_id,
                        tam.milestone_id,
                        tam.overall_score,
                        mam.milestone_eng,
                        mam.milestone_bhs')
                    ->leftJoin('trans_appraisal_milestone AS tam', 'tam.appraisal_milestone_id', 'trans_appraisal_milestone_detail.appraisal_milestone_id')
                    ->leftJoin('mst_appraisal_milestone AS mam', 'mam.milestone_id', 'tam.milestone_id')
                    ->where('tam.appraisal_id', $appraisal->appraisal_id)
                ->get();

                $competency = AppraisalCompetencyNew::query()
                    ->selectRaw('trans_appraisal_competency_new.*, acn.*')
                    ->leftJoin('mst_appraisal_competency_new AS acn', 'acn.competency_new_id', 'trans_appraisal_competency_new.competency_new_id')
                    ->where('trans_appraisal_competency_new.appraisal_id', $appraisal->appraisal_id)
                    ->groupBy('trans_appraisal_competency_new.appraisal_competency_new_id')
                ->get();

                $milestone_next = AppraisalMain::query()
                    ->selectRaw('trans_appraisal_main.appraisal_id,
                        amn.appraisal_milestone_next_id,
                        amn.milestone_id,
                        amnd.appraisal_milestone_next_detail_id,
                        amnd.milestone_description,
                        amnd.milestone_measurement')
                    ->leftJoin('trans_appraisal_milestone_next AS amn', 'amn.appraisal_id', 'trans_appraisal_main.appraisal_id')
                    ->leftJoin('trans_appraisal_milestone_next_detail AS amnd', 'amnd.appraisal_milestone_next_id', 'amn.appraisal_milestone_next_id')
                    ->where('trans_appraisal_main.appraisal_id', $appraisal->appraisal_id)
                ->get();

                return view('appraisal.approval_form', compact('appraisal', 'period', 'milestone', 'competency', 'milestone_template', 'milestone_next'));
            }
        }
        
    }

    public function saveAsDraft(Request $request)
    {
        DB::transaction(function() use ($request) {
            $appraisal = AppraisalMain::where('appraisal_id', $request->appraisal_id)->first();
            $appraisal->personal_development_superior = $request->personal_development_superior;
            $appraisal->career_development_superior = $request->career_development_superior;
            $appraisal->beyond_milestone = $request->beyond_milestone;
            $appraisal->beyond_milestone_score = $request->beyond_milestone_score;
            $appraisal->milestone_feedback = $request->milestone_feedback;
            $appraisal->competency_feedback = $request->competency_feedback;
            $appraisal->improvement = $request->improvement;
            $appraisal->superior_feedback = $request->superior_feedback;
            $appraisal->overall_milestone_score = $request->overall_milestone_score;
            $appraisal->overall_competency_score = $request->overall_competency_score;
            $appraisal->overall_performance_score = $request->overall_performance_score_rounded;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();

            if(count($request->milestone_id) > 0) {
                foreach($request->milestone_id as $key => $milestone_id) {
                    $milestone_exist = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id)
                    ->exists();

                    if($milestone_exist) {
                        $milestone = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id)
                        ->first();

                        if(count($request->milestone_detail_id[$milestone_id]) > 0) {
                            foreach($request->milestone_detail_id[$milestone_id] as $key => $milestone_detail_id) {
                                $milestone_detail_exist = AppraisalMilestoneDetail::where('appraisal_milestone_detail_id', $milestone_detail_id)->exists();

                                if($milestone_detail_exist) {
                                    $milestone_detail = AppraisalMilestoneDetail::where('appraisal_milestone_detail_id', $milestone_detail_id)->first();
                                    $milestone_detail->superior_assessment = $request->superior_assessment[$milestone_id][$key];
                                    $milestone_detail->superior_score = $request->superior_score[$milestone_id][$key];
                                    $milestone_detail->updated_by = Auth::user()->user_name;
                                    $milestone_detail->save();
                                }
                            }
                        }
                        
                        $milestone->overall_score = $request->overall_score[$milestone_id];
                        $milestone->updated_by = Auth::user()->user_name;
                        $milestone->save();
                    }
                }
            }

            foreach($request->appraisal_competency_new_id as $key=> $appraisal_competency_new_id) {
                $competency = AppraisalCompetencyNew::find($appraisal_competency_new_id);
                $competency->superior_rating = isset($request->superior_rating[$key]) ? $request->superior_rating[$key] : null;
                $competency->updated_by = Auth::user()->user_name;
                $competency->save();
            }

            if(count($request->milestone_id_next) > 0) {
                foreach($request->milestone_id_next as $key => $milestone_id_next) {
                    $milestone_next_exist = AppraisalMilestoneNext::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id_next)
                    ->exists();

                    if($milestone_next_exist) {
                        $milestone_next = AppraisalMilestoneNext::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id_next)
                        ->first();

                        if(count($request->milestone_description_next[$milestone_id_next]) > 0) {
                            AppraisalMilestoneNextDetail::where('appraisal_milestone_next_id', $milestone_next->appraisal_milestone_next_id)->forceDelete();
                            foreach($request->milestone_description_next[$milestone_id_next] as $key => $milestone_desc) {
                                if($request->milestone_description_next[$milestone_id_next][$key] != NULL || $request->milestone_measurement_next[$milestone_id_next][$key] != NULL) {
                                    $detail_next = new AppraisalMilestoneNextDetail();
                                    $detail_next->appraisal_milestone_next_id = $milestone_next->appraisal_milestone_next_id;
                                    $detail_next->milestone_description = $request->milestone_description_next[$milestone_id_next][$key];
                                    $detail_next->milestone_measurement = $request->milestone_measurement_next[$milestone_id_next][$key];
                                    $detail_next->created_by = Auth::user()->user_name;
                                    $detail_next->updated_by = Auth::user()->user_name;
                                    $detail_next->save();
                                }
                            }
                        }
                    } else {
                        $milestone_next = new AppraisalMilestoneNext();
                        $milestone_next->milestone_id = $milestone_id_next;
                        $milestone_next->appraisal_id = $appraisal->appraisal_id;
                        $milestone_next->created_by = Auth::user()->user_name;
                        $milestone_next->updated_by = Auth::user()->user_name;
                        $milestone_next->save();

                        if(count($request->milestone_description_next[$milestone_id_next]) > 0) {
                            foreach($request->milestone_description_next[$milestone_id_next] as $key => $milestone_desc) {
                                if($request->milestone_description_next[$milestone_id_next][$key] != NULL || $request->milestone_measurement_next[$milestone_id][$key] != NULL) {
                                    $detail_next = new AppraisalMilestoneNextDetail();
                                    $detail_next->appraisal_milestone_next_id = $milestone_next->appraisal_milestone_next_id;
                                    $detail_next->milestone_description = $request->milestone_description_next[$milestone_id_next][$key];
                                    $detail_next->milestone_measurement = $request->milestone_measurement_next[$milestone_id_next][$key];
                                    $detail_next->created_by = Auth::user()->user_name;
                                    $detail_next->updated_by = Auth::user()->user_name;
                                    $detail_next->save();
                                }
                            }
                        }
                    }
                }
            }
        });

        return response()->json();
    }

    public function approve(Request $request)
    {
        $email = (object) array();
        $status = 'open';

        DB::transaction(function() use ($request, &$email, &$status) {
            $appraisal = AppraisalMain::where('appraisal_id', $request->appraisal_id)->first();

            $approval_matrix = ApprovalMatrix::where('user_nik', $appraisal->appraisal_user_nik)->first();

            if($approval_matrix->approval_nik_1 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_1 == NULL) {
                $appraisal->appraisal_approval_status_1 = '1';
                $appraisal->appraisal_approval_title_1 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_approval_nik_1 = Auth::user()->user_nik;
                $appraisal->appraisal_approval_name_1 = Auth::user()->user_name;
                $appraisal->appraisal_approval_date_1 = date('Y-m-d');

                $appraisal->appraisal_status = 'IN PROGRESS';

                if($approval_matrix->approval_nik_2 == NULL) {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();
                } else {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_2)->first();
                }

                $email->recipient_name = $recipient->user_name;
                $email->recipient_email = $recipient->user_email;
            } else if($approval_matrix->approval_nik_2 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_2 == NULL) {
                $appraisal->appraisal_approval_status_2 = '1';
                $appraisal->appraisal_approval_title_2 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_approval_nik_2 = Auth::user()->user_nik;
                $appraisal->appraisal_approval_name_2 = Auth::user()->user_name;
                $appraisal->appraisal_approval_date_2 = date('Y-m-d');

                $appraisal->appraisal_status = 'IN PROGRESS';

                if($approval_matrix->approval_nik_3 == NULL) {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();
                } else {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_3)->first();
                }

                $email->recipient_name = $recipient->user_name;
                $email->recipient_email = $recipient->user_email;
            } else if($approval_matrix->approval_nik_3 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_3 == NULL) {
                $appraisal->appraisal_approval_status_3 = '1';
                $appraisal->appraisal_approval_title_3 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_approval_nik_3 = Auth::user()->user_nik;
                $appraisal->appraisal_approval_name_3 = Auth::user()->user_name;
                $appraisal->appraisal_approval_date_3 = date('Y-m-d');

                $appraisal->appraisal_status = 'IN PROGRESS';

                if($approval_matrix->approval_nik_4 == NULL) {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();
                } else {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_4)->first();
                }

                $email->recipient_name = $recipient->user_name;
                $email->recipient_email = $recipient->user_email;
            } else if($approval_matrix->approval_nik_4 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_4 == NULL) {
                $appraisal->appraisal_approval_status_4 = '1';
                $appraisal->appraisal_approval_title_4 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_approval_nik_4 = Auth::user()->user_nik;
                $appraisal->appraisal_approval_name_4 = Auth::user()->user_name;
                $appraisal->appraisal_approval_date_4 = date('Y-m-d');

                $appraisal->appraisal_status = 'IN PROGRESS';

                if($approval_matrix->approval_nik_5 == NULL) {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();
                } else {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_5)->first();
                }

                $email->recipient_name = $recipient->user_name;
                $email->recipient_email = $recipient->user_email;
            } else if($approval_matrix->approval_nik_5 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_5 == NULL) {
                $appraisal->appraisal_approval_status_5 = '1';
                $appraisal->appraisal_approval_title_5 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_approval_nik_5 = Auth::user()->user_nik;
                $appraisal->appraisal_approval_name_5 = Auth::user()->user_name;
                $appraisal->appraisal_approval_date_5 = date('Y-m-d');

                $appraisal->appraisal_status = 'IN PROGRESS';

                if($approval_matrix->approval_nik_6 == NULL) {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();
                } else {
                    $recipient = User::where('user_nik', $approval_matrix->approval_nik_6)->first();
                }

                $email->recipient_name = $recipient->user_name;
                $email->recipient_email = $recipient->user_email;
            } else if($approval_matrix->approval_nik_6 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_6 == NULL) {
                $appraisal->appraisal_approval_status_6 = '1';
                $appraisal->appraisal_approval_title_6 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_approval_nik_6 = Auth::user()->user_nik;
                $appraisal->appraisal_approval_name_6 = Auth::user()->user_name;
                $appraisal->appraisal_approval_date_6 = date('Y-m-d');

                $appraisal->appraisal_status = 'IN PROGRESS';

                $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();

                $email->recipient_name = $recipient->user_name;
                $email->recipient_email = $recipient->user_email;
            } else if($approval_matrix->approval_nik_hr == Auth::user()->user_nik && $appraisal->appraisal_approval_status_hr == NULL) {
                $appraisal->appraisal_approval_status_hr = '1';
                $appraisal->appraisal_approval_title_hr = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_approval_nik_hr = Auth::user()->user_nik;
                $appraisal->appraisal_approval_name_hr = Auth::user()->user_name;
                $appraisal->appraisal_approval_date_hr = date('Y-m-d');
                $appraisal->appraisal_status = 'CLOSED';

                $status = 'closed';

                $recipient = User::where('user_id', $appraisal->user_id)->first();

                $email->recipient_name = $recipient->user_name;
                $email->recipient_email = $recipient->user_email;
            }

            $appraisal->personal_development_superior = $request->personal_development_superior;
            $appraisal->career_development_superior = $request->career_development_superior;
            $appraisal->beyond_milestone = $request->beyond_milestone;
            $appraisal->beyond_milestone_score = $request->beyond_milestone_score;
            $appraisal->milestone_feedback = $request->milestone_feedback;
            $appraisal->competency_feedback = $request->competency_feedback;
            $appraisal->improvement = $request->improvement;
            $appraisal->superior_feedback = $request->superior_feedback;
            $appraisal->overall_milestone_score = $request->overall_milestone_score;
            $appraisal->overall_competency_score = $request->overall_competency_score;
            $appraisal->overall_performance_score = $request->overall_performance_score_rounded;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();

            if(count($request->milestone_id) > 0) {
                foreach($request->milestone_id as $key => $milestone_id) {
                    $milestone_exist = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id)
                    ->exists();

                    if($milestone_exist) {
                        $milestone = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id)
                        ->first();

                        if(count($request->milestone_detail_id[$milestone_id]) > 0) {
                            foreach($request->milestone_detail_id[$milestone_id] as $key => $milestone_detail_id) {
                                $milestone_detail_exist = AppraisalMilestoneDetail::where('appraisal_milestone_detail_id', $milestone_detail_id)->exists();

                                if($milestone_detail_exist) {
                                    $milestone_detail = AppraisalMilestoneDetail::where('appraisal_milestone_detail_id', $milestone_detail_id)->first();
                                    $milestone_detail->superior_assessment = $request->superior_assessment[$milestone_id][$key];
                                    $milestone_detail->superior_score = $request->superior_score[$milestone_id][$key];
                                    $milestone_detail->updated_by = Auth::user()->user_name;
                                    $milestone_detail->save();
                                }
                            }
                        }
                        
                        $milestone->overall_score = $request->overall_score[$milestone_id];
                        $milestone->updated_by = Auth::user()->user_name;
                        $milestone->save();
                    }
                }
            }

            foreach($request->appraisal_competency_new_id as $key=> $appraisal_competency_new_id) {
                $competency = AppraisalCompetencyNew::find($appraisal_competency_new_id);
                $competency->superior_rating = isset($request->superior_rating[$key]) ? $request->superior_rating[$key] : null;
                $competency->updated_by = Auth::user()->user_name;
                $competency->save();
            }

            if(count($request->milestone_id_next) > 0) {
                foreach($request->milestone_id_next as $key => $milestone_id_next) {
                    $milestone_next_exist = AppraisalMilestoneNext::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id_next)
                    ->exists();

                    if($milestone_next_exist) {
                        $milestone_next = AppraisalMilestoneNext::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id_next)
                        ->first();

                        if(count($request->milestone_description_next[$milestone_id_next]) > 0) {
                            AppraisalMilestoneNextDetail::where('appraisal_milestone_next_id', $milestone_next->appraisal_milestone_next_id)->forceDelete();
                            foreach($request->milestone_description_next[$milestone_id_next] as $key => $milestone_desc) {
                                if($request->milestone_description_next[$milestone_id_next][$key] != NULL || $request->milestone_measurement_next[$milestone_id_next][$key] != NULL) {
                                    $detail_next = new AppraisalMilestoneNextDetail();
                                    $detail_next->appraisal_milestone_next_id = $milestone_next->appraisal_milestone_next_id;
                                    $detail_next->milestone_description = $request->milestone_description_next[$milestone_id_next][$key];
                                    $detail_next->milestone_measurement = $request->milestone_measurement_next[$milestone_id_next][$key];
                                    $detail_next->created_by = Auth::user()->user_name;
                                    $detail_next->updated_by = Auth::user()->user_name;
                                    $detail_next->save();
                                }
                            }
                        }
                    } else {
                        $milestone_next = new AppraisalMilestoneNext();
                        $milestone_next->milestone_id = $milestone_id_next;
                        $milestone_next->appraisal_id = $appraisal->appraisal_id;
                        $milestone_next->created_by = Auth::user()->user_name;
                        $milestone_next->updated_by = Auth::user()->user_name;
                        $milestone_next->save();

                        if(count($request->milestone_description_next[$milestone_id_next]) > 0) {
                            foreach($request->milestone_description_next[$milestone_id_next] as $key => $milestone_desc) {
                                if($request->milestone_description_next[$milestone_id_next][$key] != NULL || $request->milestone_measurement_next[$milestone_id][$key] != NULL) {
                                    $detail_next = new AppraisalMilestoneNextDetail();
                                    $detail_next->appraisal_milestone_next_id = $milestone_next->appraisal_milestone_next_id;
                                    $detail_next->milestone_description = $request->milestone_description_next[$milestone_id_next][$key];
                                    $detail_next->milestone_measurement = $request->milestone_measurement_next[$milestone_id_next][$key];
                                    $detail_next->created_by = Auth::user()->user_name;
                                    $detail_next->updated_by = Auth::user()->user_name;
                                    $detail_next->save();
                                }
                            }
                        }
                    }
                }
            }

            $user = User::where('user_id', $appraisal->user_id)->first();
            $department = Departement::where('department_id', $user->department_id)->first();
            $level = GradeGroup::query()
                ->selectRaw('mst_main_user_grade_group.grade_group_name')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_group_id', 'mst_main_user_grade_group.grade_group_id')
                ->where('g.grade_id', $user->grade_id)
            ->first();

            $email->nik = $user->user_nik;
            $email->employee = $user->user_name;
            $email->department = $department->department_name;
            $email->level = $level->grade_group_name;
        });

        return response()->json([$status, $email]);
    }

    public function reject(Request $request)
    {
        $email = (object) array();

        DB::transaction(function() use ($request, &$email) {
            $appraisal = AppraisalMain::where('appraisal_id', $request->appraisal_id)->first();
            $appraisal->appraisal_status = 'DRAFT';
            $appraisal->appraisal_approval_status_1 = NULL;
            $appraisal->appraisal_approval_title_1 = NULL;
            $appraisal->appraisal_approval_nik_1 = NULL;
            $appraisal->appraisal_approval_name_1 = NULL;
            $appraisal->appraisal_approval_date_1 = NULL;
            $appraisal->appraisal_approval_status_2 = NULL;
            $appraisal->appraisal_approval_title_2 = NULL;
            $appraisal->appraisal_approval_nik_2 = NULL;
            $appraisal->appraisal_approval_name_2 = NULL;
            $appraisal->appraisal_approval_date_2 = NULL;
            $appraisal->appraisal_approval_status_3 = NULL;
            $appraisal->appraisal_approval_title_3 = NULL;
            $appraisal->appraisal_approval_nik_3 = NULL;
            $appraisal->appraisal_approval_name_3 = NULL;
            $appraisal->appraisal_approval_date_3 = NULL;
            $appraisal->appraisal_approval_status_4 = NULL;
            $appraisal->appraisal_approval_title_4 = NULL;
            $appraisal->appraisal_approval_nik_4 = NULL;
            $appraisal->appraisal_approval_name_4 = NULL;
            $appraisal->appraisal_approval_date_4 = NULL;
            $appraisal->appraisal_approval_status_5 = NULL;
            $appraisal->appraisal_approval_title_5 = NULL;
            $appraisal->appraisal_approval_nik_5 = NULL;
            $appraisal->appraisal_approval_name_5 = NULL;
            $appraisal->appraisal_approval_date_5 = NULL;
            $appraisal->appraisal_approval_status_6 = NULL;
            $appraisal->appraisal_approval_title_6 = NULL;
            $appraisal->appraisal_approval_nik_6 = NULL;
            $appraisal->appraisal_approval_name_6 = NULL;
            $appraisal->appraisal_approval_date_6 = NULL;
            $appraisal->appraisal_approval_status_hr = NULL;
            $appraisal->appraisal_approval_title_hr = NULL;
            $appraisal->appraisal_approval_nik_hr = NULL;
            $appraisal->appraisal_approval_name_hr = NULL;
            $appraisal->appraisal_approval_date_hr = NULL;
            $appraisal->appraisal_approval_reject_note = $request->appraisal_approval_reject_note;
            $appraisal->personal_development_superior = $request->personal_development_superior;
            $appraisal->career_development_superior = $request->career_development_superior;
            $appraisal->beyond_milestone = $request->beyond_milestone;
            $appraisal->beyond_milestone_score = $request->beyond_milestone_score;
            $appraisal->milestone_feedback = $request->milestone_feedback;
            $appraisal->competency_feedback = $request->competency_feedback;
            $appraisal->improvement = $request->improvement;
            $appraisal->superior_feedback = $request->superior_feedback;
            $appraisal->overall_milestone_score = $request->overall_milestone_score;
            $appraisal->overall_competency_score = $request->overall_competency_score;
            $appraisal->overall_performance_score = $request->overall_performance_score_rounded;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();

            if(count($request->milestone_id) > 0) {
                foreach($request->milestone_id as $key => $milestone_id) {
                    $milestone_exist = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id)
                    ->exists();

                    if($milestone_exist) {
                        $milestone = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id)
                        ->first();

                        if(count($request->milestone_detail_id[$milestone_id]) > 0) {
                            foreach($request->milestone_detail_id[$milestone_id] as $key => $milestone_detail_id) {
                                $milestone_detail_exist = AppraisalMilestoneDetail::where('appraisal_milestone_detail_id', $milestone_detail_id)->exists();

                                if($milestone_detail_exist) {
                                    $milestone_detail = AppraisalMilestoneDetail::where('appraisal_milestone_detail_id', $milestone_detail_id)->first();
                                    $milestone_detail->superior_assessment = $request->superior_assessment[$milestone_id][$key];
                                    $milestone_detail->superior_score = $request->superior_score[$milestone_id][$key];
                                    $milestone_detail->updated_by = Auth::user()->user_name;
                                    $milestone_detail->save();
                                }
                            }
                        }
                        
                        $milestone->overall_score = $request->overall_score[$milestone_id];
                        $milestone->updated_by = Auth::user()->user_name;
                        $milestone->save();
                    }
                }
            }

            foreach($request->appraisal_competency_new_id as $key=> $appraisal_competency_new_id) {
                $competency = AppraisalCompetencyNew::find($appraisal_competency_new_id);
                $competency->superior_rating = isset($request->superior_rating[$key]) ? $request->superior_rating[$key] : null;
                $competency->updated_by = Auth::user()->user_name;
                $competency->save();
            }

            if(count($request->milestone_id_next) > 0) {
                foreach($request->milestone_id_next as $key => $milestone_id_next) {
                    $milestone_next_exist = AppraisalMilestoneNext::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id_next)
                    ->exists();

                    if($milestone_next_exist) {
                        $milestone_next = AppraisalMilestoneNext::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id_next)
                        ->first();

                        if(count($request->milestone_description_next[$milestone_id_next]) > 0) {
                            AppraisalMilestoneNextDetail::where('appraisal_milestone_next_id', $milestone_next->appraisal_milestone_next_id)->forceDelete();
                            foreach($request->milestone_description_next[$milestone_id_next] as $key => $milestone_desc) {
                                if($request->milestone_description_next[$milestone_id_next][$key] != NULL || $request->milestone_measurement_next[$milestone_id_next][$key] != NULL) {
                                    $detail_next = new AppraisalMilestoneNextDetail();
                                    $detail_next->appraisal_milestone_next_id = $milestone_next->appraisal_milestone_next_id;
                                    $detail_next->milestone_description = $request->milestone_description_next[$milestone_id_next][$key];
                                    $detail_next->milestone_measurement = $request->milestone_measurement_next[$milestone_id_next][$key];
                                    $detail_next->created_by = Auth::user()->user_name;
                                    $detail_next->updated_by = Auth::user()->user_name;
                                    $detail_next->save();
                                }
                            }
                        }
                    } else {
                        $milestone_next = new AppraisalMilestoneNext();
                        $milestone_next->milestone_id = $milestone_id_next;
                        $milestone_next->appraisal_id = $appraisal->appraisal_id;
                        $milestone_next->created_by = Auth::user()->user_name;
                        $milestone_next->updated_by = Auth::user()->user_name;
                        $milestone_next->save();

                        if(count($request->milestone_description_next[$milestone_id_next]) > 0) {
                            foreach($request->milestone_description_next[$milestone_id_next] as $key => $milestone_desc) {
                                if($request->milestone_description_next[$milestone_id_next][$key] != NULL || $request->milestone_measurement_next[$milestone_id][$key] != NULL) {
                                    $detail_next = new AppraisalMilestoneNextDetail();
                                    $detail_next->appraisal_milestone_next_id = $milestone_next->appraisal_milestone_next_id;
                                    $detail_next->milestone_description = $request->milestone_description_next[$milestone_id_next][$key];
                                    $detail_next->milestone_measurement = $request->milestone_measurement_next[$milestone_id_next][$key];
                                    $detail_next->created_by = Auth::user()->user_name;
                                    $detail_next->updated_by = Auth::user()->user_name;
                                    $detail_next->save();
                                }
                            }
                        }
                    }
                }
            }

            $recipient = User::where('user_id', $appraisal->user_id)->first();

            $email->recipient_name = $recipient->user_name;
            $email->recipient_email = $recipient->user_email;
            $email->reject_note = $appraisal->appraisal_approval_reject_note;
        });

        return response()->json($email);
    }

    public function approveMilestone(Request $request)
    {
        $email = (object) array();

        DB::transaction(function() use ($request, &$email) {
            $appraisal = AppraisalMain::where('appraisal_id', $request->appraisal_id)->first();
            $appraisal->appraisal_milestone_status = 'APPROVED';
            $appraisal->appraisal_approval_status_milestone = '1';
            $appraisal->appraisal_approval_nik_milestone = Auth::user()->user_nik;
            $appraisal->appraisal_approval_name_milestone = Auth::user()->user_name;
            $appraisal->appraisal_approval_date_milestone = date('Y-m-d');
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();

            if(count($request->milestone_id) > 0) {
                foreach($request->milestone_id as $key => $milestone_id) {
                    $milestone_exist = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id)
                    ->exists();

                    if($milestone_exist) {
                        $milestone = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id)
                        ->first();
                    } else {
                        $milestone = new AppraisalMilestone();
                        $milestone->milestone_id = $milestone_id;
                        $milestone->appraisal_id = $appraisal->appraisal_id;
                        $milestone->created_by = Auth::user()->user_name;
                        $milestone->updated_by = Auth::user()->user_name;
                        $milestone->save();
                    }

                    if(count($request->milestone_description[$milestone_id]) > 0) {
                        AppraisalMilestoneDetail::where('appraisal_milestone_id', $milestone->appraisal_milestone_id)->forceDelete();
                        foreach($request->milestone_description[$milestone_id] as $key => $milestone_desc) {
                            if($request->milestone_description[$milestone_id][$key] != NULL || $request->milestone_measurement[$milestone_id][$key] != NULL || $request->employee_assessment[$milestone_id][$key] != NULL) {
                                $detail = new AppraisalMilestoneDetail();
                                $detail->appraisal_milestone_id = $milestone->appraisal_milestone_id;
                                $detail->milestone_description = $request->milestone_description[$milestone_id][$key];
                                $detail->milestone_measurement = $request->milestone_measurement[$milestone_id][$key];
                                $detail->employee_assessment = $request->employee_assessment[$milestone_id][$key];
                                $detail->created_by = Auth::user()->user_name;
                                $detail->updated_by = Auth::user()->user_name;
                                $detail->save();
                            }
                        }
                    }
                }
            }

            $recipient = User::where('user_id', $appraisal->user_id)->first();

            $email->recipient_name = $recipient->user_name;
            $email->recipient_email = $recipient->user_email;
        });

        return response()->json($email);
    }

    public function rejectMilestone(Request $request)
    {
        $email = (object) array();

        DB::transaction(function() use ($request, &$email) {
            $appraisal = AppraisalMain::where('appraisal_id', $request->appraisal_id)->first();
            $appraisal->appraisal_milestone_status = 'DRAFT';
            $appraisal->appraisal_approval_status_milestone = NULL;
            $appraisal->appraisal_approval_nik_milestone = NULL;
            $appraisal->appraisal_approval_name_milestone = NULL;
            $appraisal->appraisal_approval_date_milestone = NULL;
            $appraisal->appraisal_approval_reject_note = $request->appraisal_approval_reject_note;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();

            if(count($request->milestone_id) > 0) {
                foreach($request->milestone_id as $key => $milestone_id) {
                    $milestone_exist = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('milestone_id', $milestone_id)
                    ->exists();

                    if($milestone_exist) {
                        $milestone = AppraisalMilestone::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('milestone_id', $milestone_id)
                        ->first();
                    } else {
                        $milestone = new AppraisalMilestone();
                        $milestone->milestone_id = $milestone_id;
                        $milestone->appraisal_id = $appraisal->appraisal_id;
                        $milestone->created_by = Auth::user()->user_name;
                        $milestone->updated_by = Auth::user()->user_name;
                        $milestone->save();
                    }

                    if(count($request->milestone_description[$milestone_id]) > 0) {
                        AppraisalMilestoneDetail::where('appraisal_milestone_id', $milestone->appraisal_milestone_id)->forceDelete();
                        foreach($request->milestone_description[$milestone_id] as $key => $milestone_desc) {
                            if($request->milestone_description[$milestone_id][$key] != NULL || $request->milestone_measurement[$milestone_id][$key] != NULL || $request->employee_assessment[$milestone_id][$key] != NULL) {
                                $detail = new AppraisalMilestoneDetail();
                                $detail->appraisal_milestone_id = $milestone->appraisal_milestone_id;
                                $detail->milestone_description = $request->milestone_description[$milestone_id][$key];
                                $detail->milestone_measurement = $request->milestone_measurement[$milestone_id][$key];
                                $detail->employee_assessment = $request->employee_assessment[$milestone_id][$key];
                                $detail->created_by = Auth::user()->user_name;
                                $detail->updated_by = Auth::user()->user_name;
                                $detail->save();
                            }
                        }
                    }
                }
            }

            $recipient = User::where('user_id', $appraisal->user_id)->first();

            $email->recipient_name = $recipient->user_name;
            $email->recipient_email = $recipient->user_email;
            $email->reject_note = $appraisal->appraisal_approval_reject_note;
        });

        return response()->json($email);
    }

    public function approveStaff(Request $request)
    {
        $data = (object) array();

        DB::transaction(function() use ($request, &$data) {
            $appraisal = AppraisalStaffMain::find($request->appraisal_staff_id);
            $appraisal->appraisal_summary = $request->appraisal_summary;
            $appraisal->objective_comment = $request->objective_comment;
            $appraisal->competency_comment = $request->competency_comment;
            $appraisal->training_superior = $request->training_superior;
            $appraisal->career_development_superior = $request->career_development_superior;
            $appraisal->overall_objective_score = $request->overall_objective_score;
            $appraisal->overall_competency_score = $request->overall_competency_score;
            $appraisal->overall_performance_score = $request->overall_performance_score_rounded;
            
            if($request->approval_type != 'DRAFT') {
                if($request->approval_type == 'APPROVE') {
                    $data->appraisal_status = 'IN PROGRESS';
                }
                
                $approval_matrix = ApprovalMatrix::where('user_nik', $appraisal->appraisal_user_nik)->first();

                if($approval_matrix->approval_nik_1 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_1 == NULL) {
                    $appraisal->appraisal_approval_status_1 = $request->approval_type == 'APPROVE' ? '1' : '0';
                    $appraisal->appraisal_approval_title_1 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                    $appraisal->appraisal_approval_nik_1 = Auth::user()->user_nik;
                    $appraisal->appraisal_approval_name_1 = Auth::user()->user_name;
                    $appraisal->appraisal_approval_date_1 = date('Y-m-d');

                    if($approval_matrix->approval_nik_2 != NULL) {
                        $data->recipient_name = User::where('user_nik', $approval_matrix->approval_nik_2)->first()->user_name;
                        $data->recipient_email = User::where('user_nik', $approval_matrix->approval_nik_2)->first()->user_email;
                    } else {
                        $data->recipient_name = User::where('user_nik', $approval_matrix->approval_nik_hr)->first()->user_name;
                        $data->recipient_email = User::where('user_nik', $approval_matrix->approval_nik_hr)->first()->user_email;
                    }
                } else if($approval_matrix->approval_nik_2 == Auth::user()->user_nik && $appraisal->appraisal_approval_status_2 == NULL) {
                    $appraisal->appraisal_approval_status_2 = $request->approval_type == 'APPROVE' ? '1' : '0';
                    $appraisal->appraisal_approval_title_2 = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                    $appraisal->appraisal_approval_nik_2 = Auth::user()->user_nik;
                    $appraisal->appraisal_approval_name_2 = Auth::user()->user_name;
                    $appraisal->appraisal_approval_date_2 = date('Y-m-d');

                    $data->recipient_name = User::where('user_nik', $approval_matrix->approval_nik_hr)->first()->user_name;
                    $data->recipient_email = User::where('user_nik', $approval_matrix->approval_nik_hr)->first()->user_email;
                } else if($approval_matrix->approval_nik_hr == Auth::user()->user_nik && $appraisal->appraisal_approval_status_hr == NULL) {
                    $appraisal->appraisal_approval_status_hr = $request->approval_type == 'APPROVE' ? '1' : '0';
                    $appraisal->appraisal_approval_title_hr = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                    $appraisal->appraisal_approval_nik_hr = Auth::user()->user_nik;
                    $appraisal->appraisal_approval_name_hr = Auth::user()->user_name;
                    $appraisal->appraisal_approval_date_hr = date('Y-m-d');

                    if($request->approval_type == 'APPROVE') {
                        $appraisal->appraisal_status = 'CLOSED';
                        $data->appraisal_status = 'CLOSED';
                        $data->recipient_name = $appraisal->appraisal_user_name;
                        $data->recipient_email = User::where('user_nik', $appraisal->appraisal_user_nik)->first()->user_email;
                    }
                }

                if($request->approval_type == 'REJECT') {
                    $appraisal->appraisal_status = 'REJECTED';
                    $appraisal->appraisal_approval_reject_note = $request->appraisal_approval_reject_note;

                    $data->appraisal_status = 'REJECTED';
                    $data->recipient_name = $appraisal->appraisal_user_name;
                    $data->recipient_email = User::where('user_nik', $appraisal->appraisal_user_nik)->first()->user_email;
                    $data->reject_note = $appraisal->appraisal_approval_reject_note;
                }
            } else if($request->approval_type == 'DRAFT') {
                $data->appraisal_status = 'DRAFT';
            }

            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();

            foreach($request->appraisal_staff_objective_id as $key => $appraisal_staff_objective_id) {
                $objective = AppraisalStaffObjective::find($appraisal_staff_objective_id);
                $objective->superior_assessment = $request->superior_assessment[$key];
                $objective->superior_score = $request->superior_score[$key];
                $objective->updated_by = Auth::user()->user_name;
                $objective->save();
            }

            foreach($request->appraisal_staff_competency_id as $key=> $appraisal_staff_competency_id) {
                $competency = AppraisalStaffCompetency::find($appraisal_staff_competency_id);
                $competency->superior_rating = isset($request->superior_rating[$key]) ? $request->superior_rating[$key] : null;
                $competency->updated_by = Auth::user()->user_name;
                $competency->save();
            }

            if(count($request->objective_next_description) > 0) {
                AppraisalStaffObjectiveNext::where('appraisal_staff_id', $appraisal->appraisal_staff_id)->forceDelete();
                foreach($request->objective_next_description as $key => $objective_next_description) {
                    if($objective_next_description != NULL) {
                        $objective = new AppraisalStaffObjectiveNext();
                        $objective->appraisal_staff_id = $appraisal->appraisal_staff_id;
                        $objective->objective_next_description = $objective_next_description;
                        $objective->created_by = Auth::user()->user_name;
                        $objective->updated_by = Auth::user()->user_name;
                        $objective->save();
                    }
                }
            }

            $data->nik = $appraisal->appraisal_user_nik;
            $data->employee = $appraisal->appraisal_user_name;
            $data->level = 'Staff';
            $data->department = Departement::where('department_id', $appraisal->department_id)->first()->department_name;
        });

        return response()->json($data);
    }

    public function getAppraisal(Request $request)
    {
    	$period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();
        $appraisal_period = AppraisalPeriod::where('period_id', $period->period_id)->first();

    	$spv_above = User::query()
    		->selectRaw('am.*, mst_main_user.user_nik, mst_main_user.user_name,
    			CONCAT("[", mst_main_user.user_nik, "] ", mst_main_user.user_name) AS user,
                matrix.approval_nik_1, matrix.approval_nik_2, matrix.approval_nik_3, matrix.approval_nik_4,
                matrix.approval_nik_5, matrix.approval_nik_6, matrix.approval_nik_hr,
                ugg.grade_group_name, dept.department_name')
    		->leftJoin('trans_appraisal_main AS am', function($join) use ($period) {
    			$join->on('am.user_id', 'mst_main_user.user_id')
    				->where('am.period_id', $period->period_id);
    		})
            ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS ugg', 'ugg.grade_group_id', 'ug.grade_group_id')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
            ->leftJoin('mst_main_user_approval_matrix AS matrix', 'matrix.user_nik', 'mst_main_user.user_nik')
            ->whereIn('ug.grade_group_id', $this->gg_spv_above)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 180')
            ->groupBy('am.appraisal_id')
            ->orderBy('mst_main_user.grade_id', 'DESC')
            ->orderBy('mst_main_user.user_nik')
    	->get();

        $staff = User::query()
    		->selectRaw('asm.*, mst_main_user.user_nik, mst_main_user.user_name,
    			CONCAT("[", mst_main_user.user_nik, "] ", mst_main_user.user_name) AS user,
                matrix.approval_nik_1, matrix.approval_nik_2, matrix.approval_nik_3, matrix.approval_nik_4,
                matrix.approval_nik_5, matrix.approval_nik_6, matrix.approval_nik_hr,
                dept.department_name, ugg.grade_group_name')
    		->leftJoin('trans_appraisal_staff_main AS asm', function($join) use ($period) {
    			$join->on('asm.user_id', 'mst_main_user.user_id')
    				->where('asm.period_id', $period->period_id);
    		})
            ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS ugg', 'ugg.grade_group_id', 'ug.grade_group_id')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
            ->leftJoin('mst_main_user_approval_matrix AS matrix', 'matrix.user_nik', 'mst_main_user.user_nik')
            ->whereIn('ug.grade_group_id', $this->gg_staff)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180')
            ->groupBy('asm.appraisal_staff_id')
            ->orderBy('mst_main_user.grade_id', 'DESC')
            ->orderBy('mst_main_user.user_nik')
    	->get();

        $user = array();
        foreach($spv_above as $val) {
            $user[] = $val;
        }
        foreach($staff as $val) {
            $user[] = $val;
        }

        $data = array();

        foreach($user as $u) {
            if($u->grade_group_name != 'Staff') {
                if($u->appraisal_milestone_status == 'PENDING') {
                    if($u->appraisal_approval_status_milestone == NULL && $u->approval_nik_1 == Auth::user()->user_nik) {
                        array_push($data, $u);
                    }
                } else if($u->appraisal_status == 'OPEN' || $u->appraisal_status == 'IN PROGRESS') {
                    if($u->appraisal_approval_status_1 == NULL && $u->approval_nik_1 == Auth::user()->user_nik) {
                        array_push($data, $u);
                    } else if($u->appraisal_approval_status_2 == NULL && $u->approval_nik_2 == Auth::user()->user_nik) {
                        if($u->appraisal_approval_status_1 == '1') {
                            array_push($data, $u);
                        }
                    } else if($u->appraisal_approval_status_3 == NULL && $u->approval_nik_3 == Auth::user()->user_nik) {
                        if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1') {
                            array_push($data, $u);
                        }
                    } else if($u->appraisal_approval_status_4 == NULL && $u->approval_nik_4 == Auth::user()->user_nik) {
                        if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->appraisal_approval_status_3 == '1') {
                            array_push($data, $u);
                        }
                    } else if($u->appraisal_approval_status_5 == NULL && $u->approval_nik_5 == Auth::user()->user_nik) {
                        if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->appraisal_approval_status_3 == '1' && $u->appraisal_approval_status_4 == '1') {
                            array_push($data, $u);
                        }
                    } else if($u->appraisal_approval_status_6 == NULL && $u->approval_nik_6 == Auth::user()->user_nik) {
                        if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->appraisal_approval_status_3 == '1' && $u->appraisal_approval_status_4 == '1' && $u->appraisal_approval_status_5 == '1') {
                            array_push($data, $u);
                        }
                    } else if($u->appraisal_approval_status_hr == NULL && $u->approval_nik_hr == Auth::user()->user_nik) {
                        if($u->appraisal_approval_status_1 == '1' && $u->approval_nik_2 == NULL) {
                            array_push($data, $u);
                        } else if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->approval_nik_3 == NULL) {
                            array_push($data, $u);
                        } else if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->appraisal_approval_status_3 == '1' && $u->approval_nik_4 == NULL) {
                            array_push($data, $u);
                        } else if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->appraisal_approval_status_3 == '1' && $u->appraisal_approval_status_4 == '1' && $u->approval_nik_5 == NULL) {
                            array_push($data, $u);
                        } else if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->appraisal_approval_status_3 == '1' && $u->appraisal_approval_status_4 == '1' && $u->appraisal_approval_status_5 == '1' && $u->approval_nik_6 == NULL) {
                            array_push($data, $u);
                        } else if($u->appraisal_approval_status_1 == '1' && $u->appraisal_approval_status_2 == '1' && $u->appraisal_approval_status_3 == '1' && $u->appraisal_approval_status_4 == '1' && $u->appraisal_approval_status_5 == '1' && $u->appraisal_approval_status_6 == '1') {
                            array_push($data, $u);
                        }
                    }
                }
            } else {
                if($u->appraisal_status == 'OPEN' || $u->appraisal_status == 'IN PROGRESS') {
                    if($u->appraisal_approval_status_1 == NULL && $u->approval_nik_1 == Auth::user()->user_nik) {
                        array_push($data, $u);
                    } else if($u->appraisal_approval_status_2 == NULL && $u->approval_nik_2 == Auth::user()->user_nik) {
                        if($u->appraisal_approval_status_1 == '1') {
                            array_push($data, $u);
                        }
                    } else if($u->appraisal_approval_status_hr == NULL && $u->approval_nik_hr == Auth::user()->user_nik) {
                        if($u->approval_nik_1 == NULL) {
                            array_push($data, $u);
                        } else if($u->approval_nik_2 == NULL && $u->appraisal_approval_status_1 == '1') {
                            array_push($data, $u);
                        } else if($u->appraisal_approval_status_2 == '1') {
                            array_push($data, $u);
                        }
                    }
                }
            }
        }

    	return datatables()->of($data)->addIndexColumn()
    		->addColumn('action_needed', function($data) {
    			return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
    		})
    		->addColumn('view', function($data) {
    			if($data->appraisal_status == null || $data->appraisal_status == 'DRAFT') {
                    return '<a href="javascript:;" data-toggle="tooltip" title="Lock"><i class="fa fa-lock"></i></a>';
                } else if($data->appraisal_status == 'IN PROGRESS') {
                    return '<a href="javascript:;" class="'.($data->grade_group_name == 'Staff' ? 'btn-view_in_progress_staff' : 'btn-view_in_progress').'" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
                } else if($data->appraisal_status == 'CLOSED') {
                    return '<a href="javascript:;" class="'.($data->grade_group_name == 'Staff' ? 'btn-view_closed_staff' : 'btn-view_closed').'" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
                }
    		})
    		->rawColumns(['action_needed', 'view'])
    	->toJson();
    }

    public function sendMailApproved(Request $request)
    {
        try {
            \Mail::to(['address' => $request->recipient_email])
                ->cc($this->cc_email)
            ->send(new AppraisalApprovedMail($request));
        } catch (\Throwable $th) {
            throw new Exception("Failed To Send Email", 1);
        }

        return "Email Sent";
    }

    public function sendMailReject(Request $request)
    {
        try {
            \Mail::to(['address' => $request->recipient_email])
                ->cc($this->cc_email)
            ->send(new AppraisalRejectMail($request));
        } catch (\Throwable $th) {
            throw new Exception("Failed To Send Email", 1);
        }

        return "Email Sent";
    }
}
