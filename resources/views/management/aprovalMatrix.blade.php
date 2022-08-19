@extends('master/master')
@section('title','Management Aproval Matrix')
@section('breadcumb','List Data Aproval Matrix')
@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <button class="btn btn-success mb-2" onclick="modalShow('add')"><i class="fas fa-plus"></i> Add Approval Matrix</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col table-responsive">
                        <table class="table table-hover table-striped table-bordered table-sm" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th style="width: 5px;"">No.</th>
                                    <th style="width: 70px;"">User Name</th>
                                    <th style="width: 65px;">Aproval 1</th>
                                    <th style="width: 65px;">Aproval 2</th>
                                    <th style="width: 65px;">Aproval 3</th>
                                    <th style="width: 65px;">Aproval 4</th>
                                    <th style="width: 65px;">Aproval 5</th>
                                    <th style="width: 65px;">Aproval 6</th>
                                    <th style="width: 80px;">Aproval CEO</th>
                                    <th style="width: 70px;">Aproval HR</th>
                                    <th style="width: 10px;">Edit</th>
                                    <th style="width: 10px;">Delete</th>
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
<div class="modal fade" id="modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="static">
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
                        <label>Approval User</label>
                        <select name="user_nik" id="user_nik" class="form-control select2bs4">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Approval 1</label>
                        <select name="approval_nik_1" id="approval_nik_1" class="form-control select2bs4" onchange="validasiApproval(this.id,'1')">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Approval 2</label>
                        <select name="approval_nik_2" id="approval_nik_2" class="form-control select2bs4" onchange="validasiApproval(this.id,'2')">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Approval 3</label>
                        <select name="approval_nik_3" id="approval_nik_3" class="form-control select2bs4" onchange="validasiApproval(this.id,'3')">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Approval 4</label>
                        <select name="approval_nik_4" id="approval_nik_4" class="form-control select2bs4" onchange="validasiApproval(this.id,'4')">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Approval 5</label>
                        <select name="approval_nik_5" id="approval_nik_5" class="form-control select2bs4" onchange="validasiApproval(this.id,'5')">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Approval 6</label>
                        <select name="approval_nik_6" id="approval_nik_6" class="form-control select2bs4" onchange="validasiApproval(this.id,'6')">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#table').dataTable({
            // processing: true,
            serverSide: true,
            responsive: true,
            language: {
                processing: '<div class="se-pre-con"></div>'
            },
            ajax: "{{url('/getAll/approval')}}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'approval_name_1',
                    name: 'approval_name_1'
                },
                {
                    data: 'approval_name_2',
                    name: 'approval_name_2'
                },
                {
                    data: 'approval_name_3',
                    name: 'approval_name_3'
                },
                {
                    data: 'approval_name_4',
                    name: 'approval_name_4'
                },
                {
                    data: 'approval_name_5',
                    name: 'approval_name_5'
                },
                {
                    data: 'approval_name_6',
                    name: 'approval_name_6'
                },
                {
                    data: 'approval_name_ceo',
                    name: 'approval_name_ceo'
                },
                {
                    data: 'approval_name_hr',
                    name: 'approval_name_hr'
                },
                {
                    data: 'approval_id',
                    name: 'approval_id',
                    render:function(data,row,type,meta)
                    {
                        return `<center>
                                    <button class="btn btn-sm btn-success" onclick="modalShow('edit','${data}')" title="Edit"><i class="fas fa-user-edit"></i></button>
                                </center>`
                    }
                },
                {
                    data: 'approval_id',
                    name: 'approval_id',
                    render:function(data,row,type,meta)
                    {
                        return `<center>
                                    <button class="btn btn-sm btn-danger" onclick="deleteApprovalMatrix('${data}')" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </center>`
                    }
                }
            ]
        });

        getOption()
    });

    function validasiApproval(id,index){
        let user_nik = $('#user_nik').val();
        let user_approval = $(`#${id}`).val();
        let index_approval = index==1 ? 'user_nik' :  'approval_nik_' + (index - 1)
        let user_approval_before = $(`#${index_approval}`).val()
        if (user_nik == user_approval || user_approval_before == user_approval) {
            $(`#${id}`).addClass('is-invalid');
            $(`#${id}`).val('').select2({
                theme: 'bootstrap4'
            });
            sweetError(`can't selected nik`);
            $(`#${id}`).focus();
        }else{
            $(`#${id}`).removeClass('is-invalid');
        }
    }

    function getOption() {
        $.ajax({
            type: "get",
            url: "{{url('/getall/user')}}",
            success: function (response) {
                let data = response.data;
                let option = '';
                for (let index = 0; index < data.length; index++) {
                    option += `<option value="${data[index].user_nik}">
                                    ${data[index].user_nik} - ${data[index].user_name}
                                </option>`;
                }

                $('#user_nik').append(option);
                $('#approval_nik_1').append(option);
                $('#approval_nik_2').append(option);
                $('#approval_nik_3').append(option);
                $('#approval_nik_4').append(option);
                $('#approval_nik_5').append(option);
                $('#approval_nik_6').append(option);

            }
        })
    }

    function modalShow(type, id) {
        $('.is-invalid').removeClass('is-invalid');
        $('.select2bs4').val('').select2({
            theme: 'bootstrap4'
        });
        $('#user_nik').prop('disabled', false);
        if (type == 'edit') {
            modalEdit(id)
        } else {
            modalAdd()
        }
    }

    function deleteApprovalMatrix(id) {
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
            type: "DELETE",
            url: "{{url('/delete/ApprovalByid')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                approval_id: id
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
            url: "{{url('/get/approvalById')}}/" + id,
            success: function (response) {
                $('#modal').modal('show');
                $('#title-modal').text('Edit Grade');
                $('.modal-body').append(`<div class="approval_id" hidden>
                                            <input type="text" id="approval_id" name="approval_id">
                                        </div>`);
                $('#user_nik').prop('disabled', true);
                $('#user_nik').val(response.data.user_nik).select2({
                    theme: 'bootstrap4'
                });
                $('#approval_nik_1').val(response.data.approval_nik_1).select2({
                    theme: 'bootstrap4'
                });
                $('#approval_nik_2').val(response.data.approval_nik_2).select2({
                    theme: 'bootstrap4'
                });
                $('#approval_nik_3').val(response.data.approval_nik_3).select2({
                    theme: 'bootstrap4'
                });
                $('#approval_nik_4').val(response.data.approval_nik_4).select2({
                    theme: 'bootstrap4'
                });
                $('#approval_nik_5').val(response.data.approval_nik_5).select2({
                    theme: 'bootstrap4'
                });
                $('#approval_nik_6').val(response.data.approval_nik_6).select2({
                    theme: 'bootstrap4'
                });
                $('#approval_id').val(response.data.approval_id);
                $('#button-modal').attr('onclick', `validasi('update')`);
            }
        })

    }

    function updateData() {
        let data = $('#form').serialize();
        $.ajax({
            type: "PUT",
            url: "{{url('/update/approval')}}",
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

    function loopingError(fail, key) {
        if (fail.hasOwnProperty(key)) {
            $(`#${key}`).addClass('is-invalid');
            sweetError(fail[key][0]);
        }
    }

    function modalAdd() {
        $('#title-modal').text('Add Grade');
        $('#modal').modal('show');
        $('#button-modal').attr('onclick', `validasi('add')`);
    }

    function closeModal() {
        $('#modal').modal('hide');
        $('.approval_id').remove();
        $('#form')[0].reset()
    }

    function validasi(type) {
        let data = $('#form').serializeArray();
        if ($('#user_nik').val() != '') {
            if (type == 'update') {
                updateData();
            } else {
                insert();
            }
        } else {
            $(`#user_nik`).addClass('is-invalid');
            document.getElementById('user_nik').focus();
            sweetError('Form cannot be empty');
        }
    }

    function insert() {
        let data = $('#form').serialize();
        $.ajax({
            type: "POST",
            url: "{{url('/insert/insertApproval')}}",
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

</script>
@endsection
