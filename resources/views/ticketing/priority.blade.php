@extends('ticketing/master/master')
@section('title','Management Priority')
@section('breadcumb','Management Priority')

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
                        Add Priority
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Priority Name</th>
                                    <th>Last Update</th>
                                    <th><center>Edit</center></th>
                                    <th><center>Delete</center></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Priority Name</th>
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
    <div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
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
                                        <label for="priority_name">Priority Name</label>
                                        <input type="text" id="priority_name" class="form-control option" name="priority_name" placeholder="Primary Name">
                                        <small id="priority_name_alert" class="form-text text-danger"></small>
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
                ajax: "{{url('ticketing/all/priority')}}",
                columns:[
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "priority_name",
                        name: "priority_name"
                    },
                    {
                        data: "updated_by",
                        name: "updated_by",
                        render: function (data, type, row, meta) {
                            console.log(row)
                            return `${data} - ${row.updated_at}`;
                        }
                    },
                    {
                        data: 'priority_id',
                        name: 'priority_id',
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
                        data: 'priority_id',
                        name: 'priority_id',
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
        });

        const data = {
            id_name : "priority_id",
            url:"{{url('ticketing/all/priority')}}"
        }

        const Helper = new valbon (data)
        const field = ["priority_name"];

        modal = (type,id = null) => {
            Helper.modal(type,id,'Priority')
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

    </script>
@endsection