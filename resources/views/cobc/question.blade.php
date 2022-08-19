@extends('layouts.cobc')

@section('assets-top')
<link href="{{ asset('assets_dashforge/lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/select2-bootstrap4-theme/select2-bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet">

<style type="text/css">
    .card-header .bootstrap-switch {
        float: right;
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
            <h4 class="page-title d-inline">Question</h4>
            <div class="d-flex align-items-center float-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active" aria-current="page">Question</li>
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
			<div class="card">
				<div class="card-header">
					<a href="#addQuestion" class="btn btn-primary" data-toggle="modal">
						<i class="fas fa-plus"></i> Add Question
					</a>
                    <input type="checkbox" class="float-right" id="language" value="1" data-bootstrap-switch>
                    <input type="hidden" name="language" value="eng">
				</div>
				<div class="card-body">
					<table class="table table-bordered table-striped" id="table-question" style="width: 100%;">
						<thead>
							<tr>
								<th rowspan="2" style="text-align: center; width: 25px;"> No </th>
                                <th rowspan="2"> Question </th>
								<th rowspan="2" style="width: 15%;"> Option 1 </th>
                                <th rowspan="2" style="width: 15%;"> Option 2 </th>
                                <th rowspan="2" style="width: 15%;"> Option 3 </th>
                                <th rowspan="2" style="width: 50px;"> Answer </th>
                                <th rowspan="1" colspan="2" style="text-align: center;"> Action </th>
                            </tr>
                            <tr>
                                <th style="text-align: center; width: 65px;"> Edit </th>
                                <th style="text-align: center; width: 65px;"> Delete </th>
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
<!-- Begin Modal add -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addQuestion">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<div class="modal-header">
					<h4 class="modal-title">Add Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
                    <ul class="nav nav-tabs nav-justified" id="questionTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="eng-tab" data-toggle="tab" href="#eng" role="tab" aria-controls="english" aria-selected="true">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ina-tab" data-toggle="tab" href="#ina" role="tab" aria-controls="indonesia" aria-selected="false">Indonesia</a>
                        </li>
                    </ul>
                    <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="questionTabContent">
                        <div class="tab-pane fade show active" id="eng" role="tabpanel" aria-labelledby="eng-tab">
                            <div class="form-group">
                                <label>Question</label>
                                <textarea name="question_text_eng" class="form-control" id="question_text_eng_add" rows="3" placeholder="Type question.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <label class="d-inline-block">Options</label>
                            <div class="form-group mb-1">
                                <textarea name="question_option_1_eng" class="form-control" id="question_option_1_eng_add" rows="2" placeholder="Type option 1.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="question_option_2_eng" class="form-control" id="question_option_2_eng_add" rows="2" placeholder="Type option 2.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-0">
                                <textarea name="question_option_3_eng" class="form-control" id="question_option_3_eng_add" rows="2" placeholder="Type option 3.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ina" role="tabpanel" aria-labelledby="ina-tab">
                            <div class="form-group">
                                <label>Pertanyaan</label>
                                <textarea name="question_text_bhs" class="form-control" id="question_text_bhs_add" rows="3" placeholder="Isi pertanyaan.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <label class="d-inline-block">Pilihan</label>
                            <div class="form-group mb-1">
                                <textarea name="question_option_1_bhs" class="form-control" id="question_option_1_bhs_add" rows="2" placeholder="Type option 1.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="question_option_2_bhs" class="form-control" id="question_option_2_bhs_add" rows="2" placeholder="Type option 2.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-0">
                                <textarea name="question_option_3_bhs" class="form-control" id="question_option_3_bhs_add" rows="2" placeholder="Type option 3.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="col-form-label col-2">Answer</label>
                        <div class="col-3">
                            <select name="question_answer" class="form-control select2" id="question_answer_add" data-placeholder="Select An Answer" style="width: 100%;">
                                <option></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End Modal add -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal edit -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editQuestion">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-header">
					<h4 class="modal-title">Edit Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs nav-justified" id="questionTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="eng-tab-edit" data-toggle="tab" href="#eng-edit" role="tab" aria-controls="english" aria-selected="true">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ina-tab-edit" data-toggle="tab" href="#ina-edit" role="tab" aria-controls="indonesia" aria-selected="false">Indonesia</a>
                        </li>
                    </ul>
                    <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="questionTabContent">
                        <div class="tab-pane fade show active" id="eng-edit" role="tabpanel" aria-labelledby="eng-tab">
                            <div class="form-group">
                                <label>Question</label>
                                <textarea name="question_text_eng" class="form-control" id="question_text_eng_edit" rows="3" placeholder="Type question.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <label class="d-inline-block">Options</label>
                            <div class="form-group mb-1">
                                <textarea name="question_option_1_eng" class="form-control" id="question_option_1_eng_edit" rows="2" placeholder="Type option 1.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="question_option_2_eng" class="form-control" id="question_option_2_eng_edit" rows="2" placeholder="Type option 2.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-0">
                                <textarea name="question_option_3_eng" class="form-control" id="question_option_3_eng_edit" rows="2" placeholder="Type option 3.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ina-edit" role="tabpanel" aria-labelledby="ina-tab">
                            <div class="form-group">
                                <label>Pertanyaan</label>
                                <textarea name="question_text_bhs" class="form-control" id="question_text_bhs_edit" rows="3" placeholder="Isi pertanyaan.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <label class="d-inline-block">Pilihan</label>
                            <div class="form-group mb-1">
                                <textarea name="question_option_1_bhs" class="form-control" id="question_option_1_bhs_edit" rows="2" placeholder="Type option 1.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="question_option_2_bhs" class="form-control" id="question_option_2_bhs_edit" rows="2" placeholder="Type option 2.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group mb-0">
                                <textarea name="question_option_3_bhs" class="form-control" id="question_option_3_bhs_edit" rows="2" placeholder="Type option 3.."></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="col-form-label col-2">Answer</label>
                        <div class="col-3">
                            <select name="question_answer" class="form-control select2" id="question_answer_edit" data-placeholder="Select An Answer" style="width: 100%;">
                                <option></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End Modal edit -->
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

        $('.nav-management').addClass('active');
        $('.nav-management_question').addClass('active');

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

		var table = $('#table-question').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/cobc/question') }}",
                data : function(d) {
                    d.lang = $('input[name=language]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'question_text', name : 'question_text' },
                { data : 'question_option_1', name : 'question_option_1' },
                { data : 'question_option_2', name : 'question_option_2' },
                { data : 'question_option_3', name : 'question_option_3' },
                { data : 'question_answer', name : 'question_answer' },
                { data : 'edit', name : 'edit' },
                { data : 'delete', name : 'delete' },
            ],
            columnDefs : [
                { orderable : false, targets : [0,1,2,3,4,5,6,7] },
                { searchable : false, targets : [0,6,7] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,5,6,7]
                }
            ],
			order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
		});

        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(state) {
                $('input[name=language]').val('ina');
            } else {
                $('input[name=language]').val('eng');
            }

            table.draw();
        });

		$(document).on('show.bs.modal', '#addQuestion', function(e) {
			$('#addQuestion .form-group .form-control').removeClass('is-invalid');
			$('#addQuestion .form-group .invalid-feedback').empty();

			$('#addQuestion textarea').val('');
            $('#addQuestion select').val(0).trigger('change');
		});

		$(document).on('submit', '#addQuestion form', function(e) {
			e.preventDefault();

			$.ajax({
				url : "{{ url('api/cobc/question') }}",
                type : "POST",
                data : $('#addQuestion form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addQuestion').modal('hide');

                    toastr.success('Question have been added!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addQuestion .form-group .form-control').removeClass('is-invalid');
                    $('#addQuestion .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_add')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val);

                            if(key.includes('eng')) {
                                $('#addQuestion a[href="#eng"]').tab('show');
                            } else if(key.includes('bhs')) {
                                $('#addQuestion a[href="#ina"]').tab('show');
                            }
                        });
                    }
                }
			});
		});

		$(document).on('click', '.btn-edit', function(e) {
			var modal = $('#editQuestion');
            var id = e.currentTarget.dataset.id;

			modal.find('.form-group .form-control').removeClass('is-invalid');
            modal.find('.form-group .invalid-feedback').empty();

			modal.find('input[name=id]').val(id);
            
            $.ajax({
                type : "GET",
                url : "{{ url('api/cobc/question/get-question') }}?id="+id,
                dataType : "JSON",
                success : function(res) {
                    modal.find('textarea[name=question_text_eng]').val(res.question_text_eng);
                    modal.find('textarea[name=question_option_1_eng]').val(res.question_option_1_eng);
                    modal.find('textarea[name=question_option_2_eng]').val(res.question_option_2_eng);
                    modal.find('textarea[name=question_option_3_eng]').val(res.question_option_3_eng);
                    modal.find('textarea[name=question_text_bhs]').val(res.question_text_bhs);
                    modal.find('textarea[name=question_option_1_bhs]').val(res.question_option_1_bhs);
                    modal.find('textarea[name=question_option_2_bhs]').val(res.question_option_2_bhs);
                    modal.find('textarea[name=question_option_3_bhs]').val(res.question_option_3_bhs);
                    modal.find('select[name=question_answer]').val(res.question_answer).trigger('change');
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            })

			modal.modal('show');
		});

		$(document).on('submit', '#editQuestion form', function(e) {
			e.preventDefault();

			$.ajax({
				url : "{{ url('api/cobc/question/update') }}",
                type : "POST",
                data : $('#editQuestion form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editQuestion').modal('hide');

                    toastr.success('Question have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editQuestion .form-group .form-control').removeClass('is-invalid');
                    $('#editQuestion .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_edit')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val);

                            if(key.includes('eng')) {
                                $('#editQuestion a[href="#eng-edit"]').tab('show');
                            } else if(key.includes('bhs')) {
                                $('#editQuestion a[href="#ina-edit"]').tab('show');
                            }
                        });
                    }
                }
			});
		});

        $(document).on('click', '.btn-delete', function(e) {
            swal({
                title : 'Are you sure?',
                text : 'You\'re going to Delete this Question',
                type : 'warning',
                showCancelButton : true, 
                confirmButtonText : 'Yes, Delete',
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/cobc/question/delete') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id
                        },
                        success : function(res) {
                            table.draw();

                            toastr.success('Question have been deleted!', 'Success', { "closeButton": true });
                        },
                        error : function(jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        });
	});

</script>
@endsection