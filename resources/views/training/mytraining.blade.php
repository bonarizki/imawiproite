@extends('training/master/master')
@section('title','My Training')
@section('breadcumb','My Training')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4 class="card-title">Training History</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-bordered table-striped" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th style=" width: 5px !important;">#</th>
                                    <th style=" width: 55px !important;">Training ID</th>
                                    <th style=" width: 55px !important;">Training Topic</th>
                                    <th style=" width: 55px !important;">Total Participant</th>
                                    <th style=" width: 80px !important;">Start Date</th>
                                    <th style=" width: 80px !important;">End Date</th>
                                    <th style=" width: 30px !important;">Status</th>
                                    <th style=" width: 15px !important;">Detail</th>
                                    <th style=" width: 15px !important;">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style=" width: 5px !important;">#</th>
                                    <th style=" width: 55px !important;">Training ID</th>
                                    <th style=" width: 55px !important;">Training Topic</th>
                                    <th style=" width: 55px !important;">Total Participant</th>
                                    <th style=" width: 80px !important;">Start Date</th>
                                    <th style=" width: 80px !important;">End Date</th>
                                    <th style=" width: 30px !important;">Status</th>
                                    <th style=" width: 15px !important;">Detail</th>
                                    <th style=" width: 15px !important;">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" data-backdrop="static" data-keyboard="false" id="modal_detail" role="dialog" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal-detail"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>Training Topic</td>
                            <td>:</td>
                            <td id="training_topic"></td>
                        </tr>
                        <tr>
                            <td>Instructor</td>
                            <td>:</td>
                            <td id="vendor_name"></td>
                        </tr>
                        <tr>
                            <td>Training Fee</td>
                            <td>:</td>
                            <td class="training_fee"></td>
                        </tr>
                        <tr>
                            <td>Training Participant</td>
                            <td>:</td>
                            <td id="training_participants"></td>
                        </tr>
                        <tr id="service-bond-master">
                            <td>Service Bond</td>
                            <td>:</td>
                            <td id="service-bond"></td>
                        </tr>
                        <tr>
                            <td>Training Category</td>
                            <td>:</td>
                            <td id="training_category_td"></td>
                        </tr>
                        <tr>
                            <td>Training Date Actual</td>
                            <td>:</td>
                            <td class="training_date_actual"></td>
                        </tr>
                        <tr>
                            <td>Meeting Session</td>
                            <td>:</td>
                            <td class="training_total"></td>
                        </tr>
                        <tr>
                            <td>Training Method</td>
                            <td>:</td>
                            <td class="training_method"></td>
                        </tr>
                        <tr>
                            <td class="align-top">Training Purpose</td>
                            <td class="align-top">:</td>
                            <td style="width:500px">
                                <textarea name="training_purpose" id="training_purpose" rows="3" class="form-control form"></textarea>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div class="border border-secondary">
                        <div class="pl-1 pr-1 mt-1 mb-1">
                            <h3>Detail Participants</h3>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 25%"><center>User Nik	</center></th>
                                        <th style="width: 25%"><center>User Name</center></th>
                                        <th style="width: 25%"><center>Department</center></th>
                                        <th style="width: 25%"><center>Cost Training</center></th>
                                    </tr>
                                </thead>
                                <tbody id="detail-participant">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="border border-secondary">
                        <div class="pl-1 pr-1 mt-1 mb-1">
                            <h3>Detail Approval</h3>
                            <table class="table table-striped" >
                                <thead>
                                    <tr>
                                        <th style="width: 12%"><center>Approval Nik 1</center></th>
                                        <th style="width: 12%"><center>Approval Nik 2</center></th>
                                        <th style="width: 12%"><center>Approval Nik 3</center></th>
                                        <th style="width: 12%"><center>Approval Nik 4</center></th>
                                        <th style="width: 12%"><center>Approval Nik 5</center></th>
                                        <th style="width: 12%"><center>Approval Nik 6</center></th>
                                    </tr>
                                </thead>
                                <tbody id="detail-approval">

                                </tbody>
                            </table>
                            <table class="table table-striped" >
                                <thead>
                                    <tr>
                                        <th style="width: 12%"><center>Approval Nik CEO</center></th>
                                        <th style="width: 12%"><center>Approval HR</center></th>
                                    </tr>
                                </thead>
                                <tbody id="detail-approval-CEOHR">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="button-download">Download</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('training/trainingFeedbackForm')
