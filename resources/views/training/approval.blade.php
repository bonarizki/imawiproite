@extends('training/master/master')
@section('breadcumb','Approval Training')
@section('title','Approval Training')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered table-hover table-sm" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th style=" width: 55px !important;">Training ID</th>
                                    <th style=" width: 55px !important;">Training Topic</th>
                                    <th style=" width: 55px !important;">Total Participant</th>
                                    <th style=" width: 55px !important;">Training Fee</th>
                                    <th style=" width: 50px !important;">Start Date</th>
                                    <th style=" width: 50px !important;">End Date</th>
                                    <th style=" width: 15px !important;">View</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style=" width: 55px !important;">Training ID</th>
                                    <th style=" width: 55px !important;">Training Topic</th>
                                    <th style=" width: 55px !important;">Total Participant</th>
                                    <th style=" width: 55px !important;">Training Fee</th>
                                    <th style=" width: 50px !important;">Start Date</th>
                                    <th style=" width: 50px !important;">End Date</th>
                                    <th style=" width: 15px !important;">View</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal View Detail Training --}}
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
                        <td id="training_fee"></td>
                    </tr>
                    <tr>
                        <td>Training Participant</td>
                        <td>:</td>
                        <td id="training_participants"></td>
                    </tr>
                    <tr id="service-bond-master" hidden>
                        <td>Service Bond</td>
                        <td>:</td>
                        <td id="service-bond"></td>
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
                <div id="approve-reject" hidden>
                    <button class="btn btn-danger pr-2" id="btn-reject">
                        <span class="" title="Reject" data-toggle="tooltip" data-placement="bottom">
                            Reject
                        </span>
                    </button>
                    <button class="btn btn-success" id="btn-approve">
                        <span class="" title="Approve" data-toggle="tooltip" data-placement="bottom">
                            Approve
                        </span>
                    </button>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<link type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            destroy:true,
            info: false,
            ajax : "{{url('training/approval/data')}}",
            columns:[
                {
                    data:"training_id",
                    name:"training_id",
                },
                {
                    data:"training.training_topic",
                    name:"training.training_topic",
                },
                {
                    data:"training.training_participants",
                    name:"training.training_participants",
                },
                {
                    data:"training.training_fee",
                    name:"training.training_fee",
                    render:(data) => {
                        return 'Rp. ' + parseInt(data).toLocaleString();
                    }
                },
                {
                    data:"training.training_start_date",
                    name:"training.training_start_date",
                },
                {
                    data:"training.training_end_date",
                    name:"training.training_end_date",
                },
                {
                    data:"training_id",
                    name:"training_id",
                    render:(data) => {
                        return `<center>
                                    <button class="btn btn-sm btn-info" title="Detail" data-toggle="tooltip" data-placement="bottom" onclick="detail('${data}')">
                                        <span class="fa fa-eye">
                                        </span>
                                        Detail
                                    </button>
                                </center>`
                    }
                },
            ], 
            
            rowCallback: function (row, data, index) {
                let result = approvalaAction(data);
                if (result == true) $(row).hide(); // true untuk hide , false untuk show
            },
        })
    });

    const Helper = new valbon();

    detail = (id) => {
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
                let vendor_name = data.vendor == null ? 'Vendor Not Set' : data.vendor.vendor_name;
                $('#title-modal-detail').text(`Detail Training Request ${data.training_id} - ${Helper.capitalizeFirstWords(data.training_approval.training_status)}`);
                $('#training_topic').text(data.training_topic);
                $('#vendor_name').text(vendor_name);
                $('#training_fee').text(formatRp(data.training_fee));
                $('#training_participants').text(data.training_participants);
                let participant = detailParticipant(data);
                let detailData = detailApproval(data.training_approval); //mendapatkan data detail approval nik 1-6 dan approval nik ceo-hr
                let bond = conditionBond(Math.round(parseInt(data.training_fee) / parseInt(data.training_participants)));
                if (bond != null || bond != '') {
                    $('#service-bond').text(bond);
                    $('#service-bond-master').attr('hidden',false);
                }
                $('#detail-approval').append(detailData.Number);
                $('#detail-approval-CEOHR').append(detailData.CEOHR);
                $('#detail-participant').append(participant);
                $('#modal_detail').modal('show');
                
                let condition = checkApproval(data.training_approval)
                if (condition == false) {
                    $('#approve-reject').attr('hidden',false);
                    $('#btn-reject').attr('onclick',`confirm('${id}','reject')`);
                    $('#btn-approve').attr('onclick',`confirm('${id}','approve')`);
                }else{
                    $('#approve-reject').attr('hidden',true);
                }

                $('.training_fee').text(formatRp(data.training_fee));
                $('#training_purpose').val(data.training_purpose).attr('readonly',true);
            },
            error: (response) => {
                Helper.errorHandle(response);
            },
            complete: () => {
                $('.se-pre-con').hide();
            }
        })
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

    approvalaAction = (data) => { 
        let approver = "{{Auth::user()->user_nik}}";
        let array = arrayApproval(data); // data nama field training nik approval 1- 6 yang tidak kosong
        let string = '';
        let result = '';
        for (let index = 1; index <= 8; index++) { // looping 8 x karena approval 1 s/d 6  + hr + ceo
            //string digunakan untunk menyimpan nilai dari index yang akan di gunakan 
            let string = chooseIndex(index);
            if (data[`training_approval_nik_${string}`] == approver) { // jika data training approval nik sama dengan approver (approver di ambil dari session)
                if (index != 1) {
                    if (string == 'hr' || string == 'ceo') { // untuk approval nik ceo dan hr
                        let LastApprovalNik = array[array.length - 1];
                        if (data[LastApprovalNik+='_date'] == null) {
                            result = true;
                            break;
                        }else{
                            //jika string hr dan approval ceo tidak kosong dan ceo belom approve maka hide
                            if (string == 'ceo' && data[`training_approval_nik_hr`] != null && data[`training_approval_nik_hr_date`] == null) {
                                result = true;
                                break;
                            }

                            // jika approval nik current tidak kosong maka hide
                            if (data[`training_approval_nik_${string}_date`] != null) { 
                                result = true;
                                break
                            }

                            result = false;
                            break;
                        }
                    }else{ // untuk approval nik 1 - 6
                        let field_date = `training_approval_nik_${parseInt(string)-1}_date`;
                        if (data[field_date] == null  ) { // jika approval nik sebelumnya null maka hide
                            result = true;
                            break
                        }else{
                            if (data[`training_approval_nik_${string}_date`] != null) { // jika approval nik current tidak kosong maka hide
                                result = true;
                                break
                            }

                            result = false; // menapmpilkan 
                            break
                        }
                    }
                }else{
                    if (index == 1 && data[`training_approval_nik_${parseInt(string)}_date`] == null) {
                        result = false;
                        break;
                    }

                    result = true
                    break;
                }
            }    
        }
        return result;
    }


    confirm = (id,type) => {
        Swal.fire({
            title: `Are you sure to ${type} this request?`,
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${type} it!`,
            preConfirm: () => {
                if(type == 'approve'){
                    prosesApprove(id)
                }else{
                    prosesReject(id);
                } 
            }
        })
    }

    prosesReject = (id) => {
        $.ajax({
            type:"post",
            url : "{{url('training/approval/data/reject')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                training_id : id
            },
            beforeSend : () => {
                $('.se-pre-con').show();
            },
            success : (response) => {
                Helper.sweetSuccess(response.message,response.data.message);
                $(`#table`).DataTable().ajax.reload();
            },
            complete : () => {
                $('.se-pre-con').hide();
            }
        })
    }

    prosesApprove = (id) => {
        $.ajax({
            type:"post",
            url : "{{url('training/approval/data')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                training_id : id
            },
            beforeSend : () => {
                $('.se-pre-con').show();
            },
            success : (response) => {
                Helper.sweetSuccess(response.message,response.data.message);
                $(`#table`).DataTable().ajax.reload();
                $('#modal_detail').modal('hide');
            },
            complete : () => {
                $('.se-pre-con').hide();
            }
        })
    }

    checkApproval = (data) => {
        let user_nik = "{{Auth::user()->user_nik}}";
        let training_approval = "training_approval_nik_";
        let result = '';
        for (let index = 1; index <= 8 ; index++) {
            //string digunakan untunk menyimpan nilai dari index yang akan di gunakan 
            let string = chooseIndex(index);
            if (user_nik == data[`${training_approval+string}`]) {
                if (data[`${training_approval+string}_date`] != null ) {
                    return true;
                    break;
                }else {
                    result = false; //false jika training_approval_{index}_date masih null
                    break;
                }
            }
        }
        return result;
    }

    chooseImage = (array,approval_nik,data) => {
        let inarr = array.indexOf(approval_nik)
        let image = ''
        if (data[array[inarr + 1]+='_date'] == null && data.training_status == 'reject') {
            image = '/images/rejected.png';
        }else{
            image = '/images/approved.png'
        }
        return image;
    }

    chooseIndex = (index) => {
        let str = '';

        if (index == 7) {
            str = 'ceo'
        }else if(index == 8) {
            str = 'hr'
        }else{
            str = index
        }

        return str;
    }

    arrayApproval = (data) => {
        let array = [];
        for (let index = 1; index <= 6; index++) { // looing data approval training nik 1 - 6
            if (data[`training_approval_nik_${index}`] != null) { // jika data looping approval nik tidak kosong maka di masukan kedalam array
                array.push(`training_approval_nik_${index}`);
            }
        }
        return array;
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

    formatRp = (data) => {
        let nominal = 'Rp. ' + parseInt(data).toLocaleString();
        return nominal;
    }

    conditionBond = (average_fee) => {
        let textInfo = null;
        if (average_fee >= 10000000 && average_fee <= 15999999) {
            textInfo = 'service bond 18 (Eighteen) months.'
        }else if(average_fee >= 16000000 && average_fee <= 25000000){
            textInfo = 'servicebond for 30 (thirty) months'
        }else if(average_fee > 25000000){
            textInfo = 'servicebond for 36 (thirty six) months'
        }
        return textInfo;
    }


    
</script>
@endsection