@extends('awards/master/master')
@section('breadcumb', 'Dashboard')
@section('title', 'Dashboard')

@section('content')
<style type="text/css">
	.top-count {
	    flex: 0 0 20%;
	    max-width: 20%;
	    position: relative;
	    width: 100%;
	    padding-right: 10px;
	    padding-left: 10px;
	}

	* {
	    margin: 0;
	    padding: 0;
	}

	.imgbox {
	    display: grid;
	    height: 100%;
	}

	.center-fit {
	    max-width: 100%;
	    max-height: 100vh;
	    margin: auto;
	}
</style>
<section id="basic-horizontal-layouts">
	<!-- ============================================================== -->
	<!-- Bread crumb -->
	<!-- ============================================================== -->
	<div class="content-header row">
	    <div class="content-header-left col-md-9 col-12 mb-2">
	        <div class="row breadcrumbs-top">
	            <div class="col-12">
	                <h2 class="content-header-title float-left mb-0">Dashboard</h2>
	                <div class="breadcrumb-wrapper col-12">
	                    <ol class="breadcrumb">
	                        <li class="breadcrumb-item active">Dashboard</li>
	                    </ol>
	                </div>
	            </div>
	        </div>
	    </div>
	    {{-- <div class="content-header-right col-md-3 col-12 d-md-block d-none">
	        <div class="form-group row">
	        	<label class="col-form-label col-4">Period</label>
	        	<div class="col-8">
	        		<select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
	                    @foreach($period_all as $p)
	                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
	                    @endforeach
	                </select>
	        	</div>
	        </div>
	    </div> --}}
	</div>
	<!-- ============================================================== -->
	<!-- End Bread crumb -->
	<!-- ============================================================== -->
	<div class="imgbox">
		<img class="center-fit" src="{{ asset('images/awards.png') }}">
	</div>
</section>
@endsection

@section('script')
<script type="text/javascript">
	
	$(document).ready(function() {


	});

</script>
@endsection
    