@extends('koperasi/master/master')
@section('title','Management Order Limit')
@section('breadcumb','Dashboard')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_tabler/dist/libs/datatables/datatables.min.css')}}"/>
    <style>
        .image-banner {
            height: 150px; 
            width: auto; 
            max-width: auto; 
            max-height: 150px;
            display: block;
            margin: 0 auto;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-header d-print-none pt-3">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Dashboard
                </h2>
                <div class="text-muted mt-1">Koperasi</div>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ml-auto">
                <div class="d-flex">
                    <div class="mr-3">
                        <div class="form-group row">
                            <label class="col-form-label col-4">Years</label>
                            <div class="col-8">
                                <select name="year_name" id="year_name" class="form-control select2bs4" style="width: 100%;" onchange="getAllDataDashboard()">
                                    {{-- @foreach($period_all as $p)
                                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mr-3">
                        <div class="form-group row">
                            <label class="col-form-label col-4">Month</label>
                            <div class="col-8">
                                <select name="month_name" id="month_name" class="form-control select2bs4" style="width: 100%;" onchange="getAllDataDashboard()">
                                    {{-- @foreach($period_all as $p)
                                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">News</h3>
                </div>
                <div class="card-body">
                    <div id="carousel-captions" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @for ($i = 0; $i < count($banner); $i++)
                                <div class="carousel-item {{$i == 0 ? "active" : ""}}">
                                    <img class="d-block w-100 image-banner" alt="" 
                                        src="{{asset('file_uploads/images/koperasi/banner')."/".$banner[$i]->banner_image}}"
                                        data-holder-rendered="true">
                                    <div class="carousel-item-background d-none d-md-block"></div>
                                    {{-- <div class="carousel-caption d-none d-md-block">
                                        <h3>Slide label</h3>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                    </div> --}}
                                </div>
                            @endfor
                        </div>
                        <a class="carousel-control-prev" href="#carousel-captions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-captions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-4">
            <div class="card" style="cursor: pointer;">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2><i class="fa fa-trophy"></i> Top Spender M-2 </h2>
                        <h1 class="text-bold-700 top-spender-2">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="cursor: pointer;">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2><i class="fa fa-trophy"></i> Top Spender M-1 </h2>
                        <h1 class="text-bold-700 top-spender-1">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="cursor: pointer;">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2><i class="fa fa-trophy"></i> Top Spender TM </h2>
                        <h1 class="text-bold-700 top-spender-tm">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Koperasi Member</h4>
                </div>
                <div class="card-body">
                    <div id="koperasi-member" class="d-flex justify-content-center height-400"></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Member Order</h4>
                </div>
                <div class="card-body ">
                    <div id="koperasi-order-member" class="d-flex justify-content-center height-400"></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Order Status</h4>
                </div>
                <div class="card-body ">
                    <div id="koperasi-order-status" class="d-flex justify-content-center height-400"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Producut</h4>
                </div>
                <div class="card-body">
                    <div id="most-order" class="height-400">
                        <div style="height: 320px" class="most-order-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Brand</h4>
                </div>
                <div class="card-body">
                    <div id="brand-rank" class="height-400"></div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('footer')
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <script src="{{asset('assets_tabler/dist/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
    <script>
        $(window).on('load', function () {
            firstLoader();
        })

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $(document).ready(function () {
            getSelection()
            .then((res)=>{
                setTimeout(function () {
                    getAllDataDashboard()
                }, 350)
                
            })
            .catch((res)=>{
                getSelection()
            });

        });

        getSelection = () => {
            return Promise.resolve(
                getMonth(),
                getYears()
            )
        }

        getMonth = () => {
            return Promise.resolve(
                $.ajax({
                    type:"get",
                    url: "{{url('/getall/plugin/month')}}",
                    beforeSend:() =>{
                        $('.se-pre-con').show();
                    },
                    success: (res) => {
                        let data = res.data;
                        let date = new Date();
                        let monthName = date.toLocaleString('en-us', { month: 'long' }).toUpperCase();
                        let option = ''
                        for (let index = 0; index < data.length; index++) {
                            let condition = monthName == data[index].month_name ? 'selected' : '';
                            option += `<option value="${data[index].month_name}" ${condition}>${data[index].month_name}</option>`;
                        }
                        $('#month_name').append(option)
                    },
                    error:  (response) => {
                        this.errorHandle(response);
                    },
                    complete : () => {
                        $('.se-pre-con').hide();
                    }
                })
            )
           
        }

        getYears = () => {
            return Promise.resolve(
                $.ajax({
                    type:"get",
                    url: "{{url('/getall/plugin/year/active')}}",
                    beforeSend:() =>{
                        $('.se-pre-con').show();
                    },
                    success: (res) => {
                        let data = res.data;
                        let year = new Date().getFullYear();
                        let option = ''
                        for (let index = 0; index < data.length; index++) {
                            let condition = year == data[index].year_name ? 'selected' : '';
                            option += `<option value="${data[index].year_name}" ${condition}>${data[index].year_name}</option>`;
                        }
                        $('#year_name').append(option)
                    },
                    error:  (response) => {
                        this.errorHandle(response);
                    },
                    complete : () => {
                        $('.se-pre-con').hide();
                    }
                })
            )
        }

        getAllDataDashboard = () => {
            // let period_id = $('#period_id').val();
            $.ajax({
                type:"post",
                url:"{{url('koperasi/data-dashboard')}}",
                data:{
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    year_name : $('#year_name').val(),
                    month_name : $('#month_name').val(),

                },
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success:(res) => {
                    let data = res.data.data
                    showKoperasiMember(data.koperasi_member);
                    showKoperasiOrderMember(data.koperasi_order_member);
                    showKoperasiOrderStatus(data.koperasi_order_status);
                    mostOrder(data.most_order);
                    brandRank(data.brand_rank);
                    topSpenderM2(data.top_spender_m_2)
                    topSpenderM1(data.top_spender_m_1)
                    topSpenderTM(data.top_spender_t_m)
                    // showInformationLevel(data.information_level);
                    // showInformationDept(data.information_piechart);
                    // showInformtationCategory(data.information_piechart);
                },
                complete : () => {
                    
                }
            }).done(()=>{
                $('.se-pre-con').hide();
            })
        }

        topSpenderM2 = (data) => {
            $('.top-spender-2').empty();
            if (data.length >= 1) {
                $('.top-spender-2').text(`${data[0].user_nik}-${data[0].user_name}-${data[0].department_name}`)
            }else{
                $('.top-spender-2').text(`-`)
            }
        }

        topSpenderM1 = (data) => {
            $('.top-spender-1').empty();
            if (data.length >= 1) {
                $('.top-spender-1').text(`${data[0].user_nik}-${data[0].user_name}-${data[0].department_name}`)
            }else{
                $('.top-spender-1').text(`-`)
            }
        }

        topSpenderTM = (data) => {
            $('.top-spender-tm').empty();
            if (data.length >= 1) {
                $('.top-spender-tm').text(`${data[0].user_nik}-${data[0].user_name}-${data[0].department_name}`)
            }else{
                $('.top-spender-tm').text(`-`)
            }
        }

        showKoperasiMember = (data) => {
            $('#koperasi-member').empty()
            window.ApexCharts && (new ApexCharts(document.getElementById('koperasi-member'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 240,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                fill: {
                    opacity: 1,
                },
                series: createArray(data,'total'),
                labels: createArray(data,'name'),
                grid: {
                    strokeDashArray: 4,
                },
                colors: ["#206bc4", "#ff8100"],
                legend: {
                    show: false,
                },
                tooltip: {
                    fillSeriesColor: true
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Member',
                                    formatter: () => {
                                        return `${data[0].total}`
                                    }
                                }
                            }
                        },
                        expandOnClick: true
                    }
                }
            })).render();
        }

        showKoperasiOrderMember = (data) => {
            $('#koperasi-order-member').empty()
            window.ApexCharts && (new ApexCharts(document.getElementById('koperasi-order-member'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 240,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                fill: {
                    opacity: 1,
                },
                series: createArray(data,'total'),
                labels: createArray(data,'name'),
                grid: {
                    strokeDashArray: 4,
                },
                colors: ["#206bc4", "#06ab00"],
                legend: {
                    show: false,
                },
                tooltip: {
                    fillSeriesColor: false
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Member',
                                    formatter: () => {
                                        return `${data[0].total}`
                                    }
                                }
                            }
                        },
                        expandOnClick: true
                    }
                },
            })).render();
        }

        showKoperasiOrderStatus = (data) => {
            $('#koperasi-order-status').empty()
            var color = [
                '#0011ff', 
                '#06ab00', 
                '#ff0000',
                '#00b8ff' 
            ];
            window.ApexCharts && (new ApexCharts(document.getElementById('koperasi-order-status'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 240,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false
                    },
                },
                fill: {
                    opacity: 1,
                },
                series: createArray(data,'total'),
                labels: createArray(data,'name'),
                grid: {
                    strokeDashArray: 4,
                },
                colors: color,
                legend: {
                    show: false,
                },
                tooltip: {
                    fillSeriesColor: false
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Done',
                                    formatter: () => {
                                        return `${data[1].total}`;
                                    }
                                }
                            }
                        },
                        expandOnClick: true
                    }
                },
            })).render();
        }

        mostOrder = (data) => {
            $('.most-order-body').empty();
            for (let index = 0; index < data.length; index++) {
                $('.most-order-body').append(`<h2><span class="fas fa-award">${index + 1}.</span> ${data[index].product.product_name} - ${data[index].product.product_code}</h2>`)
            }
        }

        brandRank = (data) => {
            window.ApexCharts && (new ApexCharts(document.getElementById('brand-rank'), {
                chart: {
                    type: "bar",
                    fontFamily: 'inherit',
                    height: 320,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: false
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [{
                    name: 'Total',
                    data: createArray(data,'total')
                }],
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    categories: createArray(data,'product.brand_name'),
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                colors: ["#ff8100"],
                legend: {
                    show: false,
                },
            })).render();
        }

        createArray = (data,key) => {
            let newKey = key.split('.')
            let array = []
            data.forEach(item => {
                if (newKey.length > 1) {
                    let object = item[newKey[0]]
                    array.push(object[newKey[1]]);
                }else{
                    array.push(item[newKey]);
                }
            });
            return array
        }
    </script>
@endsection