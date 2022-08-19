@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .table thead th {
        vertical-align: middle !important;
    }
    #table-appraisal tbody tr td {
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
                <h2 class="page-title">Appraisal Approval</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Appraisal Approval</li>
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
                    <table class="table table-bordered table-striped" id="table-appraisal" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 25px;"> No </th>
                                <th> Employee </th>
                                <th> Level </th>
                                <th> Department </th>
                                <th style="text-align: center; width: 300px;"> Action Needed </th>
                                <th style="text-align: center; width: 50px;"> View </th>
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

@include('appraisal.modal.in_progress')
@include('appraisal.modal.in_progress_staff')

@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-appraisal_approval').addClass('active');

        $('.language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        var table = $('#table-appraisal').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/approval') }}",
                data : function(d) {
                    
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'user', name : 'user' },
                { data : 'grade_group_name', name : 'grade_group_name' },
                { data : 'department_name', name : 'department_name' },
                { data : 'action_needed', name : 'action_needed' },
                { data : 'view', name : 'view' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,4,5] },
                { searchable : false, targets : [0,4,5] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,4,5]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

	});

</script>
@endsection