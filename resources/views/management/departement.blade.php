@extends('master/master')
@section('title','Management Department')
@section('breadcumb','List Data Department')
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

<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col">
                        <button class="btn btn-success" onclick="modalShow('add')"><i class="fas fa-plus"></i> Add
                            Departement</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-hover table-striped table-bordered table-sm" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Departement Name</th>
                                    <th>Edit</th>
                                    <th>Access</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form">
        @csrf
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h5 class="modal-title" id="title-modal" style="color: white"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Department Name</label>
                        <input type="text" class="form-control" id="department_name" name="department_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal" >Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="accessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <div class="col-3">Department</div>
                        <div class="col-1">:</div>
                        <div class="col-8 department"></div>
                    </div>
                    <hr>
                    <input type="hidden" name="department_id">
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
                            <div class="col-4">
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
        $('#form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });

        $('#table').dataTable({
        processing: true,
        language: {
            loadingRecords: "Please Wait - loading",
            processing: '<div class="se-pre-con"></div>'
        },
        serverSide: true,
        ajax: "{{url('/getAll/departement')}}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'department_name',
                name: 'department_name'
            },
            {
                data: 'department_id',
                name: 'department_id',
                render: function (data, row, type, meta) {
                    return `<center>
                                <badge class="btn btn-sm btn-success" onclick="modalShow('edit','${data}')">
                                    <i class="fas fa-user-edit"></i> Edit
                                </badge>
                            </center>`
                }
            },
            {
                data: 'department_id',
                name: 'department_id',
                render: function (data, row, type, meta) {
                    return `<center>
                                <badge class="btn btn-sm btn-info" onclick="access('${data}')">
                                    <i class="fas fa-user-cog"></i> Access
                                </badge>
                            </center>`
                }
            },
            {
                data: 'department_id',
                name: 'department_id',
                render: function (data, row, type, meta) {
                    return `<center>
                                <badge class="btn btn-sm btn-danger" onclick="deleteDepartement('${data}')">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </badge>
                            </center>`
                }
            }

        ]
        });
        });

        function modalShow(type, id) {
            $('.is-invalid').removeClass('is-invalid');
            if (type == 'edit') {
                modalEdit(id)
            } else {
                modalAdd()
            }
        }

        function deleteDepartement(id) {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm: function () {
                    prosesDelete(id)
                }
            })

        }

        function prosesDelete(id) {
            $.ajax({
                type: "delete",
                url: "{{url('/delete/departmentByid')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    department_id: id
                },
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    $(`#table`).DataTable().ajax.reload();
                    closeModal();
                }
            })
        }

        function modalEdit(id) {
            $.ajax({
                type: "GET",
                url: "{{url('/get/departementById')}}/" + id,
                success: function (response) {
                    $('#modal').modal('show');
                    $('#title-modal').text('Edit Department');
                    $('.modal-body').append(`<div class="department_id" hidden>
                                                <input type="text" id="department_id" name="department_id">
                                            </div>`);
                    $('#department_name').val(response.data.department_name);
                    $('#department_id').val(response.data.department_id);
                    $('#button-modal').attr('onclick', `validasi('update')`);
                }
            })

        }

        function updateData() {
            let data = $('#form').serialize();
            $.ajax({
                type: "put",
                url: "{{url('/update/departement')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    $(`#table`).DataTable().ajax.reload();
                    closeModal();
                },
                error: function (response) {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
                }
            })
        }

        function modalAdd() {
            $('#title-modal').text('Add Department');
            $('#modal').modal('show');
            $('#button-modal').attr('onclick', `validasi('add')`);
        }

        function closeModal() {
            $('#modal').modal('hide');
            $('.department_id').remove();
            $('#form')[0].reset()
        }

        function validasi(type) {
            let data = $('#form').serializeArray();
            let result = loopingValidasi(data)
            if (result.length == 0) {
                if (type == 'update') {
                    updateData()
                } else {
                    insert()
                }
            } else {
                for (let index = 0; index < result.length; index++) {
                    $(`#${result[index]}`).addClass('is-invalid');
                    sweetError('Form cannot be empty');
                }
            }
        }

        function insert() {
            let data = $('#form').serialize();
            $.ajax({
                type: "POST",
                url: "{{url('/insert/insertDepartment')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    $(`#table`).DataTable().ajax.reload();
                    closeModal();
                },
                error: function (response) {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
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

        function loopingError(fail, key) {
            if (fail.hasOwnProperty(key)) {
                $(`#${key}`).addClass('is-invalid');
                sweetError(fail[key][0]);
            }
        }

        function sweetError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function sweetSuccess(status, message) {
            Swal.fire(
                'Good job!',
                message,
                status
            );
        }

        function access(id) {
            var modal = $('#accessModal');

            modal.find('input[name=department_id]').val(id);
            modal.find('input[type=checkbox]').prop('checked', false);

            $.ajax({
                type: "GET",
                url: "{{ url('/get/accessPosition') }}?department_id=" + id,
                dataType: "JSON",
                success: function (res) {
                    modal.find('.department').html(res.department_name);

                    if (res.module) {
                        var mod = res.module.split('#');

                        for (var i = 0; i < mod.length; i++) {
                            modal.find('input[name="module[]"][value="' + mod[i] + '"]').prop('checked', true);
                        }
                    }

                    if (res.menu) {
                        var menu = res.menu.split('#');
                        var parent = menu[0].split(',');
                        var child = menu[1].split(',');
                        var grand_child = menu[2].split(',');

                        for (var i = 0; i < parent.length; i++) {
                            modal.find('input[name="menu_parent[]"][value="' + parent[i] + '"]').prop('checked', true);
                        }

                        for (var i = 0; i < child.length; i++) {
                            modal.find('input[name="menu_child[]"][value="' + child[i] + '"]').prop('checked', true);
                        }

                        for (var i = 0; i < grand_child.length; i++) {
                            modal.find('input[name="menu_grand_child[]"][value="' + grand_child[i] + '"]').prop('checked', true);
                        }
                    }
                },
                error: function (jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            modal.modal('show');
        }

        $(document).on('submit', '#accessModal form', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ url('/save/accessPosition') }}",
                data: $('#accessModal form').serialize(),
                success: function (res) {
                    $('#accessModal').modal('hide');

                    Swal.fire(
                        'Success!',
                        'Access Position Updated',
                        'success'
                    );
                },
                error: function (jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });
        });


</script>
@endsection
