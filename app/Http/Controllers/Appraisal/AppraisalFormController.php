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
use App\Model\Appraisal\CompetencyNew;
use App\Model\Appraisal\CompetencyStaff;
use App\Model\Appraisal\Milestone;
use App\Model\Plugin\PluginPeriod;

use App\Mail\MailAppraisal\AppraisalMail;
use App\Mail\MailAppraisal\AppraisalFeedbackMail;
use App\Mail\MailAppraisal\AppraisalMilestoneMail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB, Exception;

class AppraisalFormController extends Controller
{
    protected $cc_email;
    protected $excluded_title;
    protected $grade_staff;

    public function __construct()
    {
        // CC EMAIL : SYSTEM IMAWIPROITE
        $this->cc_email = array(
            'system.imawiproite@wipro-unza.co.id'
        );

        $this->excluded_title = array(73); // Management Trainee
        $this->grade_staff = array(5, 6); // Grade Staff
    }

    public function index()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        $period_before = PluginPeriod::where('period_name', ((int) explode('-', $period_name)[0] - 1).'-'.((int) explode('-', $period_name)[1] - 1))->first();

        $appraisal_period = AppraisalPeriod::where('period_id', $period->period_id)->first();

        // APPRAISAL STAFF
        if(in_array(Auth::user()->grade_id, $this->grade_staff)) {
            if(date('Y-m-d') >= $appraisal_period->appraisal_staff_period_start && date('Y-m-d') <= $appraisal_period->appraisal_staff_period_end) {
                $work_days = User::query()
                    ->selectRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) AS work_days')
                    ->where('user_id', Auth::user()->user_id)
                ->first()->work_days;

                // WORK DAYS 6 MONTHS
                if($work_days > 180) {
                    $appraisal_exist = AppraisalStaffMain::where('period_id', $period->period_id)
                        ->where('user_id', Auth::user()->user_id)
                    ->exists();

                    if($appraisal_exist) {
                        $appraisal = AppraisalStaffMain::where('period_id', $period->period_id)
                            ->where('user_id', Auth::user()->user_id)
                        ->first();
                    } else {
                        $appraisal = new AppraisalStaffMain();
                        $appraisal->appraisal_user_nik = Auth::user()->user_nik;
                        $appraisal->appraisal_user_name = Auth::user()->user_name;
                        $appraisal->user_id = Auth::user()->user_id;
                        $appraisal->period_id = $period->period_id;
                        $appraisal->department_id = Auth::user()->department_id;
                        $appraisal->appraisal_status = 'DRAFT';
                        $appraisal->created_by = Auth::user()->user_name;
                        $appraisal->updated_by = Auth::user()->user_name;
                        $appraisal->save();
                    }

                    if($appraisal->appraisal_status == 'CLOSED') {
                        $message = "You have completed your Appraisal";

                        return view('appraisal.form_done', compact('message'));
                    } else {
                        $objective = AppraisalStaffObjective::query()
                            ->where('appraisal_staff_id', $appraisal->appraisal_staff_id)
                        ->get();
                        
                        $competency_template = CompetencyStaff::where('competency_status', '1')->get();

                        $competency = CompetencyStaff::query()
                            ->selectRaw('mst_appraisal_competency_staff.*,
                                asc.employee_rating,
                                asc.appraisal_staff_id')
                            ->leftJoin('trans_appraisal_staff_competency AS asc', 'asc.competency_staff_id', 'mst_appraisal_competency_staff.competency_staff_id')
                            ->leftJoin('trans_appraisal_staff_main AS asm', 'asm.appraisal_staff_id', 'asc.appraisal_staff_id')
                            ->where('asm.period_id', $period->period_id)
                            ->where('asm.user_id', Auth::user()->user_id)
                            ->where('mst_appraisal_competency_staff.competency_status', '1')
                            ->groupBy('mst_appraisal_competency_staff.competency_staff_id')
                        ->get();

                        $objective_next = AppraisalStaffObjectiveNext::query()
                            ->where('appraisal_staff_id', $appraisal->appraisal_staff_id)
                        ->get();

                        $objective_from_last_year = AppraisalStaffMain::query()
                            ->selectRaw('next.*')
                            ->leftJoin('trans_appraisal_staff_objective_next AS next', 'next.appraisal_staff_id', 'trans_appraisal_staff_main.appraisal_staff_id')
                            ->where('trans_appraisal_staff_main.user_id', Auth::user()->user_id)
                            ->where('trans_appraisal_staff_main.period_id', $period_before->period_id)
                        ->get();

                        return view('appraisal.form_staff', compact('appraisal', 'objective', 'competency_template', 'competency', 'objective_next', 'objective_from_last_year'));
                    }
                } else {
                    $message = "You haven't work in Wipro Unza Indonesia for more than 6 months";
    
                    return view('appraisal.form_done', compact('message'));
                }
            } else {
                $message = "Its not the time for Appraisal";
    
                return view('appraisal.form_done', compact('message'));
            }
        } 
        // APPRAISAL SUPERVISOR AND ABOVE
        else {
            if(date('Y-m-d') >= $appraisal_period->appraisal_period_start && date('Y-m-d') <= $appraisal_period->appraisal_period_end) {
                $work_days = User::query()
                    ->selectRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) AS work_days')
                    ->where('user_id', Auth::user()->user_id)
                ->first()->work_days;
    
                // WORK DAYS 6 MONTHS
                if($work_days > 180) {
                    if(!in_array(Auth::user()->title_id, $this->excluded_title)) {
                        $appraisal_exist = AppraisalMain::where('period_id', $period->period_id)
                            ->where('user_id', Auth::user()->user_id)
                        ->exists();
    
                        if($appraisal_exist) {
                            $appraisal = AppraisalMain::where('period_id', $period->period_id)
                                ->where('user_id', Auth::user()->user_id)
                            ->first();
                        } else {
                            $appraisal = new AppraisalMain();
                            $appraisal->appraisal_status = 'DRAFT';
                            $appraisal->appraisal_milestone_status = 'DRAFT';
                            $appraisal->appraisal_user_title = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                            $appraisal->appraisal_user_nik = Auth::user()->user_nik;
                            $appraisal->appraisal_user_name = Auth::user()->user_name;
                            $appraisal->user_id = Auth::user()->user_id;
                            $appraisal->period_id = $period->period_id;
                            $appraisal->department_id = Auth::user()->department_id;
                            $appraisal->grade_group_id = Grade::where('grade_id', Auth::user()->grade_id)->first()->grade_group_id;
                            $appraisal->created_by = Auth::user()->user_name;
                            $appraisal->updated_by = Auth::user()->user_name;
                            $appraisal->save();
                        }
    
                        if($appraisal->appraisal_status == 'CLOSED') {
                            $message = "You have completed your Appraisal";
    
                            return view('appraisal.form_done', compact('message'));
                        } else {
                            $period_name_arr = explode('-', $period_name);
                            $period_next_name = ((int) $period_name_arr[0] + 1).'-'.((int) $period_name_arr[1] + 1);
                            $period_next = PluginPeriod::where('period_name', $period_next_name)->first();
    
                            $milestone_template = Milestone::where('milestone_status', '1')->get();
    
                            $competency_template = CompetencyNew::where('competency_status', '1')->get();

                            $competency = CompetencyNew::query()
                                ->selectRaw('mst_appraisal_competency_new.*,
                                    acn.employee_rating,
                                    acn.appraisal_id')
                                ->leftJoin('trans_appraisal_competency_new AS acn', 'acn.competency_new_id', 'mst_appraisal_competency_new.competency_new_id')
                                ->leftJoin('trans_appraisal_main AS am', 'am.appraisal_id', 'acn.appraisal_id')
                                ->where('am.period_id', $period->period_id)
                                ->where('am.user_id', Auth::user()->user_id)
                                ->where('mst_appraisal_competency_new.competency_status', '1')
                                ->groupBy('mst_appraisal_competency_new.competency_new_id')
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
                                ->where('trans_appraisal_main.period_id', $period->period_id)
                                ->where('trans_appraisal_main.user_id', Auth::user()->user_id)
                            ->get();
    
                            if($appraisal->appraisal_milestone_status == 'APPROVED') {
                                $milestone = AppraisalMilestoneDetail::query()
                                    ->selectRaw('trans_appraisal_milestone_detail.appraisal_milestone_detail_id,
                                        trans_appraisal_milestone_detail.milestone_description,
                                        trans_appraisal_milestone_detail.milestone_measurement,
                                        trans_appraisal_milestone_detail.employee_assessment,
                                        trans_appraisal_milestone_detail.appraisal_milestone_id,
                                        tam.milestone_id,
                                        mam.milestone_eng,
                                        mam.milestone_bhs')
                                    ->leftJoin('trans_appraisal_milestone AS tam', 'tam.appraisal_milestone_id', 'trans_appraisal_milestone_detail.appraisal_milestone_id')
                                    ->leftJoin('mst_appraisal_milestone AS mam', 'mam.milestone_id', 'tam.milestone_id')
                                    ->where('tam.appraisal_id', $appraisal->appraisal_id)
                                ->get();
    
                                return view('appraisal.form', compact('appraisal', 'milestone_template', 'milestone', 'competency_template', 'competency', 'milestone_next'));
                            } else {
                                $milestone = AppraisalMilestone::query()
                                    ->selectRaw('trans_appraisal_milestone.appraisal_id,
                                        trans_appraisal_milestone.appraisal_milestone_id,
                                        trans_appraisal_milestone.milestone_id,
                                        amd.appraisal_milestone_detail_id,
                                        amd.milestone_description,
                                        amd.milestone_measurement,
                                        amd.employee_assessment')
                                    ->join('trans_appraisal_main AS am', 'am.appraisal_id', 'trans_appraisal_milestone.appraisal_id')
                                    ->leftJoin('trans_appraisal_milestone_detail AS amd', 'amd.appraisal_milestone_id', 'trans_appraisal_milestone.appraisal_milestone_id')
                                    ->where('am.period_id', $period->period_id)
                                    ->where('am.user_id', Auth::user()->user_id)
                                ->get();

                                $milestone_from_last_year = AppraisalMilestoneNext::query()
                                    ->selectRaw('trans_appraisal_milestone_next.appraisal_id,
                                        trans_appraisal_milestone_next.appraisal_milestone_next_id,
                                        trans_appraisal_milestone_next.milestone_id,
                                        amnd.appraisal_milestone_next_detail_id,
                                        amnd.milestone_description,
                                        amnd.milestone_measurement')
                                    ->join('trans_appraisal_main AS am', 'am.appraisal_id', 'trans_appraisal_milestone_next.appraisal_id')
                                    ->leftJoin('trans_appraisal_milestone_next_detail AS amnd', 'amnd.appraisal_milestone_next_id', 'trans_appraisal_milestone_next.appraisal_milestone_next_id')
                                    ->where('am.period_id', $period_before->period_id)
                                    ->where('am.user_id', Auth::user()->user_id)
                                ->get();
    
                                return view('appraisal.milestone_form', compact('appraisal', 'milestone_template', 'milestone', 'milestone_from_last_year'));
                            }
                        }
                    } else {
                        $message = "You work in Wipro Unza Indonesia as Management Trainee, Contact HR for more information";
    
                        return view('appraisal.form_done', compact('message'));
                    }
                } else {
                    $message = "You haven't work in Wipro Unza Indonesia for more than 6 months";
    
                    return view('appraisal.form_done', compact('message'));
                }
            } else {
                $message = "Its not the time for Appraisal";
    
                return view('appraisal.form_done', compact('message'));
            }
        }
    }

    public function store(Request $request)
    {
    	$message = '';
        $email = (object) array();

        DB::transaction(function() use ($request, &$message, &$email) {
            $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
            $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
            $period = PluginPeriod::where('period_name', $period_name)->first();

            $appraisal_exist = AppraisalMain::where('user_id', Auth::user()->user_id)
                ->where('period_id', $period->period_id)
            ->exists();

            if($appraisal_exist) {
                $appraisal = AppraisalMain::where('user_id', Auth::user()->user_id)
                    ->where('period_id', $period->period_id)
                ->first();
            } else {
                $appraisal = new AppraisalMain();
                $appraisal->user_id = Auth::user()->user_id;
                $appraisal->period_id = $period->period_id;
                $appraisal->department_id = Auth::user()->department_id;
                $appraisal->grade_group_id = Grade::where('grade_id', Auth::user()->grade_id)->first()->grade_group_id;
                $appraisal->created_by = Auth::user()->user_name;
            }

            $appraisal->personal_development_employee = $request->personal_development_employee;
            $appraisal->career_development_employee = $request->career_development_employee;
            $appraisal->appraisal_status = $request->appraisal_status;
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
                        foreach($request->milestone_description[$milestone_id] as $key => $milestone_desc) {
                            if($request->milestone_description[$milestone_id][$key] != NULL || $request->milestone_measurement[$milestone_id][$key] != NULL || $request->employee_assessment[$milestone_id][$key] != NULL) {
                                if($request->appraisal_milestone_detail_id[$milestone_id][$key] != NULL) {
                                    $detail = AppraisalMilestoneDetail::where('appraisal_milestone_detail_id', $request->appraisal_milestone_detail_id[$milestone_id][$key])->first();
                                } else {
                                    $detail = new AppraisalMilestoneDetail();
                                    $detail->created_by = Auth::user()->user_name;
                                }
                                
                                $detail->appraisal_milestone_id = $milestone->appraisal_milestone_id;
                                $detail->milestone_description = $request->milestone_description[$milestone_id][$key];
                                $detail->milestone_measurement = $request->milestone_measurement[$milestone_id][$key];
                                $detail->employee_assessment = $request->employee_assessment[$milestone_id][$key];
                                $detail->updated_by = Auth::user()->user_name;
                                $detail->save();
                            }
                        }
                    }
                }
            }

            if(count($request->competency_new_id) > 0) {
                foreach($request->competency_new_id as $key => $value) {
                    $competency_exist = AppraisalCompetencyNew::where('appraisal_id', $appraisal->appraisal_id)
                        ->where('competency_new_id', $value)
                    ->exists();

                    if($competency_exist) {
                        $competency = AppraisalCompetencyNew::where('appraisal_id', $appraisal->appraisal_id)
                            ->where('competency_new_id', $value)
                        ->first();
                        $competency->employee_rating = $request->employee_rating[$key] ?? NULL;
                        $competency->updated_by = Auth::user()->user_name;
                        $competency->save();
                    } else {
                        $competency = new AppraisalCompetencyNew();
                        $competency->competency_new_id = $value;
                        $competency->appraisal_id = $appraisal->appraisal_id;
                        $competency->employee_rating = $request->employee_rating[$key] ?? NULL;
                        $competency->created_by = Auth::user()->user_name;
                        $competency->updated_by = Auth::user()->user_name;
                        $competency->save();
                    }
                }
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
                    } else {
                        $milestone_next = new AppraisalMilestoneNext();
                        $milestone_next->milestone_id = $milestone_id_next;
                        $milestone_next->appraisal_id = $appraisal->appraisal_id;
                        $milestone_next->created_by = Auth::user()->user_name;
                        $milestone_next->updated_by = Auth::user()->user_name;
                        $milestone_next->save();
                    }

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
                }
            }