</section>
@endsection

@section('script')
    <script>

        const data = {
            create : {
                url:"{{url('training/mytraining/feedback')}}",
                method : "post",
            }
        }

        const Helper = new valbon(data);

        $(document).ready(function () {
            $('#table').DataTable({
                ajax: "{{url('training/mytraining/data')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "training_id",
                        name: "training_id"
                    },
                    {
                        data: "training.training_topic",
                        name: "training.training_topic"
                    },
                    {
                        data: "training.training_participants",
                        name: "training.training_participants"
                    },
                    {
                        data: "training.training_start_date",
                        name: "training.training_start_date"
                    },
                    {
                        data: "training.training_end_date",
                        name: "training.training_end_date"
                    },
                    {
                        data: "training.training_approval.training_status",
                        name: "training.training_approval.training_status"
                    },
                    {
                        data: "training_id",
                        name: "training_id",
                        render: (data) => {
                            return `<center>
                                                <span class="fa fa-eye" title="Detail" data-toggle="tooltip" data-placement="bottom" onclick="detail('${data}')">
                                                </span>
                                            </center>`
                        }
                    },
                    {
                        data: "training_id",
                        name: "training_id",
                        render: (data,meta,row) => {
                            if (row.feedback != null) {
                                return 'thanks for feedback'
                            }else{
                                return `<center>
                                            <span class="feather icon-edit" title="feedback" data-toggle="tooltip" data-placement="bottom" onclick="feedack('${data}')">
                                            </span>
                                        </center>`
                            }
                        }
                    }
                ]
            })
        });

        feedack = (id) => {
            let training_id = Helper.backTomin(id);
            $.ajax({
                type:"get",
                url:"{{url('training/participant')}}/"+training_id,
                success:(res) => {
                    $('#training_participant_id').val(res.data.data.training_participant_id);
                    $('#modal-feedback').modal('show');
                }
            })

        }

        detail = (id, type = null, tab = null) => {

            if (type == null || type == '') {
                //mengosongkan training category dari form
                $('#vendor_name').empty()

                //mengosongkan training purpose dari form
                $('#training_purpose').empty()

                //menhapus button save
                $('#button-save').remove();

                //mengosongkan training category dari form
                $('#training_category_td').empty();

                //mengosongkan training date actual dari form
                $('.training_date_actual').empty();

                //mengosongkan training total dari form
                $('.training_total').empty();

                //mengosongkan training method dari form
                $('.training_method').empty();

                //mengosongkan training method dari form
                $('.training_fee').empty();
            }

            $('#detail-approval').empty()
            $('#detail-approval-CEOHR').empty()
            $('#detail-participant').empty()
            $.ajax({
                url: "{{url('training/status/data-id')}}",
                data: {
                    training_id: id
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    let data = res.data
                    $('#title-modal-detail').text(`Detail Training Request ${data.training_id} - ${Helper.capitalizeFirstWords(data.training_approval.training_status)}`);
                    $('#training_topic').text(data.training_topic);
                    $('#training_fee').text(formatRp(data.training_fee));
                    $('#training_participants').text(data.training_participants);
                    let participant = detailParticipant(data);
                    let detailData = detailApproval(data.training_approval); //mendapatkan data detail approval nik 1-6 dan approval nik ceo-hr
                    let bond = conditionBond(Math.round(parseInt(data.training_fee) / parseInt(data.training_participants)));

                    bond != null
                        ? $('#service-bond').text(bond)
                        : $('#service-bond').text('does not need an bond');

                    data.category == null
                        ? $('#training_category_td').text('category not set')
                        : $('#training_category_td').text(data.category.category_name);

                    data.method == null
                        ? $('.training_method').text('method not set')
                        : $('.training_method').text(data.method.method_name);
                    
                    data.training_start_date_actual == null && data.training_end_date_actual == null
                        ? $('.training_date_actual').text('date actual not set')
                        : $('.training_date_actual').text(data.training_start_date_actual +' sd '+ data.training_end_date_actual);

                    data.training_total == null
                        ? $('.training_total').text('total training not set')
                        : $('.training_total').text(data.training_total)

                    data.vendor == null 
                        ?  $('#vendor_name').text("Vendor not set")
                        : $('#vendor_name').text(data.vendor.vendor_name);

                    $('.training_fee').text(formatRp(data.training_fee));
                    $('#training_purpose').val(data.training_purpose).attr('readonly',true);

                    $('#detail-approval').append(detailData.Number);
                    $('#detail-approval-CEOHR').append(detailData.CEOHR);
                    $('#detail-participant').append(participant);
                    $('#button-download').attr('onclick',`download('${id}')`);
                    $('#modal_detail').modal('show');
                },
                error: (response) => {
                    Helper.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        download = (id) => {
            let training_id = backTomin(id);
            window.open("{{url('training/report/request')}}/"+training_id, '_blank');
        }

        backTomin = (id) =>{ // merubah backslah to min
            return id.replace('/','-');
        }

        formatRp = (data) => {
            let nominal = 'Rp. ' + parseInt(data).toLocaleString();
            return nominal;
        }

        conditionBond = (average_fee) => {
            let textInfo = null;
            if (average_fee >= 10000000 && average_fee <= 15999999) {
                textInfo = 'service bond 18 (Eighteen) months.'
            }else if(average_fee >= 16000000 && average_fee <= 25999999){
                textInfo = 'servicebond for 30 (thirty) months'
            }else if(average_fee >= 26000000){
                textInfo = 'servicebond for 36 (thirty six) months'
            }
            return textInfo;
        }

        detailParticipant = (data) => {
            let partipant = data.participant;
            let detailTableParticipant = '';
            partipant.forEach(item => {
                detailTableParticipant += `
                    <tr>
                        <td>${item.user.user_nik}</td>
                        <td>${item.user.user_name}</td>
                        <td>${item.user.department.department_name}</td>
                        <td>${formatRp(Math.round(parseInt(data.training_fee) / parseInt(data.training_participants)))}</td>
                    </tr>
                `;
            });
            return detailTableParticipant;
        }

        detailApproval = (data) => {
            // detailTableApproval untuk data table approval 1-6
            // detailTableApprovalCEOHR untuk data table approval ceo & hr
            let detailTableApproval = '<tr>'; 
            let detailTableApprovalCEOHR = '<tr>';
            for (let index = 1; index <= 8; index++) {
                let approval_nik = 'training_approval_nik';
                let nik_str = ''
                //melakaukan set nik_str
                if (index == 7) {
                    nik_str = 'ceo';
                } else if (index == 8) {
                    nik_str = 'hr';
                } else {
                    nik_str = index;
                }
                approval_nik += `_${nik_str}`
                if (nik_str == 'ceo' || nik_str == 'hr') {
                    detailTableApprovalCEOHR += '<td>'
                    detailTableApprovalCEOHR += detailContentApproval(data,approval_nik);
                    detailTableApprovalCEOHR += '</td>';
                }else{
                    detailTableApproval += '<td>'
                    detailTableApproval += detailContentApproval(data,approval_nik);
                    detailTableApproval += '</td>';
                }
            }
            detailTableApproval += '</tr>';
            detailTableApprovalCEOHR += '</tr>';

            return {Number:detailTableApproval,CEOHR:detailTableApprovalCEOHR};
        }

        detailContentApproval = (data,approval_nik) => {
            let detailApproval = ''
            let array = arrayApproval(data);
            array.push('training_approval_nik_ceo','training_approval_nik_hr'); //menambahkan index
            if (data[approval_nik] != null) {
                let detailAppover = getNameApprove(data[approval_nik]); // mendapatkan nama approval
                detailApproval += `<center>${data[approval_nik]}</center>
                                        <center>${detailAppover}</center>`;
                if (data[approval_nik + '_date'] == null) {
                    detailApproval += `<center> <i> waiting approval </i> </center>`
                } else {
                    let image = chooseImage(array,approval_nik,data) // mendapatkan gambar reject atau approve
                    let date = data[approval_nik + '_date'].split(' ');
                    detailApproval += `<center><img src="{{ asset('${image}') }}" style="height: 50px;"></center>
                                            <center>${date[0]}</center>`
                }
            } else {
                detailApproval += '<center> - </center>';
            }
            return detailApproval;
        }

        getNameApprove = (lastApprove) => {
            let user_name = ''
            $.ajax({
                async: false,
                type: "GET",
                url: "{{url('resignation/user/nik')}}",
                data: {
                    user_nik: lastApprove
                },
                success: function (response) {
                    user_name = response.data.data.user_name
                }
            })
            return user_name;
        }

        getCategory = () => {
            $.ajax({
                type:"get",
                url:"{{url('training/all/category/data')}}",
                success:(res) => {
                    let data = res.data;
                    let option = '';
                    data.forEach(item => {
                        option += `<option value="${item.category_id}">
                                        ${item.category_name}
                                    </option>`;
                    });
                    $('#category_id').append(option);
                }
            })
        }

        chooseImage = (array,approval_nik,data) => {
            let inarr = array.indexOf(approval_nik) // inarr (in array)
            let image = ''
            if (data[array[inarr + 1]+='_date'] == null && data.training_status == 'reject') { // +1 untuk mengecek approval date selanjutnya 
                image = '/images/rejected.png';
            }else{
                image = '/images/approved.png'
            }
            return image;
        }

        arrayApproval = (data) => {
            let array = [];
            for (let index = 1; index <= 6; index++) { // looing data approval resign nik 1 - 6
                if (data[`training_approval_nik_${index}`] != null) { // jika data looping approval nik tidak kosong maka di masukan kedalam array
                    array.push(`training_approval_nik_${index}`);
                }
            }
            return array;
        }

        validasi = () => {
            let data = $('#form').serializeArray();
            let newFailData = [];
            let result = loopingValidasi(data); // melakukan pengecekan validasi apakah data null atau tidak (data returnnya data yg tidak null)
            let array = getUnique(result); //menghapus data yang samma
            let formName = allFormName(); //mendapat kan semua nama input di dalam form
            let failData = formName.filter(x => !array.includes(x));
            console.log(failData)
            if (failData.length == 0) {
                let data = $('#form').serialize();
                Helper.insert().then(()=>{
                    $('#modal-feedback').modal('hide');
                });
            }else{
                newFailData = array.length == 0 ? formName : failData
                Helper.loopingErrorEmpty(newFailData);
            }
        }

        //mengecek apakah resign feedback yang di data dan looping sama jika sama maka data tersebut direturn
        loopingValidasi = (data) => {
            let dataArray = ['training_participant_id'];
            for (let index = 1; index <= 27; index++) { // 27 karena jumlah soal itu ada 27
                for (let i = 0; i < data.length; i++) {
                    let num = index 
                    if(data[i]['name'] == "training_feedback_"+num && data[i]['value'] != ''){
                        dataArray.push(data[i]['name'])
                    }
                }
            }
            return dataArray;
        }

        getUnique = (array) => {
            var uniqueArray = [];
            // Loop through array values
            for(i=0; i < array.length; i++){
                if(uniqueArray.indexOf(array[i]) === -1) {
                    uniqueArray.push(array[i]);
                }
            }
            return uniqueArray;
        }

        allFormName = () => {
            let array = [];
            for (let i = 1 ; i <= 18 ; i++) {
                let num = i 
                array.push("training_feedback_"+num)
            }
            return array
        }
    </script>
@endsection