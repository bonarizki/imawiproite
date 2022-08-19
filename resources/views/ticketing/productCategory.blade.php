@extends('ticketing/master/master')
@section('title','Management Product Category')
@section('breadcumb','Management Product Category')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
    <style>
        table.dataTable tbody td {
            vertical-align: middle;
        }

        table {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    <button type="button" onclick="modal('add')" class="btn btn-success rounded mb-3">
                        <i class="ni ni-fat-add text-white"></i> 
                        Add Product Category
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped  table-bordered table-hover" id="table" width="100%" style="vertical-align: middle;">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" rowspan="2">#</th>
                                    <th style="vertical-align: middle;" rowspan="2">Category Name</th>
                                    <th style="vertical-align: middle;" rowspan="2">Category Rank</th>
                                    <th style="vertical-align: middle;" rowspan="2">Last Update</th>
                                    <th colspan="2"><center>Action</center></th>
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
                                        <label for="category_name">Category Name</label>
                                        <input type="text" id="category_name" class="form-control option" name="category_name" placeholder="Type Name">
                                        <small id="category_name_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="category_rank">Category Rank</label>
                                        <input type="text" name="category_rank" id="category_rank" class="form-control" placeholder="Category Rank">
                                        <small id="category_rank_alert" class="form-text text-danger"></small>
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
        const data = {
            id_name : "category_id",
            url:"{{url('ticketing/product/category')}}"
        }

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
                ajax: "{{url('ticketing/product/category')}}",
                columns:[
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "category_name",
                        name: "category_name"
                    },
                    {
                        data: "category_rank",
                        name: "category_rank"
                    },
                    {
                        data: "updated_by",
                        name: "updated_by",
                        render: function (data, type, row, meta) {
                            return `${data} - ${row.updated_at}`;
                        }
                    },
                    {
                        data: 'category_id',
                        name: 'category_id',
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
                        data: 'category_id',
                        name: 'category_id',
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

        const Helper = new valbon (data)
        const field = ["category_name","category_rank"];

        modal = (type,id = null) => {
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

    </script>
@endsection