            if($request->appraisal_status == 'DRAFT') {
                $message = 'Saved as Draft';
            } else if($request->appraisal_status == 'IN PROGRESS') {
                $message = 'Submitted to Superior';
            }

            $matrix = ApprovalMatrix::query()
                ->selectRaw('mst_main_user_approval_matrix.*')
                ->where('mst_main_user_approval_matrix.user_nik', Auth::user()->user_nik)
            ->first();

            if($matrix->approval_nik_1 == NULL) {
                $recipient = User::where('user_nik', $matrix->approval_nik_hr)->first();
            } else {
                $recipient = User::where('user_nik', $matrix->approval_nik_1)->first();
            }

            $department = Departement::where('department_id', Auth::user()->department_id)->first();
            $level = GradeGroup::query()
                ->selectRaw('mst_main_user_grade_group.grade_group_name')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_group_id', 'mst_main_user_grade_group.grade_group_id')
                ->where('g.grade_id', Auth::user()->grade_id)
            ->first();

            $email->recipient_name = $recipient->user_name;
            $email->recipient_email = $recipient->user_email;
            $email->nik = Auth::user()->user_nik;
            $email->employee = Auth::user()->user_name;
            $email->department = $department->department_name;
            $email->level = $level->grade_group_name;
        });

    	return response()->json([$message, $email]);
    }

    public function storeMilestone(Request $request)
    {
        $message = '';
        $email = (object) array();

        DB::transaction(function() use ($request, &$message, &$email) {
            $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
            $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
            $period = PluginPeriod::where('period_name', $period_name)->first();

            $appraisal_exist = AppraisalMain::where('user_id', Auth::user()->user_id)
                ->where('period_id', $period->period_id)
            ->exists();

            if($appraisal_exist) {
                $appraisal = AppraisalMain::where('user_id', Auth::user()->user_id)
                    ->where('period_id', $period->period_id)
                ->first();
            } else {
                $appraisal = new AppraisalMain();
                $appraisal->appraisal_user_title = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
                $appraisal->appraisal_user_nik = Auth::user()->user_nik;
                $appraisal->appraisal_user_name = Auth::user()->user_name;
                $appraisal->user_id = Auth::user()->user_id;
                $appraisal->period_id = $period->period_id;
                $appraisal->department_id = Auth::user()->department_id;
                $appraisal->grade_group_id = Grade::where('grade_id', Auth::user()->grade_id)->first()->grade_group_id;
                $appraisal->created_by = Auth::user()->user_name;
            }

            $appraisal->appraisal_milestone_status = $request->appraisal_milestone_status;
            $appraisal->appraisal_approval_nik_milestone = NULL;
            $appraisal->appraisal_approval_name_milestone = NULL;
            $appraisal->appraisal_approval_nik_hr = NULL;
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

            if($request->appraisal_milestone_status == 'DRAFT') {
                $message = 'Saved as Draft';
            } else if($request->appraisal_milestone_status == 'PENDING') {
                $message = 'Submitted to Superior';
            }

            $approval_matrix = ApprovalMatrix::where('user_nik', $appraisal->appraisal_user_nik)->first();

            if($approval_matrix->approval_nik_1 == NULL) {
                $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();
            } else {
                $recipient = User::where('user_nik', $approval_matrix->approval_nik_1)->first();
            }

            $department = Departement::where('department_id', Auth::user()->department_id)->first();
            $level = GradeGroup::query()
                ->selectRaw('mst_main_user_grade_group.grade_group_name')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_group_id', 'mst_main_user_grade_group.grade_group_id')
                ->where('g.grade_id', Auth::user()->grade_id)
            ->first();

            $email->recipient_name = $recipient->user_name;
            $email->recipient_email = $recipient->user_email;
            $email->nik = Auth::user()->user_nik;
            $email->employee = Auth::user()->user_name;
            $email->department = $department->department_name;
            $email->level = $level->grade_group_name;
        });

        return response()->json([$message, $email]);
    }

    public function storeAppraisalStaff(Request $request)
    {
        $message = '';
        $email = (object) array();

        DB::transaction(function() use ($request, &$message, &$email) {
            $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
            $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
            $period = PluginPeriod::where('period_name', $period_name)->first();

            $appraisal_exist = AppraisalStaffMain::where('user_id', Auth::user()->user_id)
                ->where('period_id', $period->period_id)
            ->exists();

            if($appraisal_exist) {
                $appraisal = AppraisalStaffMain::where('user_id', Auth::user()->user_id)
                    ->where('period_id', $period->period_id)
                ->first();
            } else {
                $appraisal = new AppraisalStaffMain();
                $appraisal->user_id = Auth::user()->user_id;
                $appraisal->period_id = $period->period_id;
                $appraisal->department_id = Auth::user()->department_id;
                $appraisal->created_by = Auth::user()->user_name;
            }

            $appraisal->appraisal_status = $request->appraisal_status;
            $appraisal->training_employee = $request->training_employee;
            $appraisal->career_development_employee = $request->career_development_employee;
            $appraisal->overall_objective_score = NULL;
            $appraisal->overall_competency_score = NULL;
            $appraisal->overall_performance_score = NULL;
            $appraisal->appraisal_user_title = Title::where('title_id', Auth::user()->title_id)->first()->title_name;
            $appraisal->appraisal_user_nik = Auth::user()->user_nik;
            $appraisal->appraisal_user_name = Auth::user()->user_name;
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
            $appraisal->appraisal_approval_status_hr = NULL;
            $appraisal->appraisal_approval_title_hr = NULL;
            $appraisal->appraisal_approval_nik_hr = NULL;
            $appraisal->appraisal_approval_name_hr = NULL;
            $appraisal->appraisal_approval_date_hr = NULL;
            $appraisal->appraisal_approval_reject_note = NULL;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();

            if(count($request->objective_description) > 0) {
                AppraisalStaffObjective::where('appraisal_staff_id', $appraisal->appraisal_staff_id)->forceDelete();
                foreach($request->objective_description as $key => $objective_description) {
                    if($objective_description != NULL || $request->employee_assessment[$key] != NULL) {
                        $objective = new AppraisalStaffObjective();
                        $objective->appraisal_staff_id = $appraisal->appraisal_staff_id;
                        $objective->objective_description = $objective_description;
                        $objective->employee_assessment = $request->employee_assessment[$key];
                        $objective->created_by = Auth::user()->user_name;
                        $objective->updated_by = Auth::user()->user_name;
                        $objective->save();
                    }
                }
            }

            if(count($request->competency_staff_id) > 0) {
                foreach($request->competency_staff_id as $key => $value) {
                    $competency_exist = AppraisalStaffCompetency::where('appraisal_staff_id', $appraisal->appraisal_staff_id)
                        ->where('competency_staff_id', $value)
                    ->exists();

                    if($competency_exist) {
                        $competency = AppraisalStaffCompetency::where('appraisal_staff_id', $appraisal->appraisal_staff_id)
                            ->where('competency_staff_id', $value)
                        ->first();
                        $competency->employee_rating = isset($request->employee_rating[$key]) ? $request->employee_rating[$key] : null;
                        $competency->updated_by = Auth::user()->user_name;
                        $competency->save();
                    } else {
                        $competency = new AppraisalStaffCompetency();
                        $competency->competency_staff_id = $value;
                        $competency->appraisal_staff_id = $appraisal->appraisal_staff_id;
                        $competency->employee_rating = isset($request->employee_rating[$key]) ? $request->employee_rating[$key] : null;
                        $competency->created_by = Auth::user()->user_name;
                        $competency->updated_by = Auth::user()->user_name;
                        $competency->save();
                    }
                }
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

            if($request->appraisal_status == 'DRAFT') {
                $message = 'Saved as Draft';
            } else if($request->appraisal_status == 'IN PROGRESS') {
                $message = 'Submitted to Superior';
            }

            $approval_matrix = ApprovalMatrix::where('user_nik', $appraisal->appraisal_user_nik)->first();

            if($approval_matrix->approval_nik_1 == NULL) {
                $recipient = User::where('user_nik', $approval_matrix->approval_nik_hr)->first();
            } else {
                $recipient = User::where('user_nik', $approval_matrix->approval_nik_1)->first();
            }

            $email->recipient_name = $recipient->user_name;
            $email->recipient_email = $recipient->user_email;
            $email->nik = Auth::user()->user_nik;
            $email->employee = Auth::user()->user_name;
            $email->department = Departement::where('department_id', Auth::user()->department_id)->first()->department_name;
            $email->level = 'Staff';
        });

        return response()->json([$message, $email]);
    }

    public function sendMilestoneMail(Request $request)
    {
        try {
            \Mail::to(['address' => $request->recipient_email])
                ->cc($this->cc_email)
            ->send(new AppraisalMilestoneMail($request));
        } catch (\Throwable $th) {
            throw new Exception("Failed To Send Email", 1);
        }

        return "Email Sent";
    }

    public function sendMail(Request $request)
    {
        try {
            \Mail::to(['address' => $request->recipient_email])
                ->cc($this->cc_email)
            ->send(new AppraisalMail($request));
        } catch (\Throwable $th) {
            throw new Exception("Failed To Send Email", 1);
        }

        return "Email Sent";
    }

    public function sendMailFeedback(Request $request)
    {
        try {
            \Mail::to(['address' => $request->recipient_email])
                ->cc($this->cc_email)
            ->send(new AppraisalFeedbackMail($request));
        } catch (\Throwable $th) {
            throw new Exception("Failed To Send Email", 1);
        }

        return "Email Sent";
    }
}
