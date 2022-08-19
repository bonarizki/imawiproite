@extends('layouts.cobc')

@section('assets-top')
<link href="{{ asset('assets_dashforge/lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/select2-bootstrap4-theme/select2-bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

<style type="text/css">
    .container-checkbox {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 15px;
      font-weight: 450 !important;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      width: 20px;
      background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
      background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
      left: 7px;
      top: 3px;
      width: 6px;
      height: 11px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
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
            <h4 class="page-title d-inline">Access</h4>
            <div class="d-flex align-items-center float-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active" aria-current="page">Access</li>
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
					<table class="table table-bordered table-striped" id="table-access" style="width: 100%;">
						<thead>
							<tr>
								<th style="text-align: center; width: 25px;"> No </th>
                                <th> User </th>
                                <th> Department </th>
                                <th style="text-align: center; width: 50px;"> Access </th>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editAccess">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-header">
					<h4 class="modal-title">Edit Access</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
                    <input type="hidden" name="user_id">
					<div class="row">
                        <div class="col-3">User</div>
                        <div class="col-1">:</div>
                        <div class="col-8 user"></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Department</div>
                        <div class="col-1">:</div>
                        <div class="col-8 department"></div>
                    </div>
                    <br>
                    <h5 class="font-bold">Access Setting</h5>
                    <div class="row">
                        @foreach($parent as $p)
                            <div class="col-4">
                                <label class="container-checkbox">{{ $p->menu_parent_name }}
                                    <input type="checkbox" name="menu_parent[]" value="{{ $p->menu_parent_id }}">
                                    <span class="checkmark"></span>
                                </label>
                                <div style="padding-left: 30px;">
                                    @foreach($child as $c)
                                        @if($c->menu_parent_id == $p->menu_parent_id)
                                            <label class="container-checkbox">{{ $c->menu_child_name }}
                                                <input type="checkbox" name="menu_child[]" value="{{ $c->menu_child_id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                            <div style="padding-left: 30px;"> 
                                                @foreach($grand_child as $gc)
                                                    @if($gc->menu_child_id == $c->menu_child_id)
                                                        <label class="container-checkbox">{{ $gc->menu_grand_child_name }}
                                                            <input type="checkbox" name="menu_grand_child[]" value="{{ $gc->menu_grand_child_id }}">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
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
<!-- ============================================================== -->
<!-- Begin Modal view -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewAccess">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">View Access</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">User</div>
                        <div class="col-1">:</div>
                        <div class="col-8 user"></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Department</div>
                        <div class="col-1">:</div>
                        <div class="col-8 department"></div>
                    </div>
                    <br>
                    <h5 class="font-bold">Access</h5>
                    <div class="row">
                        @foreach($parent as $p)
                            <div class="col-4">
                                <ul class="parent-{{ $p->menu_parent_id }}" style="display: none;">
                                    <li>{{ $p->menu_parent_name }}</li>
                                    @foreach($child as $c)
                                        @if($c->menu_parent_id == $p->menu_parent_id)
                                            <ul class="child-{{ $c->menu_child_id }}" style="display: none;">
                                                <li>{{ $c->menu_child_name }}</li>
                                                @foreach($grand_child as $gc)
                                                    @if($gc->menu_child_id == $c->menu_child_id)
                                                        <ul class="grand-child-{{ $gc->menu_grand_child_id }}" style="display: none;">
                                                            <li>{{ $gc->menu_grand_child_name }}</li>
                                                        </ul>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal view -->
<!-- ============================================================== -->
@endsection

@section('assets-bottom')
<script src="{{ asset('assets_dashforge/lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/autonumeric/autoNumeric.js') }}"></script>

<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-management').addClass('active');
        $('.nav-management_access').addClass('active');

        $('.select2').select2({
            theme: 'bootstrap4'
        });

		var table = $('#table-access').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/cobc/access') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'user', name : 'user' },
                { data : 'department_name', name : 'department_name' },
                { data : 'view', name : 'view' },
                { data : 'edit', name : 'edit' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,3,4] },
                { searchable : false, targets : [0,3,4] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,3,4]
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
			var modal = $('#editAccess');

			modal.find('input[type=checkbox]').prop('checked', false);

			modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=user_id]').val(e.currentTarget.dataset.user_id);
            modal.find('.user').html(e.currentTarget.dataset.user);
            modal.find('.department').html(e.currentTarget.dataset.dept);

            var mod = e.currentTarget.dataset.mod.split('#');
            var parent = mod[0].split(',');
            var child = mod[1].split(',');
            var grand_child = mod[2].split(',');

            for(var i=0; i<parent.length; i++) {
                modal.find('input[name="menu_parent[]"][value="'+parent[i]+'"]').prop('checked', true);
            }

            for(var i=0; i<child.length; i++) {
                modal.find('input[name="menu_child[]"][value="'+child[i]+'"]').prop('checked', true);
            }

            for(var i=0; i<grand_child.length; i++) {
                modal.find('input[name="menu_grand_child[]"][value="'+grand_child[i]+'"]').prop('checked', true);
            }

			modal.modal('show');
		});

		$(document).on('submit', '#editAccess form', function(e) {
			e.preventDefault();

            $.ajax({
				url : "{{ url('api/cobc/access/update') }}",
                type : "POST",
                data : $('#editAccess form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editAccess').modal('hide');

                    toastr.success('Access have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editAccess .form-group .form-control').removeClass('is-invalid');
                    $('#editAccess .form-group .invalid-feedback').empty();

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

        $(document).on('click', '.btn-view', function(e) {
            var modal = $('#viewAccess');

            modal.find('.user').html(e.currentTarget.dataset.user);
            modal.find('.department').html(e.currentTarget.dataset.dept);
            modal.find('ul').css('display', 'none');

            var mod = e.currentTarget.dataset.mod.split('#');
            var parent = mod[0].split(',');
            var child = mod[1].split(',');
            var grand_child = mod[2].split(',');

            for(var i=0; i<parent.length; i++) {
                modal.find('ul.parent-'+parent[i]).css('display', 'block');
            }

            for(var i=0; i<child.length; i++) {
                modal.find('ul.child-'+child[i]).css('display', 'block');
            }

            for(var i=0; i<grand_child.length; i++) {
                modal.find('ul.grand-child-'+grand_child[i]).css('display', 'block');
            }

            modal.modal('show');
        });

	});

</script>
@endsection