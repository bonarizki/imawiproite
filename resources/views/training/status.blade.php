@extends('training/master/master')
@section('title','Training Status')
@section('breadcumb','Training Status')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row" id="filter">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col form-group">
                                    <label>Periode</label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Period" id="period_search" name="period_search" >
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label>Training Status</label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Training Status" id="training_status_search" name="training_status_search" >
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard ">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-center" data-toggle="tab" href="#proceed" aria-controls="proceed" role="tab" aria-selected="true" onclick="getData('proceed');clearFilter();TrainingStatusFilter('proceed')">Proceed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="service-tab-center" data-toggle="tab" href="#service-center" aria-controls="service-center" role="tab" aria-selected="false" onclick="getData('unproceed');clearFilter();TrainingStatusFilter('unproceed')">Unproceed</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane table-responsive active" id="proceed" aria-labelledby="home-tab-center" role="tabpanel" >
                                <table class="table table-striped table-bordered table-hover table-sm" id="table-proceed" width="100%">
                                    <thead>
                                        <tr>
                                            <th style=" width: 5px !important;">#</th>
                                            <th style=" width: 55px !important;">Training ID</th>
                                            <th style=" width: 55px !important;">Training Topic</th>
                                            <th style=" width: 55px !important;">Participant</th>
                                            <th style=" width: 55px !important;">Training Fee</th>
                                            <th style=" width: 80px !important;">Start Date</th>
                                            <th style=" width: 80px !important;">End Date</th>
                                            <th style=" width: 10px !important;">Status</th>
                                            <th style=" width: 15px !important;">View</th>
                                            <th style=" width: 15px !important;">Cancel</th>
                                            <th style=" width: 15px !important;">Edit</th>
                                            <th style=" width: 15px !important;">Download</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style=" width: 5px !important;">#</th>
                                            <th style=" width: 55px !important;">Training ID</th>
                                            <th style=" width: 55px !important;">Training Topic</th>
                                            <th style=" width: 55px !important;">Participant</th>
                                            <th style=" width: 55px !important;">Training Fee</th>
                                            <th style=" width: 80px !important;">Start Date</th>
                                            <th style=" width: 80px !important;">End Date</th>
                                            <th style=" width: 10px !important;">Status</th>
                                            <th style=" width: 15px !important;">View</th>
                                            <th style=" width: 15px !important;">Cancel</th>
                                            <th style=" width: 15px !important;">Edit</th>
                                            <th style=" width: 15px !important;">Download</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane table-responsive" id="service-center" aria-labelledby="service-tab-center" role="tabpanel">
                                <table class="table table-striped table-bordered table-hover" id="table-unproceed" width="100%">
                                    <thead>
                                        <tr>
                                            <th style=" width: 5px !important;">#</th>
                                            <th style=" width: 55px !important;">Training ID</th>
                                            <th style=" width: 55px !important;">Training Topic</th>
                                            <th style=" width: 55px !important;">Total Participant</th>
                                            <th style=" width: 55px !important;">Training Fee</th>
                                            <th style=" width: 80px !important;">Start Date</th>
                                            <th style=" width: 80px !important;">End Date</th>
                                            <th style=" width: 10px !important;">Status</th>
                                            <th style=" width: 15px !important;">View</th>
                                            <th style=" width: 15px !important;">Cancel</th>
                                            <th style=" width: 15px !important;">Edit</th>
                                            <th style=" width: 15px !important;">Download</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style=" width: 5px !important;">#</th>
                                            <th style=" width: 55px !important;">Training ID</th>
                                            <th style=" width: 55px !important;">Training Topic</th>
                                            <th style=" width: 55px !important;">Total Participant</th>
                                            <th style=" width: 55px !important;">Training Fee</th>
                                            <th style=" width: 80px !important;">Start Date</th>
                                            <th style=" width: 80px !important;">End Date</th>
                                            <th style=" width: 10px !important;">Status</th>
                                            <th style=" width: 15px !important;">View</th>
                                            <th style=" width: 15px !important;">Cancel</th>
                                            <th style=" width: 15px !important;">Edit</th>
                                            <th style=" width: 15px !important;">Download</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View Detail Training --}}
    <div class="modal fade text-left" data-backdrop="static" data-keyboard="false" id="modal" role="dialog" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal-detail"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" class="form">
                        @csrf
                        <table>
                            <tr>
                                <td>Training Topic</td>
                                <td>:</td>
                                <td id="training_topic"></td>
                            </tr>
                            <tr>
                                <td>Instructor</td>
                                <td>:</td>
                                <td id="vendor_name"></td>
                            </tr>
                            <tr>
                                <td>Training Fee</td>
                                <td>:</td>
                                <td class="training_fee"></td>
                            </tr>
                            <tr>
                                <td>Training Participant</td>
                                <td>:</td>
                                <td id="training_participants"></td>
                            </tr>
                            <tr id="service-bond-master">
                                <td>Service Bond</td>
                                <td>:</td>
                                <td id="service-bond"></td>
                            </tr>
                            <tr>
                                <td>Training Category</td>
                                <td>:</td>
                                <td id="training_category_td"></td>
                            </tr>
                            <tr>
                                <td>Training Date Actual</td>
                                <td>:</td>
                                <td class="training_date_actual"></td>
                            </tr>
                            <tr>
                                <td>Training Hour</td>
                                <td>:</td>
                                <td class="training_hour"></td>
                            </tr>
                            <tr>
                                <td>Meeting Session</td>
                                <td>:</td>
                                <td class="training_total"></td>
                            </tr>
                            <tr>
                                <td>Training Method</td>
                                <td>:</td>
                                <td class="training_method"></td>
                            </tr>
                            <tr>
                                <td class="align-top">Training Purpose</td>
                                <td class="align-top">:</td>
                                <td style="width:500px">
                                    <textarea name="training_purpose" id="training_purpose" rows="3" class="form-control form"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Training Process</td>
                                <td>:</td>
                                <td class="training_process"></td>
                            </tr>
                        </table>
                        <hr>
                        <div class="border border-secondary">
                            <div class="pl-1 pr-1 mt-1 mb-1">
                                <div class="d-flex">
                                    <div class="mr-auto p-2">
                                        <h3>Detail Participants</h3>
                                    </div>
                                    <div class="p-2">
                                        <button type="button" class="btn btn-success btn-md" id="btn-add-participant" hidden onclick="AddParticipant()">
                                            <span class="fa fa-plus"></span>
                                            Add Participant
                                        </button>
                                    </div>
                                </div>
                                
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%"><center>User Nik	</center></th>
                                            <th style="width: 25%"><center>User Name</center></th>
                                            <th style="width: 25%"><center>Department</center></th>
                                            <th style="width: 25%"><center>Cost Training</center></th>
                                            <th style="width: 20%" id="option" hidden><center>Option</center></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-participant">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="border border-secondary">
                            <div class="pl-1 pr-1 mt-1 mb-1">
                                <h3>Detail Approval</h3>
                                <table class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th style="width: 12%"><center>Approval Nik 1</center></th>
                                            <th style="width: 12%"><center>Approval Nik 2</center></th>
                                            <th style="width: 12%"><center>Approval Nik 3</center></th>
                                            <th style="width: 12%"><center>Approval Nik 4</center></th>
                                            <th style="width: 12%"><center>Approval Nik 5</center></th>
                                            <th style="width: 12%"><center>Approval Nik 6</center></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-approval">

                                    </tbody>
                                </table>
                                <table class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th style="width: 12%"><center>Approval CEO</center></th>
                                            <th style="width: 12%"><center>Approval HR</center></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-approval-CEOHR">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <link type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            getData('proceed');
            TrainingStatusFilter('proceed')
            getAllOption();
            setFilterPeriod();
            getParticipant();
            $('.select2bs4').select2({theme:'bootstrap4'});

            (chekNik() == true) 
                ? $('#filter').attr('hidden',false)
                : $('#filter').attr('hidden',true)
        });

        const data = {
            update : {
                url:"{{url('training/request')}}",
                method : "patch"
            },
        }

        const Helper = new valbon(data);

        const ArrParticipant = []; // menampung nama array participant

        getParticipant = () => { // fungsi ini menjalankan ajax untuk mendapatkan data detail user
            let url = '';
            let nik = "{{Auth::user()->user_nik}}";
            chekNik() == true
                ? url = "{{url('training/get-participant-all')}}"
                : url = "{{url('training/get-participant')}}"
            
            $.ajax({
                url: url,
                beforeSend: () => {
                    $('.participant-select').prop("disabled", true)
                },
                success: (res) => {
                    res.forEach(item => {
                        ArrParticipant.push({
                            user_nik:item.user_nik,
                            user_name:item.user_name,
                            department:item.department.department_name
                        });
                    });
                }
            }).done( ()=>{
                calculateFeeParticipant();
            });
        }

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

        TrainingStatusFilter = (type) => {
            $('#training_status_search').empty();
            setFilter(type);
        }

        setFilter = (type) => {
            $('#department_search').attr('onchange', `getData('${type}')`)
            $('#training_status_search').attr('onchange', `getData('${type}')`)
            $('#period_search').attr('onchange', `getData('${type}')`)
            $('#nik_search').attr('onkeyup', `getData('${type}')`)
            $('#nama_search').attr('onkeyup', `getData('${type}')`)
            let optionFilter = '<option value="">Choose</option>';
            if (type == 'proceed') {
                optionFilter += `<option value="in_progress">In Progress</option>
                                 <option value="approve">Approve</option>`;
            } else {
                optionFilter += `<option value="cancel">Cancel</option>
                                <option value="reject">Reject</option>`;
            }
            $('#training_status_search').append(optionFilter);
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

        getData = (type) => {
            let url = getUrl(type);
            var table = $(`#table-${type}`).DataTable({
                processing: true,
                destroy: true,
                language: {
                    'processing': '<div class="se-pre-con"></div>'
                },
                responsive: true,
                ajax: {
                    url: url,
                    data: {
                        "department_id": $('#department_search').val(),
                        "training_status": $('#training_status_search').val(),
                        "period_id": $('#period_search').val(),
                        "user_nik": $('#nik_search').val(),
                        "user_name": $('#nama_search').val()
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "training_id",
                        name: "training_id"
                    },
                    {
                        data: "training_topic",
                        name: "training_topic"
                    },
                    {
                        data: "training_participants",
                        name: "training_participants"
                    },
                    {
                        data: "training_fee",
                        name: "training_fee",
                        render: (data) => {
                            return 'Rp. ' + parseInt(data).toLocaleString();
                        }
                    },
                    {
                        data: "training_start_date",
                        name: "training_start_date"
                    },
                    {
                        data: "training_end_date",
                        name: "training_end_date"
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
                    },
                    {
                        data: "training_id",
                        name: "training_id",
                        render: (data,meta,row) => {
                            return `<center>
                                    <span class="fa fa-eye" title="Detail" data-toggle="tooltip" data-placement="bottom" onclick="detail('${data}','','${type}')">
                                    </span>
                                </center>`;
                            
                        }
                    },
                    {
                        data: "training_id",
                        name: "training_id",
                        render: (data,meta,row) => {
                            let status = row.training_approval.training_status;
                            if (status != 'approve') {
                                return `<center>
                                            <button class="btn btn-sm btn-danger" onclick="CancelTraining('${data}','${type}')">
                                                <span class="fa fa-times-circle" title="Cancel" data-toggle="tooltip" data-placement="bottom">
                                                </span>
                                            </button>
                                        </center>`;
                            }else{
                                return  `<center>
                                            <span class="fa fa-lock"></span>
                                        </center>`;
                            }
                        }
                    },
                    {
                        data: "training_id",
                        name: "training_id",
                        render: (data) => {
                            return `<center>
                                        <button class="btn btn-sm btn-warning" onclick="EditTraining('${data}')">
                                            <span class="fa fa-pencil-square-o" title="Edit" data-toggle="tooltip" data-placement="bottom">
                                            </span>
                                        </button>
                                    </center>`
                        }
                    },
                    {
                        data: "training_id",
                        name: "training_id",
                        render: (data) => {
                            return `<center>
                                        <button type="button" class="btn btn-sm btn-info" id="button-download" onclick="download('${data}')">
                                            <span class="fa fa-file-pdf-o" title="Download" data-toggle="tooltip" data-placement="bottom">
                                            </span>
                                        </button>
                                    </center>`
                        }
                    },
                ],
                columnDefs: [
                    {
                        "targets": [10],
                        "visible": chekNik(),
                        "searchable": false
                    },
                    {
                        "targets": [9,11],
                        "visible": type == 'proceed' ? true : false ,
                        "searchable": false
                    },
                ]
            })
        }

        getUrl = (type) => {
            let url = '';
            if (chekNik() == true) {
                if (type == 'proceed') {
                    url = "{{url('training/status/data')}}";
                } else {
                    url = "{{url('training/status/data/uproceed')}}"
                }
            } else {
                if (type == 'proceed') {
                    url = "{{url('training/status/data/ById')}}";
                } else {
                    url = "{{url('training/status/data/ById/unproceed')}}";
                }
            }
            return url;
        }

        EditTraining = (id) => {

            //mengosongkan training category dari form
            $('#vendor_name').empty().promise().done(()=>{
                createVendorForm()
            })

            //mengosongkan training category dari form
            $('#training_category_td').empty().promise().done(()=>{
                //membuat pilihan category 
                let training_category = `<select id="category_id" name="category_id" class="form-control form">
                                                <option value="">Select Category</option>
                                        </select>
                                        <input type="text" id="training_id" name="training_id" class="form" hidden>
                                        `;

                // append form pilihan category
                $('#training_category_td').append(training_category);
            });

            //mengosongkan training process dari form
            $('.training_process').empty().promise().done(()=>{
                //membuat pilihan category 
                let training_process = `<select id="training_process" name="training_process" class="form-control form">
                                                <option value="in_progress">In Progress</option>
                                                <option value="complete">Complete</option>
                                        </select>
                                        `;

                // append form pilihan category
                $('.training_process').append(training_process);
            });

            //mengosongkan training date actual dari form
            $('.training_date_actual').empty().promise().done(()=>{
                // membuat form input date actual
                let training_date_actual = `<input type="text" class="form-control form" id="training_date_actual" name ="training_date_actual">`;

                //append form input date actual
                $('.training_date_actual').append(training_date_actual);

                // start progress init form input date
                $('#training_date_actual').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });

                $('#training_date_actual').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' sd ' + picker.endDate.format('YYYY-MM-DD'));
                });

                $('#training_date_actual').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                //end progress init input
            });

            //mengosongkan training time dari form
            $('.training_hour').empty().promise().done(()=>{
                // membuat form input time 
                let training_hour = `
                    <div class="row">
                        <div class="col">
                            <input class="form-control" id="training_hour" name="training_hour">
                            <small id="vendor_type_alert" class="form-text text-danger"></small>
                        </div>
                        <div class="col">
                            <input class="form-control" id="training_hour_minute" readonly>
                        </div>
                    </div>
                `;

                //append form input date actual
                $('.training_hour').append(training_hour);

                // start progress init form input date
                $('#training_hour').daterangepicker({
                    timePicker : true,
                    // singleDatePicker:true,
                    timePicker24Hour : true,
                    timePickerIncrement : 1,
                    locale : {
                        format : 'HH:mm'
                    }
                }).on('show.daterangepicker', function(ev, picker) {
                    picker.container.find(".calendar-table").hide();
                });

                $('#training_hour').on('apply.daterangepicker', function(ev, picker) {
                    let time = $('#training_hour').val()
                    let time_array = time.split('-');
                    let minutes = calculateTime(time_array[0],time_array[1]);
                    $('#training_hour_minute').val(minutes)
                });
                //end progress init input
            });

            //mengosongkan training category dari form
            $('.training_total').empty().promise().done(()=>{
                // membuat form input total training
                let training_total = `<input type="text" class="form-control form" id="training_total" name ="training_total">`;

                //append form input date actual
                $('.training_total').append(training_total);

                //function getCategory untuk menampilkan list category
                getCategory();
            });

            //mengosongkan training category dari form
            $('.training_fee').empty().promise().done(()=>{
                // membuat form input total training
                let training_fee = `<input type="text" class="form-control form" id="training_fee" name ="training_fee" onkeyup="formatRupiah(this)">`;

                //append form input date actual
                $('.training_fee').append(training_fee);
            });

            //mengosongkan training method dari form
            $('.training_method').empty().promise().done(()=>{
                //membuat pilihan method 
                let training_method = `<select id="method_id" name="method_id" class="form-control form">
                                                <option value="">Select method</option>
                                        </select>
                                        `;

                // append form pilihan method
                $('.training_method').append(training_method);

                //function getCategory untuk menampilkan list method
                getMethod();
            });

            //menhapus button save
            $('#button-save').remove();

            // append id training
            $('#training_id').val(id);

            // append button untuk membuat button save
            $('.modal-footer').append(`<button type="button" class="btn btn-success" onclick="validasi()" id="button-save">Save</button>`);

            //menampilkan modal detail
            detail(id,'edit');

        }

        detail = (id,type = null,tab = null) => {

            if (type == null || type == '') {

                //mengosongkan training category dari form
                $('#vendor_name').empty()

                //mengosongkan training purpose dari form
                $('#training_purpose').empty()

                //menhapus button save
                $('#button-save').remove();

                //mengosongkan training category dari form
                $('#training_category_td').empty();

                //mengosongkan training process dari form
                $('.training_process').empty();

                //mengosongkan training date actual dari form
                $('.training_date_actual').empty();

                //mengosongkan training total dari form
                $('.training_total').empty();

                //mengosongkan training method dari form
                $('.training_method').empty();

                //mengosongkan training method dari form
                $('.training_fee').empty();

            }

            $('#btn-add-participant').attr('hidden',true);
            $('#detail-approval').empty()
            $('#detail-approval-CEOHR').empty()
            $('#detail-participant').empty()
            $('.is-invalid').removeClass('is-invalid');
            $.ajax({
                url: "{{url('training/status/data-id')}}",
                data: {
                    training_id: id
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    let data = res.data
                    $('#title-modal-detail').text(`Detail Training Request ${data.training_id} - ${Helper.capitalizeFirstWords(data.training_approval.training_status)}`);
                    $('#training_topic').text(Helper.capitalize(data.training_topic));
                    $('#training_participants').text(data.training_participants);
                    let participant = detailParticipant(data,type);
                    let detailData = detailApproval(data.training_approval); //mendapatkan data detail approval nik 1-6 dan approval nik ceo-hr
                    let bond = conditionBond(Math.round(parseInt(data.training_fee) / parseInt(data.training_participants)));

                    bond != null
                        ? $('#service-bond').text(bond)
                        : $('#service-bond').text('does not need an bond');

                    if (type == null || type== '') { //Detail
                        data.category == null
                            ? $('#training_category_td').text('category not set')
                            : $('#training_category_td').text(data.category.category_name);

                        data.method == null
                            ? $('.training_method').text('method not set')
                            : $('.training_method').text(data.method.method_name);
                        
                        data.training_start_date_actual == null && data.training_end_date_actual == null
                            ? $('.training_date_actual').text('date actual not set')
                            : $('.training_date_actual').text(data.training_start_date_actual +' sd '+ data.training_end_date_actual);

                        data.training_total == null
                            ? $('.training_total').text('total training not set')
                            : $('.training_total').text(data.training_total)

                        if (data.vendor == null) {
                            $('#vendor_name').text("Vendor not set");
                        }else{
                            $('#vendor_name').text(data.vendor.vendor_name);
                            $('#vendor_name').append(`<button type="button" class="ml-2 btn btn-sm btn-primary" onclick="download_vendor('${data.vendor.vendor_id}')">
                                        <i class="fa fa-file"></i> 
                                    </button>`);
                        }

                        $('.training_fee').text(formatRp(data.training_fee));
                        $('#training_purpose').val(Helper.capitalize(data.training_purpose)).attr('readonly',true);
                        $('.training_hour').text(data.start_training_hour+ ' - '+data.end_training_hour + " | " + calculateTime(data.start_training_hour,data.end_training_hour));
                        $('.training_process').text(
                            data.training_process == 'in_progress' 
                                ? "In Progress"
                                : "Complete"
                        );

                    }else{ //Edit

                        $('#category_id').val(data.category_id);
                        $('#method_id').val(data.method_id);
                        $('#training_process').val(data.training_process);

                        data.training_start_date_actual == null && data.training_end_date_actual == null
                            ? $('#training_date_actual').val()
                            : $('#training_date_actual').val(data.training_start_date_actual +' sd '+ data.training_end_date_actual);

                        $('#training_total').val(data.training_total);

                        if (data.vendor != null) {
                            getVendor({value:data.vendor.vendor_type},data.vendor.vendor_id)
                            $('#vendor_type').val(data.vendor.vendor_type);
                        }

                        $('#training_hour').val(data.start_training_hour+ ' - '+data.end_training_hour);
                        let minutes = calculateTime(data.start_training_hour,data.end_training_hour);
                        $('#training_hour_minute').val(minutes)

                        $('#training_fee').val(NumberToRupiah(data.training_fee));
                        $('#training_purpose').val(data.training_purpose).attr('readonly',false);
                        $('#btn-add-participant').attr('hidden',false);

                    }

                    $('#detail-approval').append(detailData.Number);
                    $('#detail-approval-CEOHR').append(detailData.CEOHR);
                    $('#detail-participant').append(participant);
                    showParticipant();
                    $('.select2bs4').select2({theme:'bootstrap4'});
                    $('#training_participants').prop("disabled",false);

                    setParticipantOption(data,type);

                    $('#modal').modal('show');
                },
                error: (response) => {
                    Helper.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        setParticipantOption = (data,type) => {
            if (type != '' || type != null) {
                data.participant.forEach((el,index) => {
                    $('#participant_name_'+index).val(el.user.user_nik).select2({theme:'bootstrap4'});
                });
            }
        }

        detailParticipant = (data,type) => {
            let participant = data.participant;
            let detailTableParticipant = '';
            participant.forEach((item,index) => {
                
                if (type == null || type== ''){
                    detailTableParticipant += `
                        <tr>
                            <td>${item.user.user_nik}</td>
                            <td>${item.user.user_name}</td>
                            <td>${item.user.department.department_name}</td>
                            <td>${formatRp(Math.round(parseInt(data.training_fee) / parseInt(data.training_participants)))}</td>
                        </tr>
                    `;
                }else{
                    detailTableParticipant += `
                        <tr class="participant-${index}">
                            <td>
                                <div class="col">
                                    <select type="text" id="participant_name_${index}" class="form-control select2bs4 participant-select" name="participant_name[]" placeholder="Participant Name" onchange="chekUser(this)">
                                        <option value=""> Select Participant </>
                                    </select>
                                    <small id="participant_name_${index}_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <div class="col d-flex align-items-center" id="info-participant-${index}">
                                    ${item.user.user_name}
                                </div>
                            </td>
                            <td>
                                <center>
                                    <div class="col d-flex align-items-center" id="info-participant-departement-${index}">
                                        ${item.user.department.department_name} 
                                    </div>
                                </center>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col d-flex align-items-center" id="info-participant-total-${index}">
                                        ${formatRp(Math.round(parseInt(data.training_fee) / parseInt(data.training_participants)))}
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick=RemoveParticipant('${index}')>
                                            <span class="fa fa-window-close"></span>
                                        </button>
                                    </div>
                                </div> 
                            </td>
                        </tr>
                    `
                }
                
            });
            return detailTableParticipant;
        }

        AddParticipant = () => {
            $('#training_participants').text(parseInt($('#training_participants').text()) + 1 );
            let participant = $("tr[class^='participant-']");
            let last_participant = participant[participant.length - 1];
            let participant_index = parseInt($(last_participant).attr('class').split('-')[1] )+ 1; // ditambahkan satu untuk index tr baru
            let tr = `  <tr class="participant-${participant_index}">
                            <td>
                                <div class="col">
                                    <select type="text" id="participant_name_${participant_index}" class="form-control select2bs4 participant-select" name="participant_name[]" placeholder="Participant Name" onchange="chekUser(this)">
                                        <option value=""> Select Participant </>
                                    </select>
                                    <small id="participant_name_${participant_index}_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <div class="col d-flex align-items-center" id="info-participant-${participant_index}">
                                </div>
                            </td>
                            <td>
                                <center>
                                    <div class="col d-flex align-items-center" id="info-participant-departement-${participant_index}">
                                    </div>
                                </center>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col d-flex align-items-center" id="info-participant-total-${participant_index}">
                                        
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick=RemoveParticipant('${participant_index}')>
                                            <span class="fa fa-window-close"></span>
                                        </button>
                                    </div>
                                </div> 
                            </td>
                        </tr>`;

            $('#detail-participant').append(tr);
            showParticipant(`participant_name_${participant_index}`);
            $(`#participant_name_${participant_index}`).select2({theme:'bootstrap4'});
            updateCostTraining();
            calculateFeeParticipant();
            
        }

        RemoveParticipant = (index) => {
            $(`.participant-${index}`).remove();
            $('#training_participants').text($('#training_participants').text() - 1 );
            updateCostTraining();
            calculateFeeParticipant();
        }

        updateCostTraining = () => {
            let participant = $("tr[class^='participant-']");
            for (let index = 0; index < participant.length; index++) {
                let participant_index = $(participant[index]).attr('class').split('-')[1]
                let training_fee = $('#training_fee').val().replace(/[^,\d]/g, "").toString();
                let training_participant = $('#training_participants').text();
                let total = formatRp(Math.round(parseInt(training_fee) / parseInt(training_participant)))
                $(`#info-participant-total-${participant_index}`).text(total)
            }
        }

        chekUser = (data) => {
            let number = $('#training_participants').text();
            for (let index = 0; index < number; index++) {
                let id = `participant_name_${index}`;
                let nik = $(`#participant_name_${index}`).val()
                if(id != data.id){
                    if(nik === data.value){
                        $(`#${data.id}`).addClass('is-invalid');
                        $(`#${data.id}`).val('');
                        $(`#${data.id}_alert`).text(`can't select nik`);
                        Helper.sweetError(`can't select nik`)
                    }
                }else{
                        $(`#${data.id}`).removeClass('is-invalid');
                        $(`#${data.id}_alert`).text(``);
                    }
            }

            let user = $(data.options[data.selectedIndex]).data('user');
            let parent_id = $(data.options[data.selectedIndex]).parent().attr('id').split('_')[2];
            $(`#info-participant-departement-${parent_id}`).text(user.department)
            $(`#info-participant-${parent_id}`).text(user.user_name)
        }

        showParticipant = (data = null) => {
            let option = ''
            if( data == null) $('.flexibel-option').remove()
            ArrParticipant.forEach(item => {
                option += `
                            <option value="${item.user_nik}" data-user='${JSON.stringify(item)}' class="flexibel-option">${item.user_nik} - ${item.user_name}</option>
                        `
            });
            let selector = data == null ? '.participant-select' : `#${data}`;
            $(`${selector}`).append(option)
        }

        detailApproval = (data) => {
            // detailTableApproval untuk data table approval 1-6
            // detailTableApprovalCEOHR untuk data table approval ceo & hr
            let detailTableApproval = '<tr>'; 
            let detailTableApprovalCEOHR = '<tr>';
            for (let index = 1; index <= 8; index++) {
                let approval_nik = 'training_approval_nik';
                let nik_str = ''
                //melakaukan set nik_str
                if (index == 7) {
                    nik_str = 'ceo';
                } else if (index == 8) {
                    nik_str = 'hr';
                } else {
                    nik_str = index;
                }
                
                approval_nik += `_${nik_str}`
                if (nik_str == 'ceo' || nik_str == 'hr') {
                    detailTableApprovalCEOHR += '<td>'
                    detailTableApprovalCEOHR += detailContentApproval(data,approval_nik);
                    detailTableApprovalCEOHR += '</td>';
                }else{
                    detailTableApproval += '<td>'
                    detailTableApproval += detailContentApproval(data,approval_nik);
                    detailTableApproval += '</td>';
                }
            }
            detailTableApproval += '</tr>';
            detailTableApprovalCEOHR += '</tr>';

            return {Number:detailTableApproval,CEOHR:detailTableApprovalCEOHR};
        }

        detailContentApproval = (data,approval_nik) => {
            let detailApproval = ''
            let array = arrayApproval(data);
            if (data[approval_nik] != null) {
                let detailAppover = getNameApprove(data[approval_nik]); // mendapatkan nama approval
                detailApproval += `<center>${data[approval_nik]}</center>
                                        <center>${detailAppover}</center>`;
                if (data[approval_nik + '_date'] == null) {
                    detailApproval += `<center> <i> waiting approval </i> </center>`
                } else {
                    let image = chooseImage(array,approval_nik,data) // mendapatkan gambar reject atau approve
                    let date = data[approval_nik + '_date'].split(' ');
                    let newDate = new Date(date);
                    detailApproval += `<center><img src="{{ asset('${image}') }}" style="height: 50px;"></center>
                                            <center>
                                                ${(newDate.getDate() < 10) ? '0'+newDate.getDate() : newDate.getDate() }
                                                -${((newDate.getMonth()+1) < 10) ? '0'+(newDate.getMonth()+1) : newDate.getMonth()+1 }-${newDate.getFullYear()}</center>`
                }
            } else {
                detailApproval += '<center> - </center>';
            }
            return detailApproval;
        }

        getNameApprove = (lastApprove) => {
            let user_name = ''
            $.ajax({
                async: false,
                type: "GET",
                url: "{{url('resignation/user/nik')}}",
                data: {
                    user_nik: lastApprove
                },
                success: function (response) {
                    user_name = response.data.data.user_name
                }
            })
            return user_name;
        }

        getCategory = () => {
            $.ajax({
                type:"get",
                url:"{{url('training/all/category/data')}}",
                success:(res) => {
                    let data = res.data;
                    let option = '';
                    data.forEach(item => {
                        option += `<option value="${item.category_id}">
                                        ${item.category_name}
                                    </option>`;
                    });
                    $('#category_id').append(option);
                }
            })
        }

        getMethod = () => {
            $.ajax({
                type:"GET",
                url:"{{route('method-show')}}",
                success:(res) => {
                    let data = res.data;
                    let option = ''
                    data.forEach(item => {
                        option += `
                            <option class="method-option" value="${item.method_id}" >${item.method_name}</option>
                        `
                    });
                    $('#method_id').append(option)
                },
                error:(res) => {
                    Validation.errorHandle(res);
                }
            })
        }

        chooseImage = (array,approval_nik,data) => {
            let inarr = array.indexOf(approval_nik) // inarr (in array)
            let image = ''
            let approval_date = array[inarr + 1] += "_date";
            console.log(approval_date,data[approval_date])
            // // console.log(approval_nik,data[array[inarr + 1] += "_date" ], array[inarr + 1] += "_date")
            if (data[approval_date] == null && data.training_status == 'reject') { // +1 untuk mengecek approval date selanjutnya 
                image = '/images/rejected.png';
            }else{
                image = '/images/approved.png'
            }
            return image;
        }

        validasi = () => {
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').empty();
            let data = $('#form').serializeArray();
            let result = Helper.loopingValidasi(data);
            let resultArray = loopingValidasiArray(result); //mendapat kan semua nama input di dalam form
            if (resultArray.length == 0) {
                data.push({name: 'training_participants', value: $('#training_participants').text()});
                Helper.updateData(data).then( (res) => {
                    $(`#table-proceed`).DataTable().ajax.reload();
                })
            } else {
                for (let index = 0; index < result.length; index++) {
                    let form_id = resultArray[index];
                    $(`#${form_id}`).addClass('is-invalid');
                    $(`#${form_id}_alert`).text('Form cannot be empty');
                    Helper.sweetError('Form cannot be empty');
                }
            }
            // Helper.validasi('edit',data)
        }

        download = (id) => {
            let training_id = backTomin(id);
            window.open("{{url('training/report/request')}}/"+training_id, '_blank');
        }

        clearFilter = () => {
            $('#department_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#period_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#training_status_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#nik_search').val('');
            $('#nama_search').attr('');
        }

        formatRp = (data) => {
            let nominal = 'Rp. ' + parseInt(data).toLocaleString();
            return nominal;
        }

        formatRupiah = (data, prefix =  "Rp. ") => {
            let rupiah = NumberToRupiah(data.value)
            $('#training_fee').val(rupiah);
            calculateFeeParticipant();
        }

        NumberToRupiah = (angka, prefix =  "Rp. ") => {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

        calculateFeeParticipant = () => {
            let fee = $('#training_fee').val();
            let participant = $('#training_participants').text();
            let average_fee = 0;
            if(fee != 0 && fee != "" && participant != ""){
                var number_string = fee.replace(/[^,\d]/g, "").toString();
                average_fee = number_string / participant
            }
            average_fee = Math.round(average_fee);
            let textInfo = conditionBond(average_fee);
            $('#service-bond').text(textInfo);
            updateCostTraining()
        }

        conditionBond = (average_fee) => {
            let textInfo = null;
            if (average_fee >= 10000000 && average_fee <= 15999999) {
                textInfo = 'Servicebond 18 (Eighteen) months.' ;
            }else if(average_fee >= 16000000 && average_fee <= 25000000){
                textInfo = 'Servicebond for 30 (thirty) months' ; 
            }else if(average_fee > 25000000){
                textInfo = 'Servicebond for 36 (thirty six) months' ;
            }else{
                textInfo = 'Does not need an bond' ;
            }
            return textInfo;
        }

        cancel = (id,type) => {
            $.ajax({
                type:"delete",
                url:"{{url('training/status')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    training_id: id
                },
                success: (response) => {
                    Helper.sweetSuccess(response.message,response.data.message);
                    $(`#table-${type}`).DataTable().ajax.reload();
                    Helper.closeModal();
                },
                error:  (response) => {
                    Helper.errorHandle(response);
                },
            }).done(() => {
                $('.se-pre-con').hide();
            })
        }

        function CancelTraining(id,type){
            Swal.fire( {
                title: 'Are you sure to cancel your training request?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                preConfirm : function()  {
                    cancel(id,type)
                }
            })
        }

        backTomin = (id) =>{ // merubah backslah to min
            return id.replace('/','-');
        }

        arrayApproval = (data) => {
            let array = [];
            for (let index = 1; index <= 6; index++) { // looing data approval resign nik 1 - 6
                if (data[`training_approval_nik_${index}`] != null) { // jika data looping approval nik tidak kosong maka di masukan kedalam array
                    array.push(`training_approval_nik_${index}`);
                }
            }

            if (data.training_approval_nik_ceo != null) {
                array.push('training_approval_nik_ceo');
            }

            if (data.training_approval_nik_hr != null) {
                array.push('training_approval_nik_hr');
            }
            // array.push('training_approval_nik_ceo','training_approval_nik_hr'); //menambahkan index
            return array;
        }

        createVendorForm = () => {
            let tagForm = `
                <div class="row">
                    <div class="col">
                        <select id="vendor_type" name="vendor_type" class="form-control form select2bs4" onchange="getVendor(this)">
                            <option value="">Select Vendor Type</option>
                            <option value="perorangan">Personal</option>
                            <option value="lembaga">Lembaga</option>
                        </select>
                        <small id="vendor_type_alert" class="form-text text-danger"></small>
                    </div>
                    <div class="col">
                        <select id="vendor_id" name="vendor_id" class="form-control form select2bs4">
                            <option value="">Select Instructor</option>
                        </select>
                        <small id="vendor_id_alert" class="form-text text-danger"></small>
                    </div>
                </div>
            `
            $('#vendor_name').append(tagForm)
            $('.select2bs4').select2({theme:'bootstrap4'});
        }

        getVendor = (data,id) => {
            $('.vendor-option').remove();
            $.ajax({
                type:"GET",
                url:"{{route('vendor-type')}}",
                data: {
                    vendor_type : data.value
                },
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success:(res) => {
                    data = res.data;
                    let option = ''
                    data.forEach(item => {
                        option += `
                            <option class="vendor-option" value="${item.vendor_id}" >${item.vendor_name}</option>
                        `
                    });
                    option += `
                        <option class="vendor-option" value="other" >Other</option>
                    `
                    $('#vendor_id').append(option).promise().done(()=>{
                        $('#vendor_id').val(id)
                    })
                    $('.select2bs4').select2({theme:'bootstrap4'});
                },
                error:(res) => {
                    Validation.errorHandle(res);
                }
            }).done( () =>{
                $('#vendor_id').prop("disabled", false);
                $('.se-pre-con').hide();
            });
        }

        function loopingValidasiArray(result){ //mengembalikan id dari form name array yang kosong
            let newArray = [];
            let number = $('#training_participants').text();
            for (let index = 0; index < result.length; index++) { //menumukan index name form result
                var format = /[ `[\]]/; 
                if (format.test(result[index])) {
                    for (let i = 0 ; i < number ; i++) {
                        let id = "participant_name_"+i;
                        if ($(`#${id}`).val() == '') {
                            newArray.push(id);
                        }
                    }
                }else{
                    newArray.push(result[index]);
                }
            }
            return newArray
        }

        function getUnique(array){
            var uniqueArray = [];
            // Loop through array values
            for(i=0; i < array.length; i++){
                if(uniqueArray.indexOf(array[i]) === -1) {
                    uniqueArray.push(array[i]);
                }
            }
            return uniqueArray;
        }

         calculateTime = (start, end) => {
            start = start.split(":");
            end = end.split(":");
            var startDate = new Date(0, 0, 0, start[0], start[1], 0);
            var endDate = new Date(0, 0, 0, end[0], end[1], 0);
            var diff = endDate.getTime() - startDate.getTime();
            var hours = Math.floor(diff / 1000 / 60 / 60);
            diff -= hours * 1000 * 60 * 60;
            var minutes = Math.floor(diff / 1000 / 60);

            // If using time pickers with 24 hours format, add the below line get exact hours
            if (hours < 0)
            hours = hours + 24;
            // return (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
            return  (hours*60) + minutes + ` Minutes (${(hours <= 9 ? "0" : "")}${hours}:${(minutes <= 9 ? "0" : "")}${minutes})`;
        }

        download_vendor = (id) => {
            window.open("{{url('training/download-vendor')}}/"+id, '_blank');
        }
        
    </script>
@endsection