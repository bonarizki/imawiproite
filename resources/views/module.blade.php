@extends('master/master')
@section('title','Module')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<style>
    .filepond--item {
        width: calc(50% - .5em);
    }

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

    /* use a hand cursor intead of arrow for the action buttons */
    .filepond--file-action-button {
        cursor: pointer;
    }

    /* the text color of the drop label*/
    .filepond--drop-label {
        color: #555;
    }

    /* underline color for "Browse" button */
    .filepond--label-action {
        text-decoration-color: #aaa;
    }

    /* the background color of the filepond drop area */
    .filepond--panel-root {
        background-color: #eee;
    }

    /* the border radius of the drop area */
    .filepond--panel-root {
        border-radius: 0.5em;
    }

    /* the border radius of the file item */
    .filepond--item-panel {
        border-radius: 0.5em;
    }

    /* the background color of the file and file panel (used when dropping an image) */
    .filepond--item-panel {
        background-color: #555;
    }

    /* the background color of the drop circle */
    .filepond--drip-blob {
        background-color: #999;
    }

    /* the background color of the black action buttons */
    .filepond--file-action-button {
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* the icon color of the black action buttons */
    .filepond--file-action-button {
        color: white;
    }

    /* the color of the focus ring */
    .filepond--file-action-button:hover,
    .filepond--file-action-button:focus {
        box-shadow: 0 0 0 0.125em rgba(255, 255, 255, 0.9);
    }

    /* the text color of the file status and info labels */
    .filepond--file {
        color: white;
    }

    /* error state color */
    [data-filepond-item-state*='error'] .filepond--item-panel,
    [data-filepond-item-state*='invalid'] .filepond--item-panel {
        background-color: red;
    }

    [data-filepond-item-state='processing-complete'] .filepond--item-panel {
        background-color: green;
    }

</style>
@section('breadcumb','List Data Module')
@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="row mt-2">
            <div class="col">
                <button class="btn btn-success" onclick="modalShow('add')"><i class="fas fa-plus"></i> Add
                    Module
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <table class="table table-hover table-striped table-bordered" style="width: 100%" id="table">
                    <thead>
                        <tr>
                            <th>Module ID</th>
                            <th>Module Name</th>
                            <th>Module URL</th>
                            <th>Module Status</th>
                            <th>Module Admin</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form" enctype="multipart/form-data">
        @csrf
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h5 class="modal-title" id="title-modal" style="color: white"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Module Name</label>
                        <input type="text" class="form-control" id="module_name" name="module_name">
                    </div>
                    <div class="form-group">
                        <label>Module URL</label>
                        <input type="text" class="form-control" id="module_url" name="module_url">
                    </div>
                    <div class="form-group">
                        <label>Module Image</label>
                        <input type="file" class="filepond" name="module_image" id="module_image" multiple data-max-file-size="3MB" data-max-files="3">
                    </div>
                    <div class="form-group">
                        <label>Module Status</label><br>
                        <input type="checkbox" class="form-control" name="module_status" id="module_status" checked data-bootstrap-switch data-off-color="danger" data-on-color="info" data-on-text="Active" data-off-text="Inactive">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal" >Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Admin Access-->
<div class="modal fade" id="modal-admin" tabindex="-1" role="dialog"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-purple">
                <h5 class="title-module" id="title-module" style="color: white"><b></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('modal-admin')">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2 mb-1">
                    <div class="col">
                        <button class="btn btn-success" id="btn-add-admin"><i class="fas fa-plus"></i> 
                            Add Admin
                        </button>
                    </div>
                </div>
                <table class="table table-hover table-striped table-bordered" style="width: 100%" id="table-admin">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Admin NIK</th>
                            <th>Admin Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('modal-admin')">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Admin Access-->
<div class="modal fade" id="modal-admin-form" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h5 class="title-module-admin" id="title-module-admin" style="color: white"><b></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('modal-admin-form')">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <form id="form-admin" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Admin Name</label>
                        <select name="admin_nik" id="admin_nik" class="form-control select2bs4">
                            <option value="" selected>Choose</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('modal-admin-form')">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal-admin" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script>
    $(function() {
        FilePond.registerPlugin(FilePondPluginImagePreview,FilePondPluginImageTransform);
        $('.filepond').filepond();
    });

    const files = $('.filePond')

    $(document).ready(function () {
        $('#table').dataTable({
            processing: true,
            language: {
                loadingRecords: "Please Wait - loading",
                processing: '<div class="se-pre-con"></div>'
            },
            serverSide: true,
            ajax: "{{url('/getAll/module')}}",
            responsive: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'module_name',
                    name: 'module_name'
                },
                {
                    data: 'module_url',
                    name: 'module_url'
                },
                {
                    data: 'module_status',
                    name: 'module_status',
                    render: function (data, type, row, meta) {
                        if (data == 1) {
                            return `Active`
                        } else {
                            return `Not Active`
                        }
                    }
                },
                {
                    data: 'module_id',
                    name: 'module_id',
                    render: function (data, type, row, meta) {
                        return `<center>
                                    <badge class="btn btn-sm btn-primary" onclick="modalAdmin(${data},'${row.module_name}')">
                                        <i class="fas fa-key"></i> Admin
                                    </badge>
                                </center>`
                    }
                },
                {
                    data: 'module_id',
                    name: 'module_id',
                    render: function (data, type, row, meta) {
                        return `<center>
                                    <badge class="btn btn-sm btn-success" onclick="modalShow('edit','${row.module_id}')">
                                        <i class="fas fa-user-edit"></i> Edit
                                    </badge>
                                </center>`
                    }
                },
                {
                    data: 'module_id',
                    name: 'module_id',
                    render: function (data, type, row, meta) {
                        return `<center>
                                    <badge class="btn btn-sm btn-danger" onclick="deleteModule('${row.module_id}')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    
                                    </badge>
                                </center>`
                    }
                }
            ]
        });
        setStatus();

        setAdminNik();
    });

    $('#module_status').on('switchChange.bootstrapSwitch', function () {
        if ($('#module_status').is(':checked')) {
            $('#module_status').val('1')
        } else {
            $('#module_status').val('0');
        }
    })

    function setStatus(d) {
        let val = d != null ? 0 : 1;
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
            $('#module_status').val(val);
        });
    }

    function modalShow(type, id) {
        $('.is-invalid').removeClass('is-invalid');
        if (type == 'edit') {
            modalEdit(id)
        } else {
            modalAdd()
        }
    }

    function deleteModule(id) {
        Swal.fire({
            title: 'Are you sure to delete?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: function () {
                prosesDelete(id)
            }
        })
    }

    function prosesDelete(id) {
        $.ajax({
            type: "POST",
            url: "{{url('/delete/moduleByid')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                module_id: id
            },
            success: function (response) {
                sweetSuccess(response.status, response.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            }
        })
    }

    function modalEdit(id) {
        $.ajax({
            type: "GET",
            url: "{{url('/get/moduleById')}}/" + id,
            success: function (response) {
                $('#modal').modal('show');
                $('#title-modal').text('Edit Module');
                $('#form').append(`<div class="module_id" hidden>
                                            <input type="text" id="module_id" name="module_id">
                                        </div>`);
                $('#module_name').val(response.data.module_name);
                $('#module_id').val(response.data.module_id);
                $('#module_url').val(response.data.module_url);
                $('#button-modal').attr('onclick', `validasi('update')`);
                if (response.data.module_status != 1) {
                    setStatus(response.data.module_status)
                    $('#module_status').bootstrapSwitch('state', false)
                }
                showimage(JSON.parse(response.data.module_image));
            }
        })
    }

    function showimage(data)
    {
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const pond = FilePond.create();
        for (let index = 0; index < data.length; index++) {
            files.filepond('addFile', `{{asset('file_uploads/images/module/${data[index]}')}}`).then(function(file){
            });
        }
    }

    function updateData() {
        var form = $('form')[0]; // You need to use standard javascript object here
        var formData = new FormData($("form").get(0));
        formData = imageToFormData(formData); 
        $.ajax({
            type: "POST",
            url: "{{url('/update/module')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                sweetSuccess(response.status, response.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            },
            error: function (response) {
                if (response.responseJSON.errors == null) {
                    sweetError(response.responseJSON.message)
                } else {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
                }
            }
        })
    }

    function modalAdd() {
        $('#title-modal').text('Add Module');
        $('#modal').modal('show');
        $('#button-modal').attr('onclick', `validasi('add')`);
    }

    function closeModal(id = 'modal') {
        $(`#${id}`).modal('hide');
        $('.module_id').remove();
        $('#form')[0].reset();
        $('.modal').attr('hidden',false);
        let image = files.filepond('getFiles')
        files.filepond('removeFiles')
    }

    function loopingError(fail, key) {
        if (fail.hasOwnProperty(key)) {
            $(`#${key}`).addClass('is-invalid');
            sweetError(fail[key][0]);
        }
    }

    function validasi(type) {
        let data = $('#form').serializeArray();
        let result = loopingValidasi(data)
        if (result.length == 0) {
            if (type == 'update') {
                updateData()
            } else {
                insert()
            }
        } else {
            for (let index = 0; index < result.length; index++) {
                $(`#${result[index]}`).addClass('is-invalid');
                sweetError('Form cannot be empty');
            }
        }
    }

    function insert() {
        let form = $('form')[0]; // You need to use standard javascript object here
        let formData = new FormData($("form").get(0));
        formData = imageToFormData(formData);
        $.ajax({
            type: "POST",
            url: "{{url('/insert/insertModule')}}",
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                sweetSuccess(response.status, response.message);
                $(`#table`).DataTable().ajax.reload();
                closeModal();
            },
            error: function (response) {
                if (response.responseJSON.errors == null) {
                    sweetError(response.responseJSON.message)
                } else {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
                }
            }
        })
    }

    function imageToFormData(formData) {
        let image = files.filepond('getFiles')
        if(image.length == 0){
            formData.append('module_image','default-img.jpg');
        }else{
            $(image).each(function (index) {
                formData.append('module_image[]',image[index].file,image[index].file.name);
            });
        }
        return formData;
    }

    function loopingValidasi(data) {
        let dataArray = [];
        for (let index = 0; index < data.length; index++) {
            if (data[index]['name'] != 'module_image') {
                if (data[index]['value'] == '') {
                    dataArray.push(data[index]['name'])
                }
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

    function sweetSuccess(status, message) {
        Swal.fire(
            'Good job!',
            message,
            status
        );
    }

    modalAdmin = (id,name) => {
        $('#table-admin').dataTable({
            processing: true,
            destroy: true,
            language: {
                loadingRecords: "Please Wait - loading",
                processing: '<div class="se-pre-con"></div>'
            },
            serverSide: true,
            ajax: {
                url:"{{url('admin/module')}}/"+id,
                type:"post",
                data:{
                    _token: $('meta[name="csrf-token"]').attr('content'),
                }
            },
            responsive: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'admin_nik',
                    name: 'admin_nik'
                },
                {
                    data: 'user.user_name',
                    name: 'user.user_name'
                },
                {
                    data: 'admin_id',
                    name: 'admin_id',
                    render: function (data, type, row, meta) {
                        return `<center>
                                    <badge class="btn btn-sm btn-success" onclick="modalShowAdmin('edit','${row.module_id}','${data}')">
                                        <i class="fas fa-user-edit"></i> Edit
                                    </badge>
                                </center>`
                    }
                },
                {
                    data: 'admin_id',
                    name: 'admin_id',
                    render: function (data, type, row, meta) {
                        return `<center>
                                    <badge class="btn btn-sm btn-danger" onclick="deleteAdminModule('${data}')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </badge>
                                </center>`
                    }
                }
            ],
            initComplete: function( settings, json ) {
                $('#btn-add-admin').attr('onclick', `modalShowAdmin('add','${id}')`);
                $('#title-module b').text(`Admin Module ${name}`)
                $('#modal-admin').modal('show');
            }
        })
    }

    setAdminNik = () => {
        $.ajax({
            type:"get",
            url:"{{url('/getall/user')}}",
            success:(res)=>{
                let option = "";
                res.data.forEach(user => {
                    option += `<option value="${user.user_nik}">
                                    ${user.user_nik} - ${user.user_name}
                                </option >`
                });
                $('#admin_nik').append(option);
            }
        })
    }

    modalShowAdmin = (type, id_module, id) => {
        $('.is-invalid').removeClass('is-invalid');
        if (type == 'edit') {
            modalEditAdmin(id_module,id)
        } else {
            modalAddAdmin(id_module)
        }
    }

    modalAddAdmin = (module_id) => {
        $('#modal-admin').attr('hidden',true)
        $('#title-module-admin b').text('Add Admin');
        $('#modal-admin-form').modal('show');
        $('#button-modal-admin').attr('onclick', `validasiAdmin('add','${module_id}')`);
        $('#admin_nik').val("").select2({
            theme: 'bootstrap4',
        });
    }

    modalEditAdmin = (id_module,id) => {
        $.ajax({
            type:"get",
            url:"{{url('/admin/module-detail')}}/"+id,
            success:(res) => {
                let data = res.data.data;
                $('#admin_nik').val(data.admin_nik).select2({
                    theme: 'bootstrap4'
                });
                $('#modal-admin').attr('hidden',true)
                $('#title-module-admin b').text('Edit Admin');
                $('#button-modal-admin').attr('onclick', `validasiAdmin('update','${id_module}','${id}')`);
                $('#modal-admin-form').modal('show');
            }
        })
    }

    validasiAdmin = (type,module_id,id) => {
        let data = $('#form-admin').serializeArray();
        let result = loopingValidasi(data)
        if (result.length == 0) {
            if (type == 'update') {
                updateDataAdmin(module_id,id);
            } else {
                insertAdmin(module_id)
            }
        } else {
            for (let index = 0; index < result.length; index++) {
                $(`#${result[index]}`).addClass('is-invalid');
                sweetError('Form cannot be empty');
            }
        }
    }

    insertAdmin = (module_id) => {
        let data = $('#form-admin').serialize();
        $.ajax({
            type: "post",
            url: "{{url('/admin/module')}}",
            data: data += `&module_id=${module_id}` ,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: () => {
                $('.se-pre-con').show();
            },
            success: (response) => {
                sweetSuccess(response.message, response.data.message);
                $(`#table-admin`).DataTable().ajax.reload();
                closeModal('modal-admin-form');
            },
            error: (response) => {
                if (response.responseJSON.errors == null) {
                    sweetError(response.responseJSON.message)
                } else {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
                }
            },
            complete: () => {
                $('.se-pre-con').hide();
            }
        })
    }

    updateDataAdmin = (module_id,id) => {
        let data = $('#form-admin').serialize();
        $.ajax({
            type:"put",
            url:"{{url('/admin/module')}}",
            data:data += `&admin_id=${id}&module_id=${module_id}`,
            beforeSend:() =>{
                $('.se-pre-con').show();
            },
            success:(response) => {
                sweetSuccess(response.message,response.data.message);
                $(`#table-admin`).DataTable().ajax.reload();
                closeModal('modal-admin-form');
            },
            error:  (response) => {
                if (response.responseJSON.errors == null) {
                    sweetError(response.responseJSON.message)
                } else {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
                }
            },
            complete : () => {
                $('.se-pre-con').hide();
            }
        })
    }

    deleteAdminModule = (id) => {
        Swal.fire({
            title: 'Are you sure to delete?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: function () {
                prosesAdminDelete(id)
            }
        })
    }

    prosesAdminDelete = (id) => {
        $.ajax({
            type: "delete",
            url: "{{url('admin/module')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                admin_id: id
            },
            success: function (response) {
                sweetSuccess(response.status, response.message);
                $(`#table-admin`).DataTable().ajax.reload();
            }
        })
    }


</script>
@endsection