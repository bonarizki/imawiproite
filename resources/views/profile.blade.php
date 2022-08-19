@extends('master/master')
@section('title','Profile')
@section('breadcumb','Profile')
@section('content')

<div class="row">
    <div class="col-md-6">
        <!-- Profile Image -->
        <div class="card card-primary card-outline border-info shadow">
            <div class="card-body box-profile">
                <div class="text-center mb-1">
                    <img class="profile-user-img img-fluid img-circle" id="image" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center" id="profile_user"></h3>

                <p class="text-muted text-center" id="profile_nik"></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col col-sm-6">
                                <b>Department</b>
                            </div>
                            <div class="col col-sm-6">
                                <a class="float-right text-right" id="profile_department"></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col col-sm-6">
                                <b>Title</b>
                            </div>
                            <div class="col col-sm-6">
                                <a class="float-right text-right" id="profile_title"></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col col-sm-6">
                                <b>Email</b>
                            </div>
                            <div class="col col-sm-6">
                                <a class="float-right text-right" id="profile_email"></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col col-6">
                                <b>Join Date</b>
                            </div>
                            <div class="col col-6">
                                <a class="float-right text-right" id="profile_joind_date"></a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col col-sm-6">
                                <b>Employee Status</b>
                            </div>
                            <div class="col col-sm-6">
                                <a class="float-right text-right" id="profile_type"></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col-md-6">
        <div class="card border-info shadow">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#editProfile" data-toggle="tab">Edit
                            Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Change
                            Password</a></li>
                    </li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="editProfile">
                        <form id="form-profile">
                        @csrf
                            <input type="hidden" name="user_nik" id="user_nik">
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control"id="user_mobile" name="user_mobile">
                                    </div>
                                    <small id="user_mobileAlert" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Birth City</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Birth City" id="user_birth_city" name="user_birth_city">
                                    </div>
                                    <small id="user_birth_cityAlert" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label>Birth Date</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Birth Date" id="user_birth_date" name="user_birth_date">
                                    </div>
                                    <small id="user_birth_dateAlert" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" class="btn btn-primary btn-block" onclick="validasi('form-profile')">Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="changePassword">
                        <form id="form-change-password">
                            {{csrf_field() }}
                            <div class="input-group mb-3" id="groupPasswordOld">
                                <label>Old Password</label>
                                <div class="input-group">
                                    <input type="password" name="passwordOld" id="passwordOld" class="form-control" placeholder="Confirm Password" autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a onclick="showpassword('passwordOld')">
                                                <span class="fas fa-eye-slash" id="iconpasswordOld" style="color: gray;cursor: pointer;"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <small id="passwordOldAlert" class="form-text text-danger"></small>
                            </div>
                            <div class="input-group mb-3">
                                <label>New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="passwordNew" name="passwordNew" placeholder="New Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a onclick="showpassword('passwordNew')">
                                                <span class="fas fa-eye-slash" id="iconpassword" style="color: gray;cursor: pointer;"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <small id="passwordNewAlert" class="form-text text-danger"></small>
                            </div>
                            <div class="input-group mb-3" id="groupPassword">
                                <label>Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a onclick="showpassword('password')">
                                                <span class="fas fa-eye-slash" id="iconpassword" style="color: gray;cursor: pointer;"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <small id="passwordAlert" class="form-text text-danger"></small>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary btn-block" onClick="validasi('form-change-password')">Change password</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>

