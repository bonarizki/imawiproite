<!DOCTYPE html>
<html>
<head>
	<title>{{ $recruit->request_code }}</title>
	<link href="{{ public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
	<style type="text/css">
		p {
			margin-top: 2.5px;
			margin-bottom: 2.5px;
		}
		.table-view thead tr th, .table-view tbody tr td {
	        padding: .25rem;
	    }
	    .table-view thead tr th {
	        background-color: #EFEFEF;
	    }
        .table-view tbody tr td div {
            min-height: 160px;
        }
        table { page-break-inside: auto }
	    thead { display: table-header-group }
		tfoot { display: table-row-group }
		tr { page-break-inside: avoid; page-break-after: auto; }
	    @media print {
	    	.table-view {
	    		overflow : visible !important;
	    	}
	    }
	</style>
</head>
<body style="padding-left: 2.5rem; padding-right: 2.5rem;">
	
	<div class="row">
        <div class="col-md-6">
            <div class="row">
                <p class="col-md-4">Requested By</p>
                <p class="col-md-1">:</p>
                <p class="col-md-7">[{{ $recruit->user_nik }}] {{ $recruit->user_name }}</p>
            </div>
            <div class="row">
                <p class="col-md-4">Position</p>
                <p class="col-md-1">:</p>
                <p class="col-md-7">{{ $recruit->user_title }}</p>
            </div>
            <div class="row">
                <p class="col-md-4">Department</p>
                <p class="col-md-1">:</p>
                <p class="col-md-7">{{ $recruit->department_name }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <p class="col-md-4">Date of Request</p>
                <p class="col-md-1">:</p>
                <p class="col-md-7">{{ date_format(date_create($recruit->request_date), "D, j M Y") }}</p>
            </div>
            <div class="row">
                <p class="col-md-4">Ticket No</p>
                <p class="col-md-1">:</p>
                <p class="col-md-7">{{ $recruit->request_code }}</p>
            </div>
            <div class="row">
                <p class="col-md-4">Status</p>
                <p class="col-md-1">:</p>
                @if($recruit->recruit_status == 'PENDING')
                	<p class="col-md-7 text-muted">PENDING</p>
                @elseif($recruit->recruit_status == 'REJECTED')
                	<p class="col-md-7 text-danger">REJECTED</p>
                @elseif($recruit->recruit_status == 'CANCELED')
                	<p class="col-md-7 text-warning">CANCELED</p>
                @elseif($recruit->recruit_status == 'ON PROCESS')
                    <p class="col-md-7 text-primary">ON PROCESS</p>
                @elseif($recruit->recruit_status == 'FULFILLED')
                    <p class="col-md-7 text-success">FULFILLED</p>
                @endif
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <p class="col-md-3">Title</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->title_name }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Grade</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">[{{ $recruit->grade_code }}] {{ $recruit->grade_name }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Sex</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->sex }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Age</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->minimum_age }} Minimum & {{ $recruit->maximum_age }} Maximum</p>
    </div>
    <div class="row">
        <p class="col-md-3">Reason for Request</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->reason_for_request }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Point of Hire</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->point_of_hire_name }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Employment Status</p>
        <p class="col-md-1">:</p>
        @if($recruit->employment_status == 'Permanent')
        	<p class="col-md-8">Permanent with {{ $recruit->probation_length }} months probation</p>
        @elseif($recruit->employment_status == 'Contract')
            <p class="col-md-8">Contract for {{ $recruit->contract_length }} months</p>
        @elseif($recruit->employment_status == 'Internship')
            <p class="col-md-8">Internship for {{ $recruit->internship_length }} months</p>
        @elseif($recruit->employment_status == 'Daily Worker')
            <p class="col-md-8">Daily Worker for {{ $recruit->daily_worker_length }} days for {{ $recruit->daily_worker_person }} persons</p>
        @endif
    </div>
    <div class="row">
        <p class="col-md-3">Expected Join Date</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ date_format(date_create($recruit->expected_join_date), "D, j M Y") }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Status of Recruitment</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->recruitment_status }}</p>
    </div>
    <br>
    <h4>Basic Requirements</h4>
    <div class="row">
        <p class="col-md-3">Education</p>
        <p class="col-md-1">:</p>
        @if($recruit->education == 'Other')
        	<p class="col-md-8">{{ $recruit->education_other }}</p>
        @else
        	<p class="col-md-8">{{ $recruit->education }}</p>
        @endif
    </div>
    <div class="row">
        <p class="col-md-3">General Competency</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->general_competency }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Specific Competency</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->specific_competency }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Job Description</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->job_description }}</p>
    </div>
    <br>
    <h4>Proposed Package</h4>
    <div class="row">
        <p class="col-md-3">Basic Salary</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">Rp. {{ number_format($recruit->basic_salary, 0, '.', ',') }}</p>
    </div>
    <div class="row">
        <p class="col-md-3">Allowances</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">Rp. {{ number_format($recruit->allowances, 0, '.', ',') }}</p>
    </div>
    <br>
    <div class="row">
        <p class="col-md-3">Organization Structure</p>
        <p class="col-md-1">:</p>
        <p class="col-md-8">{{ $recruit->organization_structure }}</p>
    </div>
    <hr>
    <table class="table table-bordered table-view">
        <thead>
            <tr>
                <th style="text-align: center;"> Requested By </th>
                <th colspan="4" style="text-align: center;"> Approved By </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; width: 20%;">
                    <div>
                        <span>{{ $recruit->user_title }}</span><br>
                        <img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
                        <span>{{ $recruit->user_name }}</span><br>
                        <span>{{ $recruit->user_nik }}</span><br>
                        <span>{{ date_format(date_create($recruit->request_date), "d M Y") }}</span>
                    </div>
                </td>
                <td style="text-align: center; width: 20%;">
                    <div>
                    	@if($recruit->recruit_approval_status_1 != null)
                    		<span>{{ $recruit->recruit_approval_title_1 }}</span><br>
                    		@if($recruit->recruit_approval_status_1 == '1')
                    			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
                    		@elseif($recruit->recruit_approval_status_1 == '0')
                    			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
                    		@endif
                    		<span>{{ $recruit->recruit_approval_name_1 }}</span><br>
                    		<span>{{ $recruit->recruit_approval_nik_1 }}</span><br>
                    		<span>{{ date_format(date_create($recruit->recruit_approval_date_1), "d M Y") }}</span>
                    	@elseif($recruit->recruit_approval_nik_1 != null)
                    		<br><span>Waiting for Approval</span><br>
                    	@else
                    		<br><br>
                    	@endif
                    </div>
                </td>
                <td style="text-align: center; width: 20%;">
                    <div>
                        @if($recruit->recruit_approval_status_2 != null)
                    		<span>{{ $recruit->recruit_approval_title_2 }}</span><br>
                    		@if($recruit->recruit_approval_status_2 == '1')
                    			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
                    		@elseif($recruit->recruit_approval_status_2 == '0')
                    			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
                    		@endif
                    		<span>{{ $recruit->recruit_approval_name_2 }}</span><br>
                    		<span>{{ $recruit->recruit_approval_nik_2 }}</span><br>
                    		<span>{{ date_format(date_create($recruit->recruit_approval_date_2), "d M Y") }}</span>
                    	@elseif($recruit->recruit_approval_nik_2 != null)
                    		<br><span>Waiting for Approval</span><br>
                    	@else
                    		<br><br>
                    	@endif
                    </div>
                </td>
                <td style="text-align: center; width: 20%;">
                    <div>
                        @if($recruit->recruit_approval_status_3 != null)
                    		<span>{{ $recruit->recruit_approval_title_3 }}</span><br>
                    		@if($recruit->recruit_approval_status_3 == '1')
                    			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
                    		@elseif($recruit->recruit_approval_status_3 == '0')
                    			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
                    		@endif
                    		<span>{{ $recruit->recruit_approval_name_3 }}</span><br>
                    		<span>{{ $recruit->recruit_approval_nik_3 }}</span><br>
                    		<span>{{ date_format(date_create($recruit->recruit_approval_date_3), "d M Y") }}</span>
                    	@elseif($recruit->recruit_approval_nik_3 != null)
                    		<br><span>Waiting for Approval</span><br>
                    	@else
                    		<br><br>
                    	@endif
                    </div>
                </td>
                <td style="text-align: center; width: 20%;">
                    <div>
                        @if($recruit->recruit_approval_status_4 != null)
                    		<span>{{ $recruit->recruit_approval_title_4 }}</span><br>
                    		@if($recruit->recruit_approval_status_4 == '1')
                    			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
                    		@elseif($recruit->recruit_approval_status_4 == '0')
                    			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
                    		@endif
                    		<span>{{ $recruit->recruit_approval_name_4 }}</span><br>
                    		<span>{{ $recruit->recruit_approval_nik_4 }}</span><br>
                    		<span>{{ date_format(date_create($recruit->recruit_approval_date_4), "d M Y") }}</span>
                    	@elseif($recruit->recruit_approval_nik_4 != null)
                    		<br><span>Waiting for Approval</span><br>
                    	@else
                    		<br><br>
                    	@endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-view">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;"> Approved By </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; width: 50%;">
                            <div>
                                @if($recruit->recruit_approval_status_5 != null)
    		                		<span>{{ $recruit->recruit_approval_title_5 }}</span><br>
    		                		@if($recruit->recruit_approval_status_5 == '1')
    		                			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
    		                		@elseif($recruit->recruit_approval_status_5 == '0')
    		                			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
    		                		@endif
    		                		<span>{{ $recruit->recruit_approval_name_5 }}</span><br>
    		                		<span>{{ $recruit->recruit_approval_nik_5 }}</span><br>
    		                		<span>{{ date_format(date_create($recruit->recruit_approval_date_5), "d M Y") }}</span>
    		                	@elseif($recruit->recruit_approval_nik_5 != null)
    		                		<br><span>Waiting for Approval</span><br>
    		                	@else
                    				<br><br>
    		                	@endif
                            </div>
                        </td>
                        <td style="text-align: center; width: 50%;">
                            <div>
                                @if($recruit->recruit_approval_status_6 != null)
    		                		<span>{{ $recruit->recruit_approval_title_6 }}</span><br>
    		                		@if($recruit->recruit_approval_status_6 == '1')
    		                			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
    		                		@elseif($recruit->recruit_approval_status_6 == '0')
    		                			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
    		                		@endif
    		                		<span>{{ $recruit->recruit_approval_name_6 }}</span><br>
    		                		<span>{{ $recruit->recruit_approval_nik_6 }}</span><br>
    		                		<span>{{ date_format(date_create($recruit->recruit_approval_date_6), "d M Y") }}</span>
    		                	@elseif($recruit->recruit_approval_nik_6 != null)
    		                		<br><span>Waiting for Approval</span><br>
    		                	@else
                    				<br><br>
    		                	@endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-view">
                <thead>
                    <tr>
                        <th style="text-align: center;"> Approved By CEO </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">
                            <div>
                                @if($recruit->recruit_approval_status_ceo != null)
    		                		<span>{{ $recruit->recruit_approval_title_ceo }}</span><br>
    		                		@if($recruit->recruit_approval_status_ceo == '1')
    		                			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
    		                		@elseif($recruit->recruit_approval_status_ceo == '0')
    		                			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
    		                		@endif
    		                		<span>{{ $recruit->recruit_approval_name_ceo }}</span><br>
    		                		<span>{{ $recruit->recruit_approval_nik_ceo }}</span><br>
    		                		<span>{{ date_format(date_create($recruit->recruit_approval_date_ceo), "d M Y") }}</span>
    		                	@elseif($recruit->recruit_approval_nik_ceo != null)
    		                		<br><span>Waiting for Approval</span><br>
    		                	@else
                    				<br><br>
    		                	@endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-view">
                <thead>
                    <tr>
                        <th style="text-align: center;"> Reviewed By </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">
                            <div>
                                @if($recruit->recruit_approval_status_hr != null)
    		                		<span>{{ $recruit->recruit_approval_title_hr }}</span><br>
    		                		@if($recruit->recruit_approval_status_hr == '1')
    		                			<img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"><br>
    		                		@elseif($recruit->recruit_approval_status_hr == '0')
    		                			<img src="{{ public_path('/images/rejected.png') }}" style="height: 30%;"><br>
    		                		@endif
    		                		<span>{{ $recruit->recruit_approval_name_hr }}</span><br>
    		                		<span>{{ $recruit->recruit_approval_nik_hr }}</span><br>
    		                		<span>{{ date_format(date_create($recruit->recruit_approval_date_hr), "d M Y") }}</span>
    		                	@elseif($recruit->recruit_approval_nik_hr != null)
    		                		<br><span>Waiting for Approval</span><br>
    		                	@else
                    				<br><br>
    		                	@endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>

    @if($recruit->recruit_approval_note_1 != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_1 }}</label>
        <p>{{ $recruit->recruit_approval_note_1 }}</p>
    @endif

    @if($recruit->recruit_approval_note_2 != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_2 }}</label>
        <p>{{ $recruit->recruit_approval_note_2 }}</p>
    @endif

    @if($recruit->recruit_approval_note_3 != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_3 }}</label>
        <p>{{ $recruit->recruit_approval_note_3 }}</p>
    @endif

    @if($recruit->recruit_approval_note_4 != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_4 }}</label>
        <p>{{ $recruit->recruit_approval_note_4 }}</p>
    @endif

    @if($recruit->recruit_approval_note_5 != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_5 }}</label>
        <p>{{ $recruit->recruit_approval_note_5 }}</p>
    @endif

    @if($recruit->recruit_approval_note_6 != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_6 }}</label>
        <p>{{ $recruit->recruit_approval_note_6 }}</p>
    @endif

    @if($recruit->recruit_approval_note_ceo != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_ceo }}</label>
        <p>{{ $recruit->recruit_approval_note_ceo }}</p>
    @endif

    @if($recruit->recruit_approval_note_hr != null)
        <label class="font-weight-bold">Note from {{ $recruit->recruit_approval_name_hr }}</label>
        <p>{{ $recruit->recruit_approval_note_hr }}</p>
    @endif

</body>
</html>