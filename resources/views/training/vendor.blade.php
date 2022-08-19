@extends('training/master/master')
@section('title','Vendor')
@section('breadcumb','Vendor')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <div>
                            <button class="btn btn-success" onclick="modal('add')"><i class="fa fa-plus"></i> Add Vendor </button>
                            <button class="btn btn-primary" onclick="upload('upload')"><i class="fa fa-cloud-upload"></i> Upload Vendor </button>
                            <a href="{{route('vendor-download')}}" target="_blank">
                                <button class="btn btn-warning">
                                    <i class="fa fa-cloud-download"></i> Download Vendor 
                                </button>
                            </a>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor Name</th>
                                    <th>Vendor Type</th>
                                    <th>Edit</th>
                                    <th>Detail</th>
                                    <th>Delete</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor Name</th>
                                    <th>Vendor Type</th>
                                    <th>Edit</th>
                                    <th>Detail</th>
                                    <th>Delete</th>
                                    <th>Download</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="form">
                    @csrf
                    <div class="form-body">
                        <div class="row form-body-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="vendor_type">Vendor Type</label>
                                    <select type="text" id="vendor_type" class="form-control option" name="vendor_type" placeholder="Vendor Type" onchange="ShowForm(null,'add')">
                                        <option value="">SELECT VENDOR TYPE</option>
                                        <option value="perorangan">Personal</option>
                                        <option value="lembaga">Institution</option>
                                        <option value="nasional">National</option>
                                        <option value="internal">Internal</option>
                                    </select>
                                    <small id="vendor_type_alert" class="form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="col-12 button-form mt-1">
                                <button type="button" class="btn btn-primary mr-1 mb-1" id="btn-save">Submit</button>
                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-detail-label">Detail Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="table-detail" class="table table-striped" width=100%>
                    <tbody id="table-detail-body">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Upload --}}
<div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-detail-label">Upload Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-update">
                    @csrf
                    <input type="file" class="filepond excel-filepond" name="file">
                    <a href="{{asset('file_uploads/file/VendorTemplate.xlsx')}}">
                    </a>
                </form>
                <div id="table-area" hidden>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="table-upload" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor Name</th>
                                    <th>Vendor Bank Name</th>
                                    <th>Vendor Bank Number</th>
                                    <th>Vendor SIUP</th>
                                    <th>Vendor NPWP</th>
                                    <th>Vendor TDP</th>
                                    <th>Vendor Type</th>
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

