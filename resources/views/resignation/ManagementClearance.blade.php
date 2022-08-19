@extends('resignation/master/master')
@section('breadcumb','Clearance Question')
@section('title','Management Clearance')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <div>
                            <button class="btn btn-success" onclick="modal('add')"><i class="fa fa-plus"></i> Add Question</button>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Clearance Question</th>
                                    <th>Clearance Department</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Clearance Question</th>
                                    <th>Clearance Department</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="form">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="first-name-icon">Clearance Question</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="clearance_question_name" class="form-control" name="clearance_question_name" placeholder="Clearance Question">
                                        <div class="form-control-position">
                                            <i class="fa fa-question-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email-id-icon">Clearance Department Approval</label>
                                    <div class="position-relative has-icon-left">
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="">Select Department</option>
                                            <option value="1">Finance & Accounting</option>
                                            <option value="2">HR & GA</option>
                                            <option value="3">IT</option>
                                        </select>
                                        <div class="form-control-position">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" id="button-save" class="btn btn-primary mr-1 mb-1">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
            
            $('#table').DataTable({
                serverSide: true,
                destroy: true,
                ajax: "{{url('resignation/clearance/data')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "clearance_question_name",
                        name: "clearance_question_name"
                    },
                    {
                        data: "department.department_name",
                        name: "department_name"
                    },
                    {
                        data: "clearance_question_id",
                        name: "clearance_question_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-info" onclick="modal('edit',${data})">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>`
                        }
                    },
                    {
                        data: "clearance_question_id",
                        name: "clearance_question_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-danger" onclick="deleteClearance(${data})">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>`
                        }
                    },
                ]
            })
        });

        function modal(type, id) {
            $('#clearance_question_id').remove();
            $("#form")[0].reset()
            if (type == 'add') {
                $('#modalLabel').text('Add Question Clearance');
                $('#button-save').attr('onclick', `validasi('add')`)
            } else if (type == 'edit') {
                $('.form-body').append('<input hidden type="text" name="clearance_question_id" id="clearance_question_id" />');
                $('#modalLabel').text('Edit Question Clearance');
                $('#button-save').attr('onclick', `validasi('edit')`)
                showDataEdit(id)
            }
            $('#modal').modal('show');
        }

        function validasi(type) {
            let data = $('#form').serializeArray();
            let result = loopingValidasi(data)
            if (result.length == 0) {
                if (type == 'edit') {
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

        function loopingValidasi(data) {
            let dataArray = [];
            for (let index = 0; index < data.length; index++) {
                if (data[index]['value'] == '') {
                    dataArray.push(data[index]['name'])
                }
            }
            return dataArray;
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

        function insert() {
            let data = $('#form').serialize();
            $.ajax({
                type: "POST",
                url: "{{url('resignation/clearance')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.message, response.data.message);
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

        function showDataEdit(id) {
            $.ajax({
                type: "GET",
                url: "{{url('resignation/clearance')}}/" + id,
                success: function (response) {
                    $('#clearance_question_name').val(response.data.clearance_question_name);
                    $('#clearance_question_id').val(response.data.clearance_question_id);
                    $('#department_id').val(response.data.department_id);
                }
            })
        }

        function updateData() {
            let data = $('#form').serialize();
            $.ajax({
                type: "put",
                url: "{{url('resignation/clearance')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.message, response.data.message);
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

        function deleteClearance(id) {
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
                    url: "{{url('resignation/clearance')}}",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        clearance_question_id: id
                    },
                    success: function (response) {
                        sweetSuccess(response.message, response.data.message);
                        $(`#table`).DataTable().ajax.reload();
                        closeModal();
                    }
                })
            }

        function closeModal() {
            $('#modal').modal('hide');
        }
    
    </script>
@endsection