</div>
    
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            let url = "{{Auth::user()->user_image}}";
            if (url == '') {
                let sexs = "{{Auth::user()->user_sex}}"
                if (sexs == "M") {
                    url = "male.png";
                } else {
                    url = "female.png";
                }
            }
            $('#image').attr('src', `{{asset('img-user')}}/${url}`);
            dataUser();
        });

        function dataUser() {
            $.ajax({
                type: "get",
                url: `{{url('profile')}}/{{Auth::user()->user_nik}}`,
                success: function (response) {
                    let profile = response.data.profile
                    $('#profile_user').text(profile.user_name);
                    $('#user_nik').val(profile.user_nik);
                    $('#user_id').val(profile.user_id);
                    $('#profile_nik').text(`Nik - ${profile.user_nik}`);
                    $('#profile_department').text(profile.department.department_name);
                    $('#profile_title').text(`${profile.title.title_name} - ${profile.grade.grade_name}`);
                    $('#profile_email').text(profile.user_email);
                    $('#profile_email').attr('href', `mailto:${profile.user_email}`)
                    $('#profile_joind_date').text(profile.user_join_date);
                    $('#profile_type').text(profile.type.type_name);
                    $('#user_mobile').val(profile.user_mobile).inputmask('999-999-999-999', {
                        'placeholder': '___-___-___-___',
                        'removeMaskOnSubmit': true
                    });
                    $('#user_birth_city').val(toUpper(profile.user_birth_city));
                    $('#user_birth_date').val(profile.user_birth_date);
                }
            })
        }

        function toUpper(str) {
            return str
                .toLowerCase()
                .split(' ')
                .map(function (word) {
                    return word[0].toUpperCase() + word.substr(1);
                })
                .join(' ');
        }

        function saveProvile() {
            $.ajax({
                type: "PUT",
                url: "{{url('profile')}}",
                data: {
                    user_id: $('#user_id').val(),
                    user_nik: $('#user_nik').val(),
                    user_mobile: $("#user_mobile").inputmask('unmaskedvalue'),
                    user_birth_city: $("#user_birth_city").val(),
                    user_birth_date: $("#user_birth_date").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    sweetSuccess(response.message, response.data.message)
                    dataUser();
                }
            })
        }

        function showpassword(id) {
            var x = document.getElementById(`${id}`);
            if (x.type === "password") {
                x.type = "text";
                $(`#icon${id}`).removeClass();
                $(`#icon${id}`).addClass('fas fa-eye');
            } else {
                x.type = "password";
                $(`#icon${id}`).removeClass();
                $(`#icon${id}`).addClass('fas fa-eye-slash');
            }
        }

        function validasi(form) {
            $('.is-invalid').removeClass('is-invalid');
            $('small').empty();
            let data = $(`#${form}`).serializeArray();
            let result = loopingValidasi(data)
            if (result.length == 0) {
                if(form == 'form-profile') {
                    saveProvile() 
                 }else{
                    let result = MatchPassword()
                    if(result == true){
                        savePassword()
                    }else{
                        $(`#passwordNewAlert`).text(result)
                    }
                 } 
                   
            } else {
                for (let index = 0; index < result.length; index++) {
                    $(`#${result[index]}`).addClass('is-invalid');
                    $(`#${result[index]}Alert`).text('Form cannot be empty')
                    // sweetError('Form cannot be empty');
                }
            }
        }

        function MatchPassword(p) {
            let password = $('#password').val()
            let passwordNew = $('#passwordNew').val()
            if (password == passwordNew) {
                return validatePassword($('#passwordNew').val());
            }else{
                $(`#passwordNew`).addClass('is-invalid');
                $(`#passwordNewAlert`).text('Password Not Match');
            }
            
        }

        function validatePassword(p)
        {
            let errors = [];
            if (p.length < 8) {
                errors.push("Your password must be at least 8 characters.");
            }
            if (p.search(/[a-z]/i) < 0) {
                errors.push("Your password must contain at least one letter.");
            }
            if (p.search(/(?=.*[A-Z])/) < 0) {
                errors.push("Your password must contain at least one capital letter.");
            }
            if (p.search(/[0-9]/) < 0) {
                errors.push("Your password must contain at least one digit number.");
            }
            if (p.search(/[^a-zA-Z0-9]/) < 0) {
                errors.push("Your password must contain at least one unique letter.");
            }
            if (errors.length > 0) {
                return errors.join("\n");
            }
            return true;
        }

        function loopingValidasi(data) {
            let dataArray = [];
            for (let index = 0; index < data.length; index++) {
                if (data[index]['value'] == '') {
                    dataArray.push(data[index]['name'])
                }
            }
            return dataArray;
        }

        function sweetSuccess(status, message) {
            Swal.fire(
                'Good job!',
                message,
                status
            );
        }

        function sweetError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function savePassword()
        {
            $.ajax({
                type:"PUT",
                url:"{{url('profile/password')}}",
                data:{
                    user_id: $('#user_id').val(),
                    user_nik: $('#user_nik').val(),
                    password_new:$('#passwordNew').val(),
                    password:$('#passwordOld').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    sweetSuccess(response.message, response.data.message);
                    $('#form-change-password')[0].reset();
                },
                error:function(response){
                    $(`#password`).addClass('is-invalid');
                    $(`#passwordAlert`).text(response.responseJSON.message);
                }
            })
        }
    </script>
@endsection
    