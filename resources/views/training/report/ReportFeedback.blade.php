@extends('training/master/master')
@section('title','Report Training Feedback')
@section('breadcumb','Report Training Feedback')

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
                            </ul>
                            <form id="form">
                                @csrf
                                <div class="tab-content border border-dark">
                                    <div role="tabpanel" class="tab-pane active" id="search-period" aria-labelledby="search-period" aria-expanded="true">

                                    </div>
                                    <div class="tab-pane" id="search-month" role="tabpanel" aria-labelledby="search-month" aria-expanded="false">
                                        
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
                                <table id="table" class="table table-bordered table-hover table-sm table-striped" width="100%" border="1">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Topic Training</th>
                                            <th>Vendor Type</th>
                                            <th>Vendor</th>
                                            <th>Training Category</th>
                                            <th>Method Training</th>
                                            <th>Jumlah Hari</th>
                                            <th>Department</th>
                                            <th>NIK</th>
                                            <th>Participant Name</th>
                                            <th>Question 1</th>
                                            <th>Question 2</th>
                                            <th>Question 3</th>
                                            <th>Question 4</th>
                                            <th>Question 5</th>
                                            <th>Question 6</th>
                                            <th>Question 7</th>
                                            <th>Question 8</th>
                                            <th>Question 9</th>
                                            <th>Question 10</th>
                                            <th>Question 11</th>
                                            <th>Question 12</th>
                                            <th>Question 13</th>
                                            <th>Question 14</th>
                                            <th>Question 15</th>
                                            <th>Question 16</th>
                                            <th>Question 17</th>
                                            <th>Question 18</th>
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
            var id = type + '_id'
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
        $('#tbody').empty();
        let data = $('#form').serialize();
        data += `&type=${type}`;
        $.ajax({
            type:"post",
            data: data,
            url:"{{url('training/report/feedback/view')}}",
            success:function(res){
                let data = res.data.data;
                loopingTable(data)
                $('#areaData').attr('hidden',false);
                $("#download-button").attr("onclick", `download('${type}')`);
            }
        })
    }

    function download(type) {
        let data = $('#form').serialize();
        data += `&type=${type}`;
        console.log(data)
        window.open("{{url('training/report/feedback/download')}}?"+data , '_blank');
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
    
    function loopingTable(data)
    {
        $('#table').DataTable({
            destroy:true,
            data : data.original.data,
            columns : [
                {
                    data:"bulan",
                    name:"bulan",
                    render:(data)=>{
                        return MonthName(data);
                    }
                },
                {
                    data:"tahun",
                    name:"tahun"
                },
                {
                    data:"training_topic",
                    name:"training_topic"
                },
                {
                    data:"vendor_type",
                    name:"vendor_type"
                },
                {
                    data:"vendor_name",
                    name:"vendor_name"
                },
                {
                    data:"category_name",
                    name:"category_name"
                },
                {
                    data:"method_name",
                    name:"method_name"
                },
                {
                    data:"training_total",
                    name:"training_total"
                },
                {
                    data:"department_name",
                    name:"department_name"
                },
                {
                    data:"training_user_nik",
                    name:"training_user_nik"
                },
                {
                    data:"user_name",
                    name:"user_name"
                },
                {
                    data:"training_feedback_1",
                    name:"training_feedback_1"
                },
                {
                    data:"training_feedback_2",
                    name:"training_feedback_2"
                },
                {
                    data:"training_feedback_3",
                    name:"training_feedback_3"
                },
                {
                    data:"training_feedback_4",
                    name:"training_feedback_4"
                },
                {
                    data:"training_feedback_5",
                    name:"training_feedback_5"
                },
                {
                    data:"training_feedback_6",
                    name:"training_feedback_6"
                },
                {
                    data:"training_feedback_7",
                    name:"training_feedback_7"
                },
                {
                    data:"training_feedback_8",
                    name:"training_feedback_8"
                },
                {
                    data:"training_feedback_9",
                    name:"training_feedback_9"
                },
                {
                    data:"training_feedback_10",
                    name:"training_feedback_10"
                },
                {
                    data:"training_feedback_11",
                    name:"training_feedback_11"
                },
                {
                    data:"training_feedback_12",
                    name:"training_feedback_12"
                },
                {
                    data:"training_feedback_13",
                    name:"training_feedback_13"
                },
                {
                    data:"training_feedback_14",
                    name:"training_feedback_14"
                },
                {
                    data:"training_feedback_15",
                    name:"training_feedback_15"
                },
                {
                    data:"training_feedback_16",
                    name:"training_feedback_16"
                },
                {
                    data:"training_feedback_17",
                    name:"training_feedback_17"
                },
                {
                    data:"training_feedback_18",
                    name:"training_feedback_18"
                },
                

            ]
        });
    }

    MonthName = (index) => {
        var months = [ "January", "February", "March", "April", "May", "June", 
           "July", "August", "September", "October", "November", "December" ];

       return months[parseInt(index) - 1];
    }

</script>
@endsection