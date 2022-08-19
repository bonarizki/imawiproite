@extends('ticketing/master/master')
@section('title','Management Product Sub Category')
@section('breadcumb','Management Product Sub Category')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
    <style>
        table.dataTable tbody td thead {
            vertical-align: middle !important; 
        }

        table {
            vertical-align: middle !important;
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
                        Add Product Sub Category
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped  table-bordered table-hover" id="table" width="100%" style="vertical-align: middle;">
                            <thead >
                                <tr>
                                    <th style="vertical-align: middle;" rowspan="2">#</th>
                                    <th style="vertical-align: middle;" rowspan="2">Sub Category Name</th>
                                    <th style="vertical-align: middle;" rowspan="2">Sub Category Rank</th>
                                    <th style="vertical-align: middle;" rowspan="2">Category Name</th>
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
                                        <label for="category_id">Category Name</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                        </select>
                                        <small id="category_id_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="sub_category_name">Sub Category Name</label>
                                        <input type="text" id="sub_category_name" class="form-control option" name="sub_category_name" placeholder="Type Name">
                                        <small id="sub_category_name_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="sub_category_rank">Sub Category Rank</label>
                                        <input type="text" name="sub_category_rank" id="sub_category_rank" class="form-control" placeholder="Category Rank">
                                        <small id="sub_category_rank_alert" class="form-text text-danger"></small>
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
            id_name : "sub_category_id",
            url:"{{url('ticketing/product/category-sub')}}"
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
                ajax: "{{url('ticketing/product/category-sub')}}",
                columns:[
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "sub_category_name",
                        name: "sub_category_name"
                    },
                    {
                        data: "sub_category_rank",
                        name: "sub_category_rank"
                    },
                    {
                        data: "category.category_name",
                        name: "category.category_name"
                    },
                    {
                        data: "updated_by",
                        name: "updated_by",
                        render: function (data, type, row, meta) {
                            return `${data} - ${row.updated_at}`;
                        }
                    },
                    {
                        data: 'sub_category_id',
                        name: 'sub_category_id',
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
                        data: 'sub_category_id',
                        name: 'sub_category_id',
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

            $('#category_id').select2({
                dropdownParent: $('#modal'),
                theme: 'bootstrap4'
            });
        });

        const Helper = new valbon (data)
        const field = ["sub_category_name","sub_category_rank","category_id"];

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

        getOption = () => {
            $.ajax({
                type: "get",
                url: "{{url('ticketing/product/category')}}",
                success: function (response) {
                    let data = response.data;
                    let option = '';
                    for (let index = 0; index < data.length; index++) {
                        option += `<option value="${data[index].category_id}">
                                        ${data[index].category_name}
                                    </option>`;
                    }

                    $('#category_id').append(option);
                }
            })
        }

    </script>
@endsection