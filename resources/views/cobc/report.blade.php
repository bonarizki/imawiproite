@extends('layouts.cobc')

@section('assets-top')
<link href="{{ asset('assets_dashforge/lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/select2-bootstrap4-theme/select2-bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet">

<style type="text/css">
    .quiz_phase_1, .quiz_phase_2, .quiz_phase_3 {
        max-height: 300px;
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title d-inline">Report</h4>
            <div class="d-flex align-items-center float-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item active" aria-current="page">Report</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid -->
<!-- ============================================================== -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
            <fieldset class="form-fieldset" id="filter" style="padding-top: 10px; padding-bottom: 15px;">
                <legend>FILTER</legend>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="d-block">Department</label>
                            <select name="department_id" class="form-control select2" style="width: 100%;">
                                <option value="0">ALL DEPARTMENT</option>
                                @foreach($department as $d)
                                    <option value="{{ $d->department_id }}">{{ $d->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="d-block">Status</label>
                            <select name="status" class="form-control select2-hide-search" style="width: 100%;">
                                <option value="0">ALL STATUS</option>
                                <option value="1">Success</option>
                                <option value="2">Failed</option>
                                <option value="3">Haven't Taken the Test</option>
                                <option value="4">Failed Phase 1, Trying Again</option>
                                <option value="5">Failed Phase 2, Trying Again</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="d-block">Period</label>
                            <select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
                                @foreach($period_all as $p)
                                    <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-1 text-center" style="padding-left: 5px; padding-right: 5px;">
                        <a target="_blank" href="#" class="btn btn-primary btn-export">
                            <i class="fa fa-file-excel d-block" style="margin-bottom: 10px; margin-top: 5px;"></i> Export
                        </a>
                    </div>
                </div>
            </fieldset><br>
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped" id="table-report" style="width: 100%;">
						<thead>
							<tr>
								<th style="text-align: center; width: 25px;"> No </th>
                                <th> Employee </th>
                                <th> Department </th>
                                <th style="text-align: center; width: 75px;"> Phase 1 </th>
                                <th style="text-align: center; width: 75px;"> Phase 2 </th>
                                <th style="text-align: center; width: 75px;"> Phase 3 </th>
                                <th style="text-align: center;"> Status </th>
                                <th style="text-align: center; width: 50px;"> Detail </th>
                            </tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End container fluid -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin modal view -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewAnswer">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Answer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-3">Name</div>
                            <div class="col-1">:</div>
                            <div class="col-8 employee-name"></div>
                        </div>
                        <div class="row">
                            <div class="col-3">NIK</div>
                            <div class="col-1">:</div>
                            <div class="col-8 employee-nik"></div>
                        </div>
                        <div class="row">
                            <div class="col-3">Department</div>
                            <div class="col-1">:</div>
                            <div class="col-8 employee-dept"></div>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <!-- <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                        <input type="hidden" name="language" value="eng"> -->
                    </div>
                </div><br>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="phase_1-tab" data-toggle="tab" href="#phase_1" role="tab" aria-controls="phase_1" aria-selected="true">Phase 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="phase_2-tab" data-toggle="tab" href="#phase_2" role="tab" aria-controls="phase_2" aria-selected="false">Phase 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="phase_3-tab" data-toggle="tab" href="#phase_3" role="tab" aria-controls="phase_3" aria-selected="false">Phase 3</a>
                    </li>
                </ul>
                <div class="tab-content bd bd-gray-300 bd-t-0 pd-20">
                    <div class="tab-pane fade show active" id="phase_1" role="tabpanel" aria-labelledby="phase_1-tab">
                        <h5 class="d-inline">Phase 1</h5>
                        <h5 class="d-inline float-right">Score : <span class="phase_1_score"></span></h5>
                        <br><br>
                        <div class="quiz_phase_1"></div>
                    </div>
                    <div class="tab-pane fade" id="phase_2" role="tabpanel" aria-labelledby="phase_2-tab">
                        <h5 class="d-inline">Phase 2</h5>
                        <h5 class="d-inline float-right">Score : <span class="phase_2_score"></span></h5>
                        <br>
                        <div class="quiz_phase_2"></div>
                    </div>
                    <div class="tab-pane fade" id="phase_3" role="tabpanel" aria-labelledby="phase_3-tab">
                        <h5 class="d-inline">Phase 3</h5>
                        <h5 class="d-inline float-right">Score : <span class="phase_3_score"></span></h5>
                        <br>
                        <div class="quiz_phase_3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End modal view -->
<!-- ============================================================== -->
@endsection

@section('assets-bottom')
<script src="{{ asset('assets_dashforge/lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/autonumeric/autoNumeric.js') }}"></script>

<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-report').addClass('active');

        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('.select2-hide-search').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: Infinity
        });

        $('#language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

		var table = $('#table-report').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/cobc/report') }}",
                data : function(d) {
                    d.period_id = $('#filter select[name=period_id]').val();
                    d.department_id = $('#filter select[name=department_id]').val();
                    d.status = $('#filter select[name=status]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'user', name : 'user' },
                { data : 'department_name', name : 'department_name' },
                { data : 'phase_1', name : 'phase_1' },
                { data : 'phase_2', name : 'phase_2' },
                { data : 'phase_3', name : 'phase_3' },
                { data : 'status', name : 'status' },
                { data : 'view', name : 'view' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,7] },
                { searchable : false, targets : [0,3,4,5,7] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,3,4,5,6,7]
                }
            ],
			order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
		});

        $(document).on('click', '.btn-view', function(e) {
            var user = e.currentTarget.dataset.id;
            var period = e.currentTarget.dataset.period;

            var modal = $('#viewAnswer');

            modal.find('.employee-name').html(e.currentTarget.dataset.name);
            modal.find('.employee-nik').html(e.currentTarget.dataset.nik);
            modal.find('.employee-dept').html(e.currentTarget.dataset.dept);
            modal.find('.phase_1_score').html(e.currentTarget.dataset.p1);
            modal.find('.phase_2_score').html(e.currentTarget.dataset.p2);
            modal.find('.phase_3_score').html(e.currentTarget.dataset.p3);

            $.ajax({
                type : "GET",
                url : "{{ url('api/cobc/report/detail') }}?user_id="+user+"&period_id="+period,
                datType : "JSON",
                success : function(res) {
                    var phase_1 = phase_2 = phase_3 = '';
                    var p1_count = p2_count = p3_count = 1;
                    $.each(res, function(key, val) {
                        if(val['phase'] == 1) {
                            phase_1 += `<div class="row mb-3">
                                        <div class="col-1" style="max-width: 5%;">${p1_count}.</div>
                                        <div class="col-11">
                                            <p class="text-justify mb-1">${val['question_text_eng']}</p>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">A.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 1 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 1 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_1_eng']}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">B.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 2 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 2 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_2_eng']}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">C.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 3 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 3 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_3_eng']}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            p1_count++;
                        } else if(val['phase'] == 2) {
                            phase_2 += `<div class="row mb-3">
                                        <div class="col-1" style="max-width: 5%;">${p2_count}.</div>
                                        <div class="col-11">
                                            <p class="text-justify mb-1">${val['question_text_eng']}</p>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">A.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 1 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 1 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_1_eng']}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">B.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 2 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 2 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_2_eng']}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">C.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 3 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 3 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_3_eng']}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            p2_count++;
                        } else if(val['phase'] == 3) {
                            phase_3 += `<div class="row mb-3">
                                        <div class="col-1" style="max-width: 5%;">${p3_count}.</div>
                                        <div class="col-11">
                                            <p class="text-justify mb-1">${val['question_text_eng']}</p>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">A.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 1 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 1 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_1_eng']}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">B.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 2 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 2 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_2_eng']}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1" style="max-width: 5%;">C.</div>
                                                <div class="col-11">
                                                    <p class="text-justify mb-1 ${((val['question_user_answer'] == 3 && val['question_check'] == '1') ? 'bg-success' : ((val['question_user_answer'] == 3 && val['question_check'] == '0') ? 'bg-danger' : ''))}">${val['question_option_3_eng']}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            p3_count++;
                        }
                    });

                    modal.find('.quiz_phase_1').html(phase_1);
                    modal.find('.quiz_phase_2').html(phase_2);
                    modal.find('.quiz_phase_3').html(phase_3);
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

            modal.modal('show');
        });

        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

		$(document).on('change', '#filter select', function(e) {
            table.draw();
        });

        $(document).on('click', '.btn-export', function(e) {
            var period = $('#filter select[name=period_id]').val();

            $('.btn-export').attr('href', '{!! url("/cobc/report/export?period='+period+'") !!}');
        });

	});

</script>
@endsection