@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .nav-pills .nav-link {
        padding: 20px;
        margin-right: 10px;
        border-radius: 5px;
        background-color: rgba(32,107,196,.06);
    }
    .nav-pills .nav-link.active, .nav-pills .nav-link:hover {
        background-color: rgba(32,107,196,.77);
        color: #FFFFFF;
    }
    .nav-pills .nav-link .numbering {
        display: flex;
        font-size: 15px;
        border: 1px solid #757575;
        border-radius: 50%;
        justify-content: center;
        align-items: center;
        width: 25px;
        height: 25px;
        margin-right: 10px;
    }
    .nav-pills .nav-link:hover .numbering, .nav-pills .nav-link.active .numbering {
        border: 1px solid #FFFFFF;
    }
    .table thead th, .table tbody td {
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Page Title -->
    <!-- ============================================================== -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Milestone Approval</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Appraisal Approval</li>
                        <li class="breadcrumb-item active">Milestone Appraisal</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Title -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row pt-3 pl-3 pr-3" style="width: 100%;">
                    <div class="col-md-10 col-sm-12">
                        <div class="row pt-1 pl-3">
                            <div class="col-md-2">Employee</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-9">{{ $appraisal->user_name }}</div>
                        </div>
                        <div class="row pt-1 pl-3">
                            <div class="col-md-2">Department</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-9">{{ $appraisal->department_name }}</div>
                        </div>
                        <div class="row pt-1 pl-3">
                            <div class="col-md-2">Level</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-9">{{ $appraisal->grade_group_name }}</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 text-right">
                        <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                        <input type="hidden" name="language" value="eng">
                    </div>
                </div>
                <ul class="nav nav-tabs pt-3 pl-3 pr-3" data-toggle="tabs">
                    <li class="nav-item">
                        <a href="#milestone" class="nav-link active" data-toggle="tab" data-eng="Personal Milestone and Assessment" data-bhs="Penilaian Milestone Pribadi">Personal Milestone and Assessment</a>
                    </li>
                </ul>
                <div class="card-body">
                    <form class="p-2" method="post" id="milestoneForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="appraisal_id" value="{{ $appraisal->appraisal_id }}">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="milestone">
                                <h5 class="mt-1" data-eng="Your Milestones must be set and agreed with your superior and each milestone shall consist the following elements :" data-bhs="Milestone Anda harus ditetapkan dan disetujui oleh atasan Anda dan setiap milestone harus terdiri dari elemen-elemen berikut :">Your Milestones must be set and agreed with your superior and each milestone shall consist the following elements :</h5>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">I.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="How does the milestone links to your department/business strategies." data-bhs="Bagaimana milestone terhubung ke departemen / strategi bisnis Anda.">How does the milestone links to your department/business strategies.</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">II.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Each milestone must be SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), you must specify the Quantitative Measurement (e.g. financial results) and the Timeline for each milestone." data-bhs="Setiap Milestone harus SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), Anda harus menentukan Pengukuran Kuantitatif (misalnya hasil keuangan) dan Timeline untuk setiap milestone.">Each milestone must be SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), you must specify the Quantitative Measurement (e.g. financial results) and the Timeline for each milestone.</small>
                                </div>
                                <div class="nav nav-pills d-flex mt-3" data-toggle="tabs" role="tablist" aria-orientation="horizontal">
                                    @if(count($milestone_template) > 0)
                                        @foreach($milestone_template as $key => $mlst_temp)
                                            <a href="#{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" class="nav-link{{ $key == 0 ? ' active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}-pill" data-toggle="pill" role="tab" aria-controls="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" aria-selected="true">
                                                <span class="numbering">{{ $key+1 }}</span> <span class="milestone-name" data-eng="{{ $mlst_temp->milestone_eng }}" data-bhs="{{ $mlst_temp->milestone_bhs }}">{{ $mlst_temp->milestone_eng }}</span>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tab-content mt-3">
                                    @if(count($milestone_template) > 0)
                                        @foreach($milestone_template as $key => $mlst_temp)
                                            <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" role="tabpanel" aria-labelledby="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}-pill">
                                                <input type="hidden" name="milestone_id[]" value="{{ $mlst_temp->milestone_id }}">
                                                @if(count($milestone) > 0)
                                                    <?php $count = 0; ?>
                                                    @foreach($milestone as $mlst)
                                                        @if($mlst->milestone_id == null)
                                                            <div class="row mt-2">
                                                                <div style="flex: 0 0 auto; width: 32%;">
                                                                    <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                                    <textarea name="milestone_description[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 32%;">
                                                                    <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                                    <textarea name="milestone_measurement[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 32%;">
                                                                    <label class="form-label col-form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Employee's Assessment</label>
                                                                    <textarea name="employee_assessment[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type employee's assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee's assessment.."></textarea>
                                                                </div>
                                                            </div>
                                                        @elseif($mlst->milestone_id == $mlst_temp->milestone_id)
                                                            <?php $count++; ?>
                                                            <div class="row mt-2">
                                                                <input type="hidden" name="appraisal_milestone_detail_id[{{ $mlst_temp->milestone_id }}][]" value="{{ $mlst->appraisal_milestone_detail_id }}">
                                                                <div style="flex: 0 0 auto; width: 32%;">
                                                                    @if($count == 1)
                                                                        <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                                    @endif
                                                                    <textarea name="milestone_description[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."><?php echo $mlst->milestone_description; ?></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 32%;">
                                                                    @if($count == 1)
                                                                        <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                                    @endif
                                                                    <textarea name="milestone_measurement[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."><?php echo $mlst->milestone_measurement; ?></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 32%;">
                                                                    @if($count == 1)
                                                                        <label class="form-label col-form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Employee's Assessment</label>
                                                                    @endif
                                                                    <textarea name="employee_assessment[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type employee's assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee's assessment.."><?php echo $mlst->employee_assessment; ?></textarea>
                                                                </div>
                                                                @if($count > 1)
                                                                    <div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">
                                                                        <a href="javascript:;" class="text-danger btn-delete-point" data-mlst="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" style="font-size: 20px;">
                                                                            <i class="fa fa-minus-circle"></i>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <div class="added-milestone-point"></div>
                                                @if($count < 5)
                                                    <a href="javascript:;" class="btn btn-secondary btn-add-point mt-2" data-id="{{ $mlst_temp->milestone_id }}" data-mlst="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" data-count="{{ $count == 0 ? 1 : $count }}">
                                                        <i class="fa fa-plus"></i>
                                                        <span data-eng="Add More Point" data-bhs="Tambah Point"> Add More Point </span>
                                                    </a>
                                                @endif

                                                <!-- APPROVE/REJECT BUTTON AND NEXT BUTTON -->
                                                <div class="w-100 d-flex mt-5">
                                                    <button type="button" class="btn btn-danger btn-reject pt-3 pb-3" style="width: 175px;">Reject</button>
                                                    @if($key != count($milestone_template)-1)
                                                        <button type="button" class="btn btn-info btn-next ml-auto pt-3 pb-3" data-target="{{ str_replace(' ', '_', strtolower($milestone_template[$key+1]->milestone_eng)) }}" style="width: 175px;">Next</button>
                                                    @else
                                                        <button type="button" class="btn btn-success btn-approve ml-auto pt-3 pb-3" style="width: 175px;">Approve</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="appraisal_approval_reject_note">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>

