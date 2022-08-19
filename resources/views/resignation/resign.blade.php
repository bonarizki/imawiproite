@extends('resignation/master/master')
@section('breadcumb','Resign Form')
@section('title','Resign')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" id="form">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Email</span>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="position-relative has-icon-left">
                                                    <input type="email" id="user_email" class="form-control"
                                                        name="user_email" placeholder="Email">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Password</span>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="position-relative has-icon-left">
                                                    <input type="password" id="password" class="form-control"
                                                        name="password" placeholder="Password">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 offset-md-4">
                                        <button type="button" class="btn btn-primary mr-1 mb-1" onclick="validasi()">Submit</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        function validasi(){
            let data = $('#form').serializeArray();
                let result = loopingValidasi(data)
                if(result.length==0){
                    resign();
                }else{
                    for (let index = 0; index < result.length; index++) {
                        $(`#${result[index]}`).addClass('is-invalid');
                        sweetError('Form cannot be empty');
                    }
                }
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

        function loopingError(fail, key) {
            if (fail.hasOwnProperty(key)) {
                $(`#${key}`).addClass('is-invalid');
                sweetError(fail[key][0]);
            }
        }


        function resign(){
            Swal.fire({
                title: 'Are you sure to resign?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, I'm Resign`,
                preConfirm: function () {
                    insertResign();
                }
            })
        }

        function insertResign(){
            let data = $('#form').serialize();
            data+= `&user_nik={{Auth::user()->user_nik}}`
            $.ajax({
                type: 'POST',
                url: "{{url('/resignation/request/resign')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    let dataSendMail = response.data.SendEmail;
                    let userResign = response.data.userResign;
                    for (let index = 0; index < dataSendMail.length; index++) {
                        $.ajax({
                            type : "post",
                            data : {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                recipient_name : dataSendMail[index].user_name,
                                recipient_email : dataSendMail[index].user_email,
                                resign_code : userResign.resign_id,
                                requested_user : userResign.user.user_name,
                                resign_user_department : userResign.user.department.department_name,
                                resign_user_title : userResign.user.title.title_name,
                                resign_user_grade : userResign.user.grade.grade_name,
                                type : dataSendMail[index].user_nik == '77222108' ? 'updated' : 'approval'
                            },
                            url : "{{url('resignation/send-mail/resign')}}",
                            success : function(res) {
                                console.log(index)
                            },
                            error : function(jqXhr, errorThrown, textStatus) {
                                console.log(errorThrown);
                            }
                        });
                    }
                },
                error:function(response){
                    if(response.responseJSON.errors==null){
                        sweetError(response.responseJSON.message)
                    }else{
                        let fail = response.responseJSON.errors;
                        let key = Object.keys(fail)
                        loopingError(fail,key)
                    }
                }
            })
        }

        function sweetError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function sweetSuccess(status,message){
            Swal.fire(
                'Good job!',
                message,
                status
            );
        }
    </script>
@endsection