@section('script')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script>
        $(document).ready(function () {
            $('#form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) { 
                    e.preventDefault();
                    return false;
                }
            });

            FilePond.registerPlugin(FilePondPluginImagePreview,FilePondPluginImageTransform,FilePondPluginFileValidateType);
            
            $('#table').DataTable({
                serverSide: true,
                destroy: true,
                ajax: "{{url('training/all/vendor/data')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "vendor_name",
                        name: "vendor_name"
                    },
                    {
                        data: "vendor_type",
                        name: "vendor_type",
                        render : (data) => {
                            return data.charAt(0).toUpperCase() + data.slice(1);
                        }
                    },
                    {
                        data: "vendor_id",
                        name: "vendor_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-success" onclick="modal('edit',${data})">
                                        <i class="fa fa-edit"></i> 
                                    </button>`
                        }
                    },
                    {
                        data: "vendor_id",
                        name: "vendor_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-info" onclick="detail(${data})">
                                        <i class="fa fa-eye"></i> 
                                    </button>`
                        }
                    },
                    {
                        data: "vendor_id",
                        name: "vendor_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-danger" onclick="deleteData(${data})">
                                        <i class="fa fa-trash"></i> 
                                    </button>`
                        }
                    },
                    {
                        data: "vendor_id",
                        name: "vendor_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-md btn-primary" onclick="download(${data})">
                                        <i class="fa fa-file"></i> 
                                    </button>`
                        }
                    },
                ]
            })
        });

        const data = {
            id_name : "vendor_id",
            create : {
                url:"{{url('training/all/vendor')}}",
                method : "post",
            },
            update : {
                url:"{{url('training/all/vendor-update')}}",
                method : "post"
            },
            delete : {
                url : "{{url('training/all/vendor')}}",
                method : "delete"
            },
            edit : {
                url : "{{url('training/all/vendor')}}",
                method : "get"
            }
        }

        const files = $('.excel-filepond')

        const Validation = new valbon (data)

        // const field digunakan untuk membuat field
        const field = [
            "vendor_name", 
            "vendor_bank_name", 
            "vendor_bank_number",
            "vendor_bank_image",
            "vendor_npwp", 
            "vendor_npwp_image", 
            "vendor_siup",
            "vendor_siup_image",
            "vendor_tdp",
            "vendor_tdp_image"
        ];

        //const fieldImage digunakan untuk manampung nama field image
        const fieldImage = [
            "vendor_bank_image",
            "vendor_npwp_image",
            "vendor_siup_image",
            "vendor_tdp_image",
            
        ];

        //const fieldNull field yang dapat kosong
        const fieldNull = [
            "vendor_bank_name", 
            "vendor_bank_number",
            "vendor_bank_image",
            "vendor_npwp", 
            "vendor_npwp_image", 
            "vendor_siup",
            "vendor_siup_image",
            "vendor_tdp",
            "vendor_tdp_image"
        ]

        modal = (typeModal,id,form_name,formType = 'old') => {
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').empty();
            $('#modalLabel').text(`${Validation.capitalize(typeModal)} Vendor`)
            $('#btn-save').attr('onclick',`validasi('${typeModal}')`)
            if (typeModal == 'edit') {
                edit(id,'new');
            }else{
                Validation.add()
            }
        }

        validasi = (type) => {
            //merubah input file name
            let filepond = $('.image-filepond')
            for (let i = 0; i < filepond.length; i++) {
                $(`#${filepond[i].id} fieldset input`).attr(`name`,`${filepond[i].id}`)
            }

            let data = $('#form').serializeArray();
            let result = Validation.loopingValidasi(data) // mengecek data yang kosong
            let newresult = result.filter(x => !fieldNull.includes(x)) // menghapus nama field validation yang si set untuk kosong
            if (newresult.length == 0) {
                let form = $('form')[0]; // You need to use standard javascript object here
                let formData = new FormData($("#form").get(0));
                formData = setValueImage(formData);
                formData = imageToFormData(formData,result.filter(x => fieldImage.includes(x)));
                if (type == 'edit') {
                    Validation.updateDataImage(formData)
                } else {
                    Validation.insertImage(formData)
                }
            } else {
                for (let index = 0; index < newresult.length; index++) {
                    $(`#${newresult[index]}`).addClass('is-invalid');
                    Validation.sweetError('Form cannot be empty');
                }
            }
        }

        setValueImage = (formData) => {
            fieldImage.forEach(name => {
                formData.append(name,null)
            });
            return formData;
        }

        edit = (id, formType) => {
            $.ajax({
                type: `${data.edit.method}`,
                url: `${data.edit.url}/` + id,
                success: (response) => {
                    //field define by using as const
                    let data = field.slice();
                    if (formType == 'new') data = ShowForm(response);
                    data.push('vendor_type');
                    Validation.createIdForm(response)
                    for (let index = 0; index < data.length; index++) {
                        let fieldName = data[index];
                        let res = response.data;
                        if (fieldImage.includes(fieldName)) {
                            if (res[fieldName] != null || res[fieldName] == '') {
                                showimage(fieldName,res[fieldName],true);
                                //merubah name input
                                $(`#${id} fieldset input`).attr('name',`${id}`);
                            }
                        }else if (fieldName == "vendor_type") {
                            $(`#vendor_type option[value='${res[fieldName]}']`).attr("selected", "selected");
                        }else{
                            $(`#${fieldName}`).val(res[fieldName]);
                        }
                    }
                    imagePond();
                    $('#modal').modal('show');
                },
                error: (response) => {
                    Validation.errorHandle(response);
                }
            })
        }

        showimage = (id,file_name,allowRemove) => {
            // First register any plugins
            FilePond.registerPlugin(FilePondPluginImagePreview,FilePondPluginImageTransform);

            // Turn input element into a pond
            $(`#${id}`).filepond({
                files: [
                    {
                        // the server file reference
                        source: `{{asset('file_uploads/images/vendor_data/${file_name}')}}`,

                        // set type to local to indicate an already uploaded file
                        options: {
                            type: 'local',

                            // mock file information
                            file: {
                                name: file_name,
                                size: 3001025,
                                type: ['image/*']
                            }
                        }
                    }
                ]
            });
        }

        imageToFormData = (formData,arrayID) => {
            for (let index = 0; index < arrayID.length; index++) {
                let image = $(`#${arrayID[index]}`).filepond('getFiles');
                formData.append(`${arrayID[index]}`,image[0].file,image[0].file.name);
            }
            return formData;
        }

        deleteData = (id) => {
            Validation.modalDelete(id);
        }

        closeModal = () => {
            $('.flexibel-form').remove();
            $('#table-detail-body').empty();
            Validation.closeModal();
        }

        ShowForm = (data = null,type = null) => {
            let value = data == null ? $('#vendor_type').val() : data.data.vendor_type;
            $('.flexibel-form').remove()
            let array = chooseArray(value);
            loopingForm (array,type);
            return array;
        }

        loopingForm = (form_name,type) => {
            let form = '';

            for (let index = 0; index < form_name.length; index++) {
                let name = capitalizeFirstWords(form_name[index])
               
                if (fieldImage.includes(form_name[index])) {
                    form +=`    
                             <div class="col-12 flexibel-form" style="height:100%">
                                <div class="" style="height:auto">
                                    <label for="${form_name[index]}">${name}</label>
                                    <input type="file" class="filepond image-filepond ${form_name[index]}" name="${form_name[index]}" id="${form_name[index]}" data-max-file-size="3MB" data-max-files="1">
                                </div>
                            </div>`;
                } else {
                    form +=`    
                            <div class="col-12 flexibel-form">
                                <div class="form-group">
                                    <label for="${form_name[index]}">${name}</label>
                                    <input type="text" id="${form_name[index]}" class="form-control" name="${form_name[index]}" placeholder="${name}">
                                </div>
                            </div>`;
                }
                
            }

            $(form).insertBefore('.button-form');
            if (type == 'add') {
                imagePond()
            }
        }

        customSelect = (response) =>{
            $(`#vendor_type option[value='${response.data.vendor_type}']`).attr("selected", "selected");
        }

        capitalizeFirstWords = (words) => {
            let data = words.split('_');
            let new_word = ''
            for (let index = 0; index < data.length; index++) {
                new_word += data[index].charAt(0).toUpperCase() + data[index].slice(1) + ' ';
            }
            return new_word;
        }

        detail = (id) => {
            $.ajax({
                url:`${data.edit.url}/${id}`,
                success: (response) => {
                    let res = response.data;
                    let array = chooseArray(res.vendor_type);
                    array.push('vendor_type');
                    let dataModal = ''
                    array.forEach(index => {
                        if (fieldImage.includes(index)) {
                            let contentTD = '';
                            if (res[index] == null || res[index] =='') {
                                contentTD = "Dont Have File";
                            }else{
                                contentTD = `<input type="file" class="filepond image-filePond ${index}" id="${index}" readonly>`;
                            }
                            dataModal += `<tr>
                                                <td style="width: 40%">${capitalizeFirstWords(index)}</td>
                                                <td style="width: 5%"> : </td>
                                                <td style="width: 55%">
                                                    ${contentTD}
                                                </td>
                                            </tr>`
                        }else{
                            dataModal += `<tr>
                                                <td style="width: 40%">${capitalizeFirstWords(index)}</td>
                                                <td style="width: 5%"> : </td>
                                                <td style="width: 55%">${res[index]}</td>
                                            </tr>`
                        }
                    });
                    $('#table-detail-body').append(dataModal)
                    $(document).ready(function () {
                        imagePond()
                        fieldImage.forEach(index => {
                            showimage(index,res[index],false)
                        });
                    });
                }
            })
            $('#modal-detail').modal('show')
        }

        chooseArray = (value) => {
            var field_second = field.slice();
            if (value == 'perorangan') {
                field_second.splice(6, field.length);
            }else if(value == 'nasional' || value == 'internal'){
                field_second.splice(1, field.length);
            }
            return field_second;
        }

        upload = () => {
            $('#modal-upload').modal('show');
        }


        $( () => {
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
                        url: "{{url('training/all/vendor-upload')}}",
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

        imagePond = () => {
            $(function() {
                $(`.image-filepond`).filepond({
                    allowRemove : true,
                    acceptedFileTypes:[
                        'image/*'
                    ],
                    labelFileProcessingComplete: "Upload Complete",
                    labelFileProcessingError: "Template not match",
                    allowRevert: false,
                })
            });
        }

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
                        data: [5],
                        name: [5]
                    },
                    {
                        data: [6],
                        name: [6]
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
                    if ([0,1,2,6].includes(i)) {
                        if(data[index].values[keys[i]] == row[i]){
                            if(data[index].values[keys[i]] == '' || data[index].values[keys[i]] == null){
                                return data[index].errors
                            }
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

        download = (id) => {
            window.open("{{url('training/download-vendor')}}/"+id, '_blank');
        }

    </script>
@endsection