<!-- BEGIN MODAL REJECT -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="rejectModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Reject This Milestone</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="8" placeholder="Type reason for rejecting this milestone.."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL REJECT -->
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-appraisal_approval').addClass('active');

        $('#language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(state) {
                $('input[name=language]').val('ina');
                $('.nav-tabs .nav-link, .milestone-name, .competency-name, th, h5, label, small, span, button').each(function(index) {
                    $(this).html($(this).data('bhs'));
                });
                $('textarea').each(function(index) {
                    $(this).prop('placeholder', $(this).data('pl_bhs'));
                });
                $('.select2-selection__placeholder').each(function(index) {
                    $(this).html('Pilih Nilai');
                });
            } else {
                $('input[name=language]').val('eng');
                $('.nav-tabs .nav-link, .milestone-name, .competency-name, th, h5, label, small, span, button').each(function(index) {
                    $(this).html($(this).data('eng'));
                });
                $('textarea').each(function(index) {
                    $(this).prop('placeholder', $(this).data('pl_eng'));
                });
                $('.select2-selection__placeholder').each(function(index) {
                    $(this).html('Select A Rating');
                });
            }
        });

        $(document).on('click', '.btn-add-point', function(e) {
            var id = e.currentTarget.dataset.id;
            var mlst = e.currentTarget.dataset.mlst;
            var count = parseInt(e.currentTarget.dataset.count);

            var html = '';
            if($('input[name=language]').val() == 'eng') {
                html = '<div class="row mt-2">'+
                    '<div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_description['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_measurement['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="employee_assessment['+id+'][]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee assessment.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" data-mlst="'+mlst+'" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div></div>';
            } else if($('input[name=language]').val() == 'ina') {
                html = '<div class="row mt-2">'+
                    '<div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_description['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Isi deskripsi milestone.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_measurement['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Isi pencapaian milestone.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="employee_assessment['+id+'][]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Isi penilaian karyawan.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" data-mlst="'+mlst+'" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div></div>';
            }

            if(count == 4) {
                $(this).parents('.tab-pane#'+mlst).find('.added-milestone-point').append(html);
                $(this).attr('data-count', (count+1));
                $(this).hide();
            } else if(count < 5) {
                $(this).parents('.tab-pane#'+mlst).find('.added-milestone-point').append(html);
                $(this).attr('data-count', (count+1));
            }
        });

        $(document).on('click', '.btn-delete-point', function(e) {
            var mlst = e.currentTarget.dataset.mlst;

            var count = $(this).parents('.added-milestone-point').find('.row.mt-2').length;
            $(this).parents('.tab-pane').find('.btn-add-point').attr('data-count', count);

            if(count < 5) {
                $(this).parents('.tab-pane').find('.btn-add-point').show();
            }

            $(this).parents('.row.mt-2').remove();
        });

        $(document).on('change input keyup', 'select, textarea', function(e) {
            $(this).removeClass('is-invalid');
            $(this).parents('.form-group').find('.text-danger').html('');
        });

        $(document).on('click', '.btn-next', function(e) {
            $('a[href="#'+e.currentTarget.dataset.target+'"]').tab('show');
        });

        $(document).on('click', '.btn-reject', function(e) {
            var modal = $('#rejectModal');

            modal.modal('show');
        });

        $(document).on('submit', '#rejectModal form', function(e) {
            e.preventDefault();

            $('input[name=appraisal_approval_reject_note]').val($('textarea[name=note]').val());

            $.ajax({
                url : "{{ url('/appraisal/milestone/reject') }}",
                type : "POST",
                data : $('#milestoneForm').serialize(),
                beforeSend : function() {
                    $('.se-pre-con').fadeIn();
                },
                success : function(res) {
                    $.ajax({
                        type : "POST",
                        url : "{{ url('/appraisal/send-reject-mail') }}",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            recipient_name : res.recipient_name,
                            recipient_email : res.recipient_email,
                            reject_note : res.reject_note
                        },
                        success : function(res) {
                            $('.se-pre-con').fadeOut();
                            
                            Swal.fire({
                                title : 'Rejected',
                                type : 'success'
                            }).then((result) => {
                                window.location.href = "{{ url('/appraisal/approval') }}";
                            });
                        },
                        error : function(jqXhr, errorThrown, textStatus) {
                            $('.se-pre-con').fadeOut();

                            Swal.fire({
                                title : 'Rejected',
                                text : 'Failed to Send Notification Email',
                                type : 'success'
                            }).then((result) => {
                                window.location.href = "{{ url('/appraisal/approval') }}";
                            });
                        }
                    });
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    $('.se-pre-con').fadeOut();
                    toastr.error('Something is wrong, Try Again!', 'Oops!', { "closeButton": true });
                }
            });
        });

        $(document).on('click', '.btn-approve', function(e) {
            e.preventDefault();

            Swal.fire({
                    title : 'Approve this Appraisal Milestone?',
                    type : 'warning',
                    showCancelButton : true,
                    confirmButtonText : 'Yes, Approve',
                    reverseButtons : true,
                }).then((result) => {
                    if(result.value) {
                        $.ajax({
                            url : "{{ url('/appraisal/milestone/approve') }}",
                            type : "POST",
                            data : $('#milestoneForm').serialize(),
                            beforeSend : function() {
                                $('.se-pre-con').fadeIn();
                            },
                            success : function(res) {
                                $.ajax({
                                    type : "POST",
                                    url : "{{ url('/appraisal/send-approved-mail') }}",
                                    data : {
                                        "_token" : "{{ csrf_token() }}",
                                        recipient_name : res.recipient_name,
                                        recipient_email : res.recipient_email
                                    },
                                    success : function(res) {
                                        $('.se-pre-con').fadeOut();
                                        
                                        Swal.fire({
                                            title : 'Approved',
                                            type : 'success'
                                        }).then((result) => {
                                            window.location.href = "{{ url('/appraisal/approval') }}";
                                        });
                                    },
                                    error : function(jqXhr, errorThrown, textStatus) {
                                        $('.se-pre-con').fadeOut();

                                        Swal.fire({
                                            title : 'Approved',
                                            text : 'Failed to Send Notification Email',
                                            type : 'success'
                                        }).then((result) => {
                                            window.location.href = "{{ url('/appraisal/approval') }}";
                                        });
                                    }
                                });
                            },
                            error : function(jqXhr, errorThrown, textStatus) {
                                $('.se-pre-con').fadeOut();
                                toastr.error('Something is wrong, Try Again!', 'Oops!', { "closeButton": true });
                            }
                        });
                    }
                });
        });

	});

</script>
@endsection