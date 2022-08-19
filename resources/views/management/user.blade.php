@extends('master/master')
@section('title','Management User')
@section('breadcumb','List Data User')
@section('content')
<style type="text/css">
    .container-checkbox {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 17px;
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
      height: 25px;
      width: 25px;
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
      left: 9px;
      top: 4px;
      width: 7px;
      height: 13px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
</style>
<div class="card card-info shadow">
    <div class="card-header">
        <h3 class="card-title">Search Data By</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col form-group" >
                <label>Department</label>
                <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Department" id="department_search" name="department_search" onchange="AllUser()">
                    <option value="">Choose</option>
                </select>
            </div>
            <div class="col form-group">
                <label>Grade</label>
                <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Grade" id="grade_search" name="grade_search" onchange="AllUser()">
                    <option value="">Choose</option>
                </select>
            </div>
            <div class="col form-group">
                <label>NIK</label>
                <input type="text" class="form-control" style="width: 100%" placeholder="NIK" id="nik_search" name="nik_search" onkeyup="AllUser()"></input>
            </div>
            <div class="col form-group">
                <label>Name</label>
                <input type="text" class="form-control" style="width: 100%" placeholder="Name" id="nama_search" name="nama_search" onkeyup="AllUser()"></input>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<div class="row" style="padding-top: 10px">
    <div class="col">
        <div class="card card-primary shadow card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="all_user-tab" data-toggle="pill" href="#all_user" role="tab" aria-controls="all_user"aria-selected="true">All User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="deleted_user-tab" data-toggle="pill" href="#deleted_user" role="tab" aria-controls="deleted_user"aria-selected="false">Inactive User</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-primary mb-3" id="addUser" onclick="modal('add')"><i class="fas fa-plus" ></i> Add User</button>
                            <a href="{{url('management/user-upload')}}" target="_blank"><button class="btn btn-success mb-3" id="uploadUser" ><i class="fas fa-cloud-upload-alt" ></i> Upload User</button></a>
                            <a href="{{url('management/user/download')}}"><button class="btn btn-info mb-3" id="uploadUser" ><i class="fas fa-cloud-download-alt" ></i> Download User</button></a>
                        </div>
                    </div>
                    <div class="tab-pane fade show active table-responsive" id="all_user" role="tabpanel" aria-labelledby="all_user-tab">
                        <table class="table table-bordered table-hover table-sm" id="all-user-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No .</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th style=" width: 78px !important;">Mobile Number</th>
                                    <th>Edit</th>
                                    <th>Access</th>
                                    <th>Delete</th>
                                    <th>Reset Password</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade table-responsive" id="deleted_user" role="tabpanel" aria-labelledby="deleted_user-tab" style="width: 100%">
                        <table class="table table-bordered table-hover table-sm" id="all-user-deleted-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No .</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form">
        @csrf
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h5 class="modal-title" id="modal-title" style="color: white"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body" id="card-body">
                        <div class="form-group" hidden>
                            <label>Type</label>
                            <input type="text" class="form-control" name="type" id="type">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">NIK</label>
                            <input type="text" class="form-control" id="user_nik" name="user_nik" >
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" id="user_name" name="user_name">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="user_email" name="user_email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control" id="user_mobile" name="user_mobile">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Birth City</label>
                                    <input type="text" class="form-control" id="user_birth_city" name="user_birth_city">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Birth Date</label>
                                    <input type="text" class="form-control datepicker" id="user_birth_date" name="user_birth_date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="user_sex" id="user_sex">
                                        <option value="">Choose</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Join Date</label>
                                    <input type="text" class="form-control datepicker" id="user_join_date" name="user_join_date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-control select2bs4" name="department_id" id="department_id">
                                <option value="">Choose</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Grade</label>
                            <select class="form-control select2bs4" name="grade_id" id="grade_id">
                                <option value="">Choose</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <select class="form-control select2bs4" name="title_id" id="title_id">
                                <option value="">Choose</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control select2bs4" name="type_id" id="type_id">
                                <option value="">Choose</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>User Type</label>
                            <select class="form-control select2bs4" name="user_type" id="user_type">
                                <option value="">Choose</option>
                                <option value="ceo">CEO</option>
                                <option value="hr_head">HR HEAD</option>
                                <option value="finance_head">Finace & Accounting HEAD</option>
                                <option value="marketing_head">Marketing HEAD</option>
                                <option value="it_head">IT HEAD</option>
                                <option value="r&d_head">R&D HEAD</option>
                                <option value="r&d_head">R&D HEAD</option>
                                <option value="manufacture_head">Manufacture HEAD</option>
                                <option value="sales_head">Sales HEAD</option>
                                <option value="user">USER</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>User Status</label><br>
                            <input type="checkbox" class="form-control" name="user_status" id="user_status" checked data-bootstrap-switch data-off-color="danger" data-on-color="info" data-on-text="Active" data-off-text="Inactive">
                        </div>
                    </div>
                    
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal" onclick="validasi()">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="accessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="POST">
        @csrf
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="modal-title" style="color: white">Edit Access</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">NIK</div>
                        <div class="col-1">:</div>
                        <div class="col-8 employee-nik"></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Name</div>
                        <div class="col-1">:</div>
                        <div class="col-8 employee-name"></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Grade</div>
                        <div class="col-1">:</div>
                        <div class="col-8 employee-grade"></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Department</div>
                        <div class="col-1">:</div>
                        <div class="col-8 employee-department"></div>
                    </div>
                    <hr>
                    <input type="hidden" name="user_id">
                    <h5 class="font-bold">Module</h5>
                    <div class="row">
                        @foreach($module as $m)
                            <div class="col-4">
                                <label class="container-checkbox">{{ $m->module_name }}
                                    <input type="checkbox" name="module[]" value="{{ $m->module_id }}">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <h5 class="font-bold">Access Menu</h5>
                    <div class="row">
                        @foreach($menu as $m)
                            <div class="col-4 mt-3">
                                <label class="container-checkbox">{{ $m->menu_parent_name }}
                                    <input type="checkbox" name="menu_parent[]" value="{{ $m->menu_parent_id }}">
                                    <span class="checkmark"></span>
                                </label>
                                <div style="padding-left: 30px;">
                                    @foreach($menu_child as $mc)
                                        @if($mc->menu_parent_id == $m->menu_parent_id)
                                            <label class="container-checkbox">{{ $mc->menu_child_name }}
                                                <input type="checkbox" name="menu_child[]" value="{{ $mc->menu_child_id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                            <div style="padding-left: 30px;"> 
                                                @foreach($menu_grand_child as $mgc)
                                                    @if($mgc->menu_child_id == $mc->menu_child_id)
                                                        <label class="container-checkbox">{{ $mgc->menu_grand_child_name }}
                                                            <input type="checkbox" name="menu_grand_child[]" value="{{ $mgc->menu_grand_child_id }}">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            getAllOption();
            GetaAllUserDeleted();
            AllUser();
            setStatus()
        });

        $('#user_status').on('switchChange.bootstrapSwitch', function () {
            if ($('#user_status').is(':checked')) {
                $('#user_status').val('1')
            } else {
                $('#user_status').val('0');
            }
        })

        function setStatus(d) {
            let val = d != null ? 0 : 1;
            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $('#user_status').val(val);
            });
        }

        function GetaAllUserDeleted() {
            $('#all-user-deleted-table').dataTable({
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>'
                },
                serverSide: true,
                responsive: true,
                ajax: "{{url('/getall/user/deleted')}}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user_nik',
                        name: 'user_nik'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'user_email',
                        name: 'user_email'
                    },
                    {
                        data: 'user_mobile',
                        name: 'user_mobile'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        render: function (data, type, row, meta) {
                            return `<center>
                            <badge class="btn btn-sm btn-info" onclick="restoreUser('${data}')" style="width: 100%">
                                <i class="fas fa-trash-restore-alt"></i> Restore
                            </badge>
                        </center>`
                        }
                    }
                ]
            });
        }

        function search() {
            AllUser();
        }

        function AllUser() {
            $('#all-user-table').dataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: {
                    'processing': '<div class="se-pre-con"></div>'
                },
                responsive: true,
                ajax: {
                    url: "{{url('/getall/user')}}",
                    data: {
                        "department_id": $('#department_search').val(),
                        "grade_id": $('#grade_search').val(),
                        "user_nik": $('#nik_search').val(),
                        "user_name": $('#nama_search').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user_nik',
                        name: 'user_nik'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'user_email',
                        name: 'user_email'
                    },
                    {
                        data: 'user_mobile',
                        name: 'user_mobile'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        render: function (data, type, row, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-success" style="width: 78px !important;" onclick="modal('edit','${data}')" style="width: 100%">
                                                    <i class="fas fa-user-edit"></i> Edit
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        render: function (data, type, row, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-info" style="width: 100px !important;" onclick="access('${data}')" style="width: 100%">
                                            <i class="fas fa-user-cog"></i> Access
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        render: function (data, type, row, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-danger" style="width: 120px !important;" onclick="deleteUser('${data}')" style="width: 100%">
                                            <i class="fas fa-user-alt-slash"></i> Inactive User
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        render: function (data, type, row, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-warning" style="width: 150px !important;" onclick="refreshPass('${data}','${row.user_nik}')" style="width: 100%">
                                            <i class="fas fa-sync fa-spin"></i> Refresh Password
                                        </badge>
                                    </center>`
                        }
                    }
                ],
                createdRow: function (row, data, index) {
                    if (data['user_status'] == 0) {
                        $(row).addClass('table-danger');
                    }
                },
                columnDefs: [
                    { width: 30, targets: 0 },
                    { width: 120, targets: 4 }
                ],
            });
        }

        function getAllOption() {
            $.ajax({
                type: 'get',
                url: "{{url('/get/option/user')}}",
                success: function (response) {
                    showingAllOption(response.data);
                    showingOptionSearch(response.data);
                }
            })
        }

        function showingAllOption(data) {
            let index = ["type", "grade", "title", "department"];
            let test = 'type_name';
            for (let i = 0; i < index.length; i++) {
                let id = `${index[i]}_id`;
                let name = `${index[i]}_name`;
                let dataObject = data[index[i]];
                for (let u = 0; u < dataObject.length; u++) {
                    $(`#${id}`).append(`<option value="${dataObject[u][id]}">
                                            ${dataObject[u][name]}
                                        </option>`);
                }
            }

        }

        function showingOptionSearch(data){
            let index = ["grade", "department"];
            let test = 'type_name';
            for (let i = 0; i < index.length; i++) {
                let id = `${index[i]}_id`;
                let name = `${index[i]}_name`;
                let dataObject = data[index[i]];
                for (let u = 0; u < dataObject.length; u++) {
                    $(`#${index[i]}_search`).append(`<option value="${dataObject[u][id]}">
                                            ${dataObject[u][name]}
                                        </option>`);
                }
            }
        }

        function modal(type, id) {
            $('#form')[0].reset();
            $('.select2bs4').val('').select2({theme:'bootstrap4'});
            clearIsInvalid();
            if (type == 'edit') {
                editUser(id)
                $('#modal-title').text('Edit Data User');
            } else {
                $('#modal-title').text('Add User');
                $('#user_nik').attr('readonly', false);
                $('#type').val('insert');
            }
            $('#modal').modal('show');
            $('.user_id').remove();
            $('#button-modal').attr('onclick', `validasi('${type}')`)
        }

        function editUser(id) {
            $.ajax({
                type: 'get',
                url: "{{url('get/user')}}/" + id,
                success: function (response) {
                    showingDataEdit(response.data)
                },
                error:function(response){
                    if(response.responseJSON.errors==null){
                        sweetError(response.responseJSON.message)
                    }else{
                        let fail = response.responseJSON.errors;
                        let key = Object.keys(fail)
                        loopingError(fail,key)
                    }
                }
            })
        }

        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure to inactive user?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/delete/user')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "user_id": id
                        },
                        success: function (response) {
                            sweetSuccess(response.status, response.message);
                            refreshDataTables();
                        }
                    })
                }
            })
        }

        function sweetSuccess(status, message) {
            Swal.fire(
                'Good job!',
                message,
                status
            );
        }

        function sweetError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function refreshDataTables() {
            $('#all-user-table').DataTable().ajax.reload();
            $('#all-user-deleted-table').DataTable().ajax.reload();
        }

        function restoreUser(id) {
            Swal.fire({
                title: 'Are you sure to restore?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/restore/user')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "user_id": id
                        },
                        success: function (response) {
                            sweetSuccess(response.status, response.message);
                            refreshDataTables();
                        }
                    })
                }
            })
        }

        function showingDataEdit(data) {
            $('.modal-body').append(`<div class="user_id" hidden>
                                        <input type="text" id="user_id" name="user_id">
                                    </div>`)
            $('#user_nik').val(data.user_nik);
            $('#user_nik').attr('readonly', true);
            $('#user_name').val(data.user_name);
            $('#user_email').val(data.user_email);
            $('#user_mobile').val(data.user_mobile);
            $('#user_birth_city').val(data.user_birth_city);
            $('#user_birth_date').val(data.user_birth_date);
            $('#user_sex').val(data.user_sex);
            $('#user_join_date').val(data.user_join_date);
            if (data.user_status!=1) {
                    setStatus(data.user_status) 
                    $('#user_status').bootstrapSwitch('state',false)
            }
            $('#department_id').val(data.department_id).select2({theme:'bootstrap4'});
            $('#grade_id').val(data.grade_id).select2({theme:'bootstrap4'});
            $('#title_id').val(data.title_id).select2({theme:'bootstrap4'});
            $('#type_id').val(data.type_id).select2({theme:'bootstrap4'});
            $('#user_type').val(data.user_type).select2({theme:'bootstrap4'});
            $('#user_id').val(data.user_id);
            $('#type').val('update');

        }

        function validasi(type) {
            clearIsInvalid();
            let data = $('#form').serializeArray();
            let result = loopingValidasi(data)
            if (result.length == 0) {
                if (type == 'edit') {
                    updateDataUser();
                } else {
                    insertDataUser();
                }
            } else {
                for (let index = 0; index < result.length; index++) {
                    $(`#${result[index]}`).addClass('is-invalid');
                    sweetError('Form cannot be empty');
                }
            }
        }

        function insertDataUser() {
            clearIsInvalid();
            let data = $('#form').serialize();
            $.ajax({
                type: "post",
                url: "{{url('/insert/user')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    refreshDataTables();
                    $('#modal').modal('hide');
                },
                error:function(response){
                    if(response.responseJSON.errors==null){
                        sweetError(response.responseJSON.message)
                    }else{
                        let fail = response.responseJSON.errors;
                        let key = Object.keys(fail)
                        loopingError(fail,key)
                    }
                }
            })
        }

        function loopingValidasi(data) {
            let dataArray = [];
            for (let index = 0; index < data.length; index++) {
                if (data[index]['value'] == '') {
                    dataArray.push(data[index]['name'])
                }
            }
            return dataArray;
        }

        function updateDataUser() {
            let data = $('#form').serialize();
            clearIsInvalid();
            $.ajax({
                type: 'POST',
                url: "{{url('/update/data/user')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    refreshDataTables();
                    $('#modal').modal('hide');
                },
                error:function(response){
                    if(response.responseJSON.errors==null){
                        sweetError(response.responseJSON.message)
                    }else{
                        let fail = response.responseJSON.errors;
                        let key = Object.keys(fail)
                        loopingError(fail,key)
                    }
                }
            })
        }

        function loopingError(fail) {
            let data = ["user_nik", "user_name", "user_email", "user_mobile", "user_birth_city", "user_birth_date", "user_sex", "user_join_date", "user_status"];
            for (let index = 0; index < data.length; index++) {
                if (fail.hasOwnProperty(data[index])) {
                    $(`#${data[index]}`).addClass('is-invalid');
                    document.getElementById(data[index]).focus();
                    sweetError(fail[data[index]][0])
                }
            }
        }

        function clearIsInvalid() {
            $('.is-invalid').removeClass('is-invalid');
        }

        function access(id) {
            var modal = $('#accessModal');

            modal.find('input[name=user_id]').val(id);
            modal.find('input[type=checkbox]').prop('checked', false);

            $.ajax({
                type: "GET",
                url: "{{ url('/get/access') }}?user_id=" + id,
                dataType: "JSON",
                success: function (res) {
                    modal.find('.employee-nik').html(res.user_nik);
                    modal.find('.employee-name').html(res.user_name);
                    modal.find('.employee-department').html(res.department_name);
                    modal.find('.employee-grade').html(res.grade_name);

                    if(res.module) {
                        var mod = res.module.split('#');

                        for(var i=0; i<mod.length; i++) {
                            modal.find('input[name="module[]"][value="'+mod[i]+'"]').prop('checked', true);
                        }
                    }

                    if(res.menu) {
                        var menu = res.menu.split('#');
                        var parent = menu[0].split(',');
                        var child = menu[1].split(',');
                        var grand_child = menu[2].split(',');

                        for(var i=0; i<parent.length; i++) {
                            modal.find('input[name="menu_parent[]"][value="'+parent[i]+'"]').prop('checked', true);
                        }

                        for(var i=0; i<child.length; i++) {
                            modal.find('input[name="menu_child[]"][value="'+child[i]+'"]').prop('checked', true);
                        }

                        for(var i=0; i<grand_child.length; i++) {
                            modal.find('input[name="menu_grand_child[]"][value="'+grand_child[i]+'"]').prop('checked', true);
                        }
                    }
                },
                error: function (jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            modal.modal('show');
        }

        $(document).on('submit', '#accessModal form', function(e) {
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ url('/save/access') }}",
                data : $('#accessModal form').serialize(),
                success : function(res) {
                    $('#accessModal').modal('hide');
                    sweetSuccess(res.status,res.message)
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });
        });

        function refreshPass(id,nik)
        {
            Swal.fire({
                title: 'Are you sure to refresh password ??',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, refresh it!',
                preConfirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: "{{url('refresh/password')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "user_id": id,
                            "user_nik": nik,
                        },
                        success: function (response) {
                            sweetSuccess(response.status, response.data.message);
                            refreshDataTables();
                        }
                    })
                }
            })
        }

    </script>
@endsection