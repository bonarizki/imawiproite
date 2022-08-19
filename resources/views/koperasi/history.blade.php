@extends('koperasi/master/master')
@section('title','History Order')
@section('breadcumb','List History')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_tabler/dist/libs/datatables/datatables.min.css')}}"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    <div class="divide-y-4 mt-2">
                        @foreach ($history as $item)
                            <div>
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="avatar">
                                            <span class="fa fa-box align-self-center"></span>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="text-truncate">
                                            <strong>{{ Str::upper($item->order_status) }}</strong> 
                                        </div>
                                        <div class="text-muted">Order NO. {{$item->order_header_id}}</div>
                                        <div class="text-muted">Order Date. {{ $item->created_at }}</div>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <div class="row">
                                            <div class="col pr-1">
                                                <a onclick="detailHistory('{{$item->order_header_id}}')">
                                                    <button class="btn btn-info btn-sm">
                                                        <span class="fa fa-eye mr-1"></span>
                                                        Detail
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="col pr-3">
                                                <a onclick="downloadDetailHistory('{{$item->order_header_id}}')">
                                                    <button class="btn btn-success btn-sm">
                                                        <span class="fas fa-file-pdf mr-1"></span>
                                                        Download
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal modal-blur fade" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-full-width modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="label-history"></h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-transparent table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 1%"></th>
                                <th>Product</th>
                                <th class="text-center" style="width: 1%">QTY</th>
                                <th class="text-right" style="width: 1%">Price</th>
                                <th class="text-right" style="width: 1%">Discount</th>
                                <th class="text-right" style="width: 1%">Total</th>
                                <th class="text-center" style="width: 1%"></th>
                            </tr>
                        </thead>
                        <tbody id="detail-history">
                            
                        </tbody>
                    </table>
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
        
        detailHistory = (id) => {
            $('#detail-history').empty();
            $.ajax({
                type : "get",
                url:"{{url('koperasi/order')}}/"+ id.replace('/','.') + "/edit",
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success:(res)=>{
                    let data = res.data;
                    tableBody = makeDetailHistory(data.detail); 
                    $('#detail-history').append(tableBody)
                },
                complete:()=>{
                    $('#label-history').text(`Detail Order ${id}`)
                    $('#modal').modal('show');
                    $('.se-pre-con').hide();
                }
            })
        }

        makeDetailHistory = (data) => {
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
                                    </td>
                                    <td class="text-center">
                                            ${item.qty}
                                    </td>
                                    <td class="text-right harga">
                                        ${formatRp(parseFloat(item.product.product_price_koperasi))}
                                    </td>
                                    <td class="text-right diskon">
                                        <b>${diskon}%</b>
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

        downloadDetailHistory = (id) => {
            window.open("{{url('koperasi/download/history-order')}}/"+id.replace('/','.'), '_blank');
        }
    </script>
@endsection