@extends('master/master')
@section('title','Management Age Category')
@section('breadcumb','Age Category')
@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <button class="btn btn-success" onclick="modalShow('add')"><i class="fas fa-plus"></i> Add Age Category</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped table-bordered table-sm" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Years</th>
                                    <th>Name</th>
                                    <th>Edit</th>
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
                        <label>Years</label>
                        <input type="text" class="form-control" id="age_years" name="age_years">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="age_name" name="age_name">
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
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#table').dataTable({
            serverSide: true,
            processing: true,
            language: {
                loadingRecords: "Please Wait - loading",
                processing: '<div class="se-pre-con"></div>'
            },
            ajax: "{{url('management/age')}}",
            order: [[ 1, 'asc' ]],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'age_years',
                    name: 'age_years'
                },
                {
                    data: 'age_name',
                    name: 'age_name'
                },
                {
                    data: 'age_category_id',
                    name: 'age_category_id',
                    render:function(data,row,type,meta){
                        return `<center>
                                    <badge class="btn btn-sm btn-success" onclick="modalShow('edit','${data}')">
                                        <i class="fas fa-user-edit"></i> Edit
                                    </badge>
                                </center>`
                    }
                },
                {
                    data: 'age_category_id',
                    name: 'age_category_id',
                    render:function(data,row,type,meta){
                        return `<center>
                                    <badge class="btn btn-sm btn-danger" onclick="deleteGrade('${data}')">
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
        $('#grade_group_id').val('').select2({
            theme: 'bootstrap4'
        });
        if (type == 'edit') {
            modalEdit(id)
        } else {
            modalAdd()
        }
    }

    function deleteGrade(id) {
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
            url: "{{url('management/age')}}/"+id,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                age_category_id: id
            },
            success: function (response) {
                sweetSuccess(response.data.status, response.data.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            }
        })
    }

    function modalEdit(id) {
        $.ajax({
            type: "GET",
            url: "{{url('management/age')}}/" + id +'/edit',
            success: function (response) {
                $('#modal').modal('show');
                $('#title-modal').text('Edit Age Category');
                $('.modal-body').append(`<div class="age_category_id" hidden>
                                            <input type="text" id="age_category_id" name="age_category_id">
                                        </div>`);
                $('#age_years').val(response.data.age_years);
                $('#age_category_id').val(response.data.age_category_id);
                $('#age_name').val(response.data.age_name);
                $('#button-modal').attr('onclick', `validasi('update')`);
            }
        })

    }

    function updateData() {
        $('.is-invalid').removeClass('is-invalid')
        let data = $('#form').serialize();
        $.ajax({
            type: "patch",
            url: "{{url('management/age')}}/"+ $('#age_category_id').val(),
            data: data,
            success: function (response) {
                sweetSuccess(response.data.status, response.data.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            },
            error: function (response) {
                let fail = response.responseJSON.errors;
                loopingError(fail)
            }
        })
    }

    function modalAdd() {
        $('#title-modal').text('Add Grade');
        $('#modal').modal('show');
        $('#button-modal').attr('onclick', `validasi('add')`);
    }

    function closeModal() {
        $('#modal').modal('hide');
        $('.age_category_id').remove();
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
        $('.is-invalid').removeClass('is-invalid');
        let data = $('#form').serialize();
        $.ajax({
            type: "POST",
            url: "{{url('management/age')}}",
            data: data,
            success: function (response) {
                sweetSuccess(response.data.status, response.data.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            },
            error: function (response) {
                let fail = response.responseJSON.errors;
                loopingError(fail)
            }

        })
    }

    function loopingError(fail) {
        if (fail.hasOwnProperty('grade_code')) {
            $(`#grade_code`).addClass('is-invalid');
            sweetError(fail['grade_code'][0]);
        }

        if (fail.hasOwnProperty('grade_name')) {
            $(`#grade_name`).addClass('is-invalid');
            sweetError(fail['grade_name'][0]);
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


</script>
@endsection
