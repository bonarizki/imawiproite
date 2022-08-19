@extends('layouts.appraisal')

@section('assets-top')
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
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }
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
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Page Title -->
    <!-- ============================================================== -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Master Access Position</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Access Position</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Title -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="#addAccess" class="btn btn-primary" data-toggle="modal">
                        <i class="fas fa-plus"></i> Add Access Position
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-access" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 25px;"> No </th>
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
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- Begin Modal Add -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addAccess">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Add Access</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-3 form-label required">Department</label>
                        <div class="col-9">
                            <select name="department_id" class="form-control select2" id="department_id_add" data-placeholder="Select A Department" style="width: 100%;">
                                <option></option>
                                @foreach($department as $d)
                                    <option value="{{ $d->department_id }}">{{ $d->department_name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editAccess">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Access</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="department_id">
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-master').addClass('active');
        $('.nav-master_access_position').addClass('active');

        $('.select2').select2({
            theme: 'bootstrap4'
        });

        var table = $('#table-access').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/access-position') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'department_name', name : 'department_name' },
                { data : 'view', name : 'view' },
                { data : 'edit', name : 'edit' }
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

        $(document).on('submit', '#addAccess form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/access-position') }}",
                type : "POST",
                data : $('#addAccess form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addAccess').modal('hide');

                    toastr.success('Access Position have been added!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addAccess .form-group .form-control').removeClass('is-invalid');
                    $('#addAccess .form-group .invalid-feedback').empty();

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
            var modal = $('#editAccess');

            modal.find('input[type=checkbox]').prop('checked', false);

            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=department_id]').val(e.currentTarget.dataset.dept_id);
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
                url : "{{ url('api/appraisal/access-position/update') }}",
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