@extends('resignation/master/master')
@section('breadcumb','Attrition Rate Based On Talent')
@section('title','Attrition Rate Talent')

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
                            <div class="card-body">
                                <button id="download-button" type="button" class="btn btn-info"> <i class="fa fa-download"></i> Download</button>
                                <table id="table" class="table table-bordered table-hover" width="100%" border="1">
                                    <thead>
                                        <tr>
                                            <th rowspan="2"><b><center>Level</center></b></th>
                                            <th colspan="2" id="HeaderDataView"><center></center></th>
                                        </tr>
                                        <tr>
                                            <th>Talent</th>
                                            <th>Non Talent</th>
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
            if (type == 'period') {
                viewDataPeriod()
            }else if(type == 'month'){
                viewDataMonth()
            }else{
                viewDataQuarter()
            }
        } else {
            for (let index = 0; index < result.length; index++) {
                $(`#${result[index]}`).addClass('is-invalid');
                sweetError('Form cannot be empty');
            }
        }
    }

    function viewDataPeriod()
    {
        $('#tbody').empty();
        let data = $('#form').serialize();
        data += `&type=period`;
        $.ajax({
            type:"post",
            data: data,
            url:"{{url('resignation/report/AR/talent/data')}}",
            success:function(result){
                let data = result.data.data;
                loopingTable(data)
                let period_name = $('#period_name').val();
                $('#HeaderDataView center').text(`FY ${period_name}`);
                $('#areaData').attr('hidden',false);
                $("#download-button").attr("onclick", 'downloadByPeriod()');
            }
        })
    }

    function viewDataMonth()
    {
        $('#tbody').empty();
        let data = $('#form').serialize();
        data += `&type=month`;
        $.ajax({
            type:"post",
            data: data,
            url:"{{url('resignation/report/AR/talent/data')}}",
            success:function(result){
                let data = result.data.data;
                loopingTable(data)
                let month_name = $('#month_name').val();
                let year_name = $('#year_name').val();
                $('#HeaderDataView center').text(`${month_name} - ${year_name}`);
                $('#areaData').attr('hidden',false);
                $("#download-button").attr("onclick", 'downloadByMonth()');
            }
        })
    }

    function viewDataQuarter()
    {
        $('#tbody').empty();
        let data = $('#form').serialize();
        data += `&type=quarter`;
        $.ajax({
            type:"post",
            data: data,
            url:"{{url('resignation/report/AR/talent/data')}}",
            success:function(result){
                let data = result.data.data;
                loopingTable(data)
                let quarter_name = $('#quarter_name').val();
                let period_name = $('#period_name').val();
                $('#HeaderDataView center').text(`${quarter_name} ${period_name}`);
                $('#areaData').attr('hidden',false);
                $("#download-button").attr("onclick", 'downloadByQuarter()');
            }
        })
    }

    function downloadByPeriod() {
        let data = $('#form').serialize();
        data += `&type=period`;
        window.open("{{url('resignation/report/AR/talent/download')}}?"+data , '_blank');
    }

    function downloadByMonth() {
        let data = $('#form').serialize();
        data += `&type=month`;
        window.open("{{url('resignation/report/AR/talent/download')}}?"+data , '_blank');
    }

    function downloadByQuarter() {
        let data = $('#form').serialize();
        data += `&type=quarter`;
        window.open("{{url('resignation/report/AR/talent/download')}}?"+data , '_blank');
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
        let tableBody = '';
        for (let index = 0; index < data.length; index++) {
            tableBody += `<tr>
                            <td>${data[index].grade_group_name}</td>
                            <td>${data[index].total_talent}</td>
                            <td>${data[index].total_non_talent}</td>
                        </tr>`;
        }
        $('#tbody').append(tableBody);
        $('#table').DataTable().data.reload;
    }

</script>
@endsection