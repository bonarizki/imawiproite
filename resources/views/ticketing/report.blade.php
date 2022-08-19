@extends('ticketing/master/master')
@section('title','Ticketing Report')
@section('breadcumb','Report')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
@endsection

@section('content')
    <div class="row" id="filter">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header"><h4>Filter</h4></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col form-group filter-period filter">
                                    <label>Periode</label>
                                    <select type="text" class="form-control select2bs4 " style="width: 100%" placeholder="Period" id="period_id" name="period_id" >
                                    </select>
                                </div>
                                <div class="col form-group filter-type filter">
                                    <label>Ticket Type</label>
                                    <select type="text" class="form-control select2bs4 " style="width: 100%" placeholder="Type" id="type_id" name="type_id" >
                                    </select>
                                </div>
                                <div class="col-2 form-group">
                                    <label>Search</label>
                                    <button class="btn btn-primary form-control" id="button-download" onclick="search()">
                                        <span class="fa fa-search"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-hidden" hidden>
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    <button type="button" onclick="download()" class="btn btn-success rounded mb-3">
                        <i class="ni ni-fat-add text-white"></i> 
                        Download
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>Ticket Type</th>
                                    <th>Ticket Created By</th>
                                    <th>Ticket Created At</th>
                                    <th>Ticket Status</th>
                                    <th>Approval Nik 1</th>
                                    <th>Approval Nik 1 Date</th>
                                    <th>Approval Nik 1 Lead Time</th>
                                    <th>Approval Nik 2</th>
                                    <th>Approval Nik 2 Date</th>
                                    <th>Approval Nik 2 Lead Time</th>
                                    <th>Approval Nik 3</th>
                                    <th>Approval Nik 3 Date</th>
                                    <th>Approval Nik 3 Lead Time</th>
                                    <th>Approval Nik 4</th>
                                    <th>Approval Nik 4 Date</th>
                                    <th>Approval Nik 4 Lead Time</th>
                                    <th>Approval Nik 5</th>
                                    <th>Approval Nik 5 Date</th>
                                    <th>Approval Nik 5 Lead Time</th>
                                    <th>Approval Nik 6</th>
                                    <th>Approval Nik 6 Date</th>
                                    <th>Approval Nik 6 Lead Time</th>
                                    <th>Approval Nik IT 1</th>
                                    <th>Approval Nik IT 1 Date</th>
                                    <th>Approval Nik IT 1 Lead Time</th>
                                    <th>Approval Nik IT 2</th>
                                    <th>Approval Nik IT 2 Date</th>
                                    <th>Approval Nik IT 2 Lead Time</th>
                                    <th>Approval Nik Done</th>
                                    <th>Approval Nik Done Date</th>
                                    <th>Approval Nik Done Lead Time</th>
                                    <th><center>Total Lead Time</center></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" id="form">
                        @csrf
                        <div class="form-body">
                            <div class="row form-body-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="system_name">System Name</label>
                                        <input type="text" id="system_name" class="form-control option" name="system_name" placeholder="System Name">
                                        <small id="system_name_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="system_pic_nik">Pic Name</label>
                                        <select name="system_pic_nik" id="system_pic_nik" class="form-control">
                                            <option value="">Select Agent</option>
                                        </select>
                                        <small id="system_pic_nik_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 button-form d-flex flex-row-reverse">
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
    <script type="text/javascript" src="{{asset('assets_argon/vendor/datatables/datatables.min.js')}}"></script>
    {{-- Helper & Validation --}}
    <script src="{{asset('js/script.js')}}"></script>
    <script>
        $(document).ready(function () {
            getPeriod();
            getTicketType();
            $('.select2bs4').select2({theme:"bootstrap4"})
        });

        const Helper = new valbon();

        const getPeriod = () => {
            $.ajax({
                type: "get",
                url: "{{url('/getall/plugin/period/active')}}",
                success: function (response) {
                    let data = response.data
                    let periodOption = '<option value="">Choose</option>'
                    periodOption += loopingOption(data, 'period');
                    $('#period_id').append(periodOption);
                },
            })
        }

        const getTicketType = () => {
            $.ajax({
                type: "get",
                url: "{{url('ticketing/all/type')}}",
                success: function (response) {
                    let data = response.data
                    let typeOption = '<option value="">Choose</option>'
                    typeOption += loopingOption(data, 'type');
                    $('#type_id').append(typeOption);
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

        const search = (data) => {
            $('.row-hidden').attr('hidden',true);
            if ($('#period_id').val() != "" && $('#type_id').val() != "") {
                $('#table').DataTable({
                    ajax: {
                        type: "get",
                        url: "{{ url('ticketing/report') }}",
                        data: {
                            period_id: $('#period_id').val(),
                            type_id: $('#type_id').val()
                        },
                    },
                    serverSide: true,
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
                            name: "type.type_name",
                        },
                        {
                            data: "created_by",
                            name: "created_by",
                            render: (data, type, row, ) => {
                                return `${row.request_by.user_nik} - ${row.request_by.user_name}`
                            }
                        },
                        {
                            data: "created_at",
                            name: "created_at",
                        },
                        {
                            data: "ticket_status",
                            name: "ticket_status",
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_1 != null) {
                                        return `${data.ticketing_approval_nik_1} - ${data.ticketing_approval1.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_1_date != null) {
                                        return `${data.ticketing_approval_nik_1_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_1",
                            name: "lead_time_1"
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_2 != null) {
                                        return `${data.ticketing_approval_nik_2} - ${data.ticketing_approval2.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_2_date != null) {
                                        return `${data.ticketing_approval_nik_2_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_2",
                            name: "lead_time_2"
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_3 != null) {
                                        return `${data.ticketing_approval_nik_3} - ${data.ticketing_approval3.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_3_date != null) {
                                        return `${data.ticketing_approval_nik_3_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_3",
                            name: "lead_time_3"
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_4 != null) {
                                        return `${data.ticketing_approval_nik_4} - ${data.ticketing_approval4.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_4_date != null) {
                                        return `${data.ticketing_approval_nik_4_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_4",
                            name: "lead_time_4"
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_5 != null) {
                                        return `${data.ticketing_approval_nik_5} - ${data.ticketing_approval5.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_5_date != null) {
                                        return `${data.ticketing_approval_nik_5_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_5",
                            name: "lead_time_5"
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_6 != null) {
                                        return `${data.ticketing_approval_nik_6} - ${data.ticketing_approval6.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_6_date != null) {
                                        return `${data.ticketing_approval_nik_6_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_6",
                            name: "lead_time_6"
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_it1 != null) {
                                        return `${data.ticketing_approval_nik_it1} - ${data.ticketing_approvalit1.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_it1_date != null) {
                                        return `${data.ticketing_approval_nik_it1_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_it1",
                            name: "lead_time_it1"
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_it2 != null) {
                                        return `${data.ticketing_approval_nik_it2} - ${data.ticketing_approvalit2.user_name}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "approval",
                            name: "approval",
                            render: (data, type, row, ) => {
                                if (data != null) {
                                    if (data.ticketing_approval_nik_it2_date != null) {
                                        return `${data.ticketing_approval_nik_it2_date}`;
                                    } else {
                                        return "-";
                                    }

                                } else {
                                    return "-";
                                }
                            }
                        },
                        {
                            data: "lead_time_it2",
                            name: "lead_time_it2"
                        },
                        {
                            data: "ticket_status",
                            name: "ticket_status",
                            render: (data, type, row, ) => {
                                if (row.ticket_status != 'done') {
                                    return "-";
                                } else {
                                    return row.nik_update_by.user_nik + "-" + row.nik_update_by.user_name;
                                }
                            }
                        },
                        {
                            data: "ticket_status",
                            name: "ticket_status",
                            render: (data, type, row, ) => {
                                if (row.ticket_status != 'done') {
                                    return "-";
                                } else {
                                    return row.updated_at
                                }
                            }
                        },
                        {
                            data: "lead_time_done",
                            name: "lead_time_done"
                        },
                        {
                            data: "total_lead_time",
                            name: "total_lead_time"
                        },

                    ]
                });
                $('.row-hidden').attr('hidden',false);
            }else{
                Helper.sweetError("Form can't be empty");
            }

        }

        const download = () => {
            let data = $('.select2bs4').serialize();
            window.open("{{ url('ticketing/report-download') }}?"+data , '_blank');
        }
    </script>
@endsection