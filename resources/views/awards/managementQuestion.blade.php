@extends('awards/master/master')
@section('title','Access')
@section('breadcumb','Management Questions Awards')
@section('content')
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary" onclick="modal('add')">
                                    <span class="fa fa-plus"></span>
                                    Add Questions
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" width="100%" id="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle; width: 5% !important;">#</th>
                                        <th rowspan="2" style="vertical-align: middle; width: 70% !important;">Quiz</th>
                                        <th rowspan="2" style="vertical-align: middle; width: 10% !important;">Quiz For</th>
                                        <th colspan="2" style="vertical-align: middle;"><center>Action<center></th>
                                    </tr>
                                    <tr>
                                        <th><center>Edit</center></th>
                                        <th><center>Delete</center></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade text-left" data-backdrop="static" data-keyboard="false" id="modal" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="question_id" hidden>
                    <div class="mr-1 ml-1">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Question For</label>
                                    <select id="question_for" name="question_for" class="form-control select2bs4">
                                        <option value="" selected>Choose</option>
                                        <option value="asm" >ASM</option>
                                        <option value="non-asm" >NON ASM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Question</label>
                                    <textarea id="question" name="question" class="form-control" cols="30" rows="10">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script src="{{asset('js/script.js')}}"></script>
    <script>
        const data = {
            id_name : "approval_id",
            url:"{{url('sales-awards/question')}}"
        }

        const Helper = new valbon (data)
        const field = ["question","question_type","question_id"];

        $(document).ready(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('sales-awards/question')}}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'question',
                        name: 'question',
                    },
                    {
                        data: 'question_for',
                        name : 'question_for',
                    },
                    {
                        data: 'question_id',
                        data : 'question_id',
                        render: function (data,) {
                            return `<center>
                                        <a onclick="modal('edit','${data}')"><i class="fa fa-pencil-square-o" title="edit"></i></a>
                                    </center>`
                        }
                    },
                    {
                        data: 'question_id',
                        data : 'question_id',
                        render: function (data,) {
                            return `<center>
                                        <a onclick="deleteData('${data}')"><i class="fa fa-trash" title="delete"></i></a>
                                    </center>`
                        }
                    }

                ],
                columnDefs: [{
                        orderable: false,
                        targets: []
                    },
                    {
                        searchable: false,
                        targets: []
                    },
                ]
            })

        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        modal = (type,id = null) => {
            $('#question_id').val();
            if (type == "add" ) {
                $(`.select2bs4`).val("").select2({dropdownParent: $('#modal')})
                Helper.modal(type,id,'Questions')
            }else{
                $('#modalLabel').text(`${Helper.capitalize(type)} Questions`);
                $('#btn-save').attr('onclick',`validasi('${type}')`);
                edit(id);
            }
            
        }

        edit = (id) => {
            $('#question_id').val(id);
            $.ajax({
                type: "GET",
                url: `${data.url}/`+id+`/edit`,
                success: (res) => {
                    let data = res.data;
                    $('#question_for').val(data.question_for).select2({theme: 'bootstrap4'});
                    $('#question').val(data.question)
                },
                error:  (response) => {
                    this.errorHandle(response);
                }
            })

            $('#modal').modal('show');
        }

        validasi = (type) => {
            if (type == 'add') {
                Helper.validasi(type);
            }else{
                let credentials = $('#form').serialize();
                credentials += '&question_id=' + $('#question_id').val();
                Helper.validasi(type,credentials);
            }
        }

        deleteData = (id) => {
            Helper.modalDelete(id);
        }

        closeModal = () => {
            Helper.closeModal();
        }

    </script>
@endsection