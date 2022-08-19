@extends('layouts.recruitment')

@section('assets-top')
<style type="text/css">
    
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Master Standard Lead Time</h2>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Master</a>
                    </li>
                    <li class="breadcrumb-item active">Standard Lead Time
                    </li>
                </ol>
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
					<table class="table table-bordered table-striped" id="table-leadtime" style="width: 100%;">
						<thead>
							<tr>
								<th style="text-align: center; width: 25px;"> No </th>
                                <th> Grade Group </th>
                                <th style="text-align: center;"> Standard Lead Time </th>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editLeadTime">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-header">
					<h4 class="modal-title">Edit Standard Lead Time</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
                    <h4></h4>
                    <div class="form-group">
                        <label class="col-form-label">Standard Lead Time</label>
                        <input type="text" name="standard_lead_time" class="form-control numbers" id="standard_lead_time" placeholder="Fill Standard Lead Time">
                        <div class="invalid-feedback"></div>
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
<script type="text/javascript">
	
	$(document).ready(function() {

        setTimeout(function() {
            $('.nav-master').addClass('sidebar-group-active').addClass('active').addClass('open');
            $('.nav-master_standard_lead_time').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 2000);

        $('.select2').select2();
        $('.numbers').autoNumeric('init', {mDec : '0'});

		var table = $('#table-leadtime').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/lead-time') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'grade_group_name', name : 'grade_group_name' },
                { data : 'standard_lead_time', name : 'standard_lead_time' },
                { data : 'edit', name : 'edit' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,3] },
                { searchable : false, targets : [0,2,3] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,2,3]
                }
            ],
			order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
		});

		$(document).on('click', '.btn-edit', function(e) {
			var modal = $('#editLeadTime');

			modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('.modal-body h4').html(e.currentTarget.dataset.grade_group);
            modal.find('input[name=standard_lead_time]').autoNumeric('set', e.currentTarget.dataset.leadtime);

			modal.modal('show');
		});

		$(document).on('submit', '#editLeadTime form', function(e) {
			e.preventDefault();

            $.ajax({
				url : "{{ url('/recruitment/lead-time') }}",
                type : "POST",
                data : $('#editLeadTime form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editLeadTime').modal('hide');

                    toastr.success('Standard Lead Time have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editLeadTime .form-group .form-control').removeClass('is-invalid');
                    $('#editLeadTime .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key)
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