@extends('koperasi/master/master')
@section('title','Management Banner')
@section('breadcumb','Management Banner')

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
                        Add Banner
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Banner Name</th>
                                    <th>Banner Status</th>
                                    <th>Last Update</th>
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
    <div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row form-body-row">
                                <div class="form-group">
                                    <label>Image Banner</label>
                                    <input type="file" class="filepond" name="banner_image" id="banner_image" data-max-file-size="3MB">
                                </div>
                                <div class="form-group">
                                    <label >Status</label>
                                    <label class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="banner_status" id="banner_status">
                                        <span class="form-check-label label-status"></span>
                                    </label>
                                </div>
                                <div class="col-12 button-form d-flex flex-row-reverse pt-2">
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
    <script type="text/javascript" src="{{asset('assets_tabler/dist/libs/datatables/datatables.min.js')}}"></script>
    {{-- Select 2 --}}
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <script>
        $(window).on('load', function () {
            firstLoader();
        })
        
        $(function () {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageTransform);
            $('.filepond').filepond();
        });

        const files = $('.filePond')

        $(document).ready(function () {
            $('#table').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>',
                },
                ajax: "{{url('koperasi/banner-setting')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "banner_image",
                        name: "banner_image"
                    },
                    {
                        data: "banner_status",
                        name: "banner_status"
                    },
                    {
                        data: "updated_by",
                        name: "updated_by",
                        render: function (data, type, row, meta) {
                            return `${data} - ${row.updated_at}`;
                        }
                    },
                    {
                        data: 'banner_id',
                        name: 'banner_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-info" onclick="edit('${data}')">
                                            <span class="fas fa-pen mr-1"></span> 
                                            Edit
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'banner_id',
                        name: 'banner_id',
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

        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('#banner_status').change(function (e) {
            if ($('#banner_status').is(":checked")) {
                $('.label-status').text('Active');
            } else {
                $('.label-status').text('Non-Active');
            }
        })

        const data = {
            id_name: "banner_id",
            url: "{{url('koperasi/banner-setting')}}"
        }

        const Helper = new valbon(data)

        const field = ["banner_image", "banner_status"];

        modal = (type, id = null) => {
            $('#banner_id').remove();
            let files = $('#banner_image');
            files.filepond('removeFiles');
            Helper.closeModal();
            Helper.modal(type, id, 'Banner')
        }

        validasi = (type) => {
            let files = $('#banner_image');
            let image = files.filepond('getFiles')
            if (image.length == 0) {
                console.log("No files selected.");
            } else {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData($("form").get(0));
                formData = imageToFormData(formData);
                if (type == 'add') {
                    Helper.insertImage(formData);
                }else{
                   updateDataImage(formData);
                }
            }
        }

        function imageToFormData(formData) {
            let image = $('#banner_image').filepond('getFiles')

            formData.append('banner_image', image[0].file, image[0].file.name);

            return formData;
        }

        deleteData = (id) => {
            Helper.modalDelete(id);
        }

        edit = (id) => {
            $.ajax({
                type: "get",
                url: data.url + "/" + id + "/edit",
                success: (res) => {
                    $('#modal').modal('show');
                    $('#title-modal').text('Edit Banner');
                    $('#form').append(`<div class="module_id" hidden>
                                                <input type="text" id="banner_id" name="banner_id">
                                            </div>`);
                    $('#btn-save').attr('onclick', `validasi('update')`);
                    $('#banner_id').val(id);
                    if (res.data.banner_status == "active") {
                        $('#banner_status').prop('checked', true);
                    }
                    showimage(res.data.banner_image);
                }
            })
        }

        updateDataImage = (data) => {
            $.ajax({
                type:"post",
                url:`{{url('koperasi/banner-setting')}}/update`,
                data:data,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success:(response) => {
                    Helper.sweetSuccess(response.message,response.data.message);
                    $(`#table`).DataTable().ajax.reload();
                    Helper.closeModal();
                },
                error:  (response) => {
                    Helper.errorHandle(response);
                },
                complete : () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        showimage = (data) => 
        {
            FilePond.registerPlugin(FilePondPluginImagePreview);
            const pond = FilePond.create();
            
            $('#banner_image').filepond('addFile', `{{asset('file_uploads/images/koperasi/banner/${data}')}}`).then(function(file){
            });
        }

    </script>
@endsection