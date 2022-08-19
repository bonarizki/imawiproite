@extends('koperasi/master/master')
@section('title','Management Order Limit')
@section('breadcumb','Management Order Limit')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_tabler/dist/libs/datatables/datatables.min.css')}}"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    <button type="button" onclick="modal('add')" class="btn btn-success rounded mb-3">
                        <span class="fa fa-plus text-white mr-1"></span> 
                        Add Limit Category
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Limit</th>
                                    <th>Last Update</th>
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
    <div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" id="form">
                        @csrf
                        <div class="form-body">
                            <div class="row form-body-row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="category_id">Category Name</label>
                                        <select class="form-control select2bs4" name="category_id" id="category_id" placeholder="Category"/>
                                            <option value="" disabled selected>Category</option>
                                        </select>
                                        <small id="category_id_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="order_limit">Order Limit</label>
                                        <input type="text" id="order_limit" class="form-control option" name="order_limit" placeholder="Primary Name">
                                        <small id="order_limit_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 button-form d-flex flex-row-reverse pt-2">
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
    <script type="text/javascript" src="{{asset('assets_tabler/dist/libs/datatables/datatables.min.js')}}"></script>
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <script>
        $(window).on('load', function () {
            firstLoader();
        })
        
        $(document).ready(function () {
            $('#table').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>',
                },
                ajax: "{{url('koperasi/order-limit/data')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "product.category_name",
                        name: "product.category_name"
                    },
                    {
                        data: "order_limit",
                        name: "order_limit"
                    },
                    {
                        data: "updated_by",
                        name: "updated_by",
                        render: function (data, type, row, meta) {
                            return `${data} - ${row.updated_at}`;
                        }
                    },
                    {
                        data: 'order_limit_id',
                        name: 'order_limit_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-info" onclick="modal('edit','${data}')">
                                            <span class="fas fa-pen mr-1"></span> 
                                            Edit
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'order_limit_id',
                        name: 'order_limit_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-danger" onclick="deleteData('${data}')">
                                            <span class="fas fa-trash-alt mr-1"></span> 
                                            Delete
                                        </badge>
                                    </center>`
                        }
                    }
                ]
            })

            getCategoryProduct();
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        getCategoryProduct = () => {
            $.ajax({
                type: "get",
                url: "{{url('koperasi/category')}}",
                success: (res) => {
                    let option = '';
                    res.forEach(el => {
                        option += `<option value="${el.category_id}">${el.category_name}</option>`;
                    });
                    $('#category_id').append(option);
                }
            })
        }

        const data = {
            id_name: "order_limit_id",
            url: "{{url('koperasi/order-limit/data')}}"
        }

        const Helper = new valbon(data)
        
        const field = ["category_id", "order_limit"];

        modal = (type, id = null) => {
            $(`#category_id`).val("").select2({theme: 'bootstrap4'})
            Helper.closeModal();
            Helper.modal(type, id, 'Priority')
        }

        validasi = (type) => {
            Helper.validasi(type);
        }

        deleteData = (id) => {
            Helper.modalDelete(id);
        }

    </script>
@endsection