@extends('training/master/master')
@section('title','Dashboard')
<style type="text/css">
	/* .top-count {
		flex: 0 0 20%;
		max-width: 20%;
		position: relative;
		width: 100%;
		padding-right: 10px;
		padding-left: 10px;
	} */
</style>
@section('content')
    <!-- ============================================================== -->
	<!-- Bread crumb -->
	<!-- ============================================================== -->
	<div class="content-header row">
	    <div class="content-header-left col-md-9 col-12 mb-2">
	        <div class="row breadcrumbs-top">
	            <div class="col-12">
	                <h2 class="content-header-title float-left mb-0">Dashboard</h2>
	                <div class="breadcrumb-wrapper col-12">
	                    <ol class="breadcrumb">
	                        <li class="breadcrumb-item active">Dashboard</li>
	                    </ol>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="content-header-right col-md-3 col-12 d-md-block d-none">
	        <div class="form-group row">
	        	<label class="col-form-label col-4">Period</label>
	        	<div class="col-8">
	        		<select name="period_id" id="period_id" class="form-control select2-hide-search" style="width: 100%;" onchange="getAllDataDashboard()">
	                    {{-- @foreach($period_all as $p)
	                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
	                    @endforeach --}}
	                </select>
	        	</div>
	        </div>
	    </div>
	</div>
	<!-- ============================================================== -->
	<!-- End Bread crumb -->
    <!-- ============================================================== -->
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-2">
                <div class="card" onclick="showDetail('training_request')" style="cursor: pointer;">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 class="text-bold-700 mb-0 training-request">0</h2>
                            <p>Training<br>Request</p>
                        </div>
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-user-plus text-primary font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card" onclick="showDetail('training_in_progress')" style="cursor: pointer;">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 class="text-bold-700 mb-0 training-approval">0</h2>
                            <p>Waiting for<br> Approval</p>
                        </div>
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-refresh-ccw text-warning font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card" onclick="showDetail('training_reject')" style="cursor: pointer;">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 class="text-bold-700 mb-0 training-reject-cancel">0</h2>
                            <p>Cancel /<br>Reject</p>
                        </div>
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-user-x text-danger font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card" onclick="showDetail('training_approve')" style="cursor: pointer;">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 class="text-bold-700 mb-0 training-approve">0</h2>
                            <p>Training<br>Approve</p>
                        </div>
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-check-circle text-success font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card" onclick="showDetail('training_feedback')" style="cursor: pointer;">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 class="text-bold-700 mb-0 training-feedback">0</h2>
                            <p>Training <br> Feedback</p>
                        </div>
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-refresh-ccw text-warning font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card" onclick="showDetail('training_feedback_complete')" style="cursor: pointer;">
                    <div class="card-header d-flex align-items-start pb-0">
                        <div>
                            <h2 class="text-bold-700 mb-0 training-complete">0</h2>
                            <p>Feedback<br>Completed</p>
                        </div>
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-check-circle text-success font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Training Participant By Level</h4>
                    </div>
                    <div class="card-body">
                        <div id="request-level" class="height-400"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Training Participant By Department</h4>
                    </div>
                    <div class="card-body">
                        <div id="request-department" class="d-flex justify-content-center height-400"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Training Category</h4>
                    </div>
                    <div class="card-body ">
                        <div id="request-category" class="d-flex justify-content-center height-400"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal View Detail Training --}}
        <div class="modal fade text-left" data-backdrop="static" data-keyboard="false" id="modal" role="dialog" >
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info" onclick="remind()" id="remind" hidden>Remind</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const data = {
            id_name : "training_request_id",
            create : {
                url:"{{url('training/remind/feedback')}}",
                method : "post",
            }
        }

        const Helper = new valbon (data);

        $(document).ready(function () {
            getSelection()
            .then((res)=>{
                getAllDataDashboard()
            })
            .catch((res)=>{
                getSelection()
            });
        });

        getSelection = () => {
            return Promise.resolve(
                $.ajax({
                    type:"get",
                    url: "{{url('/getall/plugin/period/active')}}",
                    beforeSend:() =>{
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
            let period_id = $('#period_id').val();
            $.ajax({
                type:"get",
                url:"{{url('training/data-dashboard')}}/"+period_id,
                success:(res) => {
                    let data = res.data.data
                    showInformation(data.information);
                    showInformationLevel(data.information_level);
                    showInformationDept(data.information_piechart);
                    showInformtationCategory(data.information_piechart);
                }
            })
        }

        showInformation = (data) => {
            $('.training-request').text(data.training_request);
            $('.training-approval').text(data.waiting_approval);
            $('.training-feedback').text(data.feedback);
            $('.training-reject-cancel').text(data.reject_cancel);
            $('.training-approve').text(data.approve);
            $('.training-complete').text(data.complete);
        }

        showInformationLevel = (data) => {
            var barChart = echarts.init(document.getElementById('request-level'));

            var barChartoption = {
                legend : {},
                tooltip : {},
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis : {
                    type : 'category',
                    data : createArray(data,'level'),
                    splitLine : { show : false },
                },
                yAxis : {},
                series : [
                    {
                        name : 'Request By Level',
                        type : 'bar',
                        itemStyle : { color : '#4ea397' },
                        data : createArray(data,'total')
                    }
                ]
            };

            barChart.setOption(barChartoption);
        }

        showInformationDept = (data) => {
            var color = [
                '#ff8100', // Finance & Accounting
                '#22ff00', // HR & GA
                '#f0ff00', // IT
                '#001737', // Manufacturing
                '#0011ff', // Marketing
                '#06ab00', // R & D
                '#ff0000', // Sales
                '#00b8ff' // Skin Care
            ];

            var pieChart = echarts.init(document.getElementById('request-department'));

            var pieChartoption = {
                tooltip : {
                    trigger: 'item',
                    formatter: "{b} : {c} ({d}%)"
                },
                series : [
                    {
                        name: 'Training By Department',
                        type: 'pie',
                        radius : '60%',
                        center: ['50%', '50%'],
                        color: color,
                        data: data.department,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ],
            };

            pieChart.setOption(pieChartoption);
        }

        showInformtationCategory = (data) => {
            var color = [
                '#3483eb', //biru 
                '#eb8934', //orange
                '#eb3434', //merah
            ];

            var pieChart = echarts.init(document.getElementById('request-category'));

            var pieChartoption = {
                tooltip : {
                    trigger: 'item',
                    formatter: "{b} : {c} ({d}%)"
                },
                series : [
                    {
                        name: 'Training By Category',
                        type: 'pie',
                        radius : '60%',
                        center: ['50%', '50%'],
                        color: color,
                        data: data.category,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ],
            };

            pieChart.setOption(pieChartoption);
        }

        showDetail = (type) => {
            if (Helper.chekNik('{{Auth::user()->user_nik}}')) {
                let period_id = $('#period_id').val();
                $('#remind').attr('hidden',true)
                $('.modal-body').empty().promise().done(() => {
                    if (type == 'training_feedback') {
                        $('.modal-title').text('Participant Not Give Feedback');
                        $('#remind').attr('hidden',false)
                        TrainingFeedback(type,period_id);
                    }else if(type == 'training_request'){
                        $('.modal-title').text('Training Request');
                        TrainingRequest(type,period_id);
                    }else if(type == 'training_in_progress'){
                        $('.modal-title').text('Training Waiting Approval');
                        TrainingInProgress(type,period_id);
                    }else if(type == 'training_reject'){
                        $('.modal-title').text('Training Reject / Cancel');
                        TrainingReject(type,period_id);
                    }else if(type == 'training_approve'){
                        $('.modal-title').text('Training Approve');
                        TrainingApprove(type,period_id);
                    }else if(type == 'training_feedback_complete'){
                        $('.modal-title').text('Participant Give Feedback');
                        TrainingFeedBackComplete(type,period_id);
                    }
                })
                
                $('#modal').modal('show');
            }
        }

        TrainingFeedback = (type,period_id) => {
            let body = selectTable(type);
            $('.modal-body').append(body).promise().done(()=>{
                $('#table').DataTable({
                    destroy:true,
                    ajax: "{{url('training/participant-need-feedback')}}/" + period_id,
                    columns: [
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "training.training_topic",
                            name: "training.training_topic"
                        },
                        {
                            data: "user.user_name",
                            name: "user.user_name",
                            render:(data,meta,row) => {
                                return row.user.user_nik+' - '+data;
                            }
                        },
                        {
                            data: "user.department.department_name",
                            name: "user.department.department_name",
                        }
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            render: function(data, type, row, meta){
                                if(type === 'display'){
                                    data = `<div class="checkbox">
                                                <input type="checkbox" class="dt-checkboxes" name="user_remind[]" value="${row.user.user_nik}-${row.training_id}">
                                                <label></label>
                                            </div>`;
                                }

                                return data;
                            },
                            checkboxes: {
                                selectRow: true,
                                selectAllRender: `<div class="checkbox">
                                                        <input type="checkbox" class="dt-checkboxes">
                                                        <label></label>
                                                    </div>`
                            }
                        }
                    ],
                    select: 'multi',
                    order: [[1, 'asc']]
                });
            })
        }

        TrainingFeedBackComplete = (type,period_id) => {
            let body = selectTable(type);
            $('.modal-body').append(body).promise().done(()=>{
                $('#table').DataTable({
                    destroy:true,
                    ajax: "{{url('training/participant-feedback')}}/" + period_id,
                    columns: [
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "training.training_topic",
                            name: "training.training_topic"
                        },
                        {
                            data: "user.user_name",
                            name: "user.user_name",
                            render:(data,meta,row) => {
                                return row.user.user_nik+' - '+data;
                            }
                        },
                        {
                            data: "user.department.department_name",
                            name: "user.department.department_name",
                        }
                    ],
                });
            })
        }

        TrainingRequest = (type,period_id) => {
            let body = selectTable(type);
            $('.modal-body').append(body).promise().done(()=>{
                $('#table').DataTable({
                    destroy:true,
                    ajax: "{{url('training/all')}}/"+period_id,
                    columns: [
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "training_topic",
                            name: "training_topic"
                        },
                        {
                            data: "training_participants",
                            name: "training_participants",
                        },
                        {
                            data: "training_start_date",
                            name: "training_start_date",
                        },
                        {
                            data: "training_end_date",
                            name: "training_end_date",
                        },
                        {
                            data: "training_approval.training_status",
                            name: "training_approval.training_status",
                            render: (data) => {
                                if (data == 'in_progress') {
                                    return 'in progress'
                                } else {
                                    return data
                                }
                            }
                        }
                    ],
                })
            });
        }

        TrainingInProgress = (type,period_id) => {
            let body = selectTable(type);
            $('.modal-body').append(body).promise().done(()=>{
                $('#table').DataTable({
                    destroy:true,
                    ajax: {
                        url :"{{url('training/status/data')}}",
                        data:{
                            training_status : 'in_progress'
                        },
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "training_topic",
                            name: "training_topic"
                        },
                        {
                            data: "training_participants",
                            name: "training_participants",
                        },
                        {
                            data: "training_start_date",
                            name: "training_start_date",
                        },
                        {
                            data: "training_end_date",
                            name: "training_end_date",
                        },
                        {
                            data: "training_approval.training_status",
                            name: "training_approval.training_status",
                            render: (data) => {
                                if (data == 'in_progress') {
                                    return 'in progress'
                                } else {
                                    return data
                                }
                            }
                        }
                    ],
                })
            });
        }

        TrainingReject = (type,period_id) => {
            let body = selectTable(type);
            $('.modal-body').append(body).promise().done(()=>{
                $('#table').DataTable({
                    destroy:true,
                    ajax: {
                        url : "{{url('training/status/data/uproceed')}}",
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "training_topic",
                            name: "training_topic"
                        },
                        {
                            data: "training_participants",
                            name: "training_participants",
                        },
                        {
                            data: "training_start_date",
                            name: "training_start_date",
                        },
                        {
                            data: "training_end_date",
                            name: "training_end_date",
                        },
                        {
                            data: "training_approval.training_status",
                            name: "training_approval.training_status",
                            render: (data) => {
                                if (data == 'in_progress') {
                                    return 'in progress'
                                } else {
                                    return data
                                }
                            }
                        }
                    ],
                })
            });
        }

        TrainingApprove = (type,period_id) => {
            let body = selectTable(type);
            $('.modal-body').append(body).promise().done(()=>{
                $('#table').DataTable({
                    destroy:true,
                    serverSide: true,
                    ajax: {
                        url :"{{url('training/status/data')}}",
                        data:{
                            training_status : 'approve'
                        },
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "training_topic",
                            name: "training_topic"
                        },
                        {
                            data: "training_participants",
                            name: "training_participants",
                        },
                        {
                            data: "training_start_date",
                            name: "training_start_date",
                        },
                        {
                            data: "training_end_date",
                            name: "training_end_date",
                        },
                        {
                            data: "training_approval.training_status",
                            name: "training_approval.training_status",
                            render: (data) => {
                                if (data == 'in_progress') {
                                    return 'in progress'
                                } else {
                                    return data
                                }
                            }
                        }
                    ],
                })
            });
        }

        selectTable = (type) => {
            if (type == 'training_feedback') {
                return `<form id="form">
                            @csrf
                            <table class="table table-bordered table-striped" id="table" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Topic</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Topic</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>`;
            }else if(type == 'training_feedback_complete'){
                return `<table class="table table-bordered table-striped" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Topic</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Topic</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                </tr>
                            </tfoot>
                        </table>`;
            }else{
                return `<table class="table table-bordered table-striped" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Training Topic</th>
                                    <th>Participant</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Training Topic</th>
                                    <th>Participant</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>`;
            }
        }

        remind = () => {
            Helper.insert();
        }

        createArray = (data,key) => {
            let array = []
            data.forEach(item => {
                array.push(item[key]);
            });
            return array
        }
    </script>
@endsection
