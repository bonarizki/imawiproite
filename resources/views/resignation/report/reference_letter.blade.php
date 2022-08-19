<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reference Letter</title>
</head>
<body>
    <div align="center" style="padding-top: 10px">
        <h2><u>TO WHOM IT MAY CONCERN</u></h2>
        <h4>No Ref : {{$data->resign_id}}</h4>
    </div>
    <br>
    <div align="left" style="padding-left: 50px">
        <p style="font-size: 20px">This is to certify that,</p>
    </div>
    <div style="padding-left: 100px;
                padding-top: 40px;">
        <table style="font-size: 20px" style="width: 100%">
            <tr>
                <td><b>Name</b></td>
                <td>:</td>
                <td> &nbsp; {{$data->User->user_name}}</td>
            </tr>
            <tr>
                <td><b>ID</b></td>
                <td>:</td>
                <td> &nbsp; {{$data->User->user_nik}}</td>
            </tr>
            <tr>
                <td><b>Position</b></td>
                <td>:</td>
                <td> &nbsp; {{$data->User->Title->title_name}}</td>
            </tr>
            <tr>
                <td><b>Department</b></td>
                <td>:</td>
                <td> &nbsp; {{$data->User->Department->department_name}}</td>
            </tr>
        </table>
    </div>
    <div style="padding-top: 40px;
                padding-left: 50px;
                padding-right: 50px;
                font-size: 20px">
        <p style=" text-align: justify;">Has worked with PT. Unza Vitalis Indonesia since {{$data->User->user_join_date}}, until {{$data->resign_date}} with the last position as {{$data->User->Title->title_name}}</p>
        <p style=" text-align: justify;">During his/her time with us, Mr/Ms. {{$data->User->user_name}} had performed his/her job satisfactorily and left this company on his/her own request.</p>
        <p style=" text-align: justify;">We would like to take this opportunity to express our gratitude for the service rendered to our company, and wish you every success in future career.</p>
    </div>
    <div style="padding-top: 40px;
                padding-left: 50px;
                font-size: 20px">
        <p>Jakarta, {{date('l, d F Y')}}</p>
        <br>
        <br>
        <br>
        <br>
        <p><b><u>Ni Made Sri Andani</u></b></p>
        <p><b>HRGA Director</b></p>
    </div>
    {{-- @dd($data) --}}
</body>
</html>