@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .table thead th {
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
                <h2 class="page-title">Master Milestone</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Milestone</li>
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
                            <a href="#addMilestone" class="btn btn-primary" data-toggle="modal">
                                <i class="fa fa-plus"></i> Add Milestone
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                            <input type="hidden" name="language" value="eng">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-milestone" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; width: 25px;"> No </th>
                                <th rowspan="2"> Milestone </th>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="addMilestone">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Add Milestone</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label required">Milestone in English</label>
                        <input type="text" name="milestone_eng" class="form-control" id="milestone_eng_add"  placeholder="Type milestone in english..">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label required">Milestone in Bahasa</label>
                        <input type="text" name="milestone_bhs" class="form-control" id="milestone_bhs_add" placeholder="Type milestone in bahasa..">
                        <div class="invalid-feedback"></div>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editMilestone">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Milestone</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label required">Milestone in English</label>
                        <input type="text" name="milestone_eng" class="form-control" id="milestone_eng_edit"  placeholder="Type milestone in english..">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label required">Milestone in Bahasa</label>
                        <input type="text" name="milestone_bhs" class="form-control" id="milestone_bhs_edit" placeholder="Type milestone in bahasa..">
                        <div class="invalid-feedback"></div>
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
        $('.nav-master_milestone').addClass('active');

        $('#language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

        var table = $('#table-milestone').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/milestone') }}",
                data : function(d) {
                    d.lang = $('input[name=language]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'milestone_name', name : 'milestone_name' },
                { data : 'milestone_status', name : 'milestone_status' },
                { data : 'status', name : 'status' },
                { data : 'edit', name : 'edit' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,3,4] },
                { searchable : false, targets : [0,3,4] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,3,4]
                },
                { render : function(data, type, row, meta) {
                    if(data == '1') {
                        return '<span class="text-success">Active</span>';
                    } else if(data == '0') {
                        return '<span class="text-danger">Passive</span>';
                    }}, targets : [2]
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

        $(document).on('submit', '#addMilestone form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/milestone') }}",
                type : "POST",
                data : $('#addMilestone form').serialize(),
                success : function(res) {
                    table.draw();
                    $('#addMilestone form').trigger('reset');
                    $('#addMilestone').modal('hide');

                    toastr.success('Appraisal Milestone have been added!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#addMilestone .form-group .form-control').removeClass('is-invalid');
                    $('#addMilestone .form-group .invalid-feedback').empty();

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
            var modal = $('#editMilestone');

            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=milestone_eng]').val(e.currentTarget.dataset.eng);
            modal.find('input[name=milestone_bhs]').val(e.currentTarget.dataset.bhs);

            modal.modal('show');
        });

        $(document).on('submit', '#editMilestone form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/milestone/update') }}",
                type : "POST",
                data : $('#editMilestone form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editMilestone').modal('hide');

                    toastr.success('Appraisal Milestone have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editMilestone .form-group .form-control').removeClass('is-invalid');
                    $('#editMilestone .form-group .invalid-feedback').empty();

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
                text : 'You\'re going to '+this.dataset.message+' '+this.dataset.name,
                icon : 'warning',
                showCancelButton : true, 
                confirmButtonText : 'Yes, '+this.dataset.message,
                reverseButtons : true,
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url : "{{ url('api/appraisal/milestone/activate') }}",
                        type : "POST",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            id : this.dataset.id
                        },
                        success : function(res) {
                            table.draw(false);

                            toastr.success('Appraisal Milestone have been '+res.message+'!', 'Success', { "closeButton": true });
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