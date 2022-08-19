@extends('layouts.cobc')

@section('assets-top')
<link href="{{ asset('assets_dashforge/lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/select2-bootstrap4-theme/select2-bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

<style type="text/css">
    
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title d-inline">Period</h4>
            <div class="d-flex align-items-center float-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active" aria-current="page">Period</li>
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
                <div class="card-body">
					<table class="table table-bordered table-striped" id="table-period" style="width: 100%;">
						<thead>
							<tr>
								<th style="text-align: center; width: 25px;"> No </th>
                                <th> Period </th>
                                <th> Period Start </th>
                                <th> Period End </th>
                                <th style="text-align: center; width: 50px;"> Edit </th>
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
<!-- Begin Modal edit -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editPeriod">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-header">
					<h4 class="modal-title">Edit COBC Period</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
                    <div class="row">
                        <div class="col-3">Period</div>
                        <div class="col-1">:</div>
                        <div class="col-8 period"></div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Period Start</label>
                        <div class="col-5">
                            <input type="text" name="cobc_period_start" class="form-control" id="cobc_period_start_edit" value="" placeholder="Choose Period Start" readonly>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Period End</label>
                        <div class="col-5">
                            <input type="text" name="cobc_period_end" class="form-control" id="cobc_period_end_edit" value="" placeholder="Choose Period End" readonly>
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
<script src="{{ asset('assets_dashforge/lib/autonumeric/autoNumeric.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/daterangepicker/daterangepicker.min.js') }}"></script>

<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-management').addClass('active');
        $('.nav-management_period').addClass('active');

        $('.select2').select2({
            theme: 'bootstrap4'
        });

		var table = $('#table-period').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/cobc/period') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'period_name', name : 'period_name' },
                { data : 'cobc_period_start', name : 'cobc_period_start' },
                { data : 'cobc_period_end', name : 'cobc_period_end' },
                { data : 'edit', name : 'edit' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,4] },
                { searchable : false, targets : [0,4] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,4]
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

		$(document).on('click', '.btn-edit', function(e) {
			var modal = $('#editPeriod');

			modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('.period').html(e.currentTarget.dataset.period);

            modal.find('input[name=cobc_period_start], input[name=cobc_period_end]').daterangepicker({
                singleDatePicker : true,
                autoApply : true,
                locale : {
                    format : 'YYYY-MM-DD'
                }
            });

            if(e.currentTarget.dataset.start) {
                modal.find('input[name=cobc_period_start]').data('daterangepicker').setStartDate(e.currentTarget.dataset.start);
                modal.find('input[name=cobc_period_start]').data('daterangepicker').setEndDate(e.currentTarget.dataset.start);
            }

            if(e.currentTarget.dataset.end) {
                modal.find('input[name=cobc_period_end]').data('daterangepicker').setStartDate(e.currentTarget.dataset.end);
                modal.find('input[name=cobc_period_end]').data('daterangepicker').setEndDate(e.currentTarget.dataset.end);
            }

			modal.modal('show');
		});

		$(document).on('submit', '#editPeriod form', function(e) {
			e.preventDefault();

            $.ajax({
				url : "{{ url('api/cobc/period/update') }}",
                type : "POST",
                data : $('#editPeriod form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editPeriod').modal('hide');

                    toastr.success('COBC Period have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editPeriod .form-group .form-control').removeClass('is-invalid');
                    $('#editPeriod .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_edit')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val)
                        });
                    }
                }
			});
		});

	});

</script>
@endsection