@extends('layouts.admin')

@section('assets-top')

<link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/basic.css') }}">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="{{ asset('assets/plugins/swit-status/bootstrap4-toggle.min.css')}}"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View Profile</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">View Profile</li>
        </ol>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>

<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                      <div class="text-center">
                          @if($profile->user_image == NULL)
                            <img src="{{ asset('img-user/anonymous.jpg')}}" class="img-circle elevation-2" alt="User Image">
                          @else
                            <img src="{{ $profile->user_image }}" class="img-circle elevation-2" alt="User Image">
                          @endif
                      </div>

                      <h3 class="profile-username text-center">{{ auth()->user()->user_name}}</h3>

                      <p class="text-muted text-center">{{ $profile->position_name}}</p>

                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                    <i class="fas fa-envelope"></i> 
                        <a href="mailto:{{ auth()->user()->user_email }}" class="float-right">
                            @if( strlen(auth()->user()->user_email) >= '25')
                            {{ substr(auth()->user()->user_email,0,25).".." }}
                            @else
                            {{ auth()->user()->user_email }}
                            @endif
                        </a>
                    </li>
                    <li class="list-group-item">
                    <i class="fas fa-phone-alt"></i> <a class="float-right">{{ substr(auth()->user()->user_phone,0,4)."-".substr(auth()->user()->user_phone,4,4)."-".substr(auth()->user()->user_phone,8) }}</a>
                    </li>
                      </ul>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#edit_password">
                      Change password
                      </button>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
            <div class="right">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Activity</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Proposal</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Setting</a>
                    </li>
                </ul>
                </div>
                <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <H2 class="text-center text-warning">Under Maintenance</h2>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <H2 class="text-center text-warning">Under Maintenance</h2>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">  
                        <form id="profile_update" action="{{url('dropzone/store')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-5">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="text" value="{{ auth()->user()->user_nik }}" class="form-control"  id="nik" disabled readonly="readonly" data-width="100">
                                  </div>
                                </div>
                                <label class="col-2 col-form-label text-right">Status</label>
                                <div class="col-3">
                                @if($profile->user_status == '1')
                                <label class="checkbox float-right">
                                    <input type="checkbox" name="user_status" value="1" checked data-toggle="toggle" data-width="100" disabled/>
                                </label>
                                @elseif($profile->user_status == '0')
                                <label class="checkbox float-right">
                                    <input type="checkbox" name="user_status" value="0" checked data-toggle="toggle" data-width="100" disabled/>
                                </label>
                                @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ auth()->user()->user_name }}" class="form-control" id="name" placeholder="Type your name.." required>
                                    <span class="text-danger"></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                <div class="dropzone" id="myDropzone"></div>
                                  <input type="file" multiple="multiple" name="file" class="dz-hidden-input" id="image" style="visibility: hidden">
                                <!-- <input name="file" type="hidden" multiple /> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-3">
                                    @if($profile->user_email_status == '1')
                                    <input type="checkbox" name="email_status" value="1" checked data-toggle="toggle" data-width="100">
                                    @elseif($profile->user_email_status == '0')
                                    <input type="checkbox" name="email_status" value="0" checked data-toggle="toggle" data-width="100">
                                    @endif
                                    </div>
                                    <div class="col-9">
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" value="{{ auth()->user()->user_email }}" disabled class="form-control" id="">
                                      </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask="" id="phone" im-insert="true" value="{{ auth()->user()->user_phone }}" placeholder="Type your phone number.." required>
                                  </div>
                                  <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Position</label>
                                <div class="col-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-suitcase"></i></span>
                                    </div>
                                    <input type="text"  class="form-control" value="{{ $profile->position_name }}" disabled readonly="readonly">
                                  </div>
                                </div>
                                <label class="col-2 col-form-label text-right">Business</label>
                                <div class="col-4">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="text"  class="form-control" value="{{ $profile->business_name }}" disabled readonly="readonly">
                                  </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                  <input type="checkbox" name="checkbox" value="checkbox"  class="form-check-input" id="checkbox" required>
                                  <label for="check" class="form-check-label">I agree to the terms and conditions</label>
                                </div>
                                <span class="text-danger"></span>
                            </div>
                            <hr>
                            <div class="form-group row ">
                                <div class="col">
                                <button type="submit" id="update" class="btn btn-btn-lg btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
   
    <!-- Modal -->
    <div class="modal fade" id="edit_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="modal-body">
             
              <form action="{{  url('/ubah') }}" method="POST" class="form-horizontal">
                {{csrf_field()}}
                <div class="form-group row">
                  <label class="col-form-label col-sm-4">Old Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Type your old password..">
                    <span class="text-danger"></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-sm-4">New Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Type your new password..">
                    <span class="text-danger"></span>
                  </div>
                    
                </div>
                <div class="form-group row">
                  <label class=" col-form-label col-sm-4">Confirm Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Retype your new password..">
                    <span class="text-danger"></span>
                  </div>
                </div>
              
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
              <button type="submit" id="save" class="btn btn-flat btn-primary">Update</button>
          </div>
          </form>
        </div>
      </div>
    </div>
