<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>UNZA-HRD | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('master/include/scriptHeader')
</head>
<style>
    /* .centerMenu{
        display: block;
        margin-left: 25%;
        margin-right: 25%;
        margin-top: 25%;
        margin-bottom: 25%;
    } */
</style>

<body class="hold-transition login-page">
    <!-- Automatic element centering -->
    <div class="container container-fluid">

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <h1 class="text-center">Menu SSO</h1>
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><h3>Recruitment</h3></span>
                            {{-- <span class="info-box-number text-center text-muted mb-0">2300</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><h3>Resignation</h3></span>
                            {{-- <span class="info-box-number text-center text-muted mb-0">2000</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted"><h3>Attrition</h3></span>
                            {{-- <span class="info-box-number text-center text-muted mb-0">20 <span> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>
    <!-- /.center -->

    @include('master/include/scriptFooter')
</body>

</html>
