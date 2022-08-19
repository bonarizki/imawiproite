@extends('master/master')
@section('title','Management Grade Group')
@section('breadcumb','List Data Grade Group')
@section('content')
<div class="h1" style="padding-top: 10px"></div>
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <button class="btn btn-success" onclick="modalShow('add')"><i class="fas fa-plus"></i> Add Grade Group</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped table-bordered table-sm" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Grade Group Name</th>
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
                        <label>Grade Group Name</label>
                        <input type="text" class="form-control" id="grade_group_name" name="grade_group_name">
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
        $('#form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });
        
        $('#table').dataTable({
            serverSide: true,
            processing: true,
            language:{
                        loadingRecords : "Please Wait - loading",
                        processing : '<div class="se-pre-con"></div>'
                    },
            ajax: "{{url('/getAll/gradeGroup')}}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'grade_group_name', name: 'grade_group_name' },
                { 
                    data: 'grade_group_id', name: 'grade_group_id',
                    render:function(data,row,type,meta){
                        return`<center>
                                    <badge class="btn btn-sm btn-success" onclick="modalShow('edit','${data}')">
                                        <i class="fas fa-user-edit"></i> Edit
                                    </badge>
                                </center>`
                    }
                },
                { 
                    data: 'grade_group_id', name: 'grade_group_id',
                    render:function(data,row,type,meta){
                        return`<center>
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
        if (type == 'edit') {
            modalEdit(id);
        } else {
            modalAdd();
        }
    }

    function deleteGrade(id){
        Swal.fire( {
                title: 'Are you sure to delete?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm : function()  {
                    prosesDelete(id)
                }
            })
    }

    function prosesDelete(id){
        $.ajax({
            type:"delete",
            url: "{{url('/delete/gradeGroupByid')}}",
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                grade_group_id:id
            },
            success:function(response){
                sweetSuccess(response.status,response.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            }
        })
    }

    function modalEdit(id){
        $.ajax({
            type:"GET",
            url:"{{url('/get/gradeGroupById')}}/"+id,
            success:function(response){
                $('#modal').modal('show');
                $('#title-modal').text('Edit Grade Group');
                $('.modal-body').append(`<div class="grade_group_id" hidden>
                                            <input type="text" id="grade_group_id" name="grade_group_id">
                                        </div>`);
                $('#grade_group_name').val(response.data.grade_group_name);
                $('#grade_group_id').val(response.data.grade_group_id);
                $('#grade_group_status').val(response.data.grade_group_status);
                $('#button-modal').attr('onclick',`validasi('update')`);
            }
        })

    }
    function updateData(){
        let data = $('#form').serialize();
        $.ajax({
            type:"put",
            url:"{{url('/update/gradeGroup')}}",
            data:data,
            success:function(response){
                sweetSuccess(response.status,response.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            },
            error:function(response){
                let fail = response.responseJSON.errors;
                let key = Object.keys(fail)
                loopingError(fail,key)
            }
        })
    }

    function modalAdd(){
        $('#title-modal').text('Add Grade Group');
        $('#modal').modal('show');
        $('#button-modal').attr('onclick',`validasi('add')`);
    }   

    function closeModal() {
        $('#modal').modal('hide');
        $('.grade_group_id').remove();
        $('#form')[0].reset()
    }

    function validasi(type){
        let data = $('#form').serializeArray();
        let result = loopingValidasi(data)
        if(result.length==0){
            if(type=='update'){
                updateData()
            }else{
                insert()
            }
        }else{
            for (let index = 0; index < result.length; index++) {
                $(`#${result[index]}`).addClass('is-invalid');
                sweetError('Form cannot be empty');
            }
        }
    }

    function loopingError(fail, key) {
        if (fail.hasOwnProperty(key)) {
            $(`#${key}`).addClass('is-invalid');
            sweetError(fail[key][0]);
        }
    }

    function insert()
    {
        let data = $('#form').serialize();
        $.ajax({
            type:"POST",
            url:"{{url('/insert/insertGradeGroup')}}",
            data:data,
            success:function(response){
                sweetSuccess(response.status,response.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            },
            error:function(response){
                let fail = response.responseJSON.errors;
                let key = Object.keys(fail)
                loopingError(fail,key)
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

    function sweetSuccess(status,message){
        Swal.fire(
            'Good job!',
            message,
            status
        );
    }


</script>
@endsection