</section>
@endsection

@section('assets-bottom')
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="{{ asset('assets/plugins/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/plugins/swit-status/bootstrap4-toggle.min.js')}}"></script>
<script>

    function validateForm(form)
    {
        if(!form.agree.checked)
        {
            document.getElementById('agree_chk_error').style.visibility='visible';
            return false;
        }
        else
        {
            document.getElementById('agree_chk_error').style.visibility='hidden';
            return true;
        }
    }


  $('#myDropzone').dropzone({
      url: "{{url('dropzone/store')}}",
      uploadMultiple: true,
      paramName: "file",
      maxFiles: 10,
      acceptedFiles: '.jpeg,.jpg,.png',
      autoProcessQueue: false, // myDropzone.processQueue() to upload dropped files
      addRemoveLinks: true,
      dictRemoveFile: "Remove image"
  });


  $(document).ready(function(){

    // edit pass
    $('#save').click(function(event){
      event.preventDefault();

      var form = $('#modal-body form'),
          url = form.attr('action'),
          method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';

          form.find('.form-control').removeClass('is-invalid');

          $.ajax({
            url : url,
            method : method,
            data : form.serialize(),
            success : function(response){
              form.trigger('reset');
              $('#edit_password').modal('hide');
              $('#edit_pasword').DataTable().ajax.reload();

              swal({
                type: 'success',
                title : 'success',
                text : 'Data has been saved!'
              })
            },
            error : function(xhr){
              var res = xhr.responseJSON;
              if($.isEmptyObject(res) == false) {
                $.each(res.errors, function(key, value){
                  $('#' + key)
                    .closest('.form-control')
                    .addClass('is-invalid')
                    .closest('.form-group')
                    .find('.text-danger')
                    .html(value)
                });
              }
              console.log(res)
            }
          });
    });

    
    // UPDATE PROFILE
    $('#update').click(function(event){
      event.preventDefault();

      var form = $('#profile_update'),
          url = form.attr('action'),
          method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';

          form.find('.form-control').removeClass('is-invalid');

          $.ajax({
              url : url,
              method : method, 
              data : form.serialize(),
              success : function(response){
                form.trigger('reset');
                swal({
                  type : 'success',
                  title : 'success',
                  text : 'Profile success update'
                })
              }, 
              error : function(xhr){
                var res = xhr.responseJSON;
                if($.isEmptyObject(res) == false) {
                  $.each(res.errors, function(key, value){
                      $('#' + key)
                      .closest('.form-control')
                      .addClass('is-invalid')
                      .closest('.form-group')
                      .find('.text-danger')
                      .html(value)
                  });
                }
              }
          });
    
    });

});
</script>
@endsection
