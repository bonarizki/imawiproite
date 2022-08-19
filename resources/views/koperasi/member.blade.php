@extends('koperasi/master/master')
@section('title','Management Member')
@section('breadcumb','Management Member')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_tabler/dist/libs/datatables/datatables.min.css')}}"/>
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    <button type="button" onclick="modal('add')" class="btn btn-success rounded mb-3">
                        <span class="fa fa-plus text-white mr-1"></span> 
                        Add Member
                    </button>
                    <button type="button" onclick="upload('add')" class="btn btn-primary rounded mb-3">
                        <span class="fa fa-cloud-upload-alt text-white mr-1"></span> 
                        Upload Member
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User NIK</th>
                                    <th>User Name</th>
                                    <th>Department</th>
                                    <th>Member Status</th>
                                    <th>Member Code</th>
                                    <th><center>Edit</center></th>
                                    <th><center>Delete</center></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal modal-blur fade text-left" id="modal"  role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" id="form">
                        @csrf
                        <div class="form-body">
                            <div class="row form-body-row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="user_nik">User Name</label>
                                        <select class="form-control select2bs4" name="user_nik" id="user_nik" placeholder="Category"/>
                                            <option value="" disabled selected>User Name</option>
                                        </select>
                                        <small id="user_nik_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="member_status">Member Status</label>
                                        <select class="form-control select2bs4" name="member_status" id="member_status" placeholder="Category"/>
                                            <option value="" disabled selected>Member Status</option>
                                            <option value="member" >Member</option>
                                            <option value="non-member" >Non - Member</option>
                                        </select>
                                        <small id="member_status_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="member_code">Member Code</label>
                                        <input type="text" class="form-control" name="member_code" id="member_code" placeholder="Member Code"/>
                                        <small id="member_code_alert" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 button-form d-flex flex-row-reverse pt-2">
                                    <button type="button" class="btn btn-primary mr-1 mb-1" id="btn-save">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Upload --}}
    <div class="modal modal-blur fade" id="modal-upload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detail-label">
                        Upload Vendor | 
                        <a href="{{asset('file_uploads/file/template_member.xlsx')}}">
                            <i>download template</i>
                        </a>
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-update">
                        @csrf
                        <input type="file" class="filepond excel-filepond" name="file">
                    </form>
                    <div id="table-area" hidden>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table-upload" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Nik</th>
                                        <th>User Name</th>
                                        <th>Department</th>
                                        <th>Member Type</th>
                                        <th>Member Code</th>
                                        <th>Information</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {{-- Datatables --}}
    <script type="text/javascript" src="{{asset('assets_tabler/dist/libs/datatables/datatables.min.js')}}"></script>
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script>
        $(window).on('load', function () {
            firstLoader();
        })
        
        $(document).ready(function () {
            $('#table').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>',
                },
                ajax: "{{url('koperasi/member')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "user.user_nik",
                        name: "user.user_nik"
                    },
                    {
                        data: "user.user_name",
                        name: "user.user_name"
                    },
                    {
                        data: "user.department.department_name",
                        name: "user.department.department_name"
                    },
                    {
                        data: "member_status",
                        name: "member_status",
                        render: function(data) {
                            return capitalizeFirstLetter(data);
                        }
                    },
                    {
                        data: "member_code",
                        name: "member_code",
                        render: function(data) {
                            if (data != null) {
                                return data;
                            }

                            return "-";
                        }
                    },
                    {
                        data: 'member_id',
                        name: 'member_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-info" onclick="modal('edit','${data}')">
                                            <span class="fas fa-pen mr-1"></span> 
                                            Edit
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'member_id',
                        name: 'member_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-danger" onclick="deleteData('${data}')">
                                            <span class="fas fa-trash-alt mr-1"></span> 
                                            Delete
                                        </badge>
                                    </center>`
                        }
                    }
                ]
            })

            getUser();
        });

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });

        getUser = () => {
            $.ajax({
                type: "get",
                url: "{{url('/getall/user')}}",
                success: (res) => {
                    let data = res.data
                    let option = '';
                    data.forEach(el => {
                        option += `<option value="${el.user_nik}">${el.user_name} - ${el.user_nik}</option>`;
                    });
                    $('#user_nik').append(option);
                }
            })
        }

        const data = {
            id_name: "member_id",
            url: "{{url('koperasi/member')}}"
        }

        const Helper = new valbon(data)
        
        const field = ["user_nik", "member_status","member_code"];

        modal = (type, id = null) => {
            $(`#user_nik`).val("").select2({theme: 'bootstrap4'})
            $(`#member_status`).val("").select2({theme: 'bootstrap4'})
            Helper.closeModal();
            Helper.modal(type, id, 'Member')
        }

        validasi = (type) => {
            Helper.validasi(type);
        }

        deleteData = (id) => {
            Helper.modalDelete(id);
        }

        upload = () => {
            $('#modal-upload').modal('show');
            $('#table-area').attr('hidden',true);
            $('.excel-filepond').filepond('removeFiles');
        }

        $( () => {
            const files = $('.excel-filepond')
            //filepond upload vendor 
            files.filepond({
                acceptedFileTypes: [
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ],
                fileValidateTypeLabelExpectedTypesMap: {
                    'application/vnd.ms-excel': '.xls',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': '.xlsx'
                },
                labelFileProcessingComplete: "Upload Complete",
                labelFileProcessingError: "Template not match",
                allowRevert: false,
                server: {
                    process: {
                        type:"post",
                        url: "{{url('koperasi/member-upload')}}",
                        onload: function (response) {
                            let data = JSON.parse(response)
                            $('#table-area').attr('hidden', true);
                            $('#tbody').empty();
                            $('#information b').text(data.data.message)
                            CreateTable(data.data.data);
                            Validation.sweetSuccess(data.message, 'Upload Success')
                        },
                        onerror: function (response) {
                            Validation.sweetError('Something Error');
                        },
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }
            })
            //filepond upload vendor  
        })

        CreateTable = (data) => {
            let dataForTable = data.dataTable;
            let detailFail = data.detailFail;
            $('#table-upload').DataTable({
                destroy: true,
                data: dataForTable.original.data,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: [0],
                        name: [0]
                    },
                    {
                        data: [1],
                        name: [1]
                    },
                    {
                        data: [2],
                        name: [2]
                    },
                    {
                        data: [3],
                        name: [3]
                    },
                    {
                        data: [4],
                        name: [4]
                    },
                    {
                        data: [0],
                        name: [0],
                        render : (data, type, row, index) => {
                            return tableInformation(row, detailFail)
                        }
                    }
                ],
                createdRow: function (row, data, index) {
                    let indexFail = addFail(detailFail);
                    if (indexFail.includes(index)) {
                        $(row).addClass('table-danger');
                    }
                }
            });
            $('#table-area').attr('hidden', false);
        }

        tableInformation = (row,data) => {
            for (let index = 0; index < data.length; index++) {
                let keys = Object.keys(data[index].values);
                for (let i = 0; i < keys.length; i++) {
                    if ([0,1,3,4].includes(i)) {
                        console.log(data[index].values[keys[i]],row[index])
                        if(data[index].values[keys[i]] == row[index]){
                            return data[index].errors
                            console.log('hehe')
                            console.log(row,data);
                            // if(data[index].values[keys[i]] == '' || data[index].values[keys[i]] == null){
                            //     return data[index].errors
                            // }
                        }
                    }
                }
            }
            return 'upload success';
        }

        addFail = (data) => {
            let array = [];
            for (let index = 0; index < data.length; index++) {
                //dikuran 2 karena (excel mulai hitung array dari 1 dan dan saat row 1 itu heading)
                array.push(data[index].row - 2);
            }
            return array;
        }

    </script>
@endsection