<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-alpha.13
* @link https://tabler.io
* Copyright 2018-2020 The Tabler Authors
* Copyright 2018-2020 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>I'am A Wiproite | Koperasi - @yield('title')</title>
    <link rel="shortcut icon" href="{{asset('images/wipro.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{asset('images/wipro.ico')}}">
    @include('koperasi/master/include/header')
    @yield('header')
</head>

<body class="antialiased" style="display: block;">
    <div class="se-pre-con"></div>
    <div class="page">
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3" style="padding-top: 0px; padding-bottom: 3px;">
                    <img src="{{ asset('images/wipro-logo.png') }}" style="width: 60px; margin-right: 10px;">
                    <h2 class="mb-0">KOPERASI</h2>
                </a>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item d-none d-md-flex mr-3">
                        <a style="cursor: pointer;" class="px-0" onclick="showCart()">
                            <span class="fa fa-shopping-cart" id="cart">
                                <span class="badge bg-red" id="notif" hidden></span>
                            </span>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                            <span class="avatar avatar-sm"
                                style="background-image: url({{asset('img-user/male.png')}})"></span>
                            <div class="d-none d-xl-block pl-2">
                                <div>{{Auth::user()->user_name}}</div>
                                <div class="mt-1 small text-muted">{{\App\Repository\Dashboard\Title\TitleRepository::getTitleById(Auth::user()->title_id)->title_name}}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a href="{{url('profile')}}" class="dropdown-item">Profile</a>
                            <a href="{{url('/')}}" class="dropdown-item">Home</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{route('logout')}}" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar navbar-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            @php
                                $allMenu = App\Model\Koperasi\Menu\Menu::with(['MenuChild','MenuChild.MenuGrandChild'])->get();
                                $access = App\Model\Koperasi\Access::where('user_id', Auth::user()->user_id)->first();
                                if ($access) {
                                    $menu = explode('#', $access->menu);
                                    $parent = explode(',', $menu[0]);
                                    $child = explode(',', $menu[1]);
                                    $grand_child = explode(',', $menu[2]);
                                }else{
                                    $parent = [];
                                    $child = [];
                                    $grand_child = [];
                                }
                            @endphp
                            @foreach ($allMenu as $parentMenu)
                                @if (in_array($parentMenu->menu_parent_id, $parent))
                                    @if (count($parentMenu->MenuChild)>0)
                                        <li class="dropdown nav-item parent-{{$parentMenu->menu_parent_id}}" data-menu="dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="{{$parentMenu->menu_parent_icon}}"></i>
                                                </span>
                                                <span class="nav-link-title">
                                                    {{$parentMenu->menu_parent_name}}
                                                </span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-menu-columns">
                                                    <div class="dropdown-menu-column">
                                                        @foreach ($parentMenu->MenuChild as $menuChild)
                                                            @foreach ($child as $accessChild)
                                                                @if ($menuChild->menu_child_id == $accessChild )
                                                                    @if (count($menuChild->MenuGrandChild)>0)
                                                                        <div class="dropright">
                                                                            <a class="dropdown-item dropdown-toggle ml-1" href="#"
                                                                                data-toggle="dropdown" role="button" aria-expanded="false">
                                                                                    {{$menuChild->menu_child_name}}
                                                                            </a>
                                                                            <div class="dropdown-menu">
                                                                                @foreach ( $menuChild->MenuGrandChild as $menuGrandChild)
                                                                                    @foreach ($grand_child as $accessGrandChild)
                                                                                        @if ($menuGrandChild->menu_grand_child_id == $accessGrandChild)
                                                                                            <a href="{{url($menuGrandChild->menu_grand_child_icon)}}" class="dropdown-item">
                                                                                                {{$menuGrandChild->menu_grand_child_name}}
                                                                                            </a>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <a class="dropdown-item" href="{{url($menuChild->menu_child_url)}}">
                                                                            {{$menuChild->menu_child_name}}
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="nav-item parent-{{$parentMenu->menu_parent_id}}" >
                                            <a class="nav-link" href="{{url($parentMenu->menu_parent_url)}}">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="{{$parentMenu->menu_parent_icon}}"></i>
                                                </span>
                                                <span class="nav-link-title">
                                                    {{$parentMenu->menu_parent_name}}
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <!-- Page title -->
                <div class="page-header d-print-none breadcrumb-head" hidden>
                    <div class="row align-items-center">
                        <div class="col">
                           
                            <h2 class="content-header-title float-left mb-0">@yield('breadcumb')</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    {{-- <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Content</a>
                                    </li>
                                    <li class="breadcrumb-item active">Helper Classes
                                    </li> --}}
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-deck row-cards">
                    @yield('content')
                    {{-- Modal --}}
                    <div class="modal modal-blur fade" id="modal-cart" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Your Cart</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-transparent table-responsive">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 1%"></th>
                                                <th>Product</th>
                                                <th class="text-center" style="width: 1%">QTY</th>
                                                <th class="text-center" style="width: 1%">Harga</th>
                                                <th class="text-center" style="width: 1%">Diskon</th>
                                                <th class="text-center" style="width: 1%">Total</th>
                                                <th class="text-center" style="width: 1%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail-cart">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        <span class="fa fa-window-close mr-1"></span>
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-order">
                                        <span class="fa fa-shopping-basket mr-1"></span>
                                        Order
                                    </button>
                                    {{-- <button type="button" class="btn btn-success" id="btn-save" hidden>
                                        <span class="fa fa-save mr-1"></span>
                                        Save
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- modal --}}
                </div>
            </div>
            @php
                $version = App\Model\Plugin\PluginVersion::select('version_code','version_name')->where('version_status', '1')->first()
            @endphp
            <footer class="footer footer-transparent d-print-none">
                <div class="container">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ml-lg-auto">
                            <li class="list-inline-item">
                                <b>Version</b> {{ $version->version_code }}
                            </li>
                        </div>
                        <div class="col-12 col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                   {{ $version->version_name }}
                                    <a href="{{url('/')}}" class="link-secondary"> Wipro Unza</a>.
                                    All rights reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('koperasi/master/include/footer')
    @yield('footer')
    <script>
        firstLoader = () =>{
            setTimeout(function () {
                $('.se-pre-con').fadeOut()
            }, 2000)
        }

        $(document).ready(function () {
            let path = window.location.pathname
            path = path.substring(1)
            $.ajax({
                type: "get",
                url: "{{url('breadcumKoperasi')}}",
                data: {
                    path: path
                },
                success: function (response) {
                    let data = response.data;
                    let breadcumb = '<li class="breadcrumb-item"><a href="{{url(' / koperasi ')}}">Home</a></li>'
                    if (path != 'koperasi') {
                        if (data != null) {
                            if (data.menu_parent_name != null) breadcumb += `<li class="breadcrumb-item">${data.menu_parent_name}</li>`
                            if (data.menu_child_name != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${data.menu_child_url}')}}">${data.menu_child_name}</a></li>`
                            if (data.menu_grand_child_name != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${data.menu_grand_child_url}')}}">${data.menu_grand_child_name}</a></li>`
                        } else {
                            let pathsplit = path.split('/')
                            let parent = minToSpace(pathsplit[0])
                            let child = minToSpace(pathsplit[1])
                            let grand_child = minToSpace(pathsplit[2])
                            if (parent != null) breadcumb += `<li class="breadcrumb-item">${parent}</li>`
                            if (child != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${path}')}}">${child}</a></li>`
                            if (grand_child != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${path}')}}">${grand_child}</a></li>`
                        }
                        $('.breadcrumb').append(breadcumb);
                        $('.breadcrumb-head').attr('hidden', false);

                    } else {
                        $('.breadcrumb-head').attr('hidden', true);
                    }
                    $(`.parent-${data.menu_parent_id}`).addClass('active');
                }
            });
            $('#memory').html(window.performance.memory.totalJSHeapSize / 1000000);

            CountCart();
        });

        showCart = () => {
            $('#btn-order').attr('hidden',false);
            $('#btn-save').attr('hidden',true);
            $.ajax({
                type: "get",
                url: "{{url('koperasi/product/cart/detail')}}",
                beforeSend: () => {
                    $('.se-pre-con').show();
                    $('#detail-cart').empty();
                },
                success: (response) => {
                    let data = response.data
                    tableBody = makeTableBody(data); 
                    $('#detail-cart').append(tableBody)
                },
                complete: () => {
                    $('.se-pre-con').hide();
                    $('#modal-cart').modal('show');
                }
            })
        }

        makeTableBody = (data) => {
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

        CountCart = () => {
            $.ajax({
                type: "get",
                url: "{{url('koperasi/product/cart')}}",
                success: (res) => {
                    if (res.data > 0) {
                        $('#notif').text(res.data)
                        $('#notif').attr('hidden', false);
                    } else {
                        $('#notif').attr('hidden', true);
                    }
                }
            })
        }

        updateQty = (data, id, type, type2 = null) => {
            // type2 digunakan untuk menentukan dari modal edit atau show dia di panggil
            //jika type2 null maka fungsi akan langsung berjalan dan jika tidak null maka fungsi ajax tidak berjalan
            let parent = $(data).parent().parent().parent().attr('id');
            let selectorQty = $(`#${parent} td div #qty`);
            let qty = selectorQty.text()

            type == 'minus' ? qty-- : qty++;

            if (qty >= 1) {
                if (type2 == null) {
                    $.ajax({
                        type : "patch",
                        url : "{{url('koperasi/product')}}/"+id,
                        data : {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            order_detail_id : id,
                            qty : qty
                        },
                        success : (res) => {
                            let data = res;
                        }
                    });
                }

                selectorQty.attr('data-qty', qty);
                selectorQty.text(qty);
                updateTotal(selectorQty, parent);
                updateSubtotal();
            }
        }

        updateTotal = (selectorQty,parent) => {
            let harga = $(`#${parent} .harga`).data('harga');
            let diskon = $(`#${parent} .diskon`).data('diskon');
            let total = harga * selectorQty.text();
            let diskon_harga = (total / 100) * diskon;
            let total_harga = total - diskon_harga;
            $(`#${parent} .total span`).text(formatRp(total_harga));
            $(`#${parent} .total`).attr('data-total',total_harga);
        }

        updateSubtotal = () => {
            let listItem = $('#detail-cart tr[id^="item-"]');
            let subtotal = 0;
            for (let index = 0; index < listItem.length; index++) {
                let parent = listItem[index].id;
                let total = $(`#${parent} .total`).text();
                subtotal = subtotal + parseFloat(total.replace('Rp.','').replace(',',''));
            }

            let ppn = subtotal / 100 * 10;
            let total_payment = subtotal + ppn;
            $('#subtotal').text(formatRp(subtotal));
            $('#ppn').text(formatRp(ppn));
            $('#total_payment').text(formatRp(total_payment));
        }

        deleteCart = (data,id) => {
            let parent = $(data).parent().parent().parent().attr('id');
            $.ajax({
                type : "delete",
                url : "{{url('koperasi/product')}}/"+id,
                data : {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order_detail_id : id,
                },
                success : (res) => {
                    let data = res;
                    $(`#${parent}`).remove();
                },
                complete : () => {
                    updateSubtotal();
                    CountCart();
                }
            })
        }

        $('#btn-order').on('click',()=>{
            let Helper = new valbon ();
            $.ajax({
                type : "post",
                url : "{{url('koperasi/order')}}",
                data : {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success : (res) => {
                    Helper.sweetSuccess(res.message,res.data.message);
                    CountCart();
                    $('#modal-cart').modal('show');
                },
                error : (res) => {
                    $('.category-alert').attr("hidden",true);
                    let category = res.responseJSON.message;
                    let array = category.split("=");
                    if (array[0] == "array") { //array 0 type dari message nya yaitu array / message
                        limit(array[1]) // array 1 berisi array atau message tergantung typenya
                    }else{
                        Helper.errorHandle(res)
                    }
                },
                complete : () => {
                    $('.se-pre-con').hide();
                }
            })
        })

        limit = (data) => {
            
            let alert = new valbon ();
            
            let category = data.substring(1,data.length-1);
            category = category.split(",")

            category.forEach(el => {
                $(`.category-${el}`).attr('hidden',false);
                $(`.category-${el}`).text('This category has reached the order limit');
            });

            alert.sweetError("Your Order Exceeds The Limit")
        }

        formatRp = (data) => {
            let nominal = 'Rp.' + (parseFloat(data)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            return nominal;
        }



        
    </script>
</body>

</html>