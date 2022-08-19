@extends('ticketing/master/master')
@section('title','Dashboard')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
    <style>
        .badge-primary
        {
            color: white;
            background-color: #5e72e4;
        }
        .badge-primary[href]:hover,
        .badge-primary[href]:focus
        {
            text-decoration: none;

            color: #fff;
            background-color: #5e72e4;
        }

        .badge-yellow {
            color: black;
            background-color: #fcfc03;
        }

        a.badge-yellow:hover,
        a.badge-yellow:focus {
            color: black;
            background-color: #fcfc03;
        }

        a.badge-yellow:focus,
        a.badge-yellow.focus {
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(205, 226, 16, 0.815);
        }

        .btn-yellow {
            color: black;
            border-color: #fcfc03;
            background-color: #fcfc03;
        }
    </style>
@endsection

@section('navigation')
    <div class="header">
        <div class="container-fluid mt-1">
            <div class="header-body">
                <div class="row ">
                    <div class="col-lg mt-2">
                        <div class="">
                            <h6 class="h2 d-inline-block mb-0">Dashboard</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links">
                                
                            <li class="breadcrumb-item"><a href="http://wiproites.dev.com/ticketing"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li></ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group  d-flex justify-content-end">
                                    <label class="col-form-label d-flex justify-content-end mr-2">Period</label>
                                    <select name="period_id" id="period_id" class="form-control select2-hide-search" style="width: 100%;" onchange="getData();getDataChart();">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md" id="department_search" hidden>
                                <div class="form-group  d-flex justify-content-end" >
                                    <label class="col-form-label d-flex justify-content-end mr-2">Department</label>
                                    <select name="department_id" id="department_id" class="form-control select2-hide-search" style="width: 100%;" onchange="getData();getDataChart();">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card" onclick="showDetail('initial')" style="cursor: pointer;">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Ticketing <br> Initial</p>
                            <h5 class="font-weight-bolder" id="ticketing_initial"></h5>
                            <p class="mb-0">
                                <h2 class="text-success text-sm font-weight-bolder" id="ticketing_initial_value"></h2>
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle ">
                            <i class="fas fa-solid fa-file-circle-plus" style="color:white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card" onclick="showDetail('process')" style="cursor: pointer;">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Ticketing <br> Process</p>
                            <h5 class="font-weight-bolder" id="ticketing_process"></h5>
                            <p class="mb-0">
                                <h2 class="text-success text-sm font-weight-bolder" id="ticketing_process_value"></h2>
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                            <i class="fas fa-solid fa-file-circle-check" style="color:white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card" onclick="showDetail('approve')" style="cursor: pointer;">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Ticketing <br> Approve</p>
                            <h5 class="font-weight-bolder" id="ticketing_approve"></h5>
                            <p class="mb-0">
                                <h2 class="text-danger text-sm font-weight-bolder" id="ticketing_approve_value"></h2>
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="fas fa-solid fa-file-circle-check" style="color:white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card" onclick="showDetail('done')" style="cursor: pointer;">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Ticketing <br> Done</p>
                            <h5 class="font-weight-bolder" id="ticketing_done"></h5>
                            <p class="mb-0">
                                <h2 class="text-success text-sm font-weight-bolder" id="ticketing_done_value"></h2> 
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                            <i class="fas fa-solid fa-file-circle-check" style="color:white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl">
        <div class="card shadow rounded">
            <div class="card-header"><b>Analytics</b></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ticket By Status</h4>
                            </div>
                            <div class="card-body">
                                <div id="ticket-chartdonut" class="d-flex justify-content-center height-400"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ticket By Department</h4>
                            </div>
                            <div class="card-body">
                                <div id="ticket-barchart" class="d-flex justify-content-center height-400"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modal" role="dialog" >
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="fa fa-window-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body modal-body-offering">
                <table class="table table-bordered" id="table" width="100%">
                    <thead>
                        <tr>
                            <td><b>#</b></td>
                            <td><b>Ticket ID</b></td>
                            <td><b>Ticket Type</b></td>
                            <td><b>Ticket Status</b></td>
                            <td><b>Date Ticket</b></td>
                            <td><b>Last Approve</b></td>
                            <td><b><center>Action</center></b></td>
                        </tr>
                    </thead>
                    <tbody id="offering-view">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    <script src="{{asset('assets_tabler/dist/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            getSelection()
                .then((res) => {
                    if (chekNik() == true) {
                        $('#department_search').attr('hidden',false);
                        getDepartment();
                    }
                    getData();
                    getDataChart();
                })
                .catch((res) => {
                    console.log(res)
                });
        });

        const data = {
            url: "{{url('ticketing/dashboard/data')}}"
        }

        const Helper = new valbon(data);

        getData = () => {
            let department = null;
            if ($('#department_id').val() != null) {
                department = $('#department_id').val();
            }
            let result = chekNik();
            let type = result == true ? 'admin' : 'user';
            $.ajax({
                type: "get",
                url: data.url,
                data: {
                    type: type,
                    period_id: $('#period_id').val(),
                    department_id : department,
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    let words = type == 'admin' ? 'All Department' : 'By Department';
                    let datares = res.data.result;
                    $('#ticketing_process').text(words);
                    $('#ticketing_initial').text(words);
                    $('#ticketing_approve').text(words);
                    $('#ticketing_done').text(words);
                    $('#ticketing_process_value').text(datares.process);
                    $('#ticketing_initial_value').text(datares.initial);
                    $('#ticketing_approve_value').text(datares.approve);
                    $('#ticketing_done_value').text(datares.done);

                },
                error: (response) => {
                    this.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })

        }

        showDetail = (status) => {
            let department = null;
            if ($('#department_id').val() != null) {
                department = $('#department_id').val();
            }
            let result = chekNik();
            let type = result == true ? 'admin' : 'user';
            $('#title-modal').text(`TICKETING REQUEST ${status.toUpperCase()}`);
            var table = $(`#table`).DataTable({
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
                ajax: {
                    url: data.url + '/table',
                    data: {
                        type: type,
                        status: status,
                        period_id: $('#period_id').val(),
                        department_id : department
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "ticket_id",
                        name: "ticket_id"
                    },
                    {
                        data: "type.type_name",
                        name: "type.type_name"
                    },
                    {
                        data: "ticket_status",
                        name: "ticket_status",
                        render : (data) => {
                            return `
                                    <center>
                                        <span class="badge badge-${chooseColorStatus(data)} .text-dark">${Helper.capitalizeFirstWords(data)}</span>
                                    </center>
                                    `
                        }
                    },
                    {
                        data: "request_by.user_name",
                        name: "request_by.user_name",
                        render: (data, meta, row) => {
                            return data + "<br>" + row.created_at;
                        }
                    },
                    {
                        data:"ticket_id",
                        name:"ticket_id",
                        render: function(data, type, row, meta) {
                            let last_approve = getLastApprove(row)
                            if (last_approve != '') {
                                return `${last_approve} <br> ${row.approval.updated_at}`;
                            }else{
                                return ' - ';
                            }
                        }
                    },
                    {
                        data: "ticket_id",
                        name: "ticket_id",
                        render: (data) => {
                            return `<center>
                                            <span class="btn btn-primary" id="button-download" onclick="downloadPDF('${data}')">
                                                <i class="ni ni-cloud-download-95"></i>
                                            </span>
                                        </center>`;
                        }
                    }
                ],
            });
            $('#modal').modal('show');
        }

        downloadPDF = (id) => {
            window.open("{{url('ticketing/downloadByIdPDF')}}/" + Helper.backTomin(id), '_blank');
        }

        getSelection = () => {
            return Promise.resolve(
                $.ajax({
                    type: "get",
                    url: "{{url('/getall/plugin/period/active')}}",
                    beforeSend: () => {
                        $('.se-pre-con').show();
                    },
                    success: (res) => {
                        let data = res.data;
                        let x = 1;
                        let option = ''
                        for (let index = 0; index < data.length; index++) {
                            let condition = x == data.length ? 'selected' : '';
                            option += `<option value="${data[index].period_id}" ${condition}>${data[index].period_name}</option>`;
                            x++;
                        }
                        $('#period_id').append(option)
                    },
                    error: (response) => {
                        Helper.errorHandle(response);
                    },
                    complete: () => {
                        $('.se-pre-con').hide();
                    }
                })
            )
        }

        getDepartment = () => {
            $.ajax({
                type : "get",
                url : "{{ url('getAll/departement') }}",
                success : (res) => {
                    let data = res.data;
                    let option = `<option value="">ALL</option>`
                    data.forEach(item => {
                        option += `<option value="${item.department_id}">${item.department_name}</option>`
                    });
                    $('#department_id').append(option);
                }
            })
        }

        chekNik = () => {
            let array_admin = JSON.parse(JSON.stringify({{\Helper::instance()->checkNIK()}}));
            let nik = "{{Auth::user()->user_nik}}";
            if (array_admin.includes(parseInt(nik))) {
                return true;
            } else {
                return false;
            }
        }

        getDataChart = () => {
            let department = null;
            if ($('#department_id').val() != null) {
                department = $('#department_id').val();
            }
            let result = chekNik();
            let type = result == true ? 'admin' : 'user';
            $.ajax({
                type: "GET",
                url: data.url + '/chart',
                data: {
                    type: type,
                    period_id: $('#period_id').val(),
                    department_id : department
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    let result = res.data.result;
                    donutChart(result.donutChart);
                    barChart(result.barChart);
                },
                error: (response) => {
                    this.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        donutChart = (data) => {
            $('#ticket-chartdonut').empty();
            window.ApexCharts && (new ApexCharts(document.getElementById('ticket-chartdonut'), {
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
                series: createArray(data, 'total'),
                labels: createArray(data, 'name'),
                grid: {
                    strokeDashArray: 4,
                },
                colors: [
                    '#2dcec0',
                    '#fb7240',
                    '#f53f53'
                ],
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
                                    label: 'Approve',
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

        barChart = (data) => {
            $('#ticket-barchart').empty();
            window.ApexCharts && (new ApexCharts(document.getElementById('ticket-barchart'), {
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
                    data: createArray(data, 'total')
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
                    categories: createArray(data, 'name'),
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

        createArray = (data, key) => {
            let newKey = key.split('.')
            let array = []
            data.forEach(item => {
                if (newKey.length > 1) {
                    let object = item[newKey[0]]
                    array.push(object[newKey[1]]);
                } else {
                    array.push(item[newKey]);
                }
            });
            return array
        } 

        function getLastApprove(row) {
            let last_approve = '';
            for (let index = 1; index <= 8; index++) {
                let approval_nik = 'ticketing_approval_nik';
                let object_name = `approval`; //relationshipmodel
                let relation = 'ticketing_approval';
                let string = "";
                if (index == 7) {
                    string = 'it1';
                }else if (index == 8) {
                    string = 'it2';
                }else{
                    string = index
                }

                approval_nik += `_${string}`
                relation += `${string}`
                if (row[object_name] != null && row[object_name][approval_nik] != null && row[object_name][approval_nik + '_date'] != null) {
                    last_approve = `${row[object_name][approval_nik]} - ${row[object_name][relation]['user_name']}` 
                }
            }
            return last_approve;
        }

        chooseColorStatus = (ticket_status) => {
            if (ticket_status == 'initial' ) {
                return 'primary';
            }else if(ticket_status == 'process'){
                return 'info';
            }else if(ticket_status == 'approve'){
                return 'yellow';
            }else if(ticket_status == 'done'){
                return 'success';
            }else if(ticket_status == 'reject'){
                return 'danger';
            }else if(ticket_status == 'cancel'){
                return 'warning';
            }
        }
    </script>
@endsection