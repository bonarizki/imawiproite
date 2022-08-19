@extends('layouts.admin')

@section('assets-top')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Authorization</li>
          <li class="breadcrumb-item active">User</li>
        </ol>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>

<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- BEGIN SEARCH BOX -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 style="margin-bottom: 0px;"><i class="fas fa-search"></i> Search Box</h5>
                    </div>
                    <div class="card-body form-horizontal" id="filter">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Position</label>
                            <div class="col-md-4">
                                <select name="position_id" class="form-control select2" data-placeholder="Select A Position">
                                    <option value="0">ALL POSITION</option>
                                    @foreach($position as $p)
                                        <option value="{{ $p->position_id }}">{{ $p->position_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Business</label>
                            <div class="col-md-4">
                                <select name="business_id" class="form-control select2" data-placeholder="Select A Business">
                                    <option value="0">ALL BUSINESS</option>
                                    @foreach($business as $b)
                                        <option value="{{ $b->business_id }}">{{ $b->business_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-flat btn-success btn-search" style="width: 150px;">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SEARCH BOX -->

                <div class="card">
                    <div class="card-header">
                        <a href="#addUser" data-toggle="modal" class="btn btn-flat btn-primary">
                            <i class="fa fa-plus"></i> Add Data
                        </a>
                        <a href="#" class="btn btn-flat btn-default float-right">
                            Export <i class="fa fa-file-excel"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover nowrap" id="table-user" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; width: 25px;"> No </th>
                                    <th rowspan="2"> NIK </th>
                                    <th rowspan="2"> User </th>
                                    <th rowspan="2"> Email </th>
                                    <th rowspan="2"> Phone </th>
                                    <th rowspan="2"> Position </th>
                                    <th rowspan="2"> Business </th>
                                    <th rowspan="2"> Status </th>
                                    <th rowspan="1" colspan="3" style="text-align: center;"> Action </th>
                                </tr>
                                <tr>
                                    <th rowspan="1" style="text-align: center; width: 50px;"> Status </th>
                                    <th rowspan="1" style="text-align: center; width: 50px;"> Edit </th>
                                    <th rowspan="1" style="text-align: center; width: 50px;"> Reset </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- BEGIN MODAL ADD USER -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addUser">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">NIK</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="text" name="user_nik" class="form-control" id="user_nik_add" maxlength="10" placeholder="Type NIK..">
                                </div>
                                <span class="text-danger"></span>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input type="text" name="user_name" class="form-control" id="user_name_add" maxlength="100" placeholder="Type name..">
                                </div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Phone</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="user_phone" class="form-control" id="user_phone_add" maxlength="20" placeholder="Type phone number..">
                                </div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="text" name="user_email" class="form-control" id="user_email_add" maxlength="100" placeholder="Type email..">
                                </div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Business</label>
                            <div class="col-md-9">
                                <select name="business_id" class="form-control select2" id="business_id_add" data-placeholder="Select A Business">
                                    <option></option>
                                    @foreach($business as $b)
                                        <option value="{{ $b->business_id }}">{{ $b->business_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Position</label>
                            <div class="col-md-9">
                                <select name="position_id" class="form-control select2" id="position_id_add" data-placeholder="Select A Position">
                                    <option></option>
                                    @foreach($position as $p)
                                        <option value="{{ $p->position_id }}">{{ $p->position_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Status Email</label>
                            <div class="col-md-9">
                                <input type="checkbox" name="email_status" value="1" id="email_status_add" data-bootstrap-switch>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>      
<!-- END MODAL ADD USER -->
<!-- BEGIN MODAL EDIT USER -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editUser">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-3 text-center">
                        <img src="" id="user_image" style="width: 80%; margin-bottom: 10px;">
                        <button type="button" class="btn btn-flat btn-info">Reset Photo</button>
                        <button type="button" class="btn btn-flat btn-info btn-reset" data-id="" data-name="" data-nik="">Reset Password</button>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">NIK</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="text" name="user_nik" class="form-control" id="user_nik_edit" maxlength="10" placeholder="Type NIK..">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Name</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                            </div>
                                            <input type="text" name="user_name" class="form-control" id="user_name_edit" maxlength="100" placeholder="Type name..">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Phone</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="user_phone" class="form-control" id="user_phone_edit" maxlength="20" placeholder="Type phone number..">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Email</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="user_email" class="form-control" id="user_email_edit" maxlength="100" placeholder="Type email..">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Business</label>
                                    <div class="col-md-9">
                                        <select name="business_id" class="form-control select2" id="business_id_edit" data-placeholder="Select A Business">
                                            <option></option>
                                            @foreach($business as $b)
                                                <option value="{{ $b->business_id }}">{{ $b->business_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Position</label>
                                    <div class="col-md-9">
                                        <select name="position_id" class="form-control select2" id="position_id_edit" data-placeholder="Select A Position">
                                            <option></option>
                                            @foreach($position as $p)
                                                <option value="{{ $p->position_id }}">{{ $p->position_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Status User</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" name="user_status" value="1" id="user_status_edit" data-bootstrap-switch>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Status Email</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" name="email_status" value="1" id="email_status_edit" data-bootstrap-switch>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>      
<!-- END MODAL EDIT USER -->
@endsection

@section('assets-bottom')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $('.select2').select2({
            theme : 'bootstrap4'
        });

        $('input[data-bootstrap-switch]').each(function() {
            $(this).bootstrapSwitch();
        })

        const Toast = Swal.mixin({
            toast : true,
            position : 'top-end',
            showConfirmButton : false,
            timer : 2500
        });
        
        var table = $('#table-user').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/user') }}",
                data : function(d) {
                    d.position = $('#filter select[name=position_id]').val();
                    d.business = $('#filter select[name=business_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'user_nik', name : 'user_nik' },
                { data : 'user_name', name : 'user_name' },
                { data : 'email', name : 'email' },
                { data : 'user_phone', name : 'user_phone' },
                { data : 'position_name', name : 'position_name' },
                { data : 'business_name', name : 'business_name' },
                { data : 'user_status', name : 'user_status' },
                { data : 'status', name : 'status' },
                { data : 'edit', name : 'edit' },
                { data : 'reset', name : 'reset' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,3,8,9,10] },
                { searchable : false, targets : [0,3,8,9,10] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,3,8,9,10]
                },
                { render : function(data, type, row, meta) {
                    if(data == '1') {
                        return '<span class="text-success">Active</span>';
                    } else if(data == '0') {
                        return '<span class="text-danger">Passive</span>';
                    }}, targets : [7]
                }
            ],
            order : []
        });

        $(document).on('click', '.btn-search', function(e) {
            table.draw();
        });

        $(document).on('show.bs.modal', '#addUser', function(e) {
            $('#addUser .form-group .form-control').removeClass('is-invalid');
            $('#addUser .form-group .text-danger').empty();

            $('#addUser input[name=user_nik]').val('');
            $('#addUser input[name=user_name]').val('');
            $('#addUser input[name=user_phone]').val('');
            $('#addUser input[name=user_email]').val('');
            $('#addUser select[name=business_id]').val(0).trigger('change');
            $('#addUser select[name=position_id]').val(0).trigger('change');
            $('#addUser input[name=email_status]').bootstrapSwitch('state', false);
        });

        $(document).on('submit', '#addUser form', function(e) {
            e.preventDefault();

            if(!$('#addUser form').valid()) return false;

            $.ajax({
                url : "{{ url('api/user') }}",
                type : "POST",
                data : $('#addUser form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addUser').modal('hide');

                    Toast.fire({
                        icon : 'success',
                        title : 'User have been added'
                    });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addUser .form-group .form-control').removeClass('is-invalid');
                    $('#addUser .form-group .text-danger').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_add')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.text-danger')
                                .html(val)
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-edit', function(e) {
            var modal = $('#editUser');

            modal.find('.form-group .form-control').removeClass('is-invalid');
            modal.find('.form-group .text-danger').empty();

            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=user_nik]').val(e.currentTarget.dataset.nik);
            modal.find('input[name=user_name]').val(e.currentTarget.dataset.name);
            modal.find('input[name=user_phone]').val(e.currentTarget.dataset.phone);
            modal.find('input[name=user_email]').val(e.currentTarget.dataset.email);
            modal.find('select[name=business_id]').val(e.currentTarget.dataset.business).trigger('change');
            modal.find('select[name=position_id]').val(e.currentTarget.dataset.position).trigger('change');
            modal.find('input[name=email_status]').bootstrapSwitch('state', (e.currentTarget.dataset.email_status == '1' ? true : false));
            modal.find('input[name=user_status]').bootstrapSwitch('state', (e.currentTarget.dataset.status == '1' ? true : false));

            if(!e.currentTarget.dataset.image) {
                modal.find('#user_image').prop('src', '{!! asset("img-user/anonymous.jpg") !!}');
            }

            modal.find('.btn-reset').attr('data-id', e.currentTarget.dataset.id);
            modal.find('.btn-reset').attr('data-name', e.currentTarget.dataset.name);
            modal.find('.btn-reset').attr('data-nik', e.currentTarget.dataset.nik);

            modal.modal('show');
        });

        $(document).on('submit', '#editUser form', function(e) {
            e.preventDefault();

            if(!$('#editUser form').valid()) return false;

            $.ajax({
                url : "{{ url('api/user/update') }}",
                type : "POST",
                data : $('#editUser form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editUser').modal('hide');

                    Toast.fire({
                        icon : 'success',
                        title : 'User have been updated'
                    })
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editUser .form-group .form-control').removeClass('is-invalid');
                    $('#editUser .form-group .text-danger').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_edit')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.text-danger')
                                .html(val)
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-activate', function(e) {
            Swal.fire({
                title : 'Are you sure?',
                text : 'You\'re going to '+this.dataset.message+' '+this.dataset.name,
                icon : 'warning',
                showCancelButton : true, 
                confirmButtonText : 'Yes, '+this.dataset.message,
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/user/activate') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id
                        },
                        success : function(res) {
                            table.draw(false);

                            Toast.fire({
                                icon : 'success',
                                title : 'User have been '+res.message
                            })
                        },
                        error : function(jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-reset', function(e) {
            Swal.fire({
                title : 'Are you sure?',
                text : 'You\'re going to reset password for ['+this.dataset.nik+'] '+this.dataset.name,
                icon : 'warning',
                showCancelButton : true,
                confirmButtonText : 'Yes, Reset Password',
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/user/reset') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id
                        },
                        success : function(res) {
                            Toast.fire({
                                icon : 'success',
                                title : 'User\'s Password have been reset'
                            })
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