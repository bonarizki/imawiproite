@extends('ticketing/master/master')
@section('title','Form Request')
@section('breadcumb','Form Request')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
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

        .select2-hidden-accessible { position: fixed !important; }

        .select2-selection__choice {
            color: black !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card shadow rounded">
                <div class="card-body">
                    <div class="form-body">
                        <div class="row form-body-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="priority_name">Ticket Type</label>
                                    <select name="ticket_type" id="ticket_type" class="form-control select2" onchange="showForm(this)">
                                        <option value="">Select Ticket Type</option>
                                    </select>
                                    <small id="ticket_type_alert" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {{-- Datatables --}}
    <script type="text/javascript" src="{{asset('assets_argon/vendor/datatables/datatables.min.js')}}"></script>
    {{-- Helper & Validation --}}
    <script src="{{asset('js/script.js')}}"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>


    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script>
        const files = $('.filepond');
        
        const data = {
            id_name : "priority_id",
            url:"{{url('ticketing/request/resource')}}"
        }

        const Helper = new valbon (data);
        
        checkNIK = () => {
            let array_admin = JSON.parse(JSON.stringify({{\Helper::instance()->checkNIK()}}));
            let nik = "{{Auth::user()->user_nik}}";
            if (array_admin.includes(parseInt(nik))) {
                return true;
            } else {
                return false;
            }
        }

        create_filepond = () => {
            $(function () {
                FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
                $('.filepond').filepond({
                    allowRemove : true,
                    acceptedFileTypes: [
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/pdf'
                    ],
                    fileValidateTypeLabelExpectedTypesMap: {
                        'application/vnd.ms-excel': '.xls',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': '.xlsx',
                        'application/pdf' : '.pdf'
                    },
                    labelFileProcessingComplete: "Validation Complete",
                    labelFileProcessingError: "Template not match",
                    allowRevert: false
                });
            });
        }

        validate = () => {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            let result = $('#form')[0].checkValidity();
            if (result) {
                add_request();
            }else{
                $('#form')[0].reportValidity();
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
            });

            $.ajax({
                type:"get",
                url:"{{url('ticketing/all/type')}}",
                success:(res)=>{
                    let option = "";
                    res.data.forEach(e => {
                        option += `<option value="${e.type_id}">${e.type_name}</option>`;
                    });
                    $('#ticket_type').append(option);
                }
            })
        });

        const showForm = async (data) => {
            $('.modal-body').empty();
            if (data.value == 8) {
                $('#modalLabel').text('Form IT PO');
                it_po();
            } else if (data.value == 6) {
                $('#modalLabel').text('Form Request User');
                sap_user();
            } else if (data.value == 10) {
                $('#modalLabel').text('Change Request Form');
                cra();
            } 

            create_filepond();
            // $('.needs-validation').validation().resetForm()
            $('#modal').modal('show');

        }

        // START FUNCTION IT PO 
        it_po = () => {
            let form = `<div class="mb-2">
                            <button class="btn btn-md btn-success" onclick="create_form_it_po()">
                                <i class="fas fa-plus"></i>  Add Row
                            </button>
                            <button class="btn btn-primary" type="button" onclick="validate()"> <i class="fas fa-save"></i> 
                                Save
                            </button>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="pl-3 pr-3">
                                    <form class="form form-vertical needs-validation" novalidate id="form">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row form-body-row">
                                                <table class="table table-bordered" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:20%" rowspan="2">Category</th>
                                                            <th style="width:20%" rowspan="2">Nama Barang</th>
                                                            <th style="width:10%" rowspan="2">Qty</th>
                                                            <th style="width:20%" rowspan="2">Harga</th>
                                                            <th style="width:20%" rowspan="2">Jumlah</th>
                                                            <th style="width:5%" colspan="2"><center>Action</center></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Delete</th>
                                                            <th>Accept User</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col d-flex justify-content-end">
                                                <h3 id="all_total"></h3>
                                            </div>
                                        </div>
                                        <hr></hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Reason </label>
                                                    <textarea class="form-control" id="reason" name="reason" rows="3" wrap="hard" placeholder="Reason" style="resize:none;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Attach File </label>
                                                    <input type="file" class="filepond" name="file_upload" id="file_upload" multiple data-max-file-size="3MB" data-max-files="2">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>`
            $('.modal-body').append(form);
            create_form_it_po();
        }

        create_form_it_po = () => {
            let div = $('tr[id^="form-it-"]:last');
            if (div.length == 0 ) {
                form = `                        
                        <tr id="form-it-0">
                            <td>
                                <div class="form-group">
                                    <select class="form-control select-category" name="sub_category_id[]" data-id="sub_category_id" required></select>
                                    <small id="sub_category_id_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nama_barang[]" data-id="nama_barang" id="nama_barang" placeholder="Nama Barang" required>
                                    <small id="nama_barang_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="qty[]" data-id="qty" placeholder="QTY" id="qty" onkeyup="total_harga_it_po(this)" required>
                                    <small id="qty_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="harga[]" data-id="harga"  id="harga" placeholder="Harga" onkeyup="total_harga_it_po(this)" required>
                                    <small id="harga_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control" data-id="total_harga_row" readonly>
                            </td>
                            <td>
                                <div class="d-flex align-items-center" onclick=delete_row_it_po(this)>
                                    <button class="btn btn-danger btn-md">
                                        <i class="fas fa-trash-alt"></i> 
                                        Delete
                                    </button>
                                </div>
                            </td>
                            <td>
                                <input type="checkbox" class="form-control checkbox" id="accept_user" name="accept_user[]" alt="Check When User Have Accept Item" value="on">
                            </td>
                        </tr>`;
                $('tbody').append(form);
                getCategory();
            }else{
                $(".select-category").select2('destroy'); 
                let num = parseInt( div.prop("id").match(/\d+/g), 10 ) +1;
                let clone = div.clone().prop('id', 'form-it-'+num );
                $('tbody').append(clone);
            }
            
            $('.select-category').select2({
                dropdownParent: $('#modal'),
            })
        }

        getCategory = () => {
            $.ajax({
                type:"get",
                url:"{{url('ticketing/product/category')}}",
                success: (res) => {
                    let data = res.data;
                    let option = '<option value="">Select Category</option>';
                    for (let index = 0; index < data.length; index++) {
                        option += `<optgroup class="class="select2-result-selectable" label="${data[index].category_name}"> `;
                        let data2 = data[index].sub_product_category;
                        for (let index2 = 0; index2 < data2.length; index2++) {
                            option += `<option value="${data2[index2].sub_category_id}">${data2[index2].sub_category_name}</option>`;
                        }
                        option += '</optgroup>';
                    }
                    $('.select-category').append(option);
                }
            })
        }

        total_harga_it_po = (data) => {
            let parent = $(data).parent().parent().parent().attr('id');
            let qty = $(`#${parent} td div input[data-id="qty"]`).val();           
            let harga = $(`#${parent} td div input[data-id="harga"]`).val();
            NumberToRupiah('',harga,'Rp. ',parent)
            harga = NumberToRupiah('number',harga)
            harga = harga.replaceAll('.','');
            if (harga != 0 && qty != 0 && qty > 0) {
                let jumlah_harga_row = qty * harga;
                jumlah_harga_row = 'Rp. ' + parseInt(jumlah_harga_row).toLocaleString()
                $(`#${parent} td input[data-id="total_harga_row"]`).val(jumlah_harga_row);
            }else{
                $(`#${parent} td input[data-id="total_harga_row"]`).val("");
            }

            total_all_item();

        }

        total_all_item = () => {
            let data = $('input[data-id*="total_harga_row"]');
            let total = 0;
            for (let index = 0; index < data.length; index++) {
                let el = data[index];
                let angka = NumberToRupiah('number',el.value);
                if (angka != '') {
                    angka = angka.replaceAll('.','');
                    total = parseInt(total) + parseInt(angka);
                }
            }

            $('#all_total').text('Total : Rp. ' + parseInt(total).toLocaleString()); 

        }

        delete_row_it_po = (data) => {
            let id = $(data).parent().parent().attr('id');
            $(`#${id}`).remove()
        }

        add_request = () => {
            let formData = new FormData($("#form").get(0));
            formData = fileToFormData(formData);
            formData.append('type_id',$('#ticket_type').val());
            Helper.insertImage(formData);
        }


        fileToFormData = (formData) => {
            let image = $(`#file_upload`).filepond('getFiles');
            for (let index = 0; index < image.length; index++) {
                formData.append(`file_upload[]`,image[index].file);
            }
            return formData;
        }

        NumberToRupiah = (type,angka, prefix =  "Rp. ",id) => {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "" + split[1] : rupiah;

            if (type == "number") {
                return split.join("");
            }else{
                let result = prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
                $(`#${id} td div input[data-id="harga"]`).val(result);
            }
        }
        // END FUNCTION IT PO
        
        // START FUNCTION SAP USER
        const sap_user = () => {
            let form = `<div class="mb-2">
                            <button class="btn btn-md btn-success" onclick="create_form_sap_user()">
                                <i class="fas fa-plus"></i>  Add Row
                            </button>
                            <button class="btn btn-primary" type="button" onclick="validate()"> <i class="fas fa-save"></i> 
                                Save
                            </button>
                        </div>
                        <div class="row">
                            <div class="col">
                                    <form class="form form-vertical needs-validation" novalidate id="form">
                                        @csrf
                                        <div class="row mt-2">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Request System</label>
                                                    <select type="text" class="form-control" name="user_for[]" data-id="user_for" id="user_for" data-placeholder="Request Application" multiple="multiple" required>
                                                        <option value=""">Choose Request Application</option>
                                                    </select>
                                                    <small id="user_for_alert" class="form-text text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Request Type</label>
                                                    <select type="text" class="form-control" name="request_type" data-id="request_type" id="request_type" data-placeholder="User Type" required>
                                                        <option value="" disabled selected>User Type</option>
                                                        <option value="create_new">Create New User</option>
                                                        <option value="reset">Reset Password</option>
                                                    </select>
                                                    <small id="request_type_alert" class="form-text text-danger"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-body">
                                            <div class="row form-body-row pl-3 pr-3">
                                                <table class="table table-bordered" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:20%">User</th>
                                                            <th style="width:20%">Email</th>
                                                            <th style="width:5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <hr></hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Reason </label>
                                                    <textarea class="form-control" id="reason" name="reason" rows="3" wrap="hard" placeholder="Reason" style="resize:none;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Description </label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" wrap="hard" placeholder="Description" style="resize:none;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>`
            $('.modal-body').append(form);
            $('#user_for').select2({
                dropdownParent: $('#modal'),
                placeholder: "Select User For",
            })

            $('#request_type').select2({
                dropdownParent: $('#modal'),
                placeholder: "Select User Type",
            })
            create_form_sap_user();
            getOptionRequestSystem('#user_for');
        }

        const create_form_sap_user = () => {
            let div = $('tr[id^="form-sap-"]:last');
            if (div.length == 0 ) {
                form = `                        
                        <tr id="form-sap-0" class="sap">
                            <td>
                                <div class="form-group">
                                    <select class="form-control select-user" name="user_nik[]" data-id="user_nik" required onchange="setFormSAP(this)"></select>
                                    <small id="user_nik_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control email" name="email[]" data-id="email" id="email" placeholder="User Email" disabled>
                                    <small id="email_alert" class="form-text text-danger"></small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center" onclick=delete_row_it_po(this)>
                                    <button class="btn btn-danger btn-md">
                                        <i class="fas fa-trash-alt"></i> 
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                $('tbody').append(form);
                getUser();
                
            }else{
                $(".select-user").select2('destroy'); 
                let num = parseInt( div.prop("id").match(/\d+/g), 10 ) +1;
                let id = 'form-sap-'+ num; 
                let clone = div.clone().prop('id', id );
                $('tbody').append(clone);
                // console.log($(`#form-sap-${num} .email`))
                // console.log(`#form-sap-${num} .email`)
                $(`#form-sap-${num} .email`).val();
            }
            
            $('.select-user').select2({
                dropdownParent: $('#modal'),
            })
            
        }

        const getUser = () => {
            let department_id = checkNIK() == false ? "{{ Auth::user()->department_id }}" : null;
            $.ajax({
                url : "{{ url('/getall/user') }}",
                data : {
                    department_id : department_id
                },
                success : (res) => {
                    let data = res.data
                    let option = '<option>Select User Nik</option>'
                    data.forEach(item => {
                        option += `<option value="${item.user_nik}" data-email="${item.user_email}">${item.user_nik} - ${item.user_name}</option>`
                    });
                    $('.select-user').append(option)
                }
            })
        }

        setFormSAP = (data) => {
           let email = $('option:selected',data).data("email");
           let parent = $(data).closest('.sap');
           let id = $(parent).attr('id');
           $(`#${id} .email`).val(email);
        }

        const getOptionRequestSystem = (selector) => {
            $.ajax({
                type : "GET",
                url : "{{ url('ticketing/system/applications') }}",
                success : (res) => {
                    let data = res.data;
                    let option = '';
                    for (let index = 0; index < data.length; index++) {
                       option += `<option value="${data[index].system_name}">${data[index].system_name}</option>`
                    }
                    $(selector).append(option)
                }
            })
        }
        // END FUNCTION SAP USER

        //START FUNCTION CRA (create request application)

        const cra = () => {
            let form = `<div class="mb-2">
                            <button class="btn btn-primary" type="button" onclick="validate()"> <i class="fas fa-save"></i> 
                                Save
                            </button>
                        </div>
                        <div class="row">
                            <div class="col">
                                    <form class="form form-vertical needs-validation" novalidate id="form">
                                        @csrf
                                        <div class="row mt-2">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Request Type</label>
                                                    <select type="text" class="form-control" name="request_type" data-id="request_type" id="request_type" data-placeholder="User Type" required>
                                                        <option value="" disabled selected></option>
                                                        <option value="change_application">Change Application</option>
                                                        <option value="request_application">Request Application </option>
                                                    </select>
                                                    <small id="request_type_alert" class="form-text text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Request Application</label>
                                                    <select class="form-control" name="application_for" data-id="application_for" id="application_for" data-placeholder="User For" required>
                                                        <option val="">Choose Request Application</option>
                                                    </select>
                                                        
                                                    <small id="application_for_alert" class="form-text text-danger"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <hr></hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Reason </label>
                                                    <textarea class="form-control" id="reason" name="reason" rows="3" wrap="hard" placeholder="Reason" style="resize:none;" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Description </label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" wrap="hard" placeholder="Description" style="resize:none;" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr></hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Attach File </label>
                                                    <input type="file" class="filepond" name="file_upload" id="file_upload" multiple data-max-file-size="3MB" data-max-files="2">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>`
            $('.modal-body').append(form);
            getOptionRequestSystem('#application_for');
            $('#request_type').select2({
                dropdownParent: $('#modal'),
                placeholder: "Select User For",
                allowClear: true
            })

            $('#application_for').select2({
                dropdownParent: $('#modal'),
                placeholder: "Select User Type",
            })
        }


    </script>
@endsection