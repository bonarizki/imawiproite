@extends('koperasi/master/master')
@section('title','Order')
@section('breadcumb','List Order')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_tabler/dist/libs/datatables/datatables.min.css')}}"/>
@endsection

@section('content')
    <div class="row" id="filter">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header">
                            <div class="col d-flex align-items-center">
                                <h3>
                                    <span class="fa fa-filter mr-1"></span>
                                    Filter
                                </h3>
                            </div>
                            <div class="col-md-6 d-flex align-items-center flex-row-reverse">
                                <button class="btn btn-success" id="btn-report">
                                    <span class="fas fa-file-pdf mr-1"></span>
                                    Download
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form" action="{{url('koperasi/download/report')}}" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col form-group">
                                        <label>Periode</label>
                                        <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Period" id="period_search" name="period_search" >
                                        </select>
                                    </div>
                                    <div class="col form-group" >
                                        <label>Orders Status</label>
                                        <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Ticket Status" id="order_status_search" name="order_status_search" >
                                        </select>
                                    </div>
                                    <div class="col form-group" >
                                        <label>Department</label>
                                        <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Department" id="department_search" name="department_search" >
                                            <option value="">Choose</option>
                                        </select>
                                    </div>
                                    <div class="col form-group">
                                        <label>NIK</label>
                                        <input type="text" class="form-control" style="width: 100%" placeholder="NIK" id="nik_search" name="nik_search" ></input>
                                    </div>
                                    <div class="col form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" style="width: 100%" placeholder="Name" id="nama_search" name="nama_search" ></input>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard ">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-center" data-toggle="tab" href="#proceed" aria-controls="proceed" role="tab" aria-selected="true" onclick="getData('proceed');clearFilter();OrderStatusFilter('proceed')">Proceed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="service-tab-center" data-toggle="tab" href="#service-center" aria-controls="service-center" role="tab" aria-selected="false" onclick="getData('unproceed');clearFilter();OrderStatusFilter('unproceed')">Unproceed</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane table-responsive active" id="proceed" aria-labelledby="home-tab-center" role="tabpanel" >
                                <br>
                                <table class="table table-striped table-bordered table-hover table-sm" id="table-proceed" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Period</th>
                                            <th><center>Status</center></th>
                                            <th>Order Created At</th>
                                            <th><center>Detail</center></th>
                                            <th><center>Edit</center></th>
                                            <th><center>Option</center></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane table-responsive" id="service-center" aria-labelledby="service-tab-center" role="tabpanel">
                                <table class="table table-striped table-bordered table-hover mt-3" id="table-unproceed" width="100%">
                                    <br>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Period</th>
                                            <th>Status</th>
                                            <th>Order Created At</th>
                                            <th><center>Detail</center></th>
                                            <th><center>Edit</center></th>
                                            <th><center>Option</center></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal modal-blur fade text-left" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-full-width modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-transparent table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 1%"></th>
                                <th>Product</th>
                                <th class="text-center" style="width: 1%">QTY</th>
                                <th class="text-right" style="width: 1%">Harga</th>
                                <th class="text-right" style="width: 1%">Total</th>
                            </tr>
                        </thead>
                        <tbody id="detail-order">
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info btn-md" id="btn-update">
                        <span class="fas fa-clipboard-check mr-1"></span>
                        Submit To Jurnal
                    </button>
                    <button class="btn btn-success btn-md" id="btn-download">
                        <span class="fas fa-file-pdf mr-1"></span>
                        Download
                    </button>
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
            getData('proceed');
            OrderStatusFilter('proceed')
            getAllOption();
            setFilterPeriod();
            $('.select2bs4').select2({theme:'bootstrap4'});

        });

        const data = {
            id_name : "order_header_id",
            url:"{{url('Koperasi/order')}}"
        }

        let Helper = new valbon (data);

        setFilterPeriod = () => {
            $.ajax({
                type: "get",
                url: "{{url('/getall/plugin/period/active')}}",
                success: function (response) {
                    let data = response.data
                    let periodOption = '<option value="">Choose</option>'
                    periodOption += loopingOption(data, 'period');
                    $('#period_search').append(periodOption);
                },
            })
        }

        loopingOption = (data, type) => {
            let option = ``
            for (let index = 0; index < data.length; index++) {
                var name = type + '_name';
                var id = type + '_id';
                option += `<option value="${data[index][id]}">${data[index][name]}</option>`;
            }
            return option;
        }

        getAllOption = () => {
            $.ajax({
                type: 'get',
                url: "{{url('/get/option/user')}}",
                success: function (response) {
                    showingOptionSearch(response.data);
                }
            })
        }

        showingOptionSearch = (data) => {
            let index = ["grade", "department"];
            let test = 'type_name';
            for (let i = 0; i < index.length; i++) {
                let id = `${index[i]}_id`;
                let name = `${index[i]}_name`;
                let dataObject = data[index[i]];
                for (let u = 0; u < dataObject.length; u++) {
                    $(`#${index[i]}_search`).append(`<option value="${dataObject[u][id]}">
                                            ${dataObject[u][name]}
                                        </option>`);
                }
            }
        }

        OrderStatusFilter = (type) => {
            $('#order_status_search').empty();
            setFilter(type);
        }

        setFilter = (type) => {
            $('#department_search').attr('onchange', `getData('${type}')`)
            $('#order_status_search').attr('onchange', `getData('${type}')`)
            $('#period_search').attr('onchange', `getData('${type}')`)
            $('#nik_search').attr('onkeyup', `getData('${type}')`)
            $('#nama_search').attr('onkeyup', `getData('${type}')`)
            let optionFilter = '<option value="">Choose</option>';
            if (type == 'proceed') {
                optionFilter += `<option value="process">In Progress</option>
                                <option value="done">Done</option>`;
            } else {
                optionFilter += `<option value="cancel">Cancel</option>
                                <option value="reject">Reject</option>`;
            }
            $('#order_status_search').append(optionFilter);
        }

        clearFilter = () => {
            $('#department_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#period_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#order_status_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#nik_search').val('');
            $('#nama_search').attr('');
        }

        getData = (type) => {
            let url = "{{url('koperasi/order')}}"
            var table = $(`#table-${type}`).DataTable({
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>',
                },
                ajax: {
                    url: url,
                    data: {
                        "department_id": $('#department_search').val(),
                        "order_status": $('#order_status_search').val(),
                        "period_id": $('#period_search').val(),
                        "type": type,
                        "user_nik": $('#nik_search').val(),
                        "user_name": $('#nama_search').val()
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "order_header_id",
                        name: "order_header_id"
                    },
                    {
                        data: "period.period_name",
                        name: "period.period_name"
                    },
                    {
                        data: "order_status",
                        name: "order_status",
                        render : function (data)  {
                            let color = data == 'process' ? 'secondary' : data == 'reject' ? 'warning' : 'success' ;
                            
                            return `<center>
                                        <button class="btn btn-sm btn-${color}">${data}</button>
                                    </center>`
                        }
                    },
                    {
                        data: "created_by",
                        name: "created_by",
                        render: function (data, type, row, meta) {
                            return `${data} <br> ${row.created_at}`;
                        }
                    },
                    {
                        data: 'order_header_id',
                        name: 'order_header_id',
                        render: function (data, row, meta) {
                            return`<center>
                                        <badge class="btn btn-sm btn-info" onclick="detail('${data}','${type}')">
                                            <span class="fas fa-eye mr-1"></span> 
                                            Detail
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'order_header_id',
                        name: 'order_header_id',
                        render: function (data, meta, row) {
                            if (row.order_status == 'process') {
                                return `<center>
                                            <badge class="btn btn-sm btn-warning" onclick="detail('${data}','edit')">
                                                <span class="fas fa-pen mr-1"></span> 
                                                Edit
                                            </badge>
                                        </center>`
                            }else{
                                return `<center> 
                                            <span class="fa fa-lock"></span>
                                        </center>`;
                            }
                        }
                    },
                    {
                        data: 'order_header_id',
                        name: 'order_header_id',
                        render: function (data, meta, row) {
                            if (type == 'proceed') {
                                if (row.order_status == 'process') {
                                    return `<center>
                                                <badge class="btn btn-sm btn-danger" onclick="cancel('${data}','${type}')">
                                                    <span class="fas fa-trash-alt mr-1"></span> 
                                                    Cancel
                                                </badge>
                                            </center>`;
                                }else{
                                    return `<center> 
                                                <span class="fa fa-lock"></span>
                                            </center>`;
                                }
                            }else{
                                return `<center>
                                            <badge class="btn btn-sm btn-primary" onclick="reverse('${data}','${type}')">
                                                <span class="fas fa-undo mr-1"></span> 
                                                Reverse
                                            </badge>
                                        </center>`;
                            }
                        }
                    }
                ],
            })
        }

        cancel = (id, type) => {
            Swal.fire({
                title: 'Are you sure to cancel order ?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                preConfirm: function () {
                    cancelProcess(id, type)
                }
            })
        }

        cancelProcess = (id, type) => {
            $.ajax({
                type: "delete",
                url: "{{url('koperasi/order')}}/" + id.replace('/', '.'),
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order_header_id: id
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (response) => {
                    Helper.sweetSuccess(response.message, response.data.message);
                    $(`#table-${type}`).DataTable().ajax.reload();
                },
                complete: () => {
                    $('.se-pre-con').hide();
                },
                error: (response) => {
                    Helper.errorHandle(response);
                },
            }).done(() => {
                $('.se-pre-con').hide();
            })
        }

        detail = (id,type) => {
            type == 'edit' ? $('#detail-cart').empty() : $('#detail-order').empty();
            $.ajax({
                type: "get",
                url: "{{url('koperasi/order')}}/" + id.replace('/', '.') + "/edit",
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    let data = res.data;
                    tableBody = type == 'edit' ? makeEditBody(data.detail) : makeDetailOrder(data.detail);
                    let bodyName = type == 'edit' ? $('#detail-cart') : $('#detail-order');
                    bodyName.append(tableBody);
                    if (type == 'edit') {
                        $('#btn-order').attr('hidden',true)
                        $('#btn-save').attr('hidden',false)
                    }else{
                        $('#btn-download').attr('onclick', `downloadDetailHistory('${id}')`);
                        if (data.order_status == 'process') {
                            $('#btn-update').attr('hidden',false);
                            $('#btn-update').attr('onclick', `update('${id}','${type}')`);
                        }else{
                            $('#btn-update').attr('hidden',true);
                        }
                    }
                    
                },
                complete: () => {
                    $('#modalLabel').text(`Detail Order ${id}`)
                    type == 'edit' ? $('#modal-cart').modal('show') : $('#modal').modal('show');
                    $('.se-pre-con').hide();
                }
            })
        }

        update = (id,type) => {
            $.ajax({
                type: "patch",
                url: "{{url('koperasi/order')}}/" + id.replace('/', '.'),
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order_header_id: id
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (response) => {
                    Helper.sweetSuccess(response.message, response.data.message);
                    $(`#table-${type}`).DataTable().ajax.reload();
                    $('#modal').modal('hide');
                },
                complete: () => {
                    $('.se-pre-con').hide();
                },
                error: (response) => {
                    Helper.errorHandle(response);
                },
            }).done(() => {
                $('.se-pre-con').hide();
            })
        }

        downloadDetailHistory = (id) => {
            window.open("{{url('koperasi/download/history-order')}}/" + id.replace('/', '.'), '_blank');
        }

        makeDetailOrder = (data) => {
            //pembuatan table body
            let tableBody = ''
            let subtotal = 0;
            data.forEach((item, index) => {
                let total = item.qty * parseFloat(item.product.product_price_koperasi);
                subtotal = subtotal + total;
                tableBody += `<tr id="item-${index+1}">
                                    <td class="text-center number-${index}">${index + 1}</td>
                                    <td>
                                        <p class="strong mb-1">${item.product.brand_name} - ${item.product.category_name}</p>
                                        <div class="text-muted">${item.product.product_name} - ${item.product.product_code}</div>
                                    </td>
                                    <td class="text-center">
                                            ${item.qty}
                                    </td>
                                    <td class="text-right harga">
                                        ${formatRp(parseFloat(item.product.product_price_koperasi))}
                                    </td>
                                    <td class="text-right total">
                                        ${formatRp(total)}
                                    </td>
                                </tr>`
            });

            //penambahan subtotal
            let ppn = subtotal / 100 * 10;
            let total_payment = subtotal + ppn;
            tableBody += `  <tr>
                                <td colspan="4" class="strong text-right">Subtotal</td>
                                <td class="text-right" id="subtotal">${formatRp(subtotal)}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="strong text-right">PPN</td>
                                <td class="text-right" id="ppn">${formatRp(ppn)}</td> 
                            </tr>
                            <tr>
                                <td colspan="4" class="strong text-right">Total Payment</td>
                                <td class="text-right" id="total_payment">${formatRp(total_payment)}</td> 
                            </tr>`

            return tableBody;
        }

        makeEditBody = (data) => {
            //pembuatan table body
            let tableBody = ''
            let subtotal = 0;
            data.forEach((item, index) => {
                let total = item.qty * parseFloat(item.product.product_price_koperasi); // total harga item * qty

                let diskon_1 = parseInt(item.diskon_1 == null ? 0 : item.diskon_1 );
                let diskon_2 = parseInt(item.diskon_2 == null ? 0 : item.diskon_2 );
                let diskon_3 = parseInt(item.diskon_3 == null ? 0 : item.diskon_3 );
                let diskon = diskon_1 + diskon_2 + diskon_3; // total diskon

                let total_diskon = (total / 100) * diskon; // mencari harga diskon dari harga total
                total = total - total_diskon
                subtotal = subtotal + total;
                
                tableBody += `<tr id="item-${index+1}">
                                    <td class="text-center number-${index}">${index + 1}</td>
                                    <td>
                                        <p class="strong mb-1">${item.product.brand_name} - ${item.product.category_name}</p>
                                        <div class="text-muted">${item.product.product_name} - ${item.product.product_code}</div>
                                        <small class="form-text text-danger category-alert category-${item.product.category_id}" hidden></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center p-2">
                                            <span style="cursor: pointer;" class="fa fa-minus-circle text-warning mr-1" onclick="updateQty(this,${item.order_detail_id},'minus')"></span> 
                                            <div id="qty" data-qty="${item.qty}">${item.qty}</div>
                                            <span style="cursor: pointer;" class="fa fa-plus-circle text-info ml-1" onclick="updateQty(this,${item.order_detail_id},'plus')"></span>
                                        </div>
                                    </td>
                                    <td class="text-right harga" data-harga="${parseFloat(item.product.product_price_koperasi)}">
                                        <span class=" d-flex align-items-center p-2"> ${formatRp(parseFloat(item.product.product_price_koperasi))} </span>
                                    </td>
                                    <td class="text-right p-2 diskon" data-diskon="${diskon}">
                                        <span class=" d-flex align-items-center p-2"><b>${diskon}%</b></span>
                                    </td>
                                    <td class="text-center total" data-total="${total}">
                                        <span class=" d-flex align-items-center p-2"> ${formatRp(total)} </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center p-2">
                                            <span style="cursor: pointer;" class="fa fa-trash-alt text-danger ml-1" onclick="deleteCart(this,${item.order_detail_id})"></span>
                                        </div>
                                    </td>
                                </tr>`
            });

            //penambahan subtotal
            let ppn = subtotal / 100 * 10;
            let total_payment = subtotal + ppn;
            tableBody += `  <tr>
                                <td colspan="5" class="strong text-right">Subtotal</td>
                                <td class="text-right" id="subtotal">${formatRp(subtotal)}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="strong text-right">PPN</td>
                                <td class="text-right" id="ppn">${formatRp(ppn)}</td> 
                            </tr>
                            <tr>
                                <td colspan="5" class="strong text-right">Total Payment</td>
                                <td class="text-right" id="total_payment">${formatRp(total_payment)}</td> 
                            </tr>`

            return tableBody;
        }

        reverse = (id,type) => {
            $.ajax({
                type: "patch",
                url: "{{url('koperasi/order/reverse')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order_header_id: id
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (response) => {
                    Helper.sweetSuccess(response.message, response.data.message);
                    $(`#table-${type}`).DataTable().ajax.reload();
                    $('#modal').modal('hide');
                },
                complete: () => {
                    $('.se-pre-con').hide();
                },
                error: (response) => {
                    Helper.errorHandle(response);
                },
            }).done(() => {
                $('.se-pre-con').hide();
            })
        }

        $('#btn-report').on('click', () => {
           $('#form').submit();
        })

        edit = (id) => {
            console.log(id)
        }

        // $('#btn-save').on('click',()=>{
        //     let id = $('#modalLabel').text().split(' '); // mengambil id lalu di split menggunakan spasi
        //     let listItem = $('#detail-cart tr[id^="item-"]');
        //     let subtotal = 0;
        //     let credentials = []
        //     for (let index = 0; index < listItem.length; index++) {
        //         let parent = listItem[index].id;
        //         credentials.push({
        //             "order_detail_id" : $(`#${parent} #qty`).data('id'),
        //             "qty" : $(`#${parent} #qty`).text()
        //         })
        //     }
            
        //     $.ajax({
        //         type:"patch",
        //         url :"{{url('koperasi/order/update')}}",
        //         data : {
        //             _token: $('meta[name="csrf-token"]').attr('content'),
        //             id : id[2], // array 2 berisi id order 
        //             data : credentials
        //         },
        //         beforeSend: () => {
        //             $('.se-pre-con').show();
        //         },
        //         success: (response) => {
        //             Helper.sweetSuccess(response.message, response.data.message);
        //             $(`#table-proceed`).DataTable().ajax.reload();
        //             $('#modal').modal('hide');
        //         },
        //         complete: () => {
        //             $('.se-pre-con').hide();
        //         },
        //         error: (response) => {
        //             console.log(response)
        //             Helper.errorHandle(response);
        //         },
        //     })
        // })

    </script>
@endsection