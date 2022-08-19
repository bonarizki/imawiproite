@extends('resignation/master/master')
@section('breadcumb','Approval Clearance')
@section('title','Approval Clearance')

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
                                    <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Period" id="period_search" name="period_search" onchange="getData()">
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label>Department</label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Department" id="department_search" name="department_search" onchange="getData()">
                                        <option value="">Choose</option>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" style="width: 100%" placeholder="NIK" id="nik_search" name="nik_search" onkeyup="getData()"></input>
                                </div>
                                <div class="col form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" style="width: 100%" placeholder="Name" id="nama_search" name="nama_search" onkeyup="getData()"></input>
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
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resign User</th>
                                    <th>Resign Request Date</th>
                                    <th>Resign Date</th>
                                    <th>Resign Reason</th>
                                    <th>Approve</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Resign User</th>
                                    <th>Resign Request Date</th>
                                    <th>Resign Date</th>
                                    <th>Resign Reason</th>
                                    <th>Approve</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Clearance Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form form-horizontal" id="form">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row" id="item-form">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            getData();
            getAllOption();
            setFilterPeriod();
            $('.select2bs4').select2({theme:'bootstrap4'});
        });

        $(document).on('change','input[type="checkbox"]', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        });

        function getData(){
            $('#table').DataTable({
                destroy:true,
                serverSide: true,
                processing: true,
                ajax:{
                    url:"{{url('resignation/approva/clearance/data')}}",
                    data: {
                        "department_id": $('#department_search').val(),
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
                        data: "user.user_name",
                        name: "user.user_name"
                    },
                    {
                        data: "resign_request_date",
                        name: "resign_request_date"
                    },
                    {
                        data: "resign_date",
                        name: "resign_date"
                    },
                    {
                        data: "resign_reason",
                        name: "resign_reason"
                    },
                    {
                        data: "resign_id",
                        name: "resign_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-info btn-md" onclick="modalClearance('${data}')">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>`
                        }
                    }
                    
                ],
                "columnDefs": [
                    {
                        "targets": 0,
                        "searchable": false,
                        "orderable": false
                    },{
                        "targets": [ 4 ],
                        "visible": false,
                        "searchable": true
                    }
                ]
            })
        }

        function getAllOption() {
            $.ajax({
                type: 'get',
                url: "{{url('/get/option/user')}}",
                success: function (response) {
                    showingOptionSearch(response.data);
                }
            })
        }

        function showingOptionSearch(data){
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

        function setFilterPeriod()
        {
            $.ajax({
                type: "get",
                url: "{{url('/getall/plugin/period/active')}}",
                success: function (response) {
                    let data = response.data
                    let periodOption = '<option value="">Choose</option>'
                    periodOption += loopingOption(data,'period');
                    $('#period_search').append(periodOption);
                },
            })
        }

        function loopingOption(data, type) {
            let option = ``
            for (let index = 0; index < data.length; index++) {
                var name = type + '_name';
                var id = type + '_id';
                option += `<option value="${data[index][id]}">${data[index][name]}</option>`;
            }
            return option;
        }

        function modalClearance(resign_id)
        {
            let department_user = "{{Auth::user()->department_id}}";
            $('#item-form').empty()
            $.ajax({
                type:"get",
                url:"{{url('resignation/clearance/data')}}",
                success:function(response){
                    let data = response.data;
                    let formitem = `<input type="text" name="resign_id" id="resign_id" value="${resign_id}" hidden>`;
                    let valid_department = '';
                    for (let index = 0; index < data.length; index++) {
                        valid_department = data[index].department_id == department_user ? '' : `disabled="disabled"`;
                        formitem += `<div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>${data[index].clearance_question_name}</span>
                                            </div>
                                            <div class="col-md-8">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-inline-block mr-2">
                                                        <fieldset>
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox" name="${data[index].clearance_question_id}" class="${data[index].clearance_question_id}-sudah" value="sudah" ${valid_department}>
                                                                <span class="vs-checkbox vs-checkbox-lg">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                                <span class="">Sudah</span>
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                    <li class="d-inline-block mr-2">
                                                        <fieldset>
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox" name="${data[index].clearance_question_id}" class="${data[index].clearance_question_id}-belum" value="belum" ${valid_department}>
                                                                <span class="vs-checkbox vs-checkbox-lg">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                                <span class="">Belum</span>
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                    <li class="d-inline-block mr-2">
                                                        <fieldset>
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox" name="${data[index].clearance_question_id}" class="${data[index].clearance_question_id}-tidak_relevan" value="tidak_relevan" ${valid_department}>
                                                                <span class="vs-checkbox vs-checkbox-lg">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                                <span class="">Tidak Relevan</span>
                                                            </div>
                                                        </fieldset>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>`
                    }
                    $('#item-form').append(formitem)
                },
                complete: function (data) {
                    getAnswer(resign_id); 
                    $('#modal').modal('show')
                }
            })
        }

        function getAnswer(resign_id){
            $.ajax({
                type:"GET",
                url:"{{url('resignation/approval/clearance/answer')}}",
                data:{
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    resign_id : resign_id,
                },
                success:function(response){
                    let data = response.data.data
                    if (data != null) {
                        let answer = data.clearance_answer.split("#")
                        for (let index = 0; index < answer.length; index++) {
                            if(answer[index]!=""){
                                $(`.${answer[index]}`).attr('checked','checked');
                            }
                        }
                    }
                    
                }
            })
        }

        function save()
        {
            var myform = $('#form');
            var disabled = myform.find(':input:disabled').removeAttr('disabled');
            let data = $('#form').serializeArray()
            disabled.attr('disabled','disabled');
            let answer = makeAnswerFormat(data) //membuat format jawaban
            $.ajax({
                type:"post",
                url:"{{url('resignation/approval/clearance')}}",
                data:{
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    resign_id : $('#resign_id').val(),
                    clearance_answer : answer
                },
                success:function(response){
                    sweetSuccess(response.message, response.data.message);
                    $(`#table`).DataTable().ajax.reload();
                    $('#modal').modal('hide')
                }
            })
        }

        function makeAnswerFormat(data)
        {
            let answer = '';
            for (let index = 0; index < data.length; index++) {
                if (data[index].name != "resign_id") {
                    answer += `${data[index].name}-${data[index].value}#`
                }
            }
            return answer;
        }

        function sweetSuccess(status, message) {
            Swal.fire(
                'Good job!',
                message,
                status
            );
        }
    </script>
@endsection