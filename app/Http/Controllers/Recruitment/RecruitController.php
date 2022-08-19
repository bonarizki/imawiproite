<?php

namespace App\Http\Controllers\Recruitment;

use App\Model\User;
use App\Model\ApprovalMatrix;
use App\Model\Grade;
use App\Model\Title;
use App\Model\Plugin\PluginPeriod;
use App\Model\Recruitment\PointOfHire;
use App\Model\Recruitment\Recruit;

use App\Mail\MailRecruitment\RecruitmentMail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB, PDF, Exception;

class RecruitController extends Controller
{
	protected $super_admin;
	protected $super_admin_nik;
	protected $ceo;
	protected $hr;
    protected $hr_processor;
    protected $cc_email;

	public function __construct()
	{
		// SUPER ADMIN : CHRIS SIMON, HUSIN, MUHAMMAD BONA RIZKI
		$this->super_admin = array(221, 454, 477);
		$this->super_admin_nik = array('65161410', '75862004', '76112008');

		// CEO : AMIT KUMAR DAWN
		$this->ceo = array(408);

		// HR : NI MADE SRI ANDANI, ARDHINI RETNO PUTRI, ATIKAH MARDHIAH DJULA, CORY HEPATY MANISA, YULIANA WIDYANTARI, ANDRIYANI
		$this->hr = array(152, 279, 515, 659, 169, 164);

        // HR PROCESSOR : ARDHINI RETNO PUTRI, ATIKAH MARDHIAH DJULA, CORY HEPATY MANISA, YULIANA WIDYANTARI, ANDRIYANI
        $this->hr_processor = array(279, 515, 659, 169, 164);

        // CC EMAIL : SYSTEM IMAWIPROITE, ARDHINI RETNO PUTRI, ATIKAH MARDHIAH DJULA, CORY HEPATY MANISA, YULIANA WIDYANTARI, ANDRIYANI
        $this->cc_email = array(
            'system.imawiproite@wipro-unza.co.id',
            'ardhini.retno@wipro-unza.co.id',
            'atikah.djula@wipro-unza.co.id',
            'cory.manisa@wipro-unza.co.id',
            'yuliana.w@wipro-unza.co.id'
        );
	}

    public function index()
    {
        $grade = Grade::orderBy('grade_code')->get();
        $title = Title::orderBy('title_name')->get();
        $point_of_hire = PointOfHire::orderBy('point_of_hire_name')->get();

        return view('recruitment.recruit', compact('grade', 'title', 'point_of_hire'));
    }

    public function status()
    {
    	$grade = Grade::orderBy('grade_code')->get();
        $title = Title::orderBy('title_name')->get();
        $point_of_hire = PointOfHire::orderBy('point_of_hire_name')->get();

        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        $super_admin = $this->super_admin;
        $hr = $this->hr;

    	return view('recruitment.status', compact('grade', 'title', 'point_of_hire', 'period_all', 'period', 'super_admin', 'hr'));
    }

    public function approval()
    {
    	$grade = Grade::orderBy('grade_code')->get();
        $title = Title::orderBy('title_name')->get();
        $point_of_hire = PointOfHire::orderBy('point_of_hire_name')->get();

    	return view('recruitment.approval', compact('grade', 'title', 'point_of_hire'));
    }

    public function store(Request $request)
    {
    	$rules = [
    		'title_id' => 'required',
    		'grade_id' => 'required',
    		'sex' => 'required',
    		'minimum_age' => 'required',
    		'maximum_age' => 'required',
    		'reason_for_request' => 'required',
            'point_of_hire_id' => 'required',
    		'employment_status' => 'required',
    		'expected_join_date' => 'required',
    		'recruitment_status' => 'required',
    		'education' => 'required',
    		'general_competency' => 'required',
    		'specific_competency' => 'required',
    		'job_description' => 'required',
    		'organization_structure' => 'required'
    	];

    	$message = [
    		'title_id.required' => 'Please Select A Title',
    		'grade_id.required' => 'Please Select A Grade',
    		'sex.required' => 'Please Select A Sex',
    		'minimum_age.required' => 'Please Fill Minimum Age',
    		'maximum_age.required' => 'Please Fill Maximum Age',
    		'reason_for_request.required' => 'Please Select Reason For Request',
            'point_of_hire_id.required' => 'Please Select A Point of Hire',
    		'employment_status.required' => 'Please Select An Employment Status',
    		'expected_join_date.required' => 'Please Fill Expected Join Date',
    		'recruitment_status.required' => 'Please Select A Recruitment Status',
    		'education.required' => 'Please Select An Education',
    		'general_competency.required' => 'Please Fill General Competency',
    		'specific_competency.required' => 'Please Fill Specific Competency',
    		'job_description.required' => 'Please Fill Job Description',
    		'organization_structure.required' => 'Please Fill Organization Structure'
    	];

    	if($request->employment_status == 'Permanent') {
    		$rules['probation_length'] = 'required';
    		$message['probation_length.required'] = 'Please Fill Probation Length';
    	} else if($request->employment_status == 'Contract') {
            $rules['contract_length'] = 'required';
            $message['contract_length.required'] = 'Please Fill Contract Length';
        } else if($request->employment_status == 'Internship') {
            $rules['internship_length'] = 'required';
            $message['internship_length.required'] = 'Please Fill Internship Length';
        } else if($request->employment_status == 'Daily Worker') {
            $rules['daily_worker_length'] = 'required';
            $rules['daily_worker_person'] = 'required';
            $message['daily_worker_length.required'] = 'Please Fill Daily Worker Length';
            $message['daily_worker_person.required'] = 'Please Fill Daily Worker Person Count';
        }

    	if($request->education == 'Other') {
    		$rules['education_other'] = 'required';
    		$message['education_other.required'] = 'Please Fill Education';
    	}

    	$this->validate($request, $rules, $message);

        $data = (object) array();

        DB::transaction(function() use ($request, $data) {
            $recruit = new Recruit();

            $recruit_exist = Recruit::where('request_year', date('Y'))->where('request_month', date('m'))->exists();

            if($recruit_exist) {
                $last_code = Recruit::where('request_year', date('Y'))->where('request_month', date('m'))->orderBy('request_code', 'DESC')->first()->request_code;

                $no_urut = (int) substr($last_code, 0, 3);
                $next_no_urut = $no_urut + 1;
                if($next_no_urut >= 100) {
                    $recruit->request_code = $next_no_urut.'/'.date('m').date('y').'RCT';
                } else if($next_no_urut >= 10) {
                    $recruit->request_code = '0'.$next_no_urut.'/'.date('m').date('y').'RCT';
                } else {
                    $recruit->request_code = '00'.$next_no_urut.'/'.date('m').date('y').'RCT';
                }
            } else {
                $recruit->request_code = '001/'.date('m').date('y').'RCT';
            }

            $recruit->request_date = date('Y-m-d');
            $recruit->request_year = date('Y');
            $recruit->request_month = date('m');
            $recruit->sex = $request->sex;
            $recruit->minimum_age = $request->minimum_age;
            $recruit->maximum_age = $request->maximum_age;
            $recruit->reason_for_request = $request->reason_for_request;
            $recruit->employment_status = $request->employment_status;

            if($recruit->employment_status == 'Permanent') {
                $recruit->probation_length = $request->probation_length;
            } else if($recruit->employment_status == 'Contract') {
                $recruit->contract_length = $request->contract_length;
            } else if($recruit->employment_status == 'Internship') {
                $recruit->internship_length = $request->internship_length;
            } else if($recruit->employment_status == 'Daily Worker') {
                $recruit->daily_worker_length = $request->daily_worker_length;
                $recruit->daily_worker_person = $request->daily_worker_person;
            }

            $expected_join_date = date_create($request->expected_join_date);
            $recruit->expected_join_date = date_format($expected_join_date, 'Y-m-d');
            $recruit->recruitment_status = $request->recruitment_status;
            $recruit->education = $request->education;

            if($recruit->education == 'Other') {
                $recruit->education_other = $request->education_other;
            }

            $recruit->general_competency = $request->general_competency;
            $recruit->specific_competency = $request->specific_competency;
            $recruit->job_description = $request->job_description;
            $recruit->special_note = $request->special_note;
            $recruit->basic_salary = str_replace(',', '', $request->basic_salary);
            $recruit->allowances = str_replace(',', '', $request->allowances);
            $recruit->organization_structure = $request->organization_structure;
            $recruit->organization_structure_attach = $request->organization_structure_attach;
            $recruit->user_id = Auth::user()->user_id;
            $recruit->title_id = $request->title_id;
            $recruit->grade_id = $request->grade_id;
            $recruit->point_of_hire_id = $request->point_of_hire_id;
            $recruit->department_id = Auth::user()->department_id;

            $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
            $period = PluginPeriod::where('period_name', $period_name)->first();

            $recruit->period_id = $period->period_id;
            $recruit->created_by = Auth::user()->user_name;
            $recruit->updated_by = Auth::user()->user_name;

            $matrix = ApprovalMatrix::query()
                ->selectRaw('mst_main_user_approval_matrix.*,
                    u1.user_name AS approval_name_1,
                    u2.user_name AS approval_name_2,
                    u3.user_name AS approval_name_3,
                    u4.user_name AS approval_name_4,
                    u5.user_name AS approval_name_5,
                    u6.user_name AS approval_name_6,
                    uceo.user_name AS approval_name_ceo,
                    uhr.user_name AS approval_name_hr')
                ->leftJoin('mst_main_user AS u1', 'u1.user_nik', 'mst_main_user_approval_matrix.approval_nik_1')
                ->leftJoin('mst_main_user AS u2', 'u2.user_nik', 'mst_main_user_approval_matrix.approval_nik_2')
                ->leftJoin('mst_main_user AS u3', 'u3.user_nik', 'mst_main_user_approval_matrix.approval_nik_3')
                ->leftJoin('mst_main_user AS u4', 'u4.user_nik', 'mst_main_user_approval_matrix.approval_nik_4')
                ->leftJoin('mst_main_user AS u5', 'u5.user_nik', 'mst_main_user_approval_matrix.approval_nik_5')
                ->leftJoin('mst_main_user AS u6', 'u6.user_nik', 'mst_main_user_approval_matrix.approval_nik_6')
                ->leftJoin('mst_main_user AS uceo', 'uceo.user_nik', 'mst_main_user_approval_matrix.approval_nik_ceo')
                ->leftJoin('mst_main_user AS uhr', 'uhr.user_nik', 'mst_main_user_approval_matrix.approval_nik_hr')
                ->where('mst_main_user_approval_matrix.user_nik', Auth::user()->user_nik)
            ->first();

            $recruit->recruit_approval_nik_1 = $matrix->approval_nik_1;
            $recruit->recruit_approval_name_1 = $matrix->approval_name_1;
            $recruit->recruit_approval_nik_2 = $matrix->approval_nik_2;
            $recruit->recruit_approval_name_2 = $matrix->approval_name_2;
            $recruit->recruit_approval_nik_3 = $matrix->approval_nik_3;
            $recruit->recruit_approval_name_3 = $matrix->approval_name_3;
            $recruit->recruit_approval_nik_4 = $matrix->approval_nik_4;
            $recruit->recruit_approval_name_4 = $matrix->approval_name_4;
            $recruit->recruit_approval_nik_5 = $matrix->approval_nik_5;
            $recruit->recruit_approval_name_5 = $matrix->approval_name_5;
            $recruit->recruit_approval_nik_6 = $matrix->approval_nik_6;
            $recruit->recruit_approval_name_6 = $matrix->approval_name_6;
            $recruit->recruit_approval_nik_ceo = $matrix->approval_nik_ceo;
            $recruit->recruit_approval_name_ceo = $matrix->approval_name_ceo;
            $recruit->recruit_approval_nik_hr = $matrix->approval_nik_hr;
            $recruit->recruit_approval_name_hr = $matrix->approval_name_hr;

            $recruit->save();

            $request->merge([
                'request_code' => $recruit->request_code,
                'request_date' => $recruit->request_date,
                'request_year' => $recruit->request_year,
                'request_month' => $recruit->request_month,
                'user_id' => Auth::user()->user_id,
                'department_id' => Auth::user()->department_id,
                'period_id' => $recruit->period_id,
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name,
                'recruit_approval_nik_1' => $recruit->recruit_approval_nik_1,
                'recruit_approval_name_1' => $recruit->recruit_approval_name_1,
                'recruit_approval_nik_2' => $recruit->recruit_approval_nik_2,
                'recruit_approval_name_2' => $recruit->recruit_approval_name_2,
                'recruit_approval_nik_3' => $recruit->recruit_approval_nik_3,
                'recruit_approval_name_3' => $recruit->recruit_approval_name_3,
                'recruit_approval_nik_4' => $recruit->recruit_approval_nik_4,
                'recruit_approval_name_4' => $recruit->recruit_approval_name_4,
                'recruit_approval_nik_5' => $recruit->recruit_approval_nik_5,
                'recruit_approval_name_5' => $recruit->recruit_approval_name_5,
                'recruit_approval_nik_6' => $recruit->recruit_approval_nik_6,
                'recruit_approval_name_6' => $recruit->recruit_approval_name_6,
                'recruit_approval_nik_ceo' => $recruit->recruit_approval_nik_ceo,
                'recruit_approval_name_ceo' => $recruit->recruit_approval_name_ceo,
                'recruit_approval_nik_hr' => $recruit->recruit_approval_nik_hr,
                'recruit_approval_name_hr' => $recruit->recruit_approval_name_hr
            ]);

            \Helper::instance()->log('CREATE', $request, 'App\Model\Recruitment\Recruit');

            if($recruit->recruit_approval_nik_1 == NULL) {
                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_ceo)->first();
            } else {
                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_1)->first();
            }

            $data->recipient_name = $recipient->user_name;
            $data->recipient_email = $recipient->user_email;
            $data->recruit_code = $recruit->request_code;
            $data->recruit_request = $recruit->created_by;
            $data->recruit_title = Title::where('title_id', $recruit->title_id)->first()->title_name;

            $grade = Grade::where('grade_id', $recruit->grade_id)->first();

            $data->recruit_grade = '['.$grade->grade_code.'] '.$grade->grade_name;

        });

