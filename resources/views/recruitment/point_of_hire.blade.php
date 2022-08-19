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
            <h2 class="content-header-title float-left mb-0">Master Point of Hire</h2>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Master</a>
                    </li>
                    <li class="breadcrumb-item active">Point of Hire
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
                <div class="card-header">
                    <a href="#addPoH" class="btn btn-primary" data-toggle="modal">
                        <i class="feather icon-plus"></i> Add Point of Hire
                    </a>
                </div>
                <div class="card-body">
					<table class="table table-bordered table-striped" id="table-poh" style="width: 100%;">
						<thead>
							<tr>
								<th style="text-align: center; width: 25px;"> No </th>
                                <th> Point of Hire </th>
                                <th style="text-align: center; width: 50px;"> Edit </th>
                                <th style="text-align: center; width: 50px;"> Delete </th>
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
<!-- Begin Modal Add -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addPoH">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Add Point of Hire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Point of Hire</label>
                        <input type="text" name="point_of_hire_name" class="form-control" id="point_of_hire_name_add" placeholder="Type point of hire.." maxlength="100">
                        <div class="invalid-feedback"></div>
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
<!-- End Modal Add -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal edit -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editPoH">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-header">
					<h4 class="modal-title">Edit Point of Hire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Point of Hire</label>
                        <input type="text" name="point_of_hire_name" class="form-control" id="point_of_hire_name_edit" placeholder="Type point of hire.." maxlength="100">
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
            $('.nav-master_point_of_hire').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 2000);

        $('.select2').select2();

		var table = $('#table-poh').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/poh') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'point_of_hire_name', name : 'point_of_hire_name' },
                { data : 'edit', name : 'edit' },
                { data : 'delete', name : 'delete' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,2,3] },
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

        setTimeout(function() {
            table.draw();
        }, 3000);

        $(document).on('submit', '#addPoH form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/recruitment/poh') }}",
                type : "POST",
                data : $('#addPoH form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addPoH').modal('hide');
                    $('#addPoH form').trigger('reset');

                    toastr.success('Point of Hire have been added!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addPoH .form-group .form-control').removeClass('is-invalid');
                    $('#addPoH .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_add')
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

		$(document).on('click', '.btn-edit', function(e) {
			var modal = $('#editPoH');

			modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=point_of_hire_name]').val(e.currentTarget.dataset.name);

			modal.modal('show');
		});

		$(document).on('submit', '#editPoH form', function(e) {
			e.preventDefault();

            $.ajax({
				url : "{{ url('api/recruitment/poh/update') }}",
                type : "POST",
                data : $('#editPoH form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editPoH').modal('hide');

                    toastr.success('Point of Hire have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editPoH .form-group .form-control').removeClass('is-invalid');
                    $('#editPoH .form-group .invalid-feedback').empty();

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

        $(document).on('click', '.btn-delete', function(e) {
            swal({
                title : 'Are you sure?',
                text : 'You\'re going to Delete Point of Hire '+this.dataset.name,
                type : 'warning',
                showCancelButton : true, 
                confirmButtonText : 'Yes, Delete',
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/recruitment/poh/delete') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id
                        },
                        success : function(res) {
                            table.draw();

                            toastr.success('Point of Hire have been deleted!', 'Success', { "closeButton": true });
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