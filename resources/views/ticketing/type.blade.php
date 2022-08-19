@extends('ticketing/master/master')
@section('title','Management Type Ticketing')
@section('breadcumb','Management Type Ticketing')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
    
@endsection

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    <button type="button" onclick="modal('add')" class="btn btn-success rounded mb-3">
                        <i class="ni ni-fat-add text-white"></i> 
                        Add Ticket Type
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Name</th>
                                    <th>Agent</th>
                                    <th>Last Update</th>
                                    <th><center>Edit</center></th>
                                    <th><center>Delete</center></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Name</th>
                                    <th>Agent</th>
                                    <th>Last Update</th>
                                    <th><center>Edit</center></th>
                                    <th><center>Delete</center></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="modal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" id="form">
                        @csrf
                        <div class="form-body">
                            <div class="row form-body-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="type_name">Type Name</label>
                                        <input type="text" id="type_name" class="form-control option" name="type_name" placeholder="Type Name">
                                        <small id="type_name_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="agent_nik">Agent Name</label>
                                        <select name="agent_nik" id="agent_nik" class="form-control">
                                            <option value="">Select Agent</option>
                                        </select>
                                        <small id="agent_nik_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 button-form d-flex flex-row-reverse">
                                    <button type="button" class="btn btn-primary mr-1 mb-1" id="btn-save">Save</button>
                                    <button type="reset" class="btn btn-warning mr-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {{-- Datatables --}}
    <script type="text/javascript" src="{{asset('assets_argon/vendor/datatables/datatables.min.js')}}"></script>
    {{-- Helper & Validation --}}
    <script src="{{asset('js/script.js')}}"></script>
    
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>',
                    paginate: {
                        previous: "<b> < </b>",
                        next: "<b> > </b>",
                    }
                },
                ajax: "{{url('ticketing/all/type')}}",
                columns:[
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "type_name",
                        name: "type_name"
                    },
                    {
                        data: "user.user_nik",
                        name: "user.user_nik",
                        render: function (data, type, row, meta) {
                            return `${data} - ${row.user.user_name}`;
                        }
                    },
                    {
                        data: "updated_by",
                        name: "updated_by",
                        render: function (data, type, row, meta) {
                            return `${data} - ${row.updated_at}`;
                        }
                    },
                    {
                        data: 'type_id',
                        name: 'type_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-info" onclick="modal('edit','${data}')">
                                            <i class="fas fa-pen"></i> 
                                            Edit
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'type_id',
                        name: 'type_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-danger" onclick="deleteData('${data}')">
                                            <i class="fas fa-trash-alt"></i> 
                                            Delete
                                        </badge>
                                    </center>`
                        }
                    }
                ]
            })

            getOption();

            $('#agent_nik').select2({
                dropdownParent: $('#modal'),
            });
        });

        const data = {
            id_name : "type_id",
            url:"{{url('ticketing/all/type')}}"
        }

        const Helper = new valbon (data)
        const field = ["type_name","agent_nik"];

        modal = (type,id = null) => {
            type == "add" 
            ? $(`#agent_nik`).val("").select2({dropdownParent: $('#modal')})
            : "";
            Helper.modal(type,id,'type')
        }

        validasi = (type) => {
            Helper.validasi(type);
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

                    $('#agent_nik').append(option);
                }
            })
        }

    </script>
@endsection