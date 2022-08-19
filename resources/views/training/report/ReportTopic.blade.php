@extends('training/master/master')
@section('title','Report Training Topic')
@section('breadcumb','Report Trainin Topic')

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
                            <div class="card-body">
                                <button id="download-button" type="button" class="btn btn-info"> <i class="fa fa-download"></i> Download</button>
                                <table id="table" class="table table-bordered table-hover" width="100%" border="1">
                                    <thead>
                                        <tr>
                                            <td>Bulan</td>
                                            <td>Tahun</td>
                                            <td>Department</td>
                                            <td>Topic Training</td>
                                            <td>Peserta</td>
                                            <td>Jumlah Pertemuan</td>
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
            url:"{{url('training/report/topic/view')}}",
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
        window.open("{{url('training/report/topic/download')}}?"+data , '_blank');
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
                    render : (data) => {
                        return MonthName(data);
                    }
                },
                {
                    data:"tahun",
                    name:"tahun"
                },
                {
                    data:"department_name",
                    name:"department_name"
                },
                {
                    data:"training_topic",
                    name:"training_topic"
                },
                {
                    data:"participant",
                    name:"participant"
                },
                {
                    data:"training_total",
                    name:"training_total"
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