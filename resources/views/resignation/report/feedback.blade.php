@extends('resignation/master/master')
@section('breadcumb','Feedback')
@section('title','Report Feedback')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab-fill" data-toggle="pill" href="#search-period" onclick="formSearchByPeriod()"> Download By Period</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-fill" data-toggle="pill" href="#search-month" onclick="formSearchByMonth()"> Download By Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-fill" data-toggle="pill" href="#search-quarter" onclick="formSearchByQuarter()"> Download By Quarter</a>
                                </li>
                            </ul>
                            <form id="form">
                                @csrf
                                <div class="tab-content border border-dark">
                                    <div role="tabpanel" class="tab-pane active" id="search-period" aria-labelledby="search-period" aria-expanded="true">

                                    </div>
                                    <div class="tab-pane" id="search-month" role="tabpanel" aria-labelledby="search-month" aria-expanded="false">
                                        
                                    </div>
                                    <div class="tab-pane" id="search-quarter" role="tabpanel" aria-labelledby="search-quarter" aria-expanded="false">
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="areaData" hidden>
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-content">
                            <div class="card-body table-responsive">
                                <button id="download-button" type="button" class="btn btn-info"> <i class="fa fa-download"></i> Download</button>
                                <table id="table" class="table table-bordered table-hover" width="100%" border="1">
                                    <thead>
                                       <tr>
                                           <td>#</td>
                                           <td>Name</td>
                                           <td>Department Name</td>
                                           <td>Question 1</td>
                                           <td>Question 2</td>
                                           <td>Question 3</td>
                                           <td>Question 4</td>
                                           <td>Question 5</td>
                                           <td>Question 6</td>
                                           <td>Question 7</td>
                                           <td>Question 8</td>
                                           <td>Question 9</td>
                                           <td>Question 10</td>
                                           <td>Question 11</td>
                                           <td>Question 12</td>
                                           <td>Question 13</td>
                                           <td>Question 14</td>
                                           <td>Question 15</td>
                                           <td>Question 16</td>
                                           <td>Question 17</td>
                                           <td>Question 18</td>
                                           <td>Question 19</td>
                                           <td>Question 20</td>
                                           <td>Question 21</td>
                                           <td>Question 22</td>
                                           <td>Question 23</td>
                                           <td>Question 24</td>
                                           <td>Question 25</td>
                                           <td>Question 26</td>
                                           <td>Question 27</td>
                                       </tr>
                                    </thead>
                                    <tbody id="tbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            destroy:true,
            ordering: false
        });
        formSearchByPeriod()
    });

    function formSearchByPeriod() {
        $('.tab-pane').empty()
        $('#areaData').attr('hidden',true);
        $.ajax({
            type: "get",
            url: "{{url('/getall/plugin/period/active')}}",
            success: function (response) {
                let form = `<div class="row">
                                <div class="col">
                                    <div class="card card-info shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col form-group" >
                                                    <label><b>Period</b></label>
                                                    <select type="text" class="form-control select2bs4" style="width: 100%" id="period_name" name="period_name">
                                                        <option value="">Choose</option>
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-md btn-success" onclick="validasi('period')">
                                                    <i class="fa fa-search"></i> View Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div`
                $('#search-period').append(form);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });
                let data = response.data;
                let looping = loopingOption(data, 'period');
                $('#period_name').append(looping);
            }
        })
    }

    function loopingOption(data, type) {
        let option = ``
        for (let index = 0; index < data.length; index++) {
            var name = type + '_name';
            option += `<option value="${data[index][name]}">${data[index][name]}</option>`;
        }
        return option;
    }

    function formSearchByMonth() {
        $('.tab-pane').empty()
        $('#areaData').attr('hidden',true);
        $.ajax({
            type: "get",
            url: "{{url('/getall/plugin/month')}}",
            success: function (response) {
                let form = `<div class="row">
                                <div class="col">
                                    <div class="card card-info shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col form-group" >
                                                    <label><b>Month From</b></label>
                                                    <select type="text" class="form-control select2bs4" style="width: 100%" id="month_name" name="month_name">
                                                        <option value="">Choose</option>
                                                    </select>
                                                </div>
                                                <div class="col form-group" >
                                                    <label><b>Year</b></label>
                                                    <select type="text" class="form-control select2bs4" style="width: 100%" id="year_name" name="year_name">
                                                        <option value="">Choose</option>
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-md btn-success" onclick="validasi('month')">
                                                    <i class="fa fa-search"></i> View Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div`
                $('#search-month').append(form);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });
                let data = response.data;
                let looping = loopingOption(data, 'month');
                $('#month_name').append(looping);
                GetYearForSearch();
            }
        })
    }

    function formSearchByQuarter(){
        $('.tab-pane').empty()
        $('#areaData').attr('hidden',true);
        $.ajax({
            type: "get",
            url: "{{url('/getall/plugin/period/active')}}",
            success: function (response) {
                let form = `<div class="row">
                                <div class="col">
                                    <div class="card card-info shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col form-group" >
                                                    <label><b>Quarter</b></label>
                                                    <select type="text" class="form-control select2bs4" style="width: 100%" id="quarter_name" name="quarter_name">
                                                        <option value="">Choose</option>
                                                        <option value="Q1">Q1</option>
                                                        <option value="Q2">Q2</option>
                                                        <option value="Q3">Q3</option>
                                                        <option value="Q4">Q4</option>
                                                    </select>
                                                </div>
                                                <div class="col form-group" >
                                                    <label><b>Year</b></label>
                                                    <select type="text" class="form-control select2bs4" style="width: 100%" id="period_name" name="period_name">
                                                        <option value="">Choose</option>
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-md btn-success" onclick="validasi('quarter')">
                                                    <i class="fa fa-search"></i> View Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div`
                $('#search-quarter').append(form);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });
                let data = response.data;
                let looping = loopingOption(data, 'period');
                $('#period_name').append(looping);
            }
        })
    }

    function GetYearForSearch() {
        $.ajax({
            type: "get",
            url: "{{url('/getall/plugin/year/active')}}",
            success: function (response) {
                let data = response.data;
                let looping = loopingOption(data, 'year');
                $('#year_name').append(looping);
            }
        })
    }

    function validasi(type) {
        $('.is-invalid').removeClass('is-invalid')
        let data = $('#form').serializeArray();
        let result = loopingValidasi(data);
        if (result.length == 0) {
            viewData(type);
        } else {
            for (let index = 0; index < result.length; index++) {
                $(`#${result[index]}`).addClass('is-invalid');
                sweetError('Form cannot be empty');
            }
        }
    }

    function viewData(type)
    {
        $('#download-button').prop('disabled', false);
        $('#tbody').empty();
        let data = $('#form').serialize();
        data += `&type=${type}`;
        $('#download-button').prop('disabled', false);
        $.ajax({
            type:"post",
            data: data,
            url:"{{url('resignation/report/feedback/data')}}",
            success:function(result){
                let data = result.data;
                MakeTable(data)
                if(data.data.original.data.length == 0) $('#download-button').prop('disabled', true);
                $('#areaData').attr('hidden',false);
                $('#download-button').attr('onclick',`downloadFeedback('${type}')`)
            }
        })
    }

    downloadFeedback = (type) => {
        let data = $('#form').serialize();
        data += `&type=${type}`;
        window.open("{{url('resignation/report/feedback-download')}}?"+data , '_blank');
    }

    function loopingValidasi(data) {
        let dataArray = [];
        for (let index = 0; index < data.length; index++) {
            if (data[index]['value'] == '') {
                dataArray.push(data[index]['name'])
            }
        }
        return dataArray;
    }

    function sweetError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    }
    
    function MakeTable(data) {
        $('#table').DataTable({
            destroy: true,
            ordering: false,
            data: data.data.original.data,
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex"
                },
                {
                    data: "user_name",
                    name: "user_name"
                },
                {
                    data: "department_name",
                    name: "department_name"
                },
                {
                    data: "resign_feedback_1",
                    name: "resign_feedback_1"
                },
                {
                    data: "resign_feedback_2",
                    name: "resign_feedback_2"
                },
                {
                    data: "resign_feedback_3",
                    name: "resign_feedback_3"
                },
                {
                    data: "resign_feedback_4",
                    name: "resign_feedback_4"
                },
                {
                    data: "resign_feedback_5",
                    name: "resign_feedback_5"
                },
                {
                    data: "resign_feedback_6",
                    name: "resign_feedback_6"
                },
                {
                    data: "resign_feedback_7",
                    name: "resign_feedback_7"
                },
                {
                    data: "resign_feedback_8",
                    name: "resign_feedback_8"
                },
                {
                    data: "resign_feedback_9",
                    name: "resign_feedback_9"
                },
                {
                    data: "resign_feedback_10",
                    name: "resign_feedback_10"
                },
                {
                    data: "resign_feedback_11",
                    name: "resign_feedback_11"
                },
                {
                    data: "resign_feedback_12",
                    name: "resign_feedback_12"
                },
                {
                    data: "resign_feedback_13",
                    name: "resign_feedback_13"
                },
                {
                    data: "resign_feedback_14",
                    name: "resign_feedback_14"
                },
                {
                    data: "resign_feedback_15",
                    name: "resign_feedback_15"
                },
                {
                    data: "resign_feedback_16",
                    name: "resign_feedback_16"
                },
                {
                    data: "resign_feedback_17",
                    name: "resign_feedback_17"
                },
                {
                    data: "resign_feedback_18",
                    name: "resign_feedback_18"
                },
                {
                    data: "resign_feedback_19",
                    name: "resign_feedback_19"
                },
                {
                    data: "resign_feedback_20",
                    name: "resign_feedback_20"
                },
                {
                    data: "resign_feedback_21",
                    name: "resign_feedback_21"
                },
                {
                    data: "resign_feedback_22",
                    name: "resign_feedback_22"
                },
                {
                    data: "resign_feedback_23",
                    name: "resign_feedback_23"
                },
                {
                    data: "resign_feedback_24",
                    name: "resign_feedback_24"
                },
                {
                    data: "resign_feedback_25",
                    name: "resign_feedback_25"
                },
                {
                    data: "resign_feedback_26",
                    name: "resign_feedback_26"
                },
                {
                    data: "resign_feedback_27",
                    name: "resign_feedback_27"
                },
            ]
        });
    }

</script>
@endsection