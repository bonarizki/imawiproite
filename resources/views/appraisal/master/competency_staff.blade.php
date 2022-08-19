@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .table thead th, .table tbody td {
        vertical-align: middle !important;
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
                <h2 class="page-title">Master Competency Staff</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Competency Staff</li>
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
                <div class="card-header">
                    <div class="row" style="width: 100%;">
                        <div class="col-md-6">
                            <a href="#addCompetencyStaff" class="btn btn-primary" data-toggle="modal">
                                <i class="fa fa-plus"></i> Add Competency Staff
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                            <input type="hidden" name="language" value="eng">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-competency" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; width: 25px;"> No </th>
                                <th rowspan="2"> Competency </th>
                                <th colspan="4" style="text-align: center;"> Proficiency Level </th>
                                <th rowspan="2" style="text-align: center; width: 75px;"> Status </th>
                                <th colspan="2" style="text-align: center;"> Action </th>
                            </tr>
                            <tr>
                                <th style="text-align: center;"> 1 </th>
                                <th style="text-align: center;"> 2 </th>
                                <th style="text-align: center;"> 3 </th>
                                <th style="text-align: center;"> 4 </th>
                                <th style="text-align: center; width: 50px;"> Status </th>
                                <th style="text-align: center; width: 50px;"> Edit </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- Begin Modal Add -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addCompetencyStaff">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Add Competency Staff</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required"> Competency Title in English </label>
                            <input type="text" name="competency_title_eng" class="form-control" id="competency_title_eng_add" placeholder="Type competency title in english..">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required"> Competency Title in Bahasa </label>
                            <input type="text" name="competency_title_bhs" class="form-control" id="competency_title_bhs_add" placeholder="Type competency title in bahasa..">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Competency in English</label>
                            <textarea name="competency_eng" class="form-control" id="competency_eng_add" rows="5" placeholder="Type competency in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Competency in Bahasa</label>
                            <textarea name="competency_bhs" class="form-control" id="competency_bhs_add" rows="5" placeholder="Type competency in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 1 in English</label>
                            <textarea name="proficiency_1_eng" class="form-control" id="proficiency_1_eng_add" rows="3" placeholder="Type proficiency level 1 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 1 in Bahasa</label>
                            <textarea name="proficiency_1_bhs" class="form-control" id="proficiency_1_bhs_add" rows="3" placeholder="Type proficiency level 1 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 2 in English</label>
                            <textarea name="proficiency_2_eng" class="form-control" id="proficiency_2_eng_add" rows="3" placeholder="Type proficiency level 2 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 2 in Bahasa</label>
                            <textarea name="proficiency_2_bhs" class="form-control" id="proficiency_2_bhs_add" rows="3" placeholder="Type proficiency level 2 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 3 in English</label>
                            <textarea name="proficiency_3_eng" class="form-control" id="proficiency_3_eng_add" rows="3" placeholder="Type proficiency level 3 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 3 in Bahasa</label>
                            <textarea name="proficiency_3_bhs" class="form-control" id="proficiency_3_bhs_add" rows="3" placeholder="Type proficiency level 3 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 4 in English</label>
                            <textarea name="proficiency_4_eng" class="form-control" id="proficiency_4_eng_add" rows="3" placeholder="Type proficiency level 4 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 4 in Bahasa</label>
                            <textarea name="proficiency_4_bhs" class="form-control" id="proficiency_4_bhs_add" rows="3" placeholder="Type proficiency level 4 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Add -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal edit -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editCompetencyStaff">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Competency Staff</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required"> Competency Title in English </label>
                            <input type="text" name="competency_title_eng" class="form-control" id="competency_title_eng_edit" placeholder="Type competency title in english..">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required"> Competency Title in Bahasa </label>
                            <input type="text" name="competency_title_bhs" class="form-control" id="competency_title_bhs_edit" placeholder="Type competency title in bahasa..">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Competency in English</label>
                            <textarea name="competency_eng" class="form-control" id="competency_eng_edit" rows="5" placeholder="Type competency in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Competency in Bahasa</label>
                            <textarea name="competency_bhs" class="form-control" id="competency_bhs_edit" rows="5" placeholder="Type competency in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 1 in English</label>
                            <textarea name="proficiency_1_eng" class="form-control" id="proficiency_1_eng_edit" rows="3" placeholder="Type proficiency level 1 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 1 in Bahasa</label>
                            <textarea name="proficiency_1_bhs" class="form-control" id="proficiency_1_bhs_edit" rows="3" placeholder="Type proficiency level 1 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 2 in English</label>
                            <textarea name="proficiency_2_eng" class="form-control" id="proficiency_2_eng_edit" rows="3" placeholder="Type proficiency level 2 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 2 in Bahasa</label>
                            <textarea name="proficiency_2_bhs" class="form-control" id="proficiency_2_bhs_edit" rows="3" placeholder="Type proficiency level 2 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 3 in English</label>
                            <textarea name="proficiency_3_eng" class="form-control" id="proficiency_3_eng_edit" rows="3" placeholder="Type proficiency level 3 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 3 in Bahasa</label>
                            <textarea name="proficiency_3_bhs" class="form-control" id="proficiency_3_bhs_edit" rows="3" placeholder="Type proficiency level 3 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 4 in English</label>
                            <textarea name="proficiency_4_eng" class="form-control" id="proficiency_4_eng_edit" rows="3" placeholder="Type proficiency level 4 in english.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label required">Proficiency Level 4 in Bahasa</label>
                            <textarea name="proficiency_4_bhs" class="form-control" id="proficiency_4_bhs_edit" rows="3" placeholder="Type proficiency level 4 in bahasa.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal edit -->
<!-- ============================================================== -->
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-master').addClass('active');
        $('.nav-master_competency_staff').addClass('active');

        $('.select2').select2({
            theme : 'bootstrap4'
        });

        $('#language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

        var table = $('#table-competency').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/competency-staff') }}",
                data : function(d) {
                    d.lang = $('input[name=language]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'competency_text', name : 'competency_text' },
                { data : 'proficiency_1', name : 'proficiency_1' },
                { data : 'proficiency_2', name : 'proficiency_2' },
                { data : 'proficiency_3', name : 'proficiency_3' },
                { data : 'proficiency_4', name : 'proficiency_4' },
                { data : 'competency_status', name : 'competency_status' },
                { data : 'status', name : 'status' },
                { data : 'edit', name : 'edit' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,7,8] },
                { searchable : false, targets : [0,7,8] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,7,8]
                },
                { render : function(data, type, row, meta) {
                    if(data == '1') {
                        return '<span class="text-success">Active</span>';
                    } else if(data == '0') {
                        return '<span class="text-danger">Passive</span>';
                    }}, targets : [6]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(state) {
                $('input[name=language]').val('ina');
            } else {
                $('input[name=language]').val('eng');
            }

            table.draw();
        });

        $(document).on('show.bs.modal', '#addCompetencyStaff', function(e) {
            $('#addCompetencyStaff .form-group .form-control').removeClass('is-invalid');
            $('#addCompetencyStaff .form-group .invalid-feedback').empty();
        });

        $(document).on('submit', '#addCompetencyStaff form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/competency-staff') }}",
                type : "POST",
                data : $('#addCompetencyStaff form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addCompetencyStaff form').trigger('reset');
                    $('#addCompetencyStaff').modal('hide');

                    toastr.success('Appraisal Competency Staff have been added!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addCompetencyStaff .form-group .form-control').removeClass('is-invalid');
                    $('#addCompetencyStaff .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_add')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val)
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-edit', function(e) {
            var modal = $('#editCompetencyStaff');
            var id = e.currentTarget.dataset.id;

            modal.find('input[name=id]').val(id);
            
            $.ajax({
                type : "GET",
                url : "{{ url('api/appraisal/competency-staff') }}?competency_id="+id,
                dataType : "JSON",
                success : function(res) {
                    modal.find('input[name=competency_title_eng]').val(res.competency_title_eng);
                    modal.find('input[name=competency_title_bhs]').val(res.competency_title_bhs);
                    modal.find('textarea[name=competency_eng]').val(res.competency_eng);
                    modal.find('textarea[name=competency_bhs]').val(res.competency_bhs);
                    modal.find('textarea[name=proficiency_1_eng]').val(res.proficiency_1_eng);
                    modal.find('textarea[name=proficiency_1_bhs]').val(res.proficiency_1_bhs);
                    modal.find('textarea[name=proficiency_2_eng]').val(res.proficiency_2_eng);
                    modal.find('textarea[name=proficiency_2_bhs]').val(res.proficiency_2_bhs);
                    modal.find('textarea[name=proficiency_3_eng]').val(res.proficiency_3_eng);
                    modal.find('textarea[name=proficiency_3_bhs]').val(res.proficiency_3_bhs);
                    modal.find('textarea[name=proficiency_4_eng]').val(res.proficiency_4_eng);
                    modal.find('textarea[name=proficiency_4_bhs]').val(res.proficiency_4_bhs);
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            modal.modal('show');
        });

        $(document).on('submit', '#editCompetencyStaff form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/competency-staff/update') }}",
                type : "POST",
                data : $('#editCompetencyStaff form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editCompetencyStaff').modal('hide');

                    toastr.success('Appraisal Competency Staff have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editCompetencyStaff .form-group .form-control').removeClass('is-invalid');
                    $('#editCompetencyStaff .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_edit')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val)
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-activate', function(e) {
            Swal.fire({
                title : 'Are you sure?',
                text : 'You\'re going to '+this.dataset.message+' this competency staff',
                icon : 'warning',
                showCancelButton : true, 
                confirmButtonText : 'Yes, '+this.dataset.message,
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/appraisal/competency-staff/activate') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id
                        },
                        success : function(res) {
                            table.draw(false);

                            toastr.success('Appraisal Competency Staff have been '+res.message+'!', 'Success', { "closeButton": true });
                        },
                        error : function(jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });            
        });

	});

</script>
@endsection