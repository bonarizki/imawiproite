@extends('koperasi/master/master')
@section('title','Product')
@section('breadcumb','List Product')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
    <style>
        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='red' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
        }

        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='red' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
        }

        .d-block w-100 {
            width:100%;
            height:550px;
            object-fit:cover;
            object-position:50% 50%;
        }
        
        .image-resize {
            height: 300px; 
            width: auto; 
            max-width: auto; 
            max-height: 300px;
            display: block;
            margin: 0 auto;
        }

        .top-left {
            position: absolute;
            top: 8px;
            left: 16px;
        }
        .top-right {
            position: absolute;
            top: 8px;
            right: 16px;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card shadow-lg mb-5 bg-white rounded">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="col-auto ml-auto d-print-none">
                            <form action="{{url('koperasi/product')}}" method="GET">
                                <div class="d-flex">
                                    @csrf
                                    <div class=" d-flex align-items-center">
                                        Filter :
                                    </div>
                                    <div class="p-2">
                                        <select class="form-select select2bs4" aria-placeholder="Harga" name="filter_harga" onchange='this.form.submit()'>
                                            <option value="" selected>Harga</option>
                                            <option value="asc" {{Request::get('filter_harga') == 'asc' ? 'selected' : ''}}>Termurah</option>
                                            <option value="desc" {{Request::get('filter_harga') == 'desc' ? 'selected' : ''}}>Termahal</option>
                                        </select>
                                    </div>
                                    <div class="p-2">
                                        <select class="form-control select2bs4" name="filter_brand" placeholder="Brand" onchange='this.form.submit()'/>
                                            <option value="" selected>Brand</option>
                                            @foreach ($brand as $item)
                                                <option value="{{$item->brand_id}}"  {{Request::get('filter_brand') == $item->brand_id ? 'selected' : ''}} >
                                                    {{$item->brand_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="p-2">
                                        <select class="form-control select2bs4" name="filter_category" placeholder="Category" onchange='this.form.submit()'/>
                                            <option value="" selected>Category</option>
                                            @foreach ($category as $item)
                                                <option value="{{$item->category_id}}"  {{Request::get('filter_category') == $item->category_id ? 'selected' : ''}} >
                                                    {{$item->category_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ml-auto p-0 pt-2">
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Search Product Name" name="search_product_name" {{Request::get('search_product_name') != null ? 'value='.Request::get('search_product_name') : ''}}>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-success btn-icon" aria-label="Button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="10" cy="10" r="7" />
                                                        <line x1="21" y1="21" x2="15" y2="15" /></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row row-cards mb-3">
                        @forelse ($product as $item)
                            <div class="col-sm-6 col-lg-3">
                                <div class="card card-sm border ">
                                    <div id="carousel-controls-{{$item->product_id}}" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner ">
                                            @php $total_image_not_null  = 0;  @endphp
                                            @for ($i = 1; $i <= 4; $i++)
                                                @php 
                                                    $product_image = "product_image_".$i; 
                                                    if (isset($item->ProductSetting)) {
                                                        $product_setting = $item->ProductSetting;
                                                        $total_diskon = $product_setting->diskon_1 + $product_setting->diskon_2 + $product_setting->diskon_3;
                                                    }
                                                @endphp
                                                @if ($item->$product_image != null)
                                                    @php
                                                        $total_image_not_null = (int) $total_image_not_null + 1;
                                                    @endphp
                                                    <div class="carousel-item  {{$total_image_not_null == '1' ? "active" : "" }}">
                                                        <img class="card-img-top image-resize skeleton-image carousel-controls-{{$item->product_code}}-{{$i}}" alt=""
                                                            data-code = "{{$item->product_code}}"
                                                            data-increment = "{{$i}}" 
                                                            src=""
                                                            data-holder-rendered="true" 
                                                            onclick="detail('{{$item->product_id}}')" 
                                                            style="cursor: pointer;">
                                                        <div class="d-flex align-items-start flex-column">
                                                            <div class="top-left border border-primary bg-primary rounded-top">
                                                                <span class="pt-1 pr-1 pl-1 text-white"><b>{{$item->product_size}} ML</b></span>
                                                            </div>
                                                            @if (isset($item->ProductSetting))
                                                                @if ($total_diskon > 0)
                                                                    <div class="top-right border border-danger bg-danger rounded-top">
                                                                        <span class="pt-1 pr-1 pl-1 text-white"><b>Disc {{$total_diskon}}%</b></span>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endfor
                                            @if ($total_image_not_null == 0)
                                                <div class="carousel-item active">
                                                    <img class="card-img-top image-resize" alt="" 
                                                        src="{{ asset('images/imagenotfound.jpg')}}"
                                                        data-holder-rendered="true" onclick="detail('{{$item->product_id}}')" style="cursor: pointer;">
                                                    <div class="d-flex align-items-start flex-column">
                                                        <div class="top-left border border-primary bg-primary rounded-top">
                                                            <span class="pt-1 pr-1 pl-1 text-white"><b>{{$item->product_size}} ML</b></span>
                                                        </div>
                                                        @if (isset($item->ProductSetting))
                                                            @if ($total_diskon > 0)
                                                                <div class="top-right border border-danger bg-danger rounded-top">
                                                                    <span class="pt-1 pr-1 pl-1 text-white"><b>Disc {{$total_diskon}}%</b></span>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <a class="carousel-control-prev" href="#carousel-controls-{{$item->product_id}}" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carousel-controls-{{$item->product_id}}" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="short-text"><b>{{$item->product_name}}</b></div>
                                                <div class="text-muted">
                                                    <b> 
                                                        @if (isset($item->ProductSetting))
                                                            @if ($total_diskon == 0 ) 
                                                                Rp.{{number_format($item->product_price_koperasi,2,",",".") }}
                                                            @else
                                                                @php
                                                                    $harga_diskon = ($item->product_price_koperasi / 100) * $total_diskon;
                                                                    $total_harga = $item->product_price_koperasi - $harga_diskon;
                                                                @endphp
                                                                <strike>
                                                                    Rp.{{number_format($item->product_price_koperasi,2,",",".") }}
                                                                </strike>
                                                                Rp.{{number_format($total_harga,2,",",".") }}
                                                            @endif
                                                        @else
                                                        Rp.{{number_format($item->product_price_koperasi,2,",",".") }}
                                                        @endif
                                                        
                                                    </b>
                                                </div>
                                            </div>
                                            <div class="ml-auto">
                                                <button style="cursor: pointer;" class="btn btn-sm btn-warning" onclick="addCart('{{$item->product_id}}')">
                                                    <span class="fa fa-cart-plus mr-1"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="d-flex justify-content-center">
                                <h3>Product Not Found . . .</h3>
                            </div>
                        @endforelse
                        
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-start"">
                            Showing {{($product->currentpage()-1)*$product->perpage()+1}} to {{$product->currentpage()*$product->perpage()}} of  {{$product->total()}} entries
                        </div>
                        <div class="col d-flex justify-content-end">
                            {{ $product->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail-->
    <div class="modal modal-blur fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Product</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card shadow-lg bg-white rounded">
                            <div class="row row-0">
                                <div class="col">
                                    <div id="carousel-controls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner modal-carousel">
                                            
                                        </div>
                                        <a class="carousel-control-prev" href="#carousel-controls" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carousel-controls" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card-body">
                                        <h1 class="card-title" id="brand_name"></h1>
                                        <h2 class="card-title" id="product_name"></h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam deleniti
                                            fugit incidunt, iste, itaque minima
                                            neque pariatur perferendis sed suscipit velit vitae voluptatem.</p>
                                        
                                    </div>
                                    <div class="card-footer">
                                        <button style="cursor: pointer;" class="btn btn-warning" id="addCartDetail">
                                            <span class="fa fa-cart-plus"></span>
                                            Add Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('footer')
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <script>
        $(window).on('load', function () {
            // setTimeout(function () {
                $('.se-pre-con').fadeOut()
            // }, 2000)
        })

        const Helper = new valbon()
        
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $(document).ready(function () {
            let carousel = $('.skeleton-image');
            for (let index = 0; index < carousel.length; index++) {
                let element = carousel[index]
                let contentCarousel = $(element)
                let selector = $(`.carousel-controls-${contentCarousel.data('code')}-${contentCarousel.data('increment')}`);
                var img = $('<img/>').attr('src', `https://api-star.wipro-unza.co.id/api/v1/product/${contentCarousel.data('code')}/image/${contentCarousel.data('increment')}`)
                .on('load', function() {
                    if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
                        selector.attr('src',"{{asset('images/imagenotfound.jpg')}}")
                    } else {
                        selector.removeClass('skeleton-image')
                        selector.attr('src',`https://api-star.wipro-unza.co.id/api/v1/product/${contentCarousel.data('code')}/image/${contentCarousel.data('increment')}`)
                    }
                });
            }
        });
        
        detail = (id) => {
            $.ajax({
                type : "get",
                url : "{{url('koperasi/product')}}/" + id + "/edit",
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success : (response) => {
                    let data = response.data;
                    $('.modal-carousel').empty();
                    $('#product_name').text(data.brand_name+' - '+data.product_name);
                    let total_image_null = 0;
                    for (let index = 1; index <= 4; index++) {
                        let product_image = "product_image_"+index
                        if (data[product_image] != null) {
                            total_image_null = total_image_null + 1;
                            let item_modal = `  <div class="carousel-item ${product_image} item-modal ${total_image_null == 1 ? "active" : ""}">
                                                    <img class="card-img-top image-resize" alt=""
                                                        id="${product_image}"
                                                        data-holder-rendered="true"
                                                    >
                                                </div>`;
                            $('.modal-carousel').append(item_modal)
                            $(`#${product_image}`).attr('src',`https://api-star.wipro-unza.co.id/api/v1/product/${data.product_code}/image/${index}`)
                        }
                    }
                    if (total_image_null == 0 ) {
                        let item_modal = `  <div class="carousel-item item-modal">
                                                <img class="card-img-top image-resize" alt=""
                                                src="{{asset('images/imagenotfound.jpg')}}"
                                                data-holder-rendered="true"
                                                >
                                            </div>`;
                        $('.modal-carousel').append(item_modal)
                    }
                    $('#addCartDetail').attr('onclick',`addCart('${id}')`)
                },
                complete:()=>{
                    $('.se-pre-con').hide();
                    $('#modal').modal('show');
                }
            })
        }

        addCart = (id) => {
            $.ajax({
                type : "post",
                url : "{{url('koperasi/product')}}",
                data : {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id : id
                },
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success : (response) => {
                    Helper.sweetSuccess(response.message,response.data.message);
                    CountCart();
                },
                error : (res) => {
                    Helper.errorHandle(res);
                },
                complete:()=>{
                    $('.se-pre-con').hide();
                }
            })
        }
    </script>
@endsection