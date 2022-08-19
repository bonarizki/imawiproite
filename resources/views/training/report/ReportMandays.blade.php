@extends('training/master/master')
@section('title','Report Training Mandays')
@section('breadcumb','Report Training Mandays')

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
                            <form id="form">
                                @csrf
                                <div class="tab-content border border-dark">
                                    <div role="tabpanel" class="tab-pane active" id="search-period" aria-labelledby="search-period" aria-expanded="true">

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
                            <div class="card-body table-responsive"">
                                <button id="download-button" type="button" class="btn btn-info"> <i class="fa fa-download"></i> Download</button>
                                <table id="table" class="table table-bordered table-hover table-sm table-striped" width="100%" border="1">
                                    <thead>
                                        <tr>
                                            <th rowspan="3" class="align-middle">Grading</th>
                                            <th colspan="16" class="align-middle text-center">Training Mandays</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="align-middle text-center">Q1</th>
                                            <th colspan="4" class="align-middle text-center">Q2</th>
                                            <th colspan="4" class="align-middle text-center">Q3</th>
                                            <th colspan="4" class="align-middle text-center">Q4</th>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Karyawan</th>
                                            <th>Jumlah Participant</th>
                                            <th>Jumlah Hari</th>
                                            <th>Mandays</th>
                                            <th>Jumlah Karyawan</th>
                                            <th>Jumlah Participant</th>
                                            <th>Jumlah Hari</th>
                                            <th>Mandays</th>
                                            <th>Jumlah Karyawan</th>
                                            <th>Jumlah Participant</th>
                                            <th>Jumlah Hari</th>
                                            <th>Mandays</th>
                                            <th>Jumlah Karyawan</th>
                                            <th>Jumlah Participant</th>
                                            <th>Jumlah Hari</th>
                                            <th>Mandays</th>
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
            url:"{{url('training/report/mandays/view')}}",
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
        window.open("{{url('training/report/mandays/download')}}?"+data , '_blank');
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
                    data:"grade",
                    name:"grade"
                },
                {
                    data:"total_karyawan_q1",
                    name:"total_karyawan_q1"
                },
                {
                    data:"total_participant_q1",
                    name:"total_participant_q1"
                },
                {
                    data:"total_hari_q1",
                    name:"total_hari_q1"
                },
                {
                    data:"total_mandays_q1",
                    name:"total_mandays_q1"
                },
                {
                    data:"total_karyawan_q2",
                    name:"total_karyawan_q2"
                },
                {
                    data:"total_participant_q2",
                    name:"total_participant_q2"
                },
                {
                    data:"total_hari_q2",
                    name:"total_hari_q2"
                },
                {
                    data:"total_mandays_q2",
                    name:"total_mandays_q2"
                },
                {
                    data:"total_karyawan_q3",
                    name:"total_karyawan_q3"
                },
                {
                    data:"total_participant_q3",
                    name:"total_participant_q3"
                },
                {
                    data:"total_hari_q3",
                    name:"total_hari_q3"
                },
                {
                    data:"total_mandays_q3",
                    name:"total_mandays_q3"
                },
                {
                    data:"total_karyawan_q4",
                    name:"total_karyawan_q4"
                },
                {
                    data:"total_participant_q4",
                    name:"total_participant_q4"
                },
                {
                    data:"total_hari_q4",
                    name:"total_hari_q4"
                },
                {
                    data:"total_mandays_q4",
                    name:"total_mandays_q4"
                }
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