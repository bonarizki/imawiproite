<!DOCTYPE html>
<html>
<head>
	<title>PERFORMANCE APPRAISAL</title>
	<link href="{{ public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
	<style type="text/css">
		p {
			margin-top: 2.5px;
			margin-bottom: 2.5px;
		}
        .table thead tr th {
            vertical-align: middle;
            font-size: 14px;
        }
        .table tbody tr td, .table tfoot tr th {
            font-size: 13px;
        }
		.table-view thead tr th, .table-view tbody tr td {
	        padding: .25rem;
            font-size: 14px;
	    }
	    .table-view thead tr th {
	        background-color: #EFEFEF;
	    }
        .table-view tbody tr td div {
            min-height: 165px;
        }
        table { page-break-inside: auto; border-collapse: collapse; }
        thead { display: table-row-group; }
        tfoot { display: table-row-group; }
        tr { page-break-inside: auto !important; }
	    @media print {
            table { page-break-inside: auto; border-collapse: collapse; }
            thead { display: table-row-group; }
            tfoot { display: table-row-group; }
            tr { page-break-inside: auto !important; }
	    	.table-view {
	    		overflow : visible !important;
	    	}
	    }
	</style>
</head>
<body style="padding-left: 2.5rem; padding-right: 2.5rem;">

	<div class="row mb-3">
        <div class="col-md-9">
            <div class="row mb-1">
                <div class="col-md-3">Employee NIK</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">{{ $appraisal->user_nik }}</div>
            </div>
            <div class="row mb-1">
                <div class="col-md-3">Employee Name</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">{{ $appraisal->user_name }}</div>
            </div>
            <div class="row mb-1">
                <div class="col-md-3">Department</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">{{ $appraisal->department_name }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Level</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">{{ $appraisal->grade_group_name }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="w-100 text-center">
                <h4 class="font-weight-bold">{{ $period->period_name }}</h4>
                <h4 class="font-weight-bold">{{ $appraisal->appraisal_status }}</h4>
            </div>
        </div>
    </div>

    <h5 class="font-weight-bold">SECTION I : PERSONAL MILESTONES AND ASSESSMENT</h5>
    <p class="font-weight-bold" style="font-size: 14px;">Your Milestones must be set and agreed with your superior and each milestone shall consist the following elements :</p>
    <div class="row">
        <p class="col-md-1" style="font-size: 14px;">I.</p>
        <p class="col-md-11" style="font-size: 14px;">How does the milestone links to your department/business strategies.</p>
    </div>
    <div class="row">
        <p class="col-md-1" style="font-size: 14px;">II.</p>
        <p class="col-md-11" style="font-size: 14px; margin-bottom: 10px;">Each milestone must be SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), you must specify the Quantitative Measurement (e.g. financial results) and the Timeline for each milestone.</p>
    </div>
    <p class="font-weight-bold" style="font-size: 14px;">Guide to Milestone Rating</p>
    <table class="table table-sm table-bordered">
        <tbody>
            <tr>
                <td style="width: 20%;"><small>1 - Outstanding / Outperform</small></td>
                <td style="width: 20%;"><small>2 - Exceed Expectation</small></td>
                <td style="width: 20%;"><small>3 - Meet Expectation</small></td>
                <td style="width: 20%;"><small>4 - Below Expectation</small></td>
                <td style="width: 20%;"><small>5 - Did not Meet Expectation</small></td>
            </tr>
        </tbody>
    </table>

    <?php $count = 1; ?>
    @foreach($milestone as $key => $mlst)
        @if($key > 0 && $mlst['milestone_id'] == $milestone[($key-1)]['milestone_id'])
            <tr>
                <td style="text-align: center; vertical-align: middle;">{{ $count }}</td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->milestone_description)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->milestone_measurement)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->employee_assessment)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->superior_assessment)); ?></td>
                <td style="text-align: center; vertical-align: middle;">{{ $mlst->superior_score }}</td>
            </tr>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="6" style="text-align: center;">{{ $mlst->milestone_eng }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; width: 50px;"> No </th>
                        <th> Milestone Description </th>
                        <th> Milestone Measurement </th>
                        <th> Employee's Assessment </th>
                        <th> Superior's Assessment </th>
                        <th style="text-align: center;"> Superior's Score </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;">{{ $count }}</td>
                        <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->milestone_description)); ?></td>
                        <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->milestone_measurement)); ?></td>
                        <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->employee_assessment)); ?></td>
                        <td><?php echo str_replace("\n", "<br>", htmlentities($mlst->superior_assessment)); ?></td>
                        <td style="text-align: center; vertical-align: middle;">{{ $mlst->superior_score }}</td>
                    </tr>
        @endif

        <?php $count++; ?>

        @if($key < (count($milestone)-1) && $mlst['milestone_id'] != $milestone[($key+1)]['milestone_id'])
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"> Total Score </th>
                        <th style="text-align: center;">{{ $mlst->overall_score }}</th>
                    </tr>
                </tfoot>
            </table>
        @elseif($key == (count($milestone)-1))
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"> Total Score </th>
                        <th style="text-align: center;">{{ $mlst->overall_score }}</th>
                    </tr>
                </tfoot>
            </table>
        @endif
    @endforeach

    @if($appraisal->beyond_milestone != null)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th> Achievement Beyond Milestone </th>
                    <th style="text-align: center;"> Superior's Score </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->beyond_milestone)); ?></td>
                    <td style="text-align: center; vertical-align: middle;">{{ $appraisal->beyond_milestone_score }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <h6 class="font-weight-bold">Overall Feedback on Employee's Milestone</h6>
    <table class="table table-bordered">
        <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->milestone_feedback)); ?></td>
    </table>
    <table class="table table-striped table-bordered">
        <td class="font-weight-bold" style="width: 85%;">OVERALL MILESTONES RATING</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_milestone_score }}</td>
    </table>

    <h5 class="font-weight-bold">SECTION II : COMPETENCIES</h5>
    <p style="font-size: 14px;">This section describes How of performance</p>
    <p class="font-weight-bold" style="font-size: 14px;">Guide to Competency Rating</p>
    <table class="table table-sm table-bordered">
        <tbody>
            <tr>
                <td style="width: 20%;"><small>1 - Outstanding / Outperform</small></td>
                <td style="width: 20%;"><small>2 - Exceed Expectation</small></td>
                <td style="width: 20%;"><small>3 - Meet Expectation</small></td>
                <td style="width: 20%;"><small>4 - Below Expectation</small></td>
                <td style="width: 20%;"><small>5 - Did not Meet Expectation</small></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align: center; width: 50px;"> No </th>
                <th> Competency </th>
                <th style="text-align: center;"> Employee's Score </th>
                <th style="text-align: center;"> Superior's Score </th>
                <th> Superior's Comment </th>
            </tr>
        </thead>
        <tbody>
        	@foreach($competency as $key => $com)
        		<tr>
        			<td style="text-align: center; vertical-align: middle;">{{ $key+1 }}</td>
        			<td><?php echo str_replace("\n", "<br>", htmlentities($com->competency_eng)); ?></td>
        			<td style="text-align: center; vertical-align: middle;">{{ $com->employee_rating }}</td>
        			<td style="text-align: center; vertical-align: middle;">{{ $com->superior_rating }}</td>
        			<td><?php echo str_replace("\n", "<br>", htmlentities($com->superior_comment)); ?></td>
        		</tr>
        	@endforeach
        </tbody>
    </table>
    <h6 class="font-weight-bold">Overall Feedback on Employee's Competencies</h6>
    <table class="table table-bordered">
        <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->competency_feedback)); ?></td>
    </table>
    <table class="table table-striped table-bordered">
        <td class="font-weight-bold" style="width: 85%;">OVERALL COMPETENCIES RATING</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_competency_score }}</td>
    </table>

    <h5 class="font-weight-bold">SECTION III : PERSONAL DEVELOPMENT</h5>
    <h6 class="font-weight-bold mb-0">Job & Personal Development</h6>
    <p style="font-size: 14px;">List any areas, which with management’s help or specific training, could improve your overall performance and develop your competences and skills.</p>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th> By Employee </th>
                <th> By Superior </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->personal_development_employee)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->personal_development_superior)); ?></td>
            </tr>
        </tbody>
    </table>
    <h6 class="font-weight-bold mb-0">Career Development & Ambitions</h6>
    <p style="font-size: 14px;">Looking ahead, please indicate how you would like to see your present job and career development over the next five years' time frame.</p>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th> By Employee </th>
                <th> By Superior </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->career_development_employee)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->career_development_superior)); ?></td>
            </tr>
        </tbody>
    </table>

    <h5 class="font-weight-bold">SECTION IV : PERSONAL MILESTONES FOR NEXT YEAR</h5>
    <p style="font-size: 14px;">To be completed by Employee and agreed by Superiors</p>
    <p style="font-size: 14px; margin-bottom: 1rem;">You must specify the Quantitative measurements & Timeline for each milestone.</p>
    <?php $count = 1; ?>
    @foreach($milestone_next as $key => $mlst_next)
        @if($key > 0 && $mlst_next['milestone_id'] == $milestone_next[($key-1)]['milestone_id'])
            <tr>
                <td style="text-align: center; vertical-align: middle;">{{ $count }}</td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($mlst_next->milestone_description)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($mlst_next->milestone_measurement)); ?></td>
            </tr>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="3" style="text-align: center;">{{ $mlst_next->milestone_eng }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; width: 50px;"> No </th>
                        <th> Milestone Description </th>
                        <th> Milestone Measurement </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;">{{ $count }}</td>
                        <td><?php echo str_replace("\n", "<br>", htmlentities($mlst_next->milestone_description)); ?></td>
                        <td><?php echo str_replace("\n", "<br>", htmlentities($mlst_next->milestone_measurement)); ?></td>
                    </tr>
        @endif

        <?php $count++; ?>

        @if($key < (count($milestone_next)-1) && $mlst_next['milestone_id'] != $milestone_next[($key+1)]['milestone_id'])
                </tbody>
            </table>
        @elseif($key == (count($milestone_next)-1))
                </tbody>
            </table>
        @endif
    @endforeach

    <h5 class="font-weight-bold">SECTION V : PERFORMANCE REVIEW</h5>
    <h6 class="font-weight-bold mb-0">Strength & Area Improvements</h6>
    <p style="font-size: 14px;">Summary of appraisal identifying any special circumstances influencing performance and areas for further development/improvement.</p>
    <table class="table table-bordered mt-2">
        <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->improvement)); ?></td>
    </table>
    <h6 class="font-weight-bold">Feedback from Superior</h6>
    <table class="table table-bordered">
        <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->superior_feedback)); ?></td>
    </table>

    <table class="table table-striped table-bordered mb-0">
        <td class="font-weight-bold" style="width: 85%;">OVERALL MILESTONES RATING</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_milestone_score }}</td>
    </table>
    <table class="table table-striped table-bordered mb-0">
        <td class="font-weight-bold" style="width: 85%;">OVERALL COMPETENCIES SCORE</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_competency_score }}</td>
    </table>
    <table class="table table-striped table-bordered">
        <td class="font-weight-bold" style="width: 85%;">OVERALL JOB PERFORMANCE RATING</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_performance_score }}</td>
    </table>

    <p class="font-weight-bold" style="font-size: 14px;">Guide to Overall Job Performance Rating</p>
    <table class="table table-sm table-bordered">
        <tbody>
            <tr>
                <td style="width: 20%;"><small>1 - Outstanding / Outperform</small></td>
                <td style="width: 20%;"><small>2 - Exceed Expectation</small></td>
                <td style="width: 20%;"><small>3 - Meet Expectation</small></td>
                <td style="width: 20%;"><small>4 - Below Expectation</small></td>
                <td style="width: 20%;"><small>5 - Did not Meet Expectation</small></td>
            </tr>
        </tbody>
    </table>

    @if($appraisal->employee_feedback != null)
        <h6 class="font-weight-bold mb-0">Feedback from Employee</h6>
        <p style="font-size: 14px;">To be completed by employee after superior shares the performance rating with employee</p>
        <table class="table table-bordered mt-2">
            <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->employee_feedback)); ?></td>
        </table>
    @endif

    @if($appraisal->final_score != null)
        <table class="table table-striped table-bordered">
            <td class="font-weight-bold" style="width: 85%;"> FINAL SCORE </td>
            <td class="font-weight-bold text-center">{{ $appraisal->final_score }}</td>
        </table>
    @endif

    @if($appraisal->confidential_summary != null)
        <h6 class="font-weight-bold mb-0">Confidential Summary & Management Development Plan</h6>
        <p style="font-size: 14px;">Overall view of job holder's performance and short to medium term aspiration<br>To be completed by assessor and reviewed with his superior</p>
        <table class="table table-bordered mt-2">
            <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->confidential_summary)); ?></td>
        </table>
    @endif

    <div class="row mb-3">
    	<div class="col-md-3">
    		<table class="table table-bordered table-view" style="width: 100%;">
    			<thead>
    				<tr>
    					<th style="text-align: center;"> PROPOSED BY </th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td class="text-center">
                            <div>
        						<span>{{ $appraisal->user_title }}</span><br>
        						<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        						<span>{{ $appraisal->user_name }}</span><br>
        						<span>{{ $appraisal->user_nik }}</span><br>
        						<span>{{ date_format(date_create($appraisal->created_at), "d M Y") }}</span>
                            </div>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    	<div class="col-md-9">
    		<table class="table table-bordered table-view" style="width: 100%;">
    			<thead>
    				<tr>
    					<th colspan="3" style="text-align: center;"> APPROVED BY </th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td class="text-center" style="width: 33.3%;">
                            <div>
        						@if($appraisal->appraisal_approval_nik_1 != null)
        							<span>{{ $appraisal->approval1_title }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_1 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_1 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_1), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    					<td class="text-center" style="width: 33.3%;">
                            <div>
        						@if($appraisal->appraisal_approval_nik_2 != null)
        							<span>{{ $appraisal->approval2_title }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_2 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_2 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_2), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    					<td class="text-center" style="width: 33.3%;">
                            <div>
        						@if($appraisal->appraisal_approval_nik_3 != null)
        							<span>{{ $appraisal->approval3_title }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_3 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_3 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_3), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-9">
    		<table class="table table-bordered table-view" style="width: 100%;">
    			<thead>
    				<tr>
    					<th colspan="3" style="text-align: center;"> APPROVED BY </th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td class="text-center" style="width: 33.3%;">
                            <div>
        						@if($appraisal->appraisal_approval_nik_4 != null)
        							<span>{{ $appraisal->approval4_title }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_4 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_4 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_4), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    					<td class="text-center" style="width: 33.3%;">
                            <div>
        						@if($appraisal->appraisal_approval_nik_5 != null)
        							<span>{{ $appraisal->approval5_title }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_5 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_5 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_5), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    					<td class="text-center" style="width: 33.3%;">
                            <div>
        						@if($appraisal->appraisal_approval_nik_6 != null)
        							<span>{{ $appraisal->approval6_title }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_6 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_6 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_6), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    	<div class="col-md-3">
    		<table class="table table-bordered table-view" style="width: 100%;">
    			<thead>
    				<tr>
    					<th style="text-align: center;"> REVIEWED BY HR </th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td class="text-center">
                            <div>
        						<span>{{ $appraisal->hr_title }}</span><br>
        						<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        						<span>{{ $appraisal->appraisal_approval_name_hr }}</span><br>
        						<span>{{ $appraisal->appraisal_approval_nik_hr }}</span><br>
        						<span>{{ date_format(date_create($appraisal->appraisal_approval_date_hr), "d M Y") }}</span>
                            </div>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    </div>

</body>
</html>