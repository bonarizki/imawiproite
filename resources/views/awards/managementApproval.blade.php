@extends('awards/master/master')
@section('title','Access')
@section('breadcumb','Management Approval Awards')
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
                                    Add Approval Awards
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" width="100%" id="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;">#</th>
                                        <th rowspan="2" style="vertical-align: middle;">Name</th>
                                        <th rowspan="2" style="vertical-align: middle;">Appraise by</th>
                                        <th rowspan="2" style="vertical-align: middle;">Approval by</th>
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
                    <input type="text" id="approval_id" hidden>
                    <div class="mr-1 ml-1">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>User</label>
                                    <select id="user_nik" name="user_nik" class="form-control select2bs4">
                                        <option value="" selected>Choose</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Appraise By</label>
                                    <select id="appraise_by" name="appraise_by" class="form-control select2bs4">
                                        <option value="" selected>Choose</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Approve By</label>
                                    <select id="approve_by" name="approve_by" class="form-control select2bs4">
                                        <option value="" selected>Choose</option>
                                    </select>
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
            id_name : "type_id",
            url:"{{url('sales-awards/approval-sales-awards')}}"
        }

        const Helper = new valbon (data)
        const field = ["user_nik","appraise_by","approval_by","approval_id"];

        $(document).ready(function () {
            getOption();

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('sales-awards/approval-sales-awards')}}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user_nik',
                        name: 'user_nik',
                        render: function (data, type, row, meta) {
                            return `[${row.user_nik}] - ${row.user.user_name}`;
                        }
                    },
                    {
                        data: 'appraise_by',
                        name: 'appraise_by',
                        render: function (data, type, row, meta) {
                            return `[${data}] - ${row.appraise.user_name}`;
                        }
                    },
                    {
                        data: 'approve_by',
                        name : 'approve_by',
                        render: function (data, type, row, meta) {
                            return `[${data}] - ${row.approve.user_name}`;
                        }
                    },
                    {
                        data: 'approval_id',
                        data : 'approval_id',
                        render: function (data,) {
                            return `<center>
                                        <a onclick="modal('edit','${data}')"><i class="fa fa-pencil-square-o" title="edit"></i></a>
                                    </center>`
                        }
                    },
                    {
                        data: 'approval_id',
                        data : 'approval_id',
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
            $('#approval_id').val();
            if (type == "add" ) {
                $(`.select2bs4`).val("").select2({dropdownParent: $('#modal')})
                Helper.modal(type,id,'Approval Awards')
            }else{
                $('#modalLabel').text(`${Helper.capitalize(type)} Approval Awards`);
                $('#btn-save').attr('onclick',`validasi('${type}')`);
                edit(id);
            }
            
        }

        edit = (id) => {
            $('#approval_id').val(id);
            $.ajax({
                type: "GET",
                url: `${data.url}/`+id+`/edit`,
                success: (res) => {
                    let data = res.data;
                    $('#user_nik').val(data.user_nik).select2({theme: 'bootstrap4'});
                    $('#appraise_by').val(data.appraise_by).select2({theme: 'bootstrap4'});
                    $('#approve_by').val(data.approve_by).select2({theme: 'bootstrap4'});
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
                credentials += '&approval_id=' + $('#approval_id').val();
                Helper.validasi(type,credentials);
            }
        }

        deleteData = (id) => {
            Helper.modalDelete(id);
        }

        closeModal = () => {
            Helper.closeModal();
        }

        getOption = () => {
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

                    $('.select2bs4').append(option);
                }
            })
        }
    </script>
@endsection