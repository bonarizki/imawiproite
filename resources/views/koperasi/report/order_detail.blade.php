<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Detail</title>
    <link href="{{ public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"href="{{asset('assets_vuexy/app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">
    <link rel="stylesheet" type="text/css"href="{{asset('assets_vuexy/app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css"href="{{asset('assets_vuexy/app-assets/css/pages/dashboard-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/pages/card-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/plugins/tour/tour.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/assets/css/style.css')}}">
    <!-- END: Custom CSS-->
</head>
<body class="bg-white">
    <div style="padding-left: 30px;
        font-size: 17px;
        padding-top: 10px;
        font-color: black;
        padding-right: 30px;"
    >
        <table width="100%">
            <tr >
                <td style="width:20%">No Order</td>
                <td>:</td>
                <td><b>{{$data->order_header_id}}</b></td>
            </tr>
            <tr>
                <td>Order Item</td>
                <td>:</td>
                <td><b>{{$data->Detail->count()}} Pcs</b></td>
            </tr>
            <tr>
                <td>Order Status</td>
                <td>:</td>
                <td><b>{{ucwords($data->order_status)}}</b></td>
            </tr>
            <tr>
                <td>Order Created By</td>
                <td>:</td>
                <td>
                    <b>{{ucwords($data->User->user_name)}}</b>
                    -
                    <button class="btn btn-sm btn-@php echo $data->User->Member->member_status == 'member' ? 'success' : 'warning' @endphp text-white">
                        {{ucwords($data->User->Member->member_status)}}
                    </button>
                </td>
            </tr>
            <tr>
                <td>Order Created At</td>
                <td>:</td>
                <td><b>{{ucwords($data->created_at)}}</b></td>
            </tr>
        </table>
        <hr>
        <h1 class="text-center mb-1">Detail Order</h1>
        <table class="table table-striped table-bordered" style="border: 1px solid black;">
            <thead>
                <tr class="table-active">
                    <th style="width: 40%"><center>Product</center></th>
                    <th style="width: 10%"><center>QTY</center></th>
                    <th style="width: 25%"><center>Price</center></th>
                    <th style="width: 25%"><center>Total</center></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                @endphp
                @foreach ($data->Detail as $item)
                    @php
                        $total = $item->Product->product_price_koperasi * $item->qty;
                        $subtotal = $total + $subtotal;
                    @endphp
                    <tr>
                        <td>
                            {{$item->Product->product_name}}
                        </td>
                        <td>
                            <center>
                                {{$item->qty}}
                            </center>
                        </td>
                        <td>
                            <center>
                                Rp.{{number_format($item->Product->product_price_koperasi,2,",",".")}}
                            </center>
                        </td>
                        <td>
                            <center>
                                Rp.{{number_format($total,2,",",".")}}
                            </center>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right">
                       <b>Subtotal</b>
                    </td>
                    <td>
                        <center>
                            Rp.{{number_format($subtotal,2,",",".")}}
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">
                       <b>PPN</b>
                    </td>
                    <td>
                        <center>
                            Rp.{{number_format($subtotal / 100 * 10 ,2,",",".")}}
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">
                       <b>Total Payment</b>
                    </td>
                    <td>
                        <center>
                            Rp.{{number_format(($subtotal / 100 * 10) + $subtotal ,2,",",".")}}
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    
</body>
</html>