    	return response()->json($data);
    }

    public function update(Request $request)
    {
    	$rules = [
            'title_id' => 'required',
            'grade_id' => 'required',
            'sex' => 'required',
            'minimum_age' => 'required',
            'maximum_age' => 'required',
            'reason_for_request' => 'required',
            'point_of_hire_id' => 'required',
            'employment_status' => 'required',
            'expected_join_date' => 'required',
            'recruitment_status' => 'required',
            'education' => 'required',
            'general_competency' => 'required',
            'specific_competency' => 'required',
            'job_description' => 'required',
            'organization_structure' => 'required'
        ];

        $message = [
            'title_id.required' => 'Please Select A Title',
            'grade_id.required' => 'Please Select A Grade',
            'sex.required' => 'Please Select A Sex',
            'minimum_age.required' => 'Please Fill Minimum Age',
            'maximum_age.required' => 'Please Fill Maximum Age',
            'reason_for_request.required' => 'Please Select Reason For Request',
            'point_of_hire_id.required' => 'Please Select A Point of Hire',
            'employment_status.required' => 'Please Select An Employment Status',
            'expected_join_date.required' => 'Please Fill Expected Join Date',
            'recruitment_status.required' => 'Please Select A Recruitment Status',
            'education.required' => 'Please Select An Education',
            'general_competency.required' => 'Please Fill General Competency',
            'specific_competency.required' => 'Please Fill Specific Competency',
            'job_description.required' => 'Please Fill Job Description',
            'organization_structure.required' => 'Please Fill Organization Structure'
        ];

    	if($request->employment_status == 'Permanent') {
            $rules['probation_length'] = 'required';
            $message['probation_length.required'] = 'Please Fill Probation Length';
        } else if($request->employment_status == 'Contract') {
            $rules['contract_length'] = 'required';
            $message['contract_length.required'] = 'Please Fill Contract Length';
        } else if($request->employment_status == 'Internship') {
            $rules['internship_length'] = 'required';
            $message['internship_length.required'] = 'Please Fill Internship Length';
        } else if($request->employment_status == 'Daily Worker') {
            $rules['daily_worker_length'] = 'required';
            $message['daily_worker_length.required'] = 'Please Fill Daily Worker Length';
        }

    	if($request->education == 'Other') {
    		$rules['education_other'] = 'required';
    		$message['education_other.required'] = 'Please Fill Education';
    	}

    	$this->validate($request, $rules, $message);

    	DB::transaction(function() use ($request) {
            $request->merge([
                'recruit_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

            $recruit = Recruit::find($request->recruit_id);
            $recruit->sex = $request->sex;
            $recruit->minimum_age = $request->minimum_age;
            $recruit->maximum_age = $request->maximum_age;
            $recruit->reason_for_request = $request->reason_for_request;
            $recruit->employment_status = $request->employment_status;

            if($recruit->employment_status == 'Permanent') {
                $recruit->probation_length = $request->probation_length;
            } else if($recruit->employment_status == 'Contract') {
                $recruit->contract_length = $request->contract_length;
            } else if($recruit->employment_status == 'Internship') {
                $recruit->internship_length = $request->internship_length;
            } else if($recruit->employment_status == 'Daily Worker') {
                $recruit->daily_worker_length = $request->daily_worker_length;
            }

            $expected_join_date = date_create($request->expected_join_date);
            $recruit->expected_join_date = date_format($expected_join_date, 'Y-m-d');
            $recruit->recruitment_status = $request->recruitment_status;
            $recruit->education = $request->education;

            if($recruit->education == 'Other') {
                $recruit->education_other = $request->education_other;
            }

            $recruit->general_competency = $request->general_competency;
            $recruit->specific_competency = $request->specific_competency;
            $recruit->job_description = $request->job_description;
            $recruit->special_note = $request->special_note;
            $recruit->basic_salary = str_replace(',', '', $request->basic_salary);
            $recruit->allowances = str_replace(',', '', $request->allowances);
            $recruit->organization_structure = $request->organization_structure;
            $recruit->organization_structure_attach = $request->organization_structure_attach;
            $recruit->title_id = $request->title_id;
            $recruit->grade_id = $request->grade_id;
            $recruit->point_of_hire_id = $request->point_of_hire_id;
            $recruit->updated_by = Auth::user()->user_name;

            $recruit->save();
        });

    	return response()->json();
    }

    public function cancel(Request $request)
    {
    	$data = (object) array();

        DB::transaction(function() use ($request, $data) {
            $request->merge([
                'recruit_status' => 'CANCELED',
                'updated_by' => Auth::user()->user_name
            ]);

            $count = array();

            if($request->recruit_id) {

                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                foreach($request->recruit_id as $key => $value) {
                    $object = (object) array();

                    $recruit = Recruit::where('recruit_id', $value)->first();

                    if($recruit->recruit_status == 'PENDING' || $recruit->recruit_status == 'ON PROCESS') {
                        if($recruit->user_id == Auth::user()->user_id || in_array(Auth::user()->user_id, $this->super_admin)) {
                            $recruit->recruit_status = 'CANCELED';
                            $recruit->updated_by = Auth::user()->user_name;
                            $recruit->save();

                            $object->icon = "success";
                            $object->title = "Recruit ".$recruit->request_code." have been canceled";
                        } else {
                            $object->icon = "error";
                            $object->title = "You don't have the authority to cancel these recruits";
                        }
                    } else {
                        $object->icon = "error";
                        $object->title = "These recruits are already canceled";
                    }

                    array_push($count, $object);
                }
            } else {
                $object = (object) array();
                $object->icon = "error";
                $object->title = "No recruit selected";

                array_push($count, $object);
            }

            $data->data = $count;
        });

        return response()->json($data);
    }

    public function approve(Request $request)
    {
    	$data = (object) array();

        DB::transaction(function() use ($request, $data) {
            $count = array();

            if($request->recruit_id) {
                foreach($request->recruit_id as $key => $value) {
                    $object = (object) array();

                    $recruit = Recruit::where('recruit_id', $value)->first();

                    if(in_array(Auth::user()->user_id, $this->super_admin)) {
                        if($recruit->recruit_approval_nik_1 != NULL && $recruit->recruit_approval_status_1 == NULL) {
                            $request->merge([
                                'recruit_approval_status_1' => '1',
                                'recruit_approval_nik_1' => Auth::user()->user_nik,
                                'recruit_approval_name_1' => Auth::user()->user_name,
                                'recruit_approval_date_1' => date('Y-m-d'),
                                'recruit_approval_nik_2' => NULL,
                                'recruit_approval_nik_3' => NULL,
                                'recruit_approval_nik_4' => NULL,
                                'recruit_approval_nik_5' => NULL,
                                'recruit_approval_nik_6' => NULL
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_1 = '1';
                            $recruit->recruit_approval_nik_1 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_1 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_1 = date('Y-m-d');
                            $recruit->recruit_approval_note_1 = $request->note;
                            $recruit->recruit_approval_nik_2 = NULL;
                            $recruit->recruit_approval_nik_3 = NULL;
                            $recruit->recruit_approval_nik_4 = NULL;
                            $recruit->recruit_approval_nik_5 = NULL;
                            $recruit->recruit_approval_nik_6 = NULL;
                        } else if($recruit->recruit_approval_nik_2 != NULL && $recruit->recruit_approval_status_2 == NULL) {
                            $request->merge([
                                'recruit_approval_status_2' => '1',
                                'recruit_approval_nik_2' => Auth::user()->user_nik,
                                'recruit_approval_name_2' => Auth::user()->user_name,
                                'recruit_approval_date_2' => date('Y-m-d'),
                                'recruit_approval_nik_3' => NULL,
                                'recruit_approval_nik_4' => NULL,
                                'recruit_approval_nik_5' => NULL,
                                'recruit_approval_nik_6' => NULL
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_2 = '1';
                            $recruit->recruit_approval_nik_2 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_2 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_2 = date('Y-m-d');
                            $recruit->recruit_approval_note_2 = $request->note;
                            $recruit->recruit_approval_nik_3 = NULL;
                            $recruit->recruit_approval_nik_4 = NULL;
                            $recruit->recruit_approval_nik_5 = NULL;
                            $recruit->recruit_approval_nik_6 = NULL;
                        } else if($recruit->recruit_approval_nik_3 != NULL && $recruit->recruit_approval_status_3 == NULL) {
                            $request->merge([
                                'recruit_approval_status_3' => '1',
                                'recruit_approval_nik_3' => Auth::user()->user_nik,
                                'recruit_approval_name_3' => Auth::user()->user_name,
                                'recruit_approval_date_3' => date('Y-m-d'),
                                'recruit_approval_nik_4' => NULL,
                                'recruit_approval_nik_5' => NULL,
                                'recruit_approval_nik_6' => NULL
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_3 = '1';
                            $recruit->recruit_approval_nik_3 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_3 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_3 = date('Y-m-d');
                            $recruit->recruit_approval_note_3 = $request->note;
                            $recruit->recruit_approval_nik_4 = NULL;
                            $recruit->recruit_approval_nik_5 = NULL;
                            $recruit->recruit_approval_nik_6 = NULL;
                        } else if($recruit->recruit_approval_nik_4 != NULL && $recruit->recruit_approval_status_4 == NULL) {
                            $request->merge([
                                'recruit_approval_status_4' => '1',
                                'recruit_approval_nik_4' => Auth::user()->user_nik,
                                'recruit_approval_name_4' => Auth::user()->user_name,
                                'recruit_approval_date_4' => date('Y-m-d'),
                                'recruit_approval_nik_5' => NULL,
                                'recruit_approval_nik_6' => NULL
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_4 = '1';
                            $recruit->recruit_approval_nik_4 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_4 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_4 = date('Y-m-d');
                            $recruit->recruit_approval_note_4 = $request->note;
                            $recruit->recruit_approval_nik_5 = NULL;
                            $recruit->recruit_approval_nik_6 = NULL;
                        } else if($recruit->recruit_approval_nik_5 != NULL && $recruit->recruit_approval_status_5 == NULL) {
                            $request->merge([
                                'recruit_approval_status_5' => '1',
                                'recruit_approval_nik_5' => Auth::user()->user_nik,
                                'recruit_approval_name_5' => Auth::user()->user_name,
                                'recruit_approval_date_5' => date('Y-m-d'),
                                'recruit_approval_nik_6' => NULL
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_5 = '1';
                            $recruit->recruit_approval_nik_5 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_5 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_5 = date('Y-m-d');
                            $recruit->recruit_approval_note_5 = $request->note;
                            $recruit->recruit_approval_nik_6 = NULL;
                        } else if($recruit->recruit_approval_nik_6 != NULL && $recruit->recruit_approval_status_6 == NULL) {
                            $request->merge([
                                'recruit_approval_status_6' => '1',
                                'recruit_approval_nik_6' => Auth::user()->user_nik,
                                'recruit_approval_name_6' => Auth::user()->user_name,
                                'recruit_approval_date_6' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_6 = '1';
                            $recruit->recruit_approval_nik_6 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_6 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_6 = date('Y-m-d');
                            $recruit->recruit_approval_note_6 = $request->note;
                        } else if($recruit->recruit_approval_status_ceo == NULL) {
                            $request->merge([
                                'recruit_approval_status_ceo' => '1',
                                'recruit_approval_nik_ceo' => Auth::user()->user_nik,
                                'recruit_approval_name_ceo' => Auth::user()->user_name,
                                'recruit_approval_date_ceo' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_ceo = '1';
                            $recruit->recruit_approval_nik_ceo = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                            $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            $recruit->recruit_approval_note_ceo = $request->note;
                        } else if($recruit->recruit_approval_status_hr == NULL) {
                            $request->merge([
                                'recruit_approval_status_hr' => '1',
                                'recruit_approval_nik_hr' => Auth::user()->user_nik,
                                'recruit_approval_name_hr' => Auth::user()->user_name,
                                'recruit_approval_date_hr' => date('Y-m-d'),
                                'recruit_status' => 'ON PROCESS',
                                'lead_time_start' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_hr = '1';
                            $recruit->recruit_approval_nik_hr = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_hr = Auth::user()->user_name;
                            $recruit->recruit_approval_date_hr = date('Y-m-d');
                            $recruit->recruit_approval_note_hr = $request->note;
                            $recruit->recruit_status = 'ON PROCESS';
                            $recruit->lead_time_start = date('Y-m-d');
                        }

                        $recruit->save();

                        $object->icon = "success";
                        $object->title = "Recruits ".$recruit->request_code." have been approved";
                    } else {
                        if($recruit->recruit_approval_nik_1 != NULL && $recruit->recruit_approval_nik_1 == Auth::user()->user_nik && $recruit->recruit_approval_status_1 == NULL) {
                            $request->merge([
                                'recruit_approval_status_1' => '1',
                                'recruit_approval_name_1' => Auth::user()->user_name,
                                'recruit_approval_date_1' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_1 = '1';
                            $recruit->recruit_approval_name_1 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_1 = date('Y-m-d');
                            $recruit->recruit_approval_note_1 = $request->note;

                            if($recruit->recruit_approval_nik_1 == $recruit->recruit_approval_nik_ceo) {
                                $request->merge([
                                    'recruit_approval_status_ceo' => '1',
                                    'recruit_approval_name_ceo' => Auth::user()->user_name,
                                    'recruit_approval_date_ceo' => date('Y-m-d')
                                ]);

                                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                                $recruit->recruit_approval_status_ceo = '1';
                                $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                                $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            }

                            if($recruit->recruit_approval_nik_2 == NULL) {
                                if($recruit->recruit_approval_nik_1 == $recruit->recruit_approval_nik_ceo) {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_hr)->first();
                                } else {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_ceo)->first();
                                }
                            } else {
                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_2)->first();
                            }

                            $object->recipient_name = $recipient->user_name;
                            $object->recipient_email = $recipient->user_email;

                        } else if($recruit->recruit_approval_nik_2 != NULL && $recruit->recruit_approval_nik_2 == Auth::user()->user_nik && $recruit->recruit_approval_status_2 == NULL) {
                            $request->merge([
                                'recruit_approval_status_2' => '1',
                                'recruit_approval_name_2' => Auth::user()->user_name,
                                'recruit_approval_date_2' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_2 = '1';
                            $recruit->recruit_approval_name_2 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_2 = date('Y-m-d');
                            $recruit->recruit_approval_note_2 = $request->note;

                            if($recruit->recruit_approval_nik_2 == $recruit->recruit_approval_nik_ceo) {
                                $request->merge([
                                    'recruit_approval_status_ceo' => '1',
                                    'recruit_approval_name_ceo' => Auth::user()->user_name,
                                    'recruit_approval_date_ceo' => date('Y-m-d')
                                ]);

                                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                                $recruit->recruit_approval_status_ceo = '1';
                                $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                                $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            }

                            if($recruit->recruit_approval_nik_3 == NULL) {
                                if($recruit->recruit_approval_nik_2 == $recruit->recruit_approval_nik_ceo) {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_hr)->first();
                                } else {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_ceo)->first();
                                }
                            } else {
                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_3)->first();
                            }

                            $object->recipient_name = $recipient->user_name;
                            $object->recipient_email = $recipient->user_email;

                        } else if($recruit->recruit_approval_nik_3 != NULL && $recruit->recruit_approval_nik_3 == Auth::user()->user_nik && $recruit->recruit_approval_status_3 == NULL) {
                            $request->merge([
                                'recruit_approval_status_3' => '1',
                                'recruit_approval_name_3' => Auth::user()->user_name,
                                'recruit_approval_date_3' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_3 = '1';
                            $recruit->recruit_approval_name_3 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_3 = date('Y-m-d');
                            $recruit->recruit_approval_note_3 = $request->note;

                            if($recruit->recruit_approval_nik_3 == $recruit->recruit_approval_nik_ceo) {
                                $request->merge([
                                    'recruit_approval_status_ceo' => '1',
                                    'recruit_approval_name_ceo' => Auth::user()->user_name,
                                    'recruit_approval_date_ceo' => date('Y-m-d')
                                ]);

                                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                                $recruit->recruit_approval_status_ceo = '1';
                                $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                                $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            }

                            if($recruit->recruit_approval_nik_4 == NULL) {
                                if($recruit->recruit_approval_nik_3 == $recruit->recruit_approval_nik_ceo) {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_hr)->first();
                                } else {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_ceo)->first();
                                }
                            } else {
                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_4)->first();
                            }

                            $object->recipient_name = $recipient->user_name;
                            $object->recipient_email = $recipient->user_email;

                        } else if($recruit->recruit_approval_nik_4 != NULL && $recruit->recruit_approval_nik_4 == Auth::user()->user_nik && $recruit->recruit_approval_status_4 == NULL) {
                            $request->merge([
                                'recruit_approval_status_4' => '1',
                                'recruit_approval_name_4' => Auth::user()->user_name,
                                'recruit_approval_date_4' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_4 = '1';
                            $recruit->recruit_approval_name_4 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_4 = date('Y-m-d');
                            $recruit->recruit_approval_note_4 = $request->note;

                            if($recruit->recruit_approval_nik_4 == $recruit->recruit_approval_nik_ceo) {
                                $request->merge([
                                    'recruit_approval_status_ceo' => '1',
                                    'recruit_approval_name_ceo' => Auth::user()->user_name,
                                    'recruit_approval_date_ceo' => date('Y-m-d')
                                ]);

                                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                                $recruit->recruit_approval_status_ceo = '1';
                                $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                                $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            }

                            if($recruit->recruit_approval_nik_5 == NULL) {
                                if($recruit->recruit_approval_nik_4 == $recruit->recruit_approval_nik_ceo) {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_hr)->first();
                                } else {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_ceo)->first();
                                }
                            } else {
                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_5)->first();
                            }

                            $object->recipient_name = $recipient->user_name;
                            $object->recipient_email = $recipient->user_email;

                        } else if($recruit->recruit_approval_nik_5 != NULL && $recruit->recruit_approval_nik_5 == Auth::user()->user_nik && $recruit->recruit_approval_status_5 == NULL) {
                            $request->merge([
                                'recruit_approval_status_5' => '1',
                                'recruit_approval_name_5' => Auth::user()->user_name,
                                'recruit_approval_date_5' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_5 = '1';
                            $recruit->recruit_approval_name_5 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_5 = date('Y-m-d');
                            $recruit->recruit_approval_note_5 = $request->note;

                            if($recruit->recruit_approval_nik_5 == $recruit->recruit_approval_nik_ceo) {
                                $request->merge([
                                    'recruit_approval_status_ceo' => '1',
                                    'recruit_approval_name_ceo' => Auth::user()->user_name,
                                    'recruit_approval_date_ceo' => date('Y-m-d')
                                ]);

                                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                                $recruit->recruit_approval_status_ceo = '1';
                                $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                                $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            }

                            if($recruit->recruit_approval_nik_6 == NULL) {
                                if($recruit->recruit_approval_nik_5 == $recruit->recruit_approval_nik_ceo) {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_hr)->first();
                                } else {
                                    $recipient = User::where('user_nik', $recruit->recruit_approval_nik_ceo)->first();
                                }
                            } else {
                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_6)->first();
                            }

                            $object->recipient_name = $recipient->user_name;
                            $object->recipient_email = $recipient->user_email;

                        } else if($recruit->recruit_approval_nik_6 != NULL && $recruit->recruit_approval_nik_6 == Auth::user()->user_nik && $recruit->recruit_approval_status_6 == NULL) {
                            $request->merge([
                                'recruit_approval_status_6' => '1',
                                'recruit_approval_name_6' => Auth::user()->user_name,
                                'recruit_approval_date_6' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_6 = '1';
                            $recruit->recruit_approval_name_6 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_6 = date('Y-m-d');
                            $recruit->recruit_approval_note_6 = $request->note;

                            if($recruit->recruit_approval_nik_6 == $recruit->recruit_approval_nik_ceo) {
                                $request->merge([
                                    'recruit_approval_status_ceo' => '1',
                                    'recruit_approval_name_ceo' => Auth::user()->user_name,
                                    'recruit_approval_date_ceo' => date('Y-m-d')
                                ]);

                                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                                $recruit->recruit_approval_status_ceo = '1';
                                $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                                $recruit->recruit_approval_date_ceo = date('Y-m-d');

                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_hr)->first();
                            } else {
                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_ceo)->first();
                            }

                            $object->recipient_name = $recipient->user_name;
                            $object->recipient_email = $recipient->user_email;

                        } else if($recruit->recruit_approval_nik_ceo != NULL && $recruit->recruit_approval_nik_ceo == Auth::user()->user_nik && $recruit->recruit_approval_status_ceo == NULL) {
                            $request->merge([
                                'recruit_approval_status_ceo' => '1',
                                'recruit_approval_name_ceo' => Auth::user()->user_name,
                                'recruit_approval_date_ceo' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_ceo = '1';
                            $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                            $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            $recruit->recruit_approval_note_ceo = $request->note;

                            if($recruit->recruit_approval_nik_ceo == $recruit->recruit_approval_nik_hr) {
                                $request->merge([
                                    'recruit_approval_status_hr' => '1',
                                    'recruit_approval_name_hr' => Auth::user()->user_name,
                                    'recruit_approval_date_hr' => date('Y-m-d'),
                                    'recruit_status' => 'ON PROCESS',
                                    'lead_time_start' => date('Y-m-d')
                                ]);

                                \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                                $recruit->recruit_approval_status_hr = '1';
                                $recruit->recruit_approval_name_hr = Auth::user()->user_name;
                                $recruit->recruit_approval_date_hr = date('Y-m-d');
                                $recruit->recruit_status = 'ON PROCESS';
                                $recruit->lead_time_start = date('Y-m-d');

                                $object->status = "process";
                                $object->processor = array();

                                for($i=0; $i<count($this->hr_processor); $i++) {
                                    $object->processor[$i] = (object) array();

                                    $recipient = User::where('user_id', $this->hr_processor[$i])->first();

                                    $object->processor[$i]->recipient_name = $recipient->user_name;
                                    $object->processor[$i]->recipient_email = $recipient->user_email;
                                }
                            } else {
                                $recipient = User::where('user_nik', $recruit->recruit_approval_nik_hr)->first();

                                $object->recipient_name = $recipient->user_name;
                                $object->recipient_email = $recipient->user_email;
                            }
                        } else if($recruit->recruit_approval_nik_hr != NULL && $recruit->recruit_approval_nik_hr == Auth::user()->user_nik && $recruit->recruit_approval_status_hr == NULL) {
                            $request->merge([
                                'recruit_approval_status_hr' => '1',
                                'recruit_approval_name_hr' => Auth::user()->user_name,
                                'recruit_approval_date_hr' => date('Y-m-d'),
                                'recruit_status' => 'ON PROCESS',
                                'lead_time_start' => date('Y-m-d')
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_hr = '1';
                            $recruit->recruit_approval_name_hr = Auth::user()->user_name;
                            $recruit->recruit_approval_date_hr = date('Y-m-d');
                            $recruit->recruit_approval_note_hr = $request->note;
                            $recruit->recruit_status = 'ON PROCESS';
                            $recruit->lead_time_start = date('Y-m-d');

                            $object->status = "process";
                            $object->processor = array();

                            for($i=0; $i<count($this->hr_processor); $i++) {
                                $object->processor[$i] = (object) array();

                                $recipient = User::where('user_id', $this->hr_processor[$i])->first();

                                $object->processor[$i]->recipient_name = $recipient->user_name;
                                $object->processor[$i]->recipient_email = $recipient->user_email;
                            }
                        }

                        $recruit->save();

                        $object->icon = "success";
                        $object->title = "Recruits ".$recruit->request_code." have been approved";
                        $object->recruit_code = $recruit->request_code;
                        $object->recruit_request = $recruit->created_by;
                        $object->recruit_title = Title::where('title_id', $recruit->title_id)->first()->title_name;

                        $grade = Grade::where('grade_id', $recruit->grade_id)->first();

                        $object->recruit_grade = '['.$grade->grade_code.'] '.$grade->grade_name;
                    }

                    array_push($count, $object);
                }
            } else {
                $object = (object) array();
                $object->icon = "error";
                $object->title = "No recruit selected";

                array_push($count, $object);
            }

            $data->data = $count;
        });

        return response()->json($data);
    }

    public function reject(Request $request)
    {
    	$data = (object) array();

        DB::transaction(function() use ($request, $data) {
            $count = array();

            if($request->recruit_id) {
                foreach($request->recruit_id as $key => $value) {
                    $object = (object) array();

                    $recruit = Recruit::where('recruit_id', $value)->first();

                    if(in_array(Auth::user()->user_id, $this->super_admin)) {
                        if($recruit->recruit_approval_nik_1 != NULL && $recruit->recruit_approval_status_1 == NULL) {
                            $request->merge([
                                'recruit_approval_status_1' => '0',
                                'recruit_approval_nik_1' => Auth::user()->user_nik,
                                'recruit_approval_name_1' => Auth::user()->user_name,
                                'recruit_approval_date_1' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_1 = '0';
                            $recruit->recruit_approval_nik_1 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_1 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_1 = date('Y-m-d');
                            $recruit->recruit_approval_note_1 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_2 != NULL && $recruit->recruit_approval_status_2 == NULL) {
                            $request->merge([
                                'recruit_approval_status_2' => '0',
                                'recruit_approval_nik_2' => Auth::user()->user_nik,
                                'recruit_approval_name_2' => Auth::user()->user_name,
                                'recruit_approval_date_2' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_2 = '0';
                            $recruit->recruit_approval_nik_2 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_2 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_2 = date('Y-m-d');
                            $recruit->recruit_approval_note_2 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_3 != NULL && $recruit->recruit_approval_status_3 == NULL) {
                            $request->merge([
                                'recruit_approval_status_3' => '0',
                                'recruit_approval_nik_3' => Auth::user()->user_nik,
                                'recruit_approval_name_3' => Auth::user()->user_name,
                                'recruit_approval_date_3' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_3 = '0';
                            $recruit->recruit_approval_nik_3 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_3 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_3 = date('Y-m-d');
                            $recruit->recruit_approval_note_3 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_4 != NULL && $recruit->recruit_approval_status_4 == NULL) {
                            $request->merge([
                                'recruit_approval_status_4' => '0',
                                'recruit_approval_nik_4' => Auth::user()->user_nik,
                                'recruit_approval_name_4' => Auth::user()->user_name,
                                'recruit_approval_date_4' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_4 = '0';
                            $recruit->recruit_approval_nik_4 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_4 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_4 = date('Y-m-d');
                            $recruit->recruit_approval_note_4 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_5 != NULL && $recruit->recruit_approval_status_5 == NULL) {
                            $request->merge([
                                'recruit_approval_status_5' => '0',
                                'recruit_approval_nik_5' => Auth::user()->user_nik,
                                'recruit_approval_name_5' => Auth::user()->user_name,
                                'recruit_approval_date_5' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_5 = '0';
                            $recruit->recruit_approval_nik_5 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_5 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_5 = date('Y-m-d');
                            $recruit->recruit_approval_note_5 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_6 != NULL && $recruit->recruit_approval_status_6 == NULL) {
                            $request->merge([
                                'recruit_approval_status_6' => '0',
                                'recruit_approval_nik_6' => Auth::user()->user_nik,
                                'recruit_approval_name_6' => Auth::user()->user_name,
                                'recruit_approval_date_6' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_6 = '0';
                            $recruit->recruit_approval_nik_6 = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_6 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_6 = date('Y-m-d');
                            $recruit->recruit_approval_note_6 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_status_ceo == NULL) {
                            $request->merge([
                                'recruit_approval_status_ceo' => '0',
                                'recruit_approval_nik_ceo' => Auth::user()->user_nik,
                                'recruit_approval_name_ceo' => Auth::user()->user_name,
                                'recruit_approval_date_ceo' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_ceo = '0';
                            $recruit->recruit_approval_nik_ceo = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                            $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            $recruit->recruit_approval_note_ceo = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_status_hr == NULL) {
                            $request->merge([
                                'recruit_approval_status_hr' => '0',
                                'recruit_approval_nik_hr' => Auth::user()->user_nik,
                                'recruit_approval_name_hr' => Auth::user()->user_name,
                                'recruit_approval_date_hr' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_hr = '0';
                            $recruit->recruit_approval_nik_hr = Auth::user()->user_nik;
                            $recruit->recruit_approval_name_hr = Auth::user()->user_name;
                            $recruit->recruit_approval_date_hr = date('Y-m-d');
                            $recruit->recruit_approval_note_hr = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        }

                        $recruit->save();

                        $object->icon = "success";
                        $object->title = "Recruits ".$recruit->request_code." have been rejected";
                    } else {
                        if($recruit->recruit_approval_nik_1 != NULL && $recruit->recruit_approval_nik_1 == Auth::user()->user_nik && $recruit->recruit_approval_status_1 == NULL) {
                            $request->merge([
                                'recruit_approval_status_1' => '0',
                                'recruit_approval_name_1' => Auth::user()->user_name,
                                'recruit_approval_date_1' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_1 = '0';
                            $recruit->recruit_approval_name_1 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_1 = date('Y-m-d');
                            $recruit->recruit_approval_note_1 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_2 != NULL && $recruit->recruit_approval_nik_2 == Auth::user()->user_nik && $recruit->recruit_approval_status_2 == NULL) {
                            $request->merge([
                                'recruit_approval_status_2' => '0',
                                'recruit_approval_name_2' => Auth::user()->user_name,
                                'recruit_approval_date_2' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_2 = '0';
                            $recruit->recruit_approval_name_2 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_2 = date('Y-m-d');
                            $recruit->recruit_approval_note_2 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_3 != NULL && $recruit->recruit_approval_nik_3 == Auth::user()->user_nik && $recruit->recruit_approval_status_3 == NULL) {
                            $request->merge([
                                'recruit_approval_status_3' => '0',
                                'recruit_approval_name_3' => Auth::user()->user_name,
                                'recruit_approval_date_3' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_3 = '0';
                            $recruit->recruit_approval_name_3 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_3 = date('Y-m-d');
                            $recruit->recruit_approval_note_3 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_4 != NULL && $recruit->recruit_approval_nik_4 == Auth::user()->user_nik && $recruit->recruit_approval_status_4 == NULL) {
                            $request->merge([
                                'recruit_approval_status_4' => '0',
                                'recruit_approval_name_4' => Auth::user()->user_name,
                                'recruit_approval_date_4' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_4 = '0';
                            $recruit->recruit_approval_name_4 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_4 = date('Y-m-d');
                            $recruit->recruit_approval_note_4 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_5 != NULL && $recruit->recruit_approval_nik_5 == Auth::user()->user_nik && $recruit->recruit_approval_status_5 == NULL) {
                            $request->merge([
                                'recruit_approval_status_5' => '0',
                                'recruit_approval_name_5' => Auth::user()->user_name,
                                'recruit_approval_date_5' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_5 = '0';
                            $recruit->recruit_approval_name_5 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_5 = date('Y-m-d');
                            $recruit->recruit_approval_note_5 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_6 != NULL && $recruit->recruit_approval_nik_6 == Auth::user()->user_nik && $recruit->recruit_approval_status_6 == NULL) {
                            $request->merge([
                                'recruit_approval_status_6' => '0',
                                'recruit_approval_name_6' => Auth::user()->user_name,
                                'recruit_approval_date_6' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_6 = '0';
                            $recruit->recruit_approval_name_6 = Auth::user()->user_name;
                            $recruit->recruit_approval_date_6 = date('Y-m-d');
                            $recruit->recruit_approval_note_6 = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_ceo != NULL && $recruit->recruit_approval_nik_ceo == Auth::user()->user_nik && $recruit->recruit_approval_status_ceo == NULL) {
                            $request->merge([
                                'recruit_approval_status_ceo' => '0',
                                'recruit_approval_name_ceo' => Auth::user()->user_name,
                                'recruit_approval_date_ceo' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_ceo = '0';
                            $recruit->recruit_approval_name_ceo = Auth::user()->user_name;
                            $recruit->recruit_approval_date_ceo = date('Y-m-d');
                            $recruit->recruit_approval_note_ceo = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        } else if($recruit->recruit_approval_nik_hr != NULL && $recruit->recruit_approval_nik_hr == Auth::user()->user_nik && $recruit->recruit_approval_status_hr == NULL) {
                            $request->merge([
                                'recruit_approval_status_hr' => '0',
                                'recruit_approval_name_hr' => Auth::user()->user_name,
                                'recruit_approval_date_hr' => date('Y-m-d'),
                                'recruit_status' => 'REJECTED'
                            ]);

                            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\Recruit');

                            $recruit->recruit_approval_status_hr = '0';
                            $recruit->recruit_approval_name_hr = Auth::user()->user_name;
                            $recruit->recruit_approval_date_hr = date('Y-m-d');
                            $recruit->recruit_approval_note_hr = $request->note;
                            $recruit->recruit_status = 'REJECTED';
                        }

                        $recruit->save();

                        $object->icon = "success";
                        $object->title = "Recruits ".$recruit->request_code." have been rejected";
                    }

                    array_push($count, $object);
                }
            } else {
                $object = (object) array();
                $object->icon = "error";
                $object->title = "No recruit selected";

                array_push($count, $object);
            }

            $data->data = $count;
        });

        return response()->json($data);
    }

    public function export($id)
    {
        $recruit = Recruit::query()
            ->selectRaw('trans_recruitment_recruit.*,
                t.title_name, g.grade_code, g.grade_name, u.user_nik, u.user_name,
                tu.title_name AS user_title, d.department_name,
                poh.point_of_hire_name,
                t1.title_name AS recruit_approval_title_1,
                t2.title_name AS recruit_approval_title_2,
                t3.title_name AS recruit_approval_title_3,
                t4.title_name AS recruit_approval_title_4,
                t5.title_name AS recruit_approval_title_5,
                t6.title_name AS recruit_approval_title_6,
                tceo.title_name AS recruit_approval_title_ceo,
                thr.title_name AS recruit_approval_title_hr')
            ->leftJoin('mst_recruitment_point_of_hire AS poh', 'poh.point_of_hire_id', 'trans_recruitment_recruit.point_of_hire_id')
            ->leftJoin('mst_main_user_title AS t', 't.title_id', 'trans_recruitment_recruit.title_id')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
            ->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_recruitment_recruit.user_id')
            ->leftJoin('mst_main_user_title AS tu', 'tu.title_id', 'u.title_id')
            ->leftJoin('mst_main_department AS d', 'd.department_id', 'u.department_id')
            ->leftJoin('mst_main_user AS u1', 'u1.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_1')
            ->leftJoin('mst_main_user_title AS t1', 't1.title_id', 'u1.title_id')
            ->leftJoin('mst_main_user AS u2', 'u2.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_2')
            ->leftJoin('mst_main_user_title AS t2', 't2.title_id', 'u2.title_id')
            ->leftJoin('mst_main_user AS u3', 'u3.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_3')
            ->leftJoin('mst_main_user_title AS t3', 't3.title_id', 'u3.title_id')
            ->leftJoin('mst_main_user AS u4', 'u4.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_4')
            ->leftJoin('mst_main_user_title AS t4', 't4.title_id', 'u4.title_id')
            ->leftJoin('mst_main_user AS u5', 'u5.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_5')
            ->leftJoin('mst_main_user_title AS t5', 't5.title_id', 'u5.title_id')
            ->leftJoin('mst_main_user AS u6', 'u6.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_6')
            ->leftJoin('mst_main_user_title AS t6', 't6.title_id', 'u6.title_id')
            ->leftJoin('mst_main_user AS uceo', 'uceo.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_ceo')
            ->leftJoin('mst_main_user_title AS tceo', 'tceo.title_id', 'uceo.title_id')
            ->leftJoin('mst_main_user AS uhr', 'uhr.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_hr')
            ->leftJoin('mst_main_user_title AS thr', 'thr.title_id', 'uhr.title_id')
            ->where('trans_recruitment_recruit.recruit_id', $id)
        ->first();

        if(in_array($recruit->recruit_approval_nik_1, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_1 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_2, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_2 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_3, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_3 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_4, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_4 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_5, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_5 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_6, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_6 = 'Super Admin';
        }

        $pdf = PDF::loadView('recruitment.export', ['recruit' => $recruit]);

        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'header-html' => view('recruitment.export_header'),
            'header-spacing' => 7,
            'footer-html' => view('recruitment.export_footer'),
            'footer-spacing' => 7,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm'
        ]);

        return $pdf->inline($recruit->request_code.'.pdf');
    }

    public function exportFulfilled($id)
    {
        $recruit = Recruit::query()
            ->selectRaw('trans_recruitment_recruit.*,
                t.title_name, g.grade_code, g.grade_name, u.user_nik, u.user_name,
                tu.title_name AS user_title, d.department_name,
                poh.point_of_hire_name,
                DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start) AS lead_time,
                t1.title_name AS recruit_approval_title_1,
                t2.title_name AS recruit_approval_title_2,
                t3.title_name AS recruit_approval_title_3,
                t4.title_name AS recruit_approval_title_4,
                t5.title_name AS recruit_approval_title_5,
                t6.title_name AS recruit_approval_title_6,
                tceo.title_name AS recruit_approval_title_ceo,
                thr.title_name AS recruit_approval_title_hr')
            ->leftJoin('mst_recruitment_point_of_hire AS poh', 'poh.point_of_hire_id', 'trans_recruitment_recruit.point_of_hire_id')
            ->leftJoin('mst_main_user_title AS t', 't.title_id', 'trans_recruitment_recruit.title_id')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
            ->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_recruitment_recruit.user_id')
            ->leftJoin('mst_main_user_title AS tu', 'tu.title_id', 'u.title_id')
            ->leftJoin('mst_main_department AS d', 'd.department_id', 'u.department_id')
            ->leftJoin('mst_main_user AS u1', 'u1.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_1')
            ->leftJoin('mst_main_user_title AS t1', 't1.title_id', 'u1.title_id')
            ->leftJoin('mst_main_user AS u2', 'u2.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_2')
            ->leftJoin('mst_main_user_title AS t2', 't2.title_id', 'u2.title_id')
            ->leftJoin('mst_main_user AS u3', 'u3.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_3')
            ->leftJoin('mst_main_user_title AS t3', 't3.title_id', 'u3.title_id')
            ->leftJoin('mst_main_user AS u4', 'u4.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_4')
            ->leftJoin('mst_main_user_title AS t4', 't4.title_id', 'u4.title_id')
            ->leftJoin('mst_main_user AS u5', 'u5.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_5')
            ->leftJoin('mst_main_user_title AS t5', 't5.title_id', 'u5.title_id')
            ->leftJoin('mst_main_user AS u6', 'u6.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_6')
            ->leftJoin('mst_main_user_title AS t6', 't6.title_id', 'u6.title_id')
            ->leftJoin('mst_main_user AS uceo', 'uceo.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_ceo')
            ->leftJoin('mst_main_user_title AS tceo', 'tceo.title_id', 'uceo.title_id')
            ->leftJoin('mst_main_user AS uhr', 'uhr.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_hr')
            ->leftJoin('mst_main_user_title AS thr', 'thr.title_id', 'uhr.title_id')
            ->where('trans_recruitment_recruit.recruit_id', $id)
        ->first();

        if(in_array($recruit->recruit_approval_nik_1, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_1 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_2, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_2 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_3, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_3 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_4, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_4 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_5, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_5 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_6, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_6 = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_ceo, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_ceo = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_hr, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_hr = 'Super Admin';
        }

        $pdf = PDF::loadView('recruitment.export_fulfilled', ['recruit' => $recruit]);

        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'header-html' => view('recruitment.export_header'),
            'header-spacing' => 7,
            'footer-html' => view('recruitment.export_footer'),
            'footer-spacing' => 7,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm'
        ]);

        return $pdf->inline($recruit->request_code.'.pdf');
    }

    public function process(Request $request)
    {
        $rules = [
            'hiring_resource' => 'required',
            'join_date' => 'required'
        ];

        $message = [
            'hiring_resource.required' => 'Please Select A Hiring Resource',
            'join_date.required' => 'Please Fill Join Date'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'recruit_id' => $request->id,
                'lead_time_end' => date('Y-m-d'),
                'processed_by' => Auth::user()->user_name,
                'recruit_status' => 'FULFILLED'
            ]);
            $request->request->remove('id');

            $recruit = Recruit::find($request->recruit_id);
            $recruit->candidate_name = $request->candidate_name;
            $recruit->hiring_resource = $request->hiring_resource;

            $join_date = date_create($request->join_date);
            $recruit->join_date = date_format($join_date, 'Y-m-d');

            $recruit->external_cost = str_replace(',', '', $request->external_cost);
            $recruit->internal_cost = str_replace(',', '', $request->internal_cost);
            $recruit->advertising_expenses = str_replace(',', '', $request->advertising_expenses);
            $recruit->assessment_online = str_replace(',', '', $request->assessment_online);
            $recruit->medical_checkup = str_replace(',', '', $request->medical_checkup);
            $recruit->travel_expenses = str_replace(',', '', $request->travel_expenses);
            $recruit->hiring_bonus = str_replace(',', '', $request->hiring_bonus);
            $recruit->referral_bonus = str_replace(',', '', $request->referral_bonus);

            $recruit->lead_time_end = date('Y-m-d');
            $recruit->processed_by = Auth::user()->user_name;

            $recruit->recruit_status = 'FULFILLED';

            $recruit->save();
        });

        return response()->json();
    }

    public function getRecruit(Request $request)
    {
    	$page = NULL;
    	if($request->has('page')) {
    		$page = $request->get('page');
    	}

        $title = NULL;
        if($request->has('title_id')) {
            $title = $request->get('title_id');
        }

        $poh = NULL;
        if($request->has('point_of_hire')) {
            $poh = $request->get('point_of_hire');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

    	$recruit = Recruit::query()
    		->selectRaw('trans_recruitment_recruit.recruit_id,
    			trans_recruitment_recruit.request_code,
    			t.title_name,
    			CONCAT("[", g.grade_code, "] ", g.grade_name) AS grade,
                poh.point_of_hire_name AS point_of_hire,
    			CONCAT("[", u.user_nik, "] ", u.user_name) AS user,
    			trans_recruitment_recruit.recruit_status,
    			trans_recruitment_recruit.user_id,
    			trans_recruitment_recruit.recruit_approval_status_1,
    			trans_recruitment_recruit.recruit_approval_nik_1,
    			trans_recruitment_recruit.recruit_approval_status_2,
    			trans_recruitment_recruit.recruit_approval_nik_2,
    			trans_recruitment_recruit.recruit_approval_status_3,
    			trans_recruitment_recruit.recruit_approval_nik_3,
    			trans_recruitment_recruit.recruit_approval_status_4,
    			trans_recruitment_recruit.recruit_approval_nik_4,
    			trans_recruitment_recruit.recruit_approval_status_5,
    			trans_recruitment_recruit.recruit_approval_nik_5,
    			trans_recruitment_recruit.recruit_approval_status_6,
    			trans_recruitment_recruit.recruit_approval_nik_6,
    			trans_recruitment_recruit.recruit_approval_status_ceo,
    			trans_recruitment_recruit.recruit_approval_nik_ceo,
    			trans_recruitment_recruit.recruit_approval_status_hr,
    			trans_recruitment_recruit.recruit_approval_nik_hr,
                CASE
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_1 IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_1 IS NULL)
                    THEN "Need Approval 1"
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_2 IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_2 IS NULL)
                    THEN "Need Approval 2"
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_3 IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_3 IS NULL)
                    THEN "Need Approval 3"
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_4 IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_4 IS NULL)
                    THEN "Need Approval 4"
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_5 IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_5 IS NULL)
                    THEN "Need Approval 5"
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_6 IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_6 IS NULL)
                    THEN "Need Approval 6"
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_ceo IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_ceo IS NULL)
                    THEN "Need Approval CEO"
                    WHEN (trans_recruitment_recruit.recruit_status = "PENDING" AND trans_recruitment_recruit.recruit_approval_nik_hr IS NOT NULL AND trans_recruitment_recruit.recruit_approval_status_hr IS NULL)
                    THEN "Need Approval HR"
                    ELSE "Done"
                END AS cond')
    		->leftJoin('mst_main_user_title AS t', 't.title_id', 'trans_recruitment_recruit.title_id')
    		->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
            ->leftJoin('mst_recruitment_point_of_hire AS poh', 'poh.point_of_hire_id', 'trans_recruitment_recruit.point_of_hire_id')
    		->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_recruitment_recruit.user_id');

    	if($page == 'proceed') {
    		$recruit = $recruit->where(function($query) {
    			$query->where('trans_recruitment_recruit.recruit_status', 'PENDING')
    				->orWhere('trans_recruitment_recruit.recruit_status', 'ON PROCESS')
                    ->orWhere('trans_recruitment_recruit.recruit_status', 'FULFILLED');
    		});

    		if(!in_array(Auth::user()->user_id, $this->super_admin) && !in_array(Auth::user()->user_id, $this->ceo) && !in_array(Auth::user()->user_id, $this->hr)) {
	    		$recruit = $recruit->where(function($query) {
	    			$query->where('trans_recruitment_recruit.user_id', Auth::user()->user_id)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_1', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_2', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_3', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_4', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_5', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_6', Auth::user()->user_nik);
	    		});
	    	}
    	} else if($page == 'unproceed') {
    		$recruit = $recruit->where(function($query) {
    			$query->where('trans_recruitment_recruit.recruit_status', 'CANCELED')
    				->orWhere('trans_recruitment_recruit.recruit_status', 'REJECTED');
    		});

    		if(!in_array(Auth::user()->user_id, $this->super_admin) && !in_array(Auth::user()->user_id, $this->ceo) && !in_array(Auth::user()->user_id, $this->hr)) {
	    		$recruit = $recruit->where(function($query) {
	    			$query->where('trans_recruitment_recruit.user_id', Auth::user()->user_id)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_1', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_2', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_3', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_4', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_5', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_6', Auth::user()->user_nik);
	    		});
	    	}
    	} else if($page == 'approval') {
    		$recruit = $recruit->where('trans_recruitment_recruit.recruit_status', 'PENDING');

    		if(!in_array(Auth::user()->user_id, $this->super_admin) && !in_array(Auth::user()->user_id, $this->ceo) && !in_array(Auth::user()->user_id, $this->hr)) {
	    		$recruit = $recruit->where(function($query) {
	    			$query->where('trans_recruitment_recruit.user_id', Auth::user()->user_id)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_1', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_2', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_3', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_4', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_5', Auth::user()->user_nik)
	    				->orWhere('trans_recruitment_recruit.recruit_approval_nik_6', Auth::user()->user_nik);
	    		});
	    	}
    	}

        if($title > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.title_id', $title);
        }

        if($poh > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.point_of_hire_id', $poh);
        }

        if($period > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.period_id', $period);
        }

    	$recruit = $recruit->orderBy('trans_recruitment_recruit.recruit_id', 'DESC')->get();

        // if($page == 'approval') {
        //     $data = array();

        //     foreach($recruit as $r) {
        //         $object = (object) array();

        //         if()
        //     }
        // }

    	return datatables()->of($recruit)->addIndexColumn()
    		->addColumn('check_cancel', function($recruit) {
    			if($recruit->user_id == Auth::user()->user_id && ($recruit->recruit_status == 'PENDING' || $recruit->recruit_status == 'ON PROCESS')) {
                	return '<div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="cancel[]" value="'.$recruit->recruit_id.'"><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""></span></div>';
                } else if(in_array(Auth::user()->user_id, $this->super_admin) && ($recruit->recruit_status == 'PENDING' || $recruit->recruit_status == 'ON PROCESS')) {
                	return '<div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="cancel[]" value="'.$recruit->recruit_id.'"><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""></span></div>';
                } else {
                    return '';
                }
            })
            ->addColumn('check_approval', function($recruit) {
            	if(($recruit->cond == 'Need Approval 1' && $recruit->recruit_approval_status_1 == NULL && $recruit->recruit_approval_nik_1 == Auth::user()->user_nik) || ($recruit->cond == 'Need Approval 2' && $recruit->recruit_approval_status_2 == NULL && $recruit->recruit_approval_nik_2 == Auth::user()->user_nik) || ($recruit->cond == 'Need Approval 3' && $recruit->recruit_approval_status_3 == NULL && $recruit->recruit_approval_nik_3 == Auth::user()->user_nik) || ($recruit->cond == 'Need Approval 4' && $recruit->recruit_approval_status_4 == NULL && $recruit->recruit_approval_nik_4 == Auth::user()->user_nik) || ($recruit->cond == 'Need Approval 5' && $recruit->recruit_approval_status_5 == NULL && $recruit->recruit_approval_nik_5 == Auth::user()->user_nik) || ($recruit->cond == 'Need Approval 6' && $recruit->recruit_approval_status_6 == NULL && $recruit->recruit_approval_nik_6 == Auth::user()->user_nik) || ($recruit->cond == 'Need Approval CEO' && $recruit->recruit_approval_status_ceo == NULL && $recruit->recruit_approval_nik_ceo == Auth::user()->user_nik) || ($recruit->cond == 'Need Approval HR' && $recruit->recruit_approval_status_hr == NULL && $recruit->recruit_approval_nik_hr == Auth::user()->user_nik)) {
            		return '<div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="approval[]" value="'.$recruit->recruit_id.'"><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""></span></div>';
            	} else if(in_array(Auth::user()->user_id, $this->super_admin)) {
            		return '<div class="vs-checkbox-con vs-checkbox-primary"><input type="checkbox" name="approval[]" value="'.$recruit->recruit_id.'"><span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span><span class=""></span></div>';
            	} else {
            		return '';
            	}
            })
    		->addColumn('status', function($recruit) {
    			if($recruit->recruit_status == 'PENDING') {
    				return '<span class="text-muted">PENDING</span>';
    			} else if($recruit->recruit_status == 'REJECTED') {
    				return '<span class="text-danger">REJECTED</span>';
    			} else if($recruit->recruit_status == 'CANCELED') {
    				return '<span class="text-warning">CANCELED</span>';
    			} else if($recruit->recruit_status == 'ON PROCESS') {
                    return '<span class="text-primary">ON PROCESS</span>';
                } else if($recruit->recruit_status == 'FULFILLED') {
                    return '<span class="text-success">FULFILLED</span>';
                }
    		})
            ->addColumn('process', function($recruit) {
                if($recruit->recruit_status == 'ON PROCESS') {
                    return '<a href="javascript:;" class="btn-process" data-id="'.$recruit->recruit_id.'" data-toggle="tooltip" title="Process"><i class="feather icon-settings"></i></a>';
                } else {
                    return '<a href="javascript:;" data-toggle="tooltip" title="Lock"><i class="feather icon-lock"></i></a>';
                }
            })
    		->addColumn('edit', function($recruit) {
                if($recruit->recruit_status == 'PENDING' && ($recruit->recruit_approval_status_1 == NULL && $recruit->recruit_approval_status_2 == NULL && $recruit->recruit_approval_status_3 == NULL && $recruit->recruit_approval_status_4 == NULL && $recruit->recruit_approval_status_5 == NULL && $recruit->recruit_approval_status_6 == NULL && $recruit->recruit_approval_status_ceo == NULL && $recruit->recruit_approval_status_hr == NULL)) {
                    return '<a href="javascript:;" class="btn-edit" data-id="'.$recruit->recruit_id.'" data-toggle="tooltip" title="Edit"><i class="feather icon-edit"></i></a>';
                } else {
                    return '<a href="javascript:;" data-toggle="tooltip" title="Lock"><i class="feather icon-lock"></i></a>';
                }
    		})
    		->addColumn('view', function($recruit) {
                return '<a href="javascript:;" class="btn-view" data-id="'.$recruit->recruit_id.'" data-toggle="tooltip" title="View"><i class="feather icon-eye"></i></a>';
            })
            ->addColumn('copy', function($recruit) {
                return '<a href="javascript:;" class="btn-copy" data-id="'.$recruit->recruit_id.'" data-toggle="tooltip" title="Copy"><i class="feather icon-copy"></i></a>';
            })
            ->addColumn('export', function($recruit){
                return '<a href="'.url('/recruitment/export/'.$recruit->recruit_id).'" target="_blank" data-toggle="tooltip" title="Export"><i class="feather icon-file-text"></i></a>';
            })
            ->rawColumns(['check_cancel', 'check_approval', 'status', 'process', 'edit', 'view', 'copy', 'export'])
    	->toJson();
    }

    public function getRecruitById(Request $request)
    {
    	$recruit = Recruit::query()
    		->selectRaw('trans_recruitment_recruit.*,
    			t.title_name, g.grade_code, g.grade_name, u.user_nik, u.user_name,
    			tu.title_name AS user_title, d.department_name,
                poh.point_of_hire_name,
    			t1.title_name AS recruit_approval_title_1,
    			t2.title_name AS recruit_approval_title_2,
    			t3.title_name AS recruit_approval_title_3,
    			t4.title_name AS recruit_approval_title_4,
    			t5.title_name AS recruit_approval_title_5,
    			t6.title_name AS recruit_approval_title_6,
    			tceo.title_name AS recruit_approval_title_ceo,
    			thr.title_name AS recruit_approval_title_hr')
            ->leftJoin('mst_recruitment_point_of_hire AS poh', 'poh.point_of_hire_id', 'trans_recruitment_recruit.point_of_hire_id')
    		->leftJoin('mst_main_user_title AS t', 't.title_id', 'trans_recruitment_recruit.title_id')
    		->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
    		->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_recruitment_recruit.user_id')
    		->leftJoin('mst_main_user_title AS tu', 'tu.title_id', 'u.title_id')
    		->leftJoin('mst_main_department AS d', 'd.department_id', 'u.department_id')
    		->leftJoin('mst_main_user AS u1', 'u1.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_1')
    		->leftJoin('mst_main_user_title AS t1', 't1.title_id', 'u1.title_id')
    		->leftJoin('mst_main_user AS u2', 'u2.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_2')
    		->leftJoin('mst_main_user_title AS t2', 't2.title_id', 'u2.title_id')
    		->leftJoin('mst_main_user AS u3', 'u3.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_3')
    		->leftJoin('mst_main_user_title AS t3', 't3.title_id', 'u3.title_id')
    		->leftJoin('mst_main_user AS u4', 'u4.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_4')
    		->leftJoin('mst_main_user_title AS t4', 't4.title_id', 'u4.title_id')
    		->leftJoin('mst_main_user AS u5', 'u5.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_5')
    		->leftJoin('mst_main_user_title AS t5', 't5.title_id', 'u5.title_id')
    		->leftJoin('mst_main_user AS u6', 'u6.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_6')
    		->leftJoin('mst_main_user_title AS t6', 't6.title_id', 'u6.title_id')
    		->leftJoin('mst_main_user AS uceo', 'uceo.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_ceo')
    		->leftJoin('mst_main_user_title AS tceo', 'tceo.title_id', 'uceo.title_id')
    		->leftJoin('mst_main_user AS uhr', 'uhr.user_nik', 'trans_recruitment_recruit.recruit_approval_nik_hr')
    		->leftJoin('mst_main_user_title AS thr', 'thr.title_id', 'uhr.title_id')
    		->where('trans_recruitment_recruit.recruit_id', $request->id)
    	->first();

    	if(in_array($recruit->recruit_approval_nik_1, $this->super_admin_nik)) {
    		$recruit->recruit_approval_title_1 = 'Super Admin';
    	}

    	if(in_array($recruit->recruit_approval_nik_2, $this->super_admin_nik)) {
    		$recruit->recruit_approval_title_2 = 'Super Admin';
    	}

    	if(in_array($recruit->recruit_approval_nik_3, $this->super_admin_nik)) {
    		$recruit->recruit_approval_title_3 = 'Super Admin';
    	}

    	if(in_array($recruit->recruit_approval_nik_4, $this->super_admin_nik)) {
    		$recruit->recruit_approval_title_4 = 'Super Admin';
    	}

    	if(in_array($recruit->recruit_approval_nik_5, $this->super_admin_nik)) {
    		$recruit->recruit_approval_title_5 = 'Super Admin';
    	}

    	if(in_array($recruit->recruit_approval_nik_6, $this->super_admin_nik)) {
    		$recruit->recruit_approval_title_6 = 'Super Admin';
    	}

        if(in_array($recruit->recruit_approval_nik_ceo, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_ceo = 'Super Admin';
        }

        if(in_array($recruit->recruit_approval_nik_hr, $this->super_admin_nik)) {
            $recruit->recruit_approval_title_hr = 'Super Admin';
        }

    	return response()->json($recruit);
    }

    public function sendMail(Request $request)
    {
        try {
            if($request->type == 'approval') {
                \Mail::to(['address' => $request->recipient_email])
                    ->cc($this->cc_email)
                ->send(new RecruitmentMail($request));
            } else {
                \Mail::to(['address' => $request->recipient_email])->send(new RecruitmentMail($request));
            }
        } catch (\Throwable $th) {
            throw new Exception("Failed To Send Email", 1);
        }

        return "Email Sent";
    }

    public function tempOSA(Request $request)
    {
        $path = $request->file('filepond')->storeAs('file_uploads/organization_structure', 'osa-'.date('Y-m-d').'-'.rand().'.'.$request->file('filepond')->extension(), 'public');

        return response()->json($path);
    }
}
