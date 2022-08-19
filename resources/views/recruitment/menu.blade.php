@extends('layouts.recruitment')

@section('assets-top')
<style type="text/css">
    div.slider {
        display: none;
        padding: 20px;
    }
    table.dataTable tbody td.no-padding {
        padding: 0;
    }
    table.dataTable tbody tr.no-padding:hover {
        background-color: white;
    }
    table.table-detail tr td {
        vertical-align: middle;
        background-color: white;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Master Menu</h2>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Master</a>
                    </li>
                    <li class="breadcrumb-item active">Menu
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
                    <a href="#addMenu" class="btn btn-primary" data-toggle="modal">
                        <i class="feather icon-plus"></i> Add Menu
                    </a>
                </div>
				<div class="card-body">
					<table class="table table-bordered table-striped" id="table-menu" style="width: 100%;">
						<thead>
							<tr>
                                <th style="text-align: center; width: 25px;">#</th>
								<th style="text-align: center; width: 25px;"> No </th>
                                <th> Menu </th>
                                <th> URL </th>
                                <th style="text-align: center; width: 50px;"> Icon </th>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addMenu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Add Menu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Type Menu</label>
                        <div class="col-9">
                            <select name="menu_type" class="form-control select2-hide-search" id="menu_type_add" data-placeholder="Select A Menu Type" style="width: 100%;">
                                <option></option>
                                <option value="1">Parent Menu</option>
                                <option value="2">Child Menu</option>
                                <option value="3">Grand Child Menu</option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="menu-detail"></div>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editMenu">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-header">
					<h4 class="modal-title">Edit Menu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
                        <label class="col-3 col-form-label">Type Menu</label>
                        <div class="col-9">
                            <select name="menu_type" class="form-control select2-hide-search" id="menu_type_edit" data-placeholder="Select A Menu Type" style="width: 100%;" disabled>
                                <option></option>
                                <option value="1">Parent Menu</option>
                                <option value="2">Child Menu</option>
                                <option value="3">Grand Child Menu</option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <input type="hidden" name="type">
                    <input type="hidden" name="parent_id">
                    <input type="hidden" name="child_id">
                    <input type="hidden" name="menu_name">
                    <input type="hidden" name="menu_url">
                    <input type="hidden" name="menu_icon">
                    <div class="menu-detail"></div>
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
            $('.nav-master').addClass('sidebar-group-active active open');
            $('.nav-master_menu').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 2000);

        $('.select2').select2();

        $('.select2-hide-search').select2({
            minimumResultsForSearch: Infinity
        });

		var table = $('#table-menu').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/menu') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'detail', name : 'detail' },
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'menu_parent_name', name : 'menu_parent_name' },
                { data : 'menu_parent_url', name : 'menu_parent_url' },
                { data : 'icon', name : 'icon' },
                { data : 'edit', name : 'edit' },
                { data : 'delete', name : 'delete' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,1,4,5,6] },
                { searchable : false, targets : [0,1,4,5,6] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,1,4,5,6]
                }
            ],
			order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
		});

        $(document).on('click', '.btn-detail-child', function(e) {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if(row.child.isShown()) {
                $('div.slider', row.child()).slideUp(function() {
                    row.child.hide();
                    tr.removeClass('shown');
                });
                $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            } else {
                row.child(format(row.data(), 'child'), 'no-padding').show();
                tr.addClass('shown');
                $('div.slider', row.child()).slideDown();
                $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');

                var id = row.data().menu_parent_id;
                var table_child = $(`#table_child_${id}`).DataTable({
                    processing : true,
                    serverSide : true,
                    scrollX : true,
                    paging : false,
                    filter : false,
                    info : false,
                    lengthChange : false,
                    ajax : {
                        url : "{{ url('api/recruitment/menu/child') }}",
                        data : function(d) {
                            d.parent_id = id;
                        }
                    },
                    columns : [
                        { data : 'detail', name : 'detail' },
                        { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                        { data : 'menu_child_name', name : 'menu_child_name' },
                        { data : 'menu_child_url', name : 'menu_child_url' },
                        { data : 'icon', name : 'icon' },
                        { data : 'edit', name : 'edit' },
                        { data : 'delete', name : 'delete' }
                    ],
                    columnDefs : [
                        { orderable : false, targets : [0,1,4,5,6] },
                        { searchable : false, targets : [0,1,4,5,6] },
                        { createdCell : function(td, data, rowData, row, col) {
                            $(td).css('text-align', 'center') }, targets : [0,1,4,5,6]
                        }
                    ],
                    order : []
                })
            }

            $(`#table_child_${row.data().menu_parent_id}`).on('click', '.btn-detail-grand-child', function(e) {
                var tr = $(this).closest('tr');
                var row = table_child.row(tr);

                if(row.child.isShown()) {
                    $('div.slider', row.child()).slideUp(function() {
                        row.child.hide();
                        tr.removeClass('shown');
                    });
                    $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
                } else {
                    row.child(format(row.data(), 'grand-child'), 'no-padding').show();
                    tr.addClass('shown');
                    $('div.slider', row.child()).slideDown();
                    $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');

                    var id = row.data().menu_child_id;
                    var table_grand_child = $(`#table_grand_child_${id}`).DataTable({
                        processing : true,
                        serverSide : true,
                        scrollX : true,
                        paging : false,
                        filter : false,
                        info : false,
                        lengthChange : false,
                        ajax : {
                            url : "{{ url('api/recruitment/menu/grand-child') }}",
                            data : function(d) {
                                d.child_id = id;
                            }
                        },
                        columns : [
                            { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                            { data : 'menu_grand_child_name', name : 'menu_grand_child_name' },
                            { data : 'menu_grand_child_url', name : 'menu_grand_child_url' },
                            { data : 'icon', name : 'icon' },
                            { data : 'edit', name : 'edit' },
                            { data : 'delete', name : 'delete' }
                        ],
                        columnDefs : [
                            { orderable : false, targets : [0,3,4,5] },
                            { searchable : false, targets : [0,3,4,5] },
                            { createdCell : function(td, data, rowData, row, col) {
                                $(td).css('text-align', 'center') }, targets : [0,3,4,5]
                            }
                        ],
                        order : []
                    });
                }
            });
        });

		$(document).on('show.bs.modal', '#addMenu', function(e) {
            $('#addMenu .form-group .form-control').removeClass('is-invalid');
            $('#addMenu .form-group .invalid-feedback').empty();

            $('#addMenu select[name=menu_type]').val(0).trigger('change');
        });

        $(document).on('submit', '#addMenu form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/recruitment/menu') }}",
                type : "POST",
                data : $('#addMenu form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addMenu').modal('hide');

                    toastr.success('Menu have been added!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addMenu .form-group .form-control').removeClass('is-invalid');
                    $('#addMenu .form-group .invalid-feedback').empty();

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
			var modal = $('#editMenu');

			modal.find('.form-group .form-control').removeClass('is-invalid');
            modal.find('.form-group .invalid-feedback').empty();

            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=type]').val(e.currentTarget.dataset.type);
            modal.find('input[name=menu_name]').val(e.currentTarget.dataset.name);
            modal.find('input[name=menu_icon]').val(e.currentTarget.dataset.icon);
            modal.find('input[name=menu_url]').val(e.currentTarget.dataset.url);

            if(e.currentTarget.dataset.type == 2) {
                modal.find('input[name=parent_id]').val(e.currentTarget.dataset.parent);
            } else if(e.currentTarget.dataset.type == 3) {
                modal.find('input[name=parent_id]').val(e.currentTarget.dataset.parent);
                modal.find('input[name=child_id]').val(e.currentTarget.dataset.child);
            }

			modal.find('select[name=menu_type]').val(e.currentTarget.dataset.type).trigger('change');

			modal.modal('show');
		});

		$(document).on('submit', '#editMenu form', function(e) {
			e.preventDefault();

            $.ajax({
				url : "{{ url('api/recruitment/menu/update') }}",
                type : "POST",
                data : $('#editMenu form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#editMenu').modal('hide');

                    toastr.success('Menu have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editMenu .form-group .form-control').removeClass('is-invalid');
                    $('#editMenu .form-group .invalid-feedback').empty();

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

        $(document).on('change', '#addMenu select[name=menu_type]', function(e) {
            var html = '';
            if($(this).val() == 1) {
                var html = `<div class="form-group row">
                                <label class="col-3 col-form-label">Menu Name</label>
                                <div class="col-9">
                                    <input type="text" name="menu_parent_name" class="form-control" id="menu_parent_name_add" maxlength="100" placeholder="Type menu name..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Icon</label>
                                <div class="col-9">
                                    <input type="text" name="menu_parent_icon" class="form-control" id="menu_parent_icon_add" maxlength="50" placeholder="Type menu icon..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu URL</label>
                                <div class="col-9">
                                    <input type="text" name="menu_parent_url" class="form-control" id="menu_parent_url_add" maxlength="100" placeholder="Type menu url..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>`;

                $('#addMenu .menu-detail').html(html);
            } else if($(this).val() == 2) {
                var html = `<div class="form-group row">
                                <label class="col-3 col-form-label">Menu Parent</label>
                                <div class="col-9">
                                    <select name="menu_parent_id" class="form-control select2" id="menu_parent_id_add" data-placeholder="Select A Menu Parent" style="width: 100%;">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Name</label>
                                <div class="col-9">
                                    <input type="text" name="menu_child_name" class="form-control" id="menu_child_name_add" maxlength="100" placeholder="Type menu name..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Icon</label>
                                <div class="col-9">
                                    <input type="text" name="menu_child_icon" class="form-control" id="menu_child_icon_add" maxlength="50" placeholder="Type menu icon..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu URL</label>
                                <div class="col-9">
                                    <input type="text" name="menu_child_url" class="form-control" id="menu_child_url_add" maxlength="100" placeholder="Type menu url..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>`;

                $('#addMenu .menu-detail').html(html);
                getMenuParentAdd();
            } else if($(this).val() == 3) {
                var html = `<div class="form-group row">
                                <label class="col-3 col-form-label">Menu Parent</label>
                                <div class="col-9">
                                    <select name="menu_parent_id" class="form-control select2" id="menu_parent_id_add" data-placeholder="Select A Menu Parent" style="width: 100%;">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Child</label>
                                <div class="col-9">
                                    <select name="menu_child_id" class="form-control select2" id="menu_child_id_add" data-placeholder="Select A Menu Child" style="width: 100%;">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Name</label>
                                <div class="col-9">
                                    <input type="text" name="menu_grand_child_name" class="form-control" id="menu_grand_child_name_add" maxlength="100" placeholder="Type menu name..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Icon</label>
                                <div class="col-9">
                                    <input type="text" name="menu_grand_child_icon" class="form-control" id="menu_grand_child_icon_add" maxlength="50" placeholder="Type menu icon..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu URL</label>
                                <div class="col-9">
                                    <input type="text" name="menu_grand_child_url" class="form-control" id="menu_grand_child_url_add" maxlength="100" placeholder="Type menu url..">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>`;

                $('#addMenu .menu-detail').html(html);
                getMenuParentAdd();
                $('#addMenu select[name=menu_child_id]').select2();
            } else {
                var html = '';

                $('#addMenu .menu-detail').html(html);
            }
        });
    
        $(document).on('change', '#addMenu select[name=menu_parent_id]', function(e) {
            var type = $('#addMenu select[name=menu_type]').val();

            if(type == 3) {
                $('#addMenu select[name=menu_child_id]').empty();

                $.ajax({
                    type : "GET",
                    url : "{{ url('api/recruitment/menu/child') }}?parent_id="+$(this).val(),
                    dataType : "JSON",
                    success : function(res) {
                        if(res.data) {
                            $('#addMenu select[name=menu_child_id]').append('<option></option>');
                            $.each(res.data, function(key, val) {
                                $('#addMenu select[name=menu_child_id]').append('<option value="'+val['menu_child_id']+'">'+val['menu_child_name']+'</option>');
                            });
                        }
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            }
        });

        $(document).on('change', '#editMenu select[name=menu_type]', function(e) {
            var html = '';
            var name = $('#editMenu input[name=menu_name]').val();
            var icon = $('#editMenu input[name=menu_icon]').val();
            var url = $('#editMenu input[name=menu_url]').val();
            if($(this).val() == 1) {
                var html = `<div class="form-group row">
                                <label class="col-3 col-form-label">Menu Name</label>
                                <div class="col-9">
                                    <input type="text" name="menu_parent_name" class="form-control" id="menu_parent_name_edit" maxlength="100" placeholder="Type menu name.." value="`+name+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Icon</label>
                                <div class="col-9">
                                    <input type="text" name="menu_parent_icon" class="form-control" id="menu_parent_icon_edit" maxlength="20" placeholder="Type menu icon.." value="`+icon+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu URL</label>
                                <div class="col-9">
                                    <input type="text" name="menu_parent_url" class="form-control" id="menu_parent_url_edit" maxlength="100" placeholder="Type menu url.." value="`+url+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>`;

                $('#editMenu .menu-detail').html(html);
            } else if($(this).val() == 2) {
                var html = `<div class="form-group row">
                                <label class="col-3 col-form-label">Menu Parent</label>
                                <div class="col-9">
                                    <select name="menu_parent_id" class="form-control select2" id="menu_parent_id_edit" data-placeholder="Select A Menu Parent" style="width: 100%;">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Name</label>
                                <div class="col-9">
                                    <input type="text" name="menu_child_name" class="form-control" id="menu_child_name_edit" maxlength="100" placeholder="Type menu name.." value="`+name+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Icon</label>
                                <div class="col-9">
                                    <input type="text" name="menu_child_icon" class="form-control" id="menu_child_icon_edit" maxlength="20" placeholder="Type menu icon.." value="`+icon+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu URL</label>
                                <div class="col-9">
                                    <input type="text" name="menu_child_url" class="form-control" id="menu_child_url_edit" maxlength="100" placeholder="Type menu url.." value="`+url+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>`;

                $('#editMenu .menu-detail').html(html);
                $('#editMenu select[name=menu_parent_id]').select2();
                getMenuParentEdit();
            } else if($(this).val() == 3) {
                var html = `<div class="form-group row">
                                <label class="col-3 col-form-label">Menu Parent</label>
                                <div class="col-9">
                                    <select name="menu_parent_id" class="form-control select2" id="menu_parent_id_edit" data-placeholder="Select A Menu Parent" style="width: 100%;">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Child</label>
                                <div class="col-9">
                                    <select name="menu_child_id" class="form-control select2" id="menu_child_id_edit" data-placeholder="Select A Menu Child" style="width: 100%;">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Name</label>
                                <div class="col-9">
                                    <input type="text" name="menu_grand_child_name" class="form-control" id="menu_grand_child_name_edit" maxlength="100" placeholder="Type menu name.." value="`+name+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu Icon</label>
                                <div class="col-9">
                                    <input type="text" name="menu_grand_child_icon" class="form-control" id="menu_grand_child_icon_edit" maxlength="20" placeholder="Type menu icon.." value="`+icon+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Menu URL</label>
                                <div class="col-9">
                                    <input type="text" name="menu_grand_child_url" class="form-control" id="menu_grand_child_url_edit" maxlength="100" placeholder="Type menu url.." value="`+url+`">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>`;

                $('#editMenu .menu-detail').html(html);
                $('#editMenu select[name=menu_parent_id], #editMenu select[name=menu_child_id]').select2();
                getMenuParentEdit();
            } else {
                var html = '';

                $('#editMenu .menu-detail').html(html);
            }
        });

        $(document).on('change', '#editMenu select[name=menu_parent_id]', function(e) {
            var type = $('#editMenu select[name=menu_type]').val();

            if(type == 3) {
                $('#editMenu select[name=menu_child_id]').empty();

                $.ajax({
                    type : "GET",
                    url : "{{ url('api/recruitment/menu/child') }}?parent_id="+$(this).val(),
                    dataType : "JSON",
                    success : function(res) {
                        if(res.data) {
                            $('#editMenu select[name=menu_child_id]').append('<option></option>');
                            $.each(res.data, function(key, val) {
                                $('#editMenu select[name=menu_child_id]').append('<option value="'+val['menu_child_id']+'">'+val['menu_child_name']+'</option>');
                            });
                        }
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    },
                    complete : function() {
                        $('#editMenu select[name=menu_child_id]').val($('#editMenu input[name=child_id]').val()).trigger('change');
                        $('#editMenu input[name=child_id]').val('');
                    }
                });
            }
        });

        $(document).on('click', '.btn-delete', function(e) {
            swal({
                title : 'Are you sure?',
                text : 'You\'re going to Delete Menu '+this.dataset.name,
                type : 'warning',
                showCancelButton : true, 
                confirmButtonText : 'Yes, Delete',
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/recruitment/menu/delete') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id,
                            type : this.dataset.type
                        },
                        success : function(res) {
                            table.draw();

                            toastr.success('Menu have been deleted!', 'Success', { "closeButton": true });
                        },
                        error : function(jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        });

	});

    function getMenuParentAdd() {
        $.ajax({
            type : "GET",
            url : "{{ url('api/recruitment/menu') }}",
            dataType : "JSON",
            success : function(res) {
                $.each(res.data, function(key, val) {
                    $('#addMenu select[name=menu_parent_id]').append('<option value="'+val['menu_parent_id']+'">'+val['menu_parent_name']+'</option>');
                });
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            },
            complete : function() {
                $('#addMenu select[name=menu_parent_id]').select2();
            }
        });
    }

    function getMenuParentEdit() {
        $.ajax({
            type : "GET",
            url : "{{ url('api/recruitment/menu') }}",
            dataType : "JSON",
            success : function(res) {
                $.each(res.data, function(key, val) {
                    $('#editMenu select[name=menu_parent_id]').append('<option value="'+val['menu_parent_id']+'">'+val['menu_parent_name']+'</option>');
                });
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            },
            complete : function() {
                $('#editMenu select[name=menu_parent_id]').val($('#editMenu input[name=parent_id]').val()).trigger('change');
            }
        });
    }

    function format(d, type) {
        var table = '';
        if(type == 'child') {
            table = `<div class="slider">
                        <table class="table table-bordered table-striped" style="width: 100%;" id="table_child_${d.menu_parent_id}">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 25px;"> # </th>
                                    <th style="text-align: center; width: 25px;"> No </th>
                                    <th> Menu </th>
                                    <th> URL </th>
                                    <th style="text-align: center; width: 50px;"> Icon </th>
                                    <th style="text-align: center; width: 50px;"> Edit </th>
                                    <th style="text-align: center; width: 50px;"> Delete </th>
                                </tr>
                            </thead>
                            <tbody><tbody>
                        </table>
                    </div>`;
        } else if(type == 'grand-child') {
            table = `<div class="slider">
                        <table class="table table-bordered table-striped" style="width: 100%;" id="table_grand_child_${d.menu_child_id}">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 25px;"> No </th>
                                    <th> Menu </th>
                                    <th> URL </th>
                                    <th style="text-align: center; width: 50px;"> Icon </th>
                                    <th style="text-align: center; width: 50px;"> Edit </th>
                                    <th style="text-align: center; width: 50px;"> Delete </th>
                                </tr>
                            </thead>
                            <tbody><tbody>
                        </table>
                    </div>`;
        }

        return table;
    }

</script>
@endsection