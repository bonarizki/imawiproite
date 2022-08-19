@extends('training/master/master')
@section('title','Training Request')

{{-- filepond --}}
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

@section('breadcumb','Training Request')
@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4 class="card-title">Trainig Request Form</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <form class="form form-horizontal" id="form">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Topic of Training</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" id="training_topic" name="training_topic" class="form-control" placeholder="Topic of Training">
                                                <small id="training_topic_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Training Purpose</span>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea id="training_purpose" name="training_purpose" class="form-control" placeholder="Training Purpose" rows="5"></textarea>
                                                <small id="training_purpose_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Training Institution</span>
                                            </div>
                                            <div class="col-md-5">
                                                <select id="vendor_type" name="vendor_type" class="form-control" onchange="getVendor(this)">
                                                    <option value="">Select Vendor Type</option>
                                                    <option value="perorangan">Personal</option>
                                                    <option value="lembaga">Lembaga</option>
                                                    <option value="Internal">Internal</option>
                                                </select>
                                                <small id="vendor_type_alert" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-5">
                                                <select id="vendor_id" name="vendor_id" class="form-control select2bs4">
                                                    <option value="">Select Training Instituion</option>
                                                </select>
                                                <small id="vendor_id_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Date of Training</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" id="training_date" class="form-control format-picker" name="training_date" placeholder="Date of Training">
                                                <small id="training_start_date_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Training Hour</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" id="training_hour" class="form-control" name="training_hour" placeholder="Training Hour">
                                                <small id="training_hour_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Training Method</span>
                                            </div>
                                            <div class="col-md-10">
                                                <select id="method_id" name="method_id" class="form-control select2bs4">
                                                    <option value="">Select Training Method</option>
                                                </select>
                                                <small id="method_id_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Training Fee</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" id="training_fee" class="form-control" name="training_fee" placeholder="Training Fee" onkeyup="formatRupiah(this)">
                                                <small id="training_fee_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>Training of Participants</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="method_participant" value="input">
                                                    <label class="form-check-label" for="inlineRadio1">Input</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="method_participant" value="upload">
                                                    <label class="form-check-label" for="inlineRadio2">Upload</label>
                                                </div>
                                                <small id="method_participant_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 input last" hidden>
                                        <div class="form-group row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                                <input type="number" id="training_participants" class="form-control" name="training_participants" placeholder="Number of Participants" oninput="showFormParticipant(this)">
                                                <small id="training_participants_alert" class="form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 upload">
                                        <div class="form-group row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10" style="height:100%">
                                                <div style="height:100%">
                                                    <label>File Excel | <i><a href="{{asset('file_uploads/file/template_participant.xlsx')}}">download template</a></i></label>
                                                    <input type="file" class="filepond image-filepond" name="file" id="file" multiple data-max-file-size="3MB" data-max-files="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group buttonArea row" hidden>
                                            <div class="col-md-2"></div>
                                            <div class="col" id="clear">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                                <div id="table-area" hidden>
                                                    <hr>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped" id="table-upload" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>User NIK</th>
                                                                    <th>User Name</th>
                                                                    <th>Information</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end pt-4">
                                        <button type="button" class="btn btn-primary mr-1 mb-1" onclick="validasi()">Save</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<link type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
{{-- filepond --}}
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script>
        const data = {
            id_name : "training_request_id",
            create : {
                url:"{{url('training/request')}}",
                method : "post",
            }
        }

        const Validation = new valbon (data)
        const field = ["category_name"];
        const ArrParticipant = [];


        $(document).ready(function () {
            // $('#form').on('keyup keypress', function(e) {
            //     var keyCode = e.keyCode || e.which;
            //     if (keyCode === 13) { 
            //         e.preventDefault();
            //         return false;
            //     }
            // });

            $('#training_date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#training_date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' sd ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#training_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('#training_hour').daterangepicker({
                timePicker : true,
                // singleDatePicker:true,
                timePicker24Hour : true,
                timePickerIncrement : 1,
                locale : {
                    format : 'HH:mm'
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
            });


            getParticipant();
            getMethod();
        });

        getMethod = () => {
            $('.method-option').remove();
            $.ajax({
                type:"GET",
                url:"{{route('method-show')}}",
                success:(res) => {
                    let data = res.data;
                    let option = ''
                    data.forEach(item => {
                        option += `
                            <option class="method-option" value="${item.method_id}" >${item.method_name}</option>
                        `
                    });
                    $('#method_id').append(option)
                },
                error:(res) => {
                    Validation.errorHandle(res);
                }
            })
        }

        /* Fungsi formatRupiah */
        formatRupiah = (data, prefix =  "Rp. ") => {
            let rupiah = NumberToRupiah(data.value)
            $('#training_fee').val(rupiah);
            calculateFeeParticipant();
        }

        showFormParticipant = (data) => {
            $('#training_participants').prop("disabled",true);
            $('.participant-head').remove();
            if (data.value != "" || data.value != 0) {
                let form = '';
                for (let index = 0; index < data.value; index++) {
                    form += `<div class="col-12 participant-head" id="participant_${index}">
                                <div class="form-group row">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-5">
                                        <select type="text" id="participant_name_${index}" class="form-control select2bs4 participant-select" name="participant_name[]" placeholder="Participant Name" onchange="chekUser(this)">
                                            <option value=""> Select Participant </>
                                        </select>
                                        <small id="participant_name_${index}_alert" class="form-text text-danger"></small>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center" id="info-participant-${index}">
                                    </div>
                                    <div class="col-md-1 float-right d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick=RemoveForm(this)>
                                            <span class="fa fa-window-close"></span>
                                        </button>
                                    </div> 
                                </div>
                            </div>`;
                }
                $(form).insertAfter('.last');

                calculateFeeParticipant();
            }
            showParticipant();
            $('.select2bs4').select2({theme:'bootstrap4'});
            $('#training_participants').prop("disabled",false);
        }

        showParticipant = (data = null) => {
            let option = ''
            $('.flexibel-option').remove();
            ArrParticipant.forEach(item => {
                option += `
                            <option value="${item.user_nik}" class="flexibel-option">${item.user_nik} - ${item.user_name}</option>
                        `
            });
            let selector = data == null ? '.participant-select' : `#${data.id}`;
            $(`${selector}`).append(option)
        }

        getParticipant = () => {
            let url = '';
            let nik = "{{Auth::user()->user_nik}}";
            Validation.chekNik(nik) == true
                ? url = "{{url('training/get-participant-all')}}"
                : url = "{{url('training/get-participant')}}"
            
            $.ajax({
                url: url,
                beforeSend: () => {
                    $('.participant-select').prop("disabled", true)
                },
                success: (res) => {
                    res.forEach(item => {
                        ArrParticipant.push({
                            user_nik:item.user_nik,
                            user_name:item.user_name
                        });
                    });
                }
            }).done( ()=>{
                calculateFeeParticipant();
            });
        }

        calculateFeeParticipant = () => {
            let fee = $('#training_fee').val();
            let participant = $('#training_participants').val();
            let average_fee = 0;
            if(fee != 0 && fee != "" && participant != ""){
                var number_string = fee.replace(/[^,\d]/g, "").toString();
                average_fee = number_string / participant
            }
            average_fee = Math.round(average_fee);
            let textInfo = conditionBond(average_fee);
            showCalculateResult(textInfo);
        }

        conditionBond = (average_fee) => {
            let textInfo = null;
            if (average_fee >= 10000000 && average_fee <= 15999999) {
                textInfo = NumberToRupiah(`${average_fee}`) + ' - Servicebond 18 (Eighteen) months.'
            }else if(average_fee >= 16000000 && average_fee <= 25000000){
                textInfo = NumberToRupiah(`${average_fee}`) + ' - Servicebond for 30 (thirty) months'
            }else if(average_fee > 25000000){
                textInfo = NumberToRupiah(`${average_fee}`) + ' - Servicebond for 36 (thirty six) months'
            }else{
                textInfo =  NumberToRupiah(`${average_fee}`) ;
            }
            return textInfo;
        }

        showCalculateResult = (average_fee) => {
            let data = $('div[id^="info-participant-"]');
            for (let index = 0; index < data.length; index++) {
                $(`#${data[index].id}`).text(average_fee)
            }
        }

        NumberToRupiah = (angka, prefix =  "Rp. ") => {
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

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

        chekUser = (data) => {
            let number = $('#training_participants').val();
            $('.is-invalid').removeClass('is-invalid');
            for (let index = 0; index < number; index++) {
                let id = `participant_name_${index}`;
                let nik = $(`#participant_name_${index}`).val()
                if(id != data.id){
                    if(nik === data.value){
                        $(`#${data.id}`).addClass('is-invalid');
                        $(`#${data.id}`).val('');
                        $(`#${data.id}_alert`).text(`can't select nik`);
                        Validation.sweetError(`can't select nik`)
                    }
                }
            }
        }

        RemoveForm = (data) => {
            let parent = $(data).closest('.participant-head'); // mengambil class participant - head
            let id = parent[0].id; // mendapatkan id dari form participan yang di klik
            let total_participant = $('.participant-head').length - 1; //total class participatn-head dikuran 1 karena menghapus form participant
            $('#training_participants').val(total_participant);
            $(`#${id}`).remove();
            changeIdSelect();
            changeIdSmall();
            calculateFeeParticipant();
        }

        changeIdSelect = () => {
            let form_participant = $('select[id^="participant_name_"]'); // get semua id yg memiliki id "participant_name"
            for (let index = 0; index < form_participant.length; index++) {
                let id_participant = form_participant[index].id
                $(`#${id_participant}`).attr('id',`participant_name_${index}`);
            }
        }

        changeIdSmall = () => {
            let form_participant = $('small[id^="participant_name_"]'); // get semua id yg memiliki id "participant_name"
            for (let index = 0; index < form_participant.length; index++) {
                let id_participant = form_participant[index].id
                $(`#${id_participant}`).attr('id',`participant_name_${index}_alert`);
            }
        }

        getVendor = (data) => {
            $('.vendor-option').remove();
            $.ajax({
                type:"GET",
                url:"{{route('vendor-type')}}",
                data: {
                    vendor_type : data.value
                },
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success:(res) => {
                    data = res.data;
                    let option = ''
                    data.forEach(item => {
                        option += `
                            <option class="vendor-option" value="${item.vendor_id}" >${item.vendor_name}</option>
                        `
                    });
                    option += `
                        <option class="vendor-option" value="other" >Other</option>
                    `
                    $('#vendor_id').append(option)
                },
                error:(res) => {
                    Validation.errorHandle(res);
                }
            }).done( () =>{
                $('#vendor_id').prop("disabled", false);
                $('.se-pre-con').hide();
            });
        }

        async function validasi () {
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').empty();
            let result = Validation.loopingValidasi(data);
            if (result.length == 0) {
                var formData = new FormData($("form").get(0));
                formData = fileToFormData(formData);
                Validation.insertImage(formData).then( (res) => {
                    if (res.status == 200) {
                        $('.participant-head').remove();
                        clearForm();
                    }
                })
            } else {
                Validation.loopingErrorEmpty(result);
            }
        }

        $('input[name=method_participant]').on('change', function() {
            let type = $('input[name=method_participant]:checked').val();
            if (type == 'input') {
                clearForm()
                $('.upload').attr('hidden',true);
                $('.input').attr('hidden',false);
            }else{
                $('.participant-head').remove();
                $('.upload').attr('hidden',false);
                $('.input').attr('hidden',true);
            }
        });

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
                        url: "{{url('training/upload-participant/validate')}}",
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
                            makeTable(data)
                        },
                        onerror: function (response) {
                            Valitadion.sweetError('Template not match');
                        },
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }
            });
        });

        makeTable = (data) => {
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
                    if ([0,1].includes(i)) {
                        if(data[index].values[keys[i]] == row[i]){
                            if(data[index].values[keys[i]] == '' || data[index].values[keys[i]] == null){
                                return data[index].errors
                            }
                        }
                    }
                }
            }
            return 'validate success';
        }

        addFail = (data) => {
            let array = [];
            for (let index = 0; index < data.length; index++) {
                //dikuran 2 karena (excel mulai hitung array dari 1 dan dan saat row 1 itu heading)
                array.push(data[index].row - 2);
            }
            return array;
        }

        function clearForm() {
            $('#clear').empty();
            $('#save').empty();
            $('#card-message').empty();
            $('.buttonArea').attr('hidden', true);
            $('#table-area').attr('hidden', true);
            files.filepond('removeFiles');
        }

        function fileToFormData(formData) {
            let excel = files.filepond('getFiles')
            if (excel.length > 0) {
                formData.delete('file');
                formData.append('file', excel[0].file)
            }
            return formData;
        }

    </script>
    
@endsection