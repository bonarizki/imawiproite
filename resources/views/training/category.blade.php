@extends('training/master/master')
@section('title','Category')
@section('breadcumb','Category')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <div>
                            <button class="btn btn-success" onclick="modal('add')"><i class="fa fa-plus"></i> Add Category</button>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                    <label for="category_name">Category Name</label>
                                    <input type="text" id="category_name" class="form-control option" name="category_name" placeholder="Category Name">
                                    <small id="category_name_alert" class="form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="col-12 button-form">
                                <button type="button" class="btn btn-primary mr-1 mb-1" id="btn-save">Save</button>
                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
            
            $('#table').DataTable({
                serverSide: true,
                destroy: true,
                ajax: "{{url('training/all/category/data')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "category_name",
                        name: "category_name"
                    },
                    {
                        data: "category_id",
                        name: "category_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-info" onclick="modal('edit',${data})">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>`
                        }
                    },
                    {
                        data: "category_id",
                        name: "category_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-danger" onclick="deleteData(${data})">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>`
                        }
                    },
                ]
            })

            
        });

        const data = {
            id_name : "category_id",
            create : {
                url:"{{url('training/all/category')}}",
                method : "post",
            },
            update : {
                url:"{{url('training/all/category')}}",
                method : "patch"
            },
            delete : {
                url : "{{url('training/all/category')}}",
                method : "delete"
            },
            edit : {
                url : "{{url('training/all/category')}}",
                method : "get"
            }
        }

        const Validation = new valbon (data)
        const field = ["category_name"];

        modal = (type,id = null) => {
            Validation.modal(type,id,'Category')
        }

        validasi = (type) => {
            Validation.validasi(type);
        }

        deleteData = (id) => {
            Validation.modalDelete(id);
        }

        closeModal = () => {
            $('.flexibel-form').remove();
            $('#table-detail-body').empty();
            Validation.closeModal();
        }
    </script>
@endsection