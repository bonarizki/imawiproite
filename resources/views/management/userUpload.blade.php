@extends('master/master')
@section('title','Upload User')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<style>
    /* .filepond--item {
        width: calc(50% - .5em);
    } */

    @media (min-width: 30em) {
        .filepond--item {
            width: calc(50% - .5em);
        }
    }

    @media (min-width: 50em) {
        .filepond--item {
            width: calc(33.33% - .5em);
        }
    }

    .filepond--action-process-item{
        visibility:hidden;
    }
</style>
@section('breadcumb','Upload User')
@section('content')
<div class="card shadow">
    <div class="card-body">
        <form id="form" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label>File Excel | <i><a href="{{asset('file_uploads/file/template_upload_user.xlsx')}}">download template</a></i></label>
                <input type="file" class="filepond" name="file_upload" id="file_upload" multiple data-max-file-size="3MB" data-max-files="1">
            </div>
            <div class="form-group buttonArea" hidden>
                <div class="row">
                    <div class="col" id="clear">
                        
                    </div>
                    <div class="col" id="save">
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mt-2" id="table-area" hidden>
    <div class="card-body" >
        <div class="alert alert-success" role="alert">
            <b><p id="success"></p></b>
        </div>
        <div class="alert alert-warning" role="alert">
            <b><a data-toggle="collapse" href="#collapseOne"><p id="fail" style="color: black"></p><i style="color: black" class="fas fa-caret-square-down mb-1"></i></a></b>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="card">
                    <div class="card-body" id="card-message">
                    
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table id="table" class="table table-bordered table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Birth City</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <th>Join Date</th>
                            <th>Department</th>
                            <th>Grade</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Approval Nik 1</th>
                            <th>Approval Nik 2</th>
                            <th>Approval Nik 3</th>
                            <th>Approval Nik 4</th>
                            <th>Approval Nik 5</th>
                            <th>Approval Nik 6</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
        </div>

    </div>
    
</div>
@endsection

@section('script')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>


    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script>
        const files = $('.filePond')

        $(function () {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
            files.filepond({
                acceptedFileTypes: [
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ],
                fileValidateTypeLabelExpectedTypesMap: {
                    'application/vnd.ms-excel': '.xls',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': '.xlsx'
                },
                labelFileProcessingComplete: "Validation Complete",
                labelFileProcessingError: "Template not match",
                allowRevert: false
            });

            FilePond.setOptions({
                server: {
                    process: {
                        url: "{{url('management/user/uploadProses')}}",
                        onload: function (response) {
                            $('#clear').empty();
                            let data = JSON.parse(response);
                            if (data.failValidasi == 0) {
                                $('#save').append(`<button class="btn btn-success btn-md btn-block" onclick="SaveExcel()" type="button">
                                                        <i class="far fa-save"></i> SAVE
                                                    </button>`);
                            }
                            $('#clear').append(`<button class="btn btn-danger btn-md btn-block" onclick="clearForm()" type="button">
                                                    <i class="fas fa-sync"></i> CLEAR
                                                </button>`);
                            $('.buttonArea').attr('hidden', false);
                            $('#table-area').attr('hidden', false);
                            $('#success').text(`Valid Data : ${data.successValidasi}`)
                            $('#fail').text(`Fail Data : ${data.failValidasi}`)
                            makeTable(data.data.original.data)
                        },
                        onerror: function (response) {
                            sweetError('Template not match');
                        },
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }
            });
        });

        function makeErrorData(data) {
            for (let index = 0; index < data.length; index++) {
                if (data[index].validasi == 'error') {
                    let messageError = data[index].message
                    for (let i = 0; i < messageError.length; i++) {
                        let message = '<p>';
                        message += `row excel no ${messageError[i].row}, field = ${messageError[i].error_field}`;
                        message += '</p>';
                        $('#card-message').append(message);
                    }
                }
            }
        }

        function makeTable(data) {
            makeErrorData(data);
            $('#table').DataTable({
                data: data,
                destroy: true,
                "searching": false,
                columns: [{
                        data: 'DT_RowIndex',
                        render: function (data) {
                            return data + 1;
                        }
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'mobile_number'
                    },
                    {
                        data: 'birth_city'
                    },
                    {
                        data: 'birth_date'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'join_date'
                    },
                    {
                        data: 'department'
                    },
                    {
                        data: 'grade'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'approval_nik_1'
                    },
                    {
                        data: 'approval_nik_2'
                    },
                    {
                        data: 'approval_nik_3'
                    },
                    {
                        data: 'approval_nik_4'
                    },
                    {
                        data: 'approval_nik_5'
                    },
                    {
                        data: 'approval_nik_6'
                    },
                ],
                createdRow: function (row, data, index) {
                    if (data['validasi'] == 'error') {
                        $(row).addClass('table-danger');
                    }
                }
            });
        }

        function SaveExcel() {
            var formData = new FormData($("form").get(0));
            formData = fileToFormData(formData);
            $.ajax({
                type: "POST",
                url: "{{url('management/user/UploadSave')}}",
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(".se-pre-con").show();
                },
                success: function (response) {
                    let data = response.data.message;
                    let keys = Object.keys(data)
                    let total = keys.length;
                    let fail = 0;
                    for (let index = 0; index < keys.length; index++) {
                        let message = data[keys[index]];
                        if (message.length > 0) {
                            fail = fail + 1;
                            for (let i = 0; i < message.length; i++) {
                                let messageinfo = '<p>';
                                let error = message[i].error_field.split("_")
                                messageinfo += `row excel no ${message[i].row}, field = ${error[0]} - not valid`;
                                messageinfo += '</p>';
                                $('#card-message').append(messageinfo);
                            }
                        }
                    }
                    $('#save').empty();
                    $('#success').text(`Valid Save Data : ${total - fail}`);
                    $('#fail').text(`Fail Save Data : ${fail}`);
                    sweetSuccess(response.status, 'Save User Success');
                    files.filepond('removeFiles');
                },
                error: function (response) {
                    sweetError(response.responseJSON.message)
                },
                complete: function () {
                    $(".se-pre-con").hide();
                }
            })
        }

        function fileToFormData(formData) {
            let excel = files.filepond('getFiles')
            formData.delete('file_upload');
            formData.append('file_upload', excel[0].file)
            return formData;
        }

        function sweetError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function clearForm() {
            $('#clear').empty();
            $('#save').empty();
            $('#card-message').empty();
            $('.buttonArea').attr('hidden', true);
            $('#table-area').attr('hidden', true);
            files.filepond('removeFiles');
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