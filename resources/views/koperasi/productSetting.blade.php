@extends('koperasi/master/master')
@section('title','Management Product Setting')
@section('breadcumb','Management Product Setting')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_tabler/dist/libs/datatables/datatables.min.css')}}"/>
@endsection

@section('content')
    <div class="row mt-2" id="filter">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header">
                            <span class="fa fa-filter mr-1"></span> FILTER
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col form-group">
                                    <label><b>Brand</b></label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" id="brand_search" name="brand_search" onchange="GetCategory();getDataProduct()">
                                        <option value="" selected>Brand</option>
                                            @foreach ($brand as $item)
                                                <option value="{{$item->brand_id}}" >
                                                    {{$item->brand_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label><b>Category</b></label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" id="category_search" name="category_search" onchange="getDataProduct()" >
                                        <option value="" selected>Category</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-2">
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    {{-- <button type="button" onclick="modal('add')" class="btn btn-success rounded mb-3">
                        <span class="fa fa-plus text-white mr-1"></span> 
                        Add Limit Category
                    </button> --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>Category Name</th>
                                    <th>Diskon 1</th>
                                    <th>Diskon 2</th>
                                    <th>Diskon 3</th>
                                    <th><center>Status</center></th>
                                    <th><center>Edit</center></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="modal" tabindex="-1" role="dialog">
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
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label for="diskon_1">Diskon 1</label>
                                        <input type="text" id="diskon_1" class="form-control option" name="diskon_1" placeholder="Diskon 1">
                                        <small id="diskon_1_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label for="diskon_2">Diskon 2</label>
                                        <input type="text" id="diskon_2" class="form-control option" name="diskon_2" placeholder="Diskon 2">
                                        <small id="diskon_2_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label for="diskon_3">Diskon 3</label>
                                        <input type="text" id="diskon_3" class="form-control option" name="diskon_3" placeholder="Diskon 3">
                                        <small id="diskon_3_alert" class="form-text text-danger"></small>
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

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        const Helper = new valbon()

        $(document).ready(function () {
            getDataProduct();
            GetCategory();
        });

        getDataProduct = () => {
            $('#table').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>',
                },
                ajax: {
                    url : "{{url('koperasi/product-setting')}}",
                    data: {
                        brand_search : $('#brand_search').val(),
                        category_search : $('#category_search').val(),
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "product_code",
                        name: "product_code"
                    },
                    {
                        data: "product_name",
                        name: "product_name"
                    },
                    {
                        data: "brand_name",
                        name: "brand_name",
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                    },
                    {
                        data: 'product_setting',
                        name: 'product_setting',
                        render : (data, type, row) => {
                            if (data != null) {
                                return data.diskon_1 == null ? "-" : data.diskon_1;
                            }else{
                                return "-"
                            }
                        }
                    },
                    {
                        data: 'product_setting',
                        name: 'product_setting',
                        render : (data, type, row) => {
                            if (data != null) {
                                return data.diskon_2 == null ? "-" : data.diskon_2;
                            }else{
                                return "-"
                            }
                        }
                    },
                    {
                        data: 'product_setting',
                        name: 'product_setting',
                        render : (data, type, row) => {
                            if (data != null) {
                                return data.diskon_3 == null ? "-" : data.diskon_3;
                            }else{
                                return "-"
                            }
                        }
                    },
                    {
                        data: 'product_code',
                        name: 'product_code',
                        render: function (data, type, row) {
                            if (row.product_setting != null) {
                                if (row.product_setting.black_list_status == 'yes') { //jika di blacklist
                                    return `<center>
                                                <a onclick="confirm('${data}','no')" data-toggle="tooltip" data-placement="top" title="Unlock">
                                                    <button class="btn btn-sm btn-danger">
                                                        <span class="fa fa-lock"></span>
                                                    </button>
                                                </a>
                                            </center>`
                                } else {
                                    return `<center>
                                                <a onclick="confirm('${data}','yes')" data-toggle="tooltip" data-placement="top" title="Lock">
                                                    <button class="btn btn-sm btn-primary">
                                                        <span class="fa fa-lock-open"></span>
                                                    </button>
                                                </a>
                                            </center>`
                                }
                            } else {
                                return `<center>
                                            <a onclick="confirm('${data}','yes')" data-toggle="tooltip" data-placement="top" title="Lock">
                                                <button class="btn btn-sm btn-primary">
                                                    <span class="fa fa-lock-open"></span>
                                                </button>
                                            </a>
                                        </center>`
                            }
                        }
                    },
                    {
                        data : 'product_code',
                        name : 'product_code',
                        render : (data,type,row) => {
                            return `<center>
                                        <a onclick="modal_diskon('${data}',this)" data-toggle="tooltip" data-placement="top" title="Edit Diskon" data-data='${JSON.stringify(row)}'>
                                            <button class="btn btn-sm btn-info btn-edit" >
                                                <span class="fa fa-edit"></span>
                                            </button>
                                        </a>
                                    </center>`
                        }
                    }
                ],
                createdRow: function (row, data, index) {
                    if (data.product_setting != null) {
                        if (data.product_setting.black_list_status == 'yes') { //jika di blacklist
                            $(row).addClass("table-warning");
                        }
                    }
                }
            })
        }

        GetCategory = () => {
            $('.category_search').remove();
            let filter_brand = $('#brand_search').val();
            $.ajax({
                type: "get",
                url: "{{url('koperasi/category')}}",
                data: {
                    filter_brand: filter_brand
                },
                success: (res) => {
                    let option = '';
                    res.forEach(el => {
                        option += `<option value="${el.category_id}" class="category_search">${el.category_name}</option>`;
                    });
                    $('#category_search').append(option);
                }
            })
        }

        confirm = (product_code, black_list_status) => {
            let type = black_list_status == 'yes' ? 'Lock' : 'Unlock';
            Swal.fire({
                title: 'Are you sure?',
                text: `${type} this product`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${type} it!`,
                preConfirm: () => {
                    update(product_code, black_list_status)
                }
            })
        }

        update = (product_code, black_list_status,type = null) => {
            let data = data_update(product_code, black_list_status,type);
            $.ajax({
                type: "post",
                url: "{{url('koperasi/product-setting')}}",
                data : data,
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    $(`#table`).DataTable().ajax.reload();
                    Helper.sweetSuccess(res.message, res.data.message)
                    Helper.closeModal();
                },
                error:  (response) => {
                    Helper.errorHandle(response);
                },
                complete : () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        modal_diskon = (product_code,data) => {
            // let dataProduct = data.data();
            let product = $(data).data('data');
            $('#modal').modal('show');
            if (product.product_setting != null) {
                $('#diskon_1').val(product.product_setting.diskon_1);
                $('#diskon_2').val(product.product_setting.diskon_2);
                $('#diskon_3').val(product.product_setting.diskon_3);
            }
            let black_list_status = product.product_setting == null ? 'no' : product.product_setting.black_list_status;
            $('#btn-save').attr('onclick',`update('${product_code}','${black_list_status}','diskon')`);
            $('#modalLabel').text('Setting Diskon - ' + product_code)
        }

        data_update = (product_code, black_list_status,type) => {
            if (type == 'diskon') {
                return {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_code: product_code,
                    black_list_status: black_list_status,
                    diskon_1 : $('#diskon_1').val(),
                    diskon_2 : $('#diskon_2').val(),
                    diskon_3 : $('#diskon_3').val(),
                    // product_setting_id: product_setting_id
                }
            }

            return {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_code: product_code,
                    black_list_status: black_list_status,
            }
        }
    </script>
@endsection