@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    
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
                <h2 class="page-title">Master Period</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Period</li>
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
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-period" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 25px;"> No </th>
                                <th> Period </th>
                                <th> Appraisal Staff </th>
                                <th> Appraisal Supervisor and above </th>
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
<!-- Begin Modal edit -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editPeriod">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Appraisal Period</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">Period</div>
                        <div class="col-1">:</div>
                        <div class="col-8 period"></div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="form-label required">Period for Appraisal Staff</label>
                        <div class="form-group row">
                            <div class="col-5">
                                <div class="input-icon">
                                    <input type="text" name="appraisal_staff_period_start" class="form-control" id="appraisal_staff_period_start_edit" value="" placeholder="Choose Period Start" readonly>
                                    <span class="input-icon-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="col-1 text-center pt-2">-</div>
                            <div class="col-5">
                                <div class="input-icon">
                                    <input type="text" name="appraisal_staff_period_end" class="form-control" id="appraisal_staff_period_end_edit" value="" placeholder="Choose Period End" readonly>
                                    <span class="input-icon-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label required">Period for Appraisal Supervisor and above</label>
                        <div class="form-group row">
                            <div class="col-5">
                                <div class="input-icon">
                                    <input type="text" name="appraisal_period_start" class="form-control" id="appraisal_period_start_edit" value="" placeholder="Choose Period Start" readonly>
                                    <span class="input-icon-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="col-1 text-center pt-2">-</div>
                            <div class="col-5">
                                <div class="input-icon">
                                    <input type="text" name="appraisal_period_end" class="form-control" id="appraisal_period_end_edit" value="" placeholder="Choose Period End" readonly>
                                    <span class="input-icon-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <span class="invalid-feedback"></span>
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
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-master').addClass('active');
        $('.nav-master_period').addClass('active');

        var table = $('#table-period').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/period') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'period_name', name : 'period_name' },
                { data : 'appraisal_staff_period', name : 'appraisal_staff_period' },
                { data : 'appraisal_period', name : 'appraisal_period' },
                { data : 'edit', name : 'edit' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,4] },
                { searchable : false, targets : [0,4] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,4]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $(document).on('click', '.btn-edit', function(e) {
            var modal = $('#editPeriod');

            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('.period').html(e.currentTarget.dataset.period);

            modal.find('input[name=appraisal_staff_period_start], input[name=appraisal_staff_period_end], input[name=appraisal_period_start], input[name=appraisal_period_end]').daterangepicker({
                singleDatePicker : true,
                autoApply : true,
                locale : {
                    format : 'YYYY-MM-DD'
                }
            });

            if(e.currentTarget.dataset.staff_start) {
                modal.find('input[name=appraisal_staff_period_start]').data('daterangepicker').setStartDate(e.currentTarget.dataset.staff_start);
                modal.find('input[name=appraisal_staff_period_start]').data('daterangepicker').setEndDate(e.currentTarget.dataset.staff_start);
            }

            if(e.currentTarget.dataset.staff_end) {
                modal.find('input[name=appraisal_staff_period_end]').data('daterangepicker').setStartDate(e.currentTarget.dataset.staff_end);
                modal.find('input[name=appraisal_staff_period_end]').data('daterangepicker').setEndDate(e.currentTarget.dataset.staff_end);
            }

            if(e.currentTarget.dataset.start) {
                modal.find('input[name=appraisal_period_start]').data('daterangepicker').setStartDate(e.currentTarget.dataset.start);
                modal.find('input[name=appraisal_period_start]').data('daterangepicker').setEndDate(e.currentTarget.dataset.start);
            }

            if(e.currentTarget.dataset.end) {
                modal.find('input[name=appraisal_period_end]').data('daterangepicker').setStartDate(e.currentTarget.dataset.end);
                modal.find('input[name=appraisal_period_end]').data('daterangepicker').setEndDate(e.currentTarget.dataset.end);
            }

            modal.modal('show');
        });

        $(document).on('submit', '#editPeriod form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('api/appraisal/period/update') }}",
                type : "POST",
                data : $('#editPeriod form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#editPeriod').modal('hide');

                    toastr.success('Appraisal Period have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editPeriod .form-group .form-control').removeClass('is-invalid');
                    $('#editPeriod .form-group .invalid-feedback').empty();

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

	});

</script>
@endsection