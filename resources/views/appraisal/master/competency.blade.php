@extends('layouts.appraisal')

@section('assets-top')
<link rel="stylesheet" type="text/css" href="{{ asset('assets_dashforge/lib/filepond/filepond.css') }}">
<style type="text/css">
    .table thead th, .table tbody td {
        vertical-align: middle !important;
    }
    .filepond--root {
        margin-bottom: 0px !important;
    }
    .alert .alert-content {
        max-height: 200px;
        overflow-y: auto;
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
                <h2 class="page-title">Master Competency</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Competency</li>
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
            <div class="card mb-1" id="filter">
                <div class="card-body pb-0">
                    <h3><i class="fa fa-filter"></i> Filter</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-control select2" style="width: 100%;">
                                    <option value="0">ALL DEPARTMENT</option>
                                    @foreach($department as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Level</label>
                                <select name="grade_group_id" class="form-control select2" style="width: 100%;">
                                    <option value="0">ALL LEVEL</option>
                                    @foreach($grade_group as $gg)
                                        <option value="{{ $gg->grade_group_id }}">{{ $gg->grade_group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row" style="width: 100%;">
                        <div class="col-md-6">
                            <a href="#addCompetency" class="btn btn-primary" data-toggle="modal">
                                <i class="fa fa-plus"></i> Add Competency
                            </a>
                            <a href="#uploadCompetency" class="btn btn-info" data-toggle="modal">
                                <i class="fa fa-upload"></i> Upload Competency
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
                                <th rowspan="2"> Department </th>
                                <th rowspan="2"> Level </th>
                                <th rowspan="2"> Competency </th>
                                <th rowspan="2" style="text-align: center; width: 150px;"> Status </th>
                                <th colspan="2" style="text-align: center;"> Action </th>
                            </tr>
                            <tr>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addCompetency">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Add Competency</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Department</label>
                                <select name="department_id" class="form-control select2" id="department_id_add" data-placeholder="Select A Department" style="width: 100%;">
                                    <option></option>
                                    @foreach($department as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Level</label>
                                <select name="grade_group_id" class="form-control select2" id="grade_group_id_add" data-placeholder="Select A Level" style="width: 100%;">
                                    <option></option>
                                    @foreach($grade_group as $gg)
                                        <option value="{{ $gg->grade_group_id }}">{{ $gg->grade_group_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Competency in English</label>
                                <textarea name="competency_eng" class="form-control" id="competency_eng_add" rows="10" placeholder="Type competency in english.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Competency in Bahasa</label>
                                <textarea name="competency_bhs" class="form-control" id="competency_bhs_add" rows="10" placeholder="Type competency in bahasa.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editCompetency">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Competency</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Department</label>
                                <select name="department_id" class="form-control select2" id="department_id_edit" data-placeholder="Select A Department" style="width: 100%;">
                                    <option></option>
                                    @foreach($department as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Level</label>
                                <select name="grade_group_id" class="form-control select2" id="grade_group_id_edit" data-placeholder="Select A Level" style="width: 100%;">
                                    <option></option>
                                    @foreach($grade_group as $gg)
                                        <option value="{{ $gg->grade_group_id }}">{{ $gg->grade_group_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Competency in English</label>
                                <textarea name="competency_eng" class="form-control" id="competency_eng_edit" rows="10" placeholder="Type competency in english.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Competency in Bahasa</label>
                                <textarea name="competency_bhs" class="form-control" id="competency_bhs_edit" rows="10" placeholder="Type competency in bahasa.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
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
<!-- ============================================================== -->
<!-- Begin Modal Upload -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="uploadCompetency">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Competency</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info btn-template" style="width: 100%; height: 100%;">
                                <i class="fa fa-download"></i> Download Template
                            </button>
                        </div>
                        <div class="col-md-9">
                            <input type="file" class="filepond" data-max-file-size="10MB">
                        </div>
                    </div>
                </form>
                <hr>
                <!-- ALERT -->
                <div class="alert alert-danger alert-dismissible" style="display: none;">
                    <button type="button" class="btn-close" aria-hidden="true" aria-label="Close"></button>
                    <h5><i class="icon fa fa-ban"></i> Alert, Check your Excel File </h5>
                    <div class="alert-content"></div>
                </div>
                <!-- END ALERT -->
                <div class="x_content table-responsive">
                    <table class="table table-striped table-bordered" id="table-competency_temp" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 25px;"> No </th>
                                <th> Department </th>
                                <th> Level </th>
                                <th> Competency ENG </th>
                                <th> Competency BHS </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-reset">Reset</button>
                <button type="button" class="btn btn-success btn-submit">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Upload -->
<!-- ============================================================== -->

@endsection

@section('assets-bottom')
<script src="{{ asset('assets_dashforge/lib/filepond/filepond.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-encode.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-validate-size.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-validate-type.js') }}"></script>
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-master').addClass('active');
        $('.nav-master_competency').addClass('active');

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
                url : "{{ url('api/appraisal/competency') }}",
                data : function(d) {
                    d.lang = $('input[name=language]').val();
                    d.department_id = $('#filter select[name=department_id]').val();
                    d.grade_group_id = $('#filter select[name=grade_group_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'department_name', name : 'department_name' },
                { data : 'grade_group_name', name : 'grade_group_name' },
                { data : 'competency_text', name : 'competency_text' },
                { data : 'competency_status', name : 'competency_status' },
                { data : 'status', name : 'status' },
                { data : 'edit', name : 'edit' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,5,6] },
                { searchable : false, targets : [0,5,6] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,5,6]
                },
                { render : function(data, type, row, meta) {
                    if(data == '1') {
                        return '<span class="text-success">Active</span>';
                    } else if(data == '0') {
                        return '<span class="text-danger">Passive</span>';
                    }}, targets : [4]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        var table_temp = $('#table-competency_temp').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/competency/temp') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'department', name : 'department' },
                { data : 'level', name : 'level' },
                { data : 'competency_eng', name : 'competency_eng' },
                { data : 'competency_bhs', name : 'competency_bhs' }
            ],
            columnDefs : [
                { orderable : false, targets : [0] },
                { searchable : false, targets : [0] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0]
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

        $(document).on('change', '#filter select', function(e) {
            table.draw();
        });

        $(document).on('submit', '#addCompetency form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/competency') }}",
                type : "POST",
                data : $('#addCompetency form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addCompetency form').trigger('reset');
                    $('#addCompetency .select2').val(0).trigger('change');
                    $('#addCompetency').modal('hide');

                    toastr.success('Appraisal Competency have been added!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addCompetency .form-group .form-control').removeClass('is-invalid');
                    $('#addCompetency .form-group .invalid-feedback').empty();

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
            var modal = $('#editCompetency');

            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('select[name=department_id]').val(e.currentTarget.dataset.dept).trigger('change');
            modal.find('select[name=grade_group_id]').val(e.currentTarget.dataset.gg).trigger('change');
            modal.find('textarea[name=competency_eng]').val(e.currentTarget.dataset.eng);
            modal.find('textarea[name=competency_bhs]').val(e.currentTarget.dataset.bhs);

            modal.modal('show');
        });

        $(document).on('submit', '#editCompetency form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/competency/update') }}",
                type : "POST",
                data : $('#editCompetency form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editCompetency').modal('hide');

                    toastr.success('Appraisal Competency have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editCompetency .form-group .form-control').removeClass('is-invalid');
                    $('#editCompetency .form-group .invalid-feedback').empty();

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
                text : 'You\'re going to '+this.dataset.message+' this competency',
                icon : 'warning',
                showCancelButton : true, 
                confirmButtonText : 'Yes, '+this.dataset.message,
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/appraisal/competency/activate') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id
                        },
                        success : function(res) {
                            table.draw(false);

                            toastr.success('Appraisal Competency have been '+res.message+'!', 'Success', { "closeButton": true });
                        },
                        error : function(jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });            
        });

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        FilePond.setOptions({
            server : {
                process : (filepond, file, metadata, load, error, progress, abort, transfer, options) => {

                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append(filepond, file, file.name);

                    const request = new XMLHttpRequest();
                    request.open('POST', '{{ url("api/appraisal/competency/upload/temp") }}');

                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };

                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            // console.log(request.responseText);
                            table_temp.draw(false);

                            $('.alert').find('.alert-message').remove();
                            var res = request.response.substr(1, request.response.length-2).split('#');

                            if(res[0] != '') {
                                // console.log(res);
                                $.each(res, function(key, val) {
                                    $('.alert-content').append('<div class="alert-message">'+val+'</div>');
                                });

                                $('.alert').slideDown();
                            }

                            load(request.responseText);
                        }
                        else {
                            error('oh no');
                        }
                    };

                    request.send(formData);
                    
                    return {
                        abort: () => {
                            request.abort();
                            abort();
                        }
                    };
                }
            }
        });

        const upload = document.querySelector('.filepond');
        const pond = FilePond.create(upload, {
            acceptedFileTypes : ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        });

        $(document).on('show.bs.modal', '#uploadCompetency', function() {
            table_temp.draw();
        });

        $(document).on('click', '.btn-template', function(e) {
            window.location.href = "{{ asset('file_uploads/file/template_upload_competency.xlsx') }}";
        });

        $(document).on('click', '.alert .close', function(e) {
            $('.alert').slideUp();
        });

        $(document).on('click', '.btn-reset', function(e) {
            e.preventDefault();

            Swal.fire({
                title : 'Are you sure?',
                text : 'You\'re going to reset the uploaded Competency',
                icon : 'warning',
                showCancelButton : true,
                confirmButtonText : 'Yes, reset',
                reverseButtons : true
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        type : "GET",
                        url : "{{ url('api/appraisal/competency/upload/temp/reset') }}",
                        dataType : "JSON",
                        success : function(res) {
                            table_temp.draw();
                        },
                        error : function(jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();

            if(table_temp.rows().data().length == 0) {
                Swal.fire({
                    title : 'No Data Found',
                    text : 'You have to upload data first',
                    icon : 'warning'
                });
            } else {
                Swal.fire({
                    title : 'Are you sure?',
                    text : 'You\'re going to submit the uploaded Competency',
                    icon : 'warning',
                    showCancelButton : true,
                    confirmButtonText : 'Yes, submit',
                    reverseButtons : true
                }).then((result) => {
                    if(result.value) {
                        $.ajax({
                            type : "POST",
                            url : "{{ url('api/appraisal/competency/upload/submit') }}",
                            data : {
                                "_token" : "{{ csrf_token() }}"
                            },
                            success : function(res) {
                                table_temp.draw();

                                if(res.length == 0) {
                                    Swal.fire({
                                        title : 'Success',
                                        text : 'Competency submitted',
                                        icon : 'success',
                                        showCancelButton : false,
                                        confirmButtonText : 'OK',
                                        allowOutsideClick : false
                                    }).then((result) => {
                                        if(result.value) {
                                            table.draw();
                                            $('#uploadCompetency').modal('hide');
                                        }
                                    });
                                } else {
                                    if(res[0] != '') {
                                        $.each(res, function(key, val) {
                                            $('.alert-content').append('<div class="alert-message">'+val+'</div>');
                                        });

                                        $('.alert').slideDown();
                                    }
                                }
                            },
                            error : function(jqXhr, textStatus, errorThrown) {
                                console.log(textStatus);
                            }
                        });
                    }
                });
            }
        });

	});

</script>
@endsection