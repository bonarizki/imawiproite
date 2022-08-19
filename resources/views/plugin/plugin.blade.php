@extends('master/master')
@section('title','Plugin Years')
@section('content')

<div class="row">
    <div class="col">
        <div class="card card-primary card-outline card-outline-tabs shadow">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="plugin-year-tab" data-toggle="pill" href="#plugin-year"
                            role="tab" aria-controls="plugin-year" aria-selected="true"
                            onclick="loadPluginTab('get','Year')">Plugin Year</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="plugin-month-tab" data-toggle="pill" href="#plugin-month" role="tab"
                            aria-controls="plugin-month" aria-selected="false" onclick="loadPluginTab('get','Month')">Plugin
                            Month</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="plugin-period-tab" data-toggle="pill" href="#plugin-period"
                            role="tab" aria-controls="plugin-period" aria-selected="false"
                            onclick="loadPluginTab('get','Period')">Plugin Period</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="plugin-version-tab" data-toggle="pill" href="#plugin-version" role="tab"
                            aria-controls="plugin-version" aria-selected="false" onclick="loadPluginTab('get','Version')">Plugin Version</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="plugin-setting-tab" data-toggle="pill" href="#plugin-setting" role="tab"
                            aria-controls="plugin-setting" aria-selected="false" onclick="loadPluginTab('get','Setting')">Plugin System Setting</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary mb-2" id="addButton"></button>
                    </div>
                </div>
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active table-responsive" id="plugin-year" role="tabpanel"
                        aria-labelledby="plugin-year-tab">
                        <table class="table table-hover table-bordered table-sm" id="table-plugin-year" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Year Name</th>
                                    <th>Year Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade table-responsive" id="plugin-month" role="tabpanel"
                        aria-labelledby="plugin-month-tab" style="width: 100%">
                        <table class="table table-hover table-bordered table-sm" id="table-plugin-month" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Month Name</th>
                                    <th>Month Squence</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade table-responsive" id="plugin-period" role="tabpanel"
                        aria-labelledby="plugin-period-tab" style="width: 100%">
                        <table class="table table-hover table-bordered table-sm" id="table-plugin-period"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Period Name</th>
                                    <th>Period Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade table-responsive" id="plugin-version" role="tabpanel"
                        aria-labelledby="plugin-version-tab" style="width: 100%">
                        <table class="table table-hover table-bordered table-sm" id="table-plugin-version"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Version Code</th>
                                    <th>Version Name</th>
                                    <th>Version Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade table-responsive" id="plugin-setting" role="tabpanel"
                        aria-labelledby="plugin-setting-tab" style="width: 100%">
                        <table class="table table-hover table-bordered table-sm" id="table-plugin-setting"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Setting System Name</th>
                                    <th>Setting System Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form">
        @csrf
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h5 class="modal-title" id="title-modal" style="color: white"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
    
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            loadPluginTab('get','Year');
        });

        const variable = {
            "Year": [{
                "label": "Year ID",
                "id": "year_id",
                "name": "year_id",
                "attribut":"id",
                "tables":"",
                "form":"true",
                "search":"true"
            },{
                "label": "Year Name",
                "id": "year_name",
                "name": "year_name",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "search":"true"
            },{
                "label": "Year status",
                "id": "year_status",
                "name": "year_status",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "form_type":"status",
                "search":"",
            }],
            "Month":[{
                "label": "Month ID",
                "id": "month_id",
                "name": "month_id",
                "attribut":"id",
                "tables":"",
                "form":"",
                "search":""
            },{
                "label": "Month Name",
                "id": "month_name",
                "name": "month_name",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "search":"true"
            },{
                "label": "Month Sequence",
                "id": "month_sequence",
                "name": "month_sequence",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "search":"true"
            }],
            "Period":[{
                "label":"Period ID",
                "id": "period_id",
                "name": "period_id",
                "attribut":"id",
                "tables":"",
                "form":"",
                "search":""
            },{
                "label":"Period Name",
                "id": "period_name",
                "name": "period_name",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "search":"true"
            },{
                "label": "Period status",
                "id": "period_status",
                "name": "period_status",
                "attribut":"",
                "tables":"true",
                "form":"",
                "form_type":"status",
                "search":"true"
            }],
            "Version":[{
                "label":"Version ID",
                "id": "version_id",
                "name": "version_id",
                "attribut":"id",
                "tables":"",
                "form":"",
                "search":""
            },{
                "label":"Version Code",
                "id": "version_code",
                "name": "version_code",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "search":"true"
            },{
                "label":"Version Name",
                "id": "version_name",
                "name": "version_name",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "search":"true"
            },{
                "label":"Version Status",
                "id": "version_status",
                "name": "version_name",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "form_type":"status",
                "search":"true"
            }],
            Setting:[{
                "label":"Setting System ID",
                "id": "setting_system_id",
                "name": "setting_system_id",
                "attribut":"id",
                "tables":"",
                "form":"true",
                "search":""
            },{
                "label":"Setting System Name",
                "id": "setting_system_name",
                "name": "setting_system_name",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "search":"true"
            },{
                "label":"Setting System Status",
                "id": "setting_system_status",
                "name": "setting_system_status",
                "attribut":"",
                "tables":"true",
                "form":"true",
                "form_type":"status",
                "search":"true"
            },]
        }

        const url = {
            "Year":[{
                "getAll":"{{url('/getall/plugin/year')}}",
                "getById":"{{url('/get/plugin/yearById')}}",
                "update":"{{url('/update/plugin/yearById')}}",
                "delete":"{{url('/delete/plugin/yearByid')}}",
                "insert":"{{url('/insert/plugin/year')}}"
            }],
            "Month":[{
                "getAll":"{{url('/getall/plugin/month')}}",
                "getById":"{{url('/get/plugin/monthById')}}",
                "update":"{{url('/update/plugin/MonthById')}}",
                "delete":"{{url('/delete/plugin/MonthByid')}}",
                "insert":"{{url('/insert/plugin/Month')}}"
            }],
            "Period":[{
                "getAll":"{{url('/getall/plugin/period')}}",
                "getById":"{{url('/get/plugin/periodById')}}",
                "update":"{{url('/update/plugin/PeriodById')}}",
                "delete":"{{url('/delete/plugin/PeriodByid')}}",
                "insert":"{{url('/insert/plugin/Period')}}"
            }],
            "Version":[{
                "getAll":"{{url('/getall/plugin/version')}}",
                "getById":"{{url('/get/plugin/versionById')}}",
                "update":"{{url('/update/plugin/VersionById')}}",
                "delete":"{{url('/delete/plugin/VersionByid')}}",
                "insert":"{{url('/insert/plugin/Version')}}"
            }],
            "Setting":[{
                "getAll":"{{url('/getall/system/setting')}}",
                "getById":"{{url('/get/plugin/systemSettingById/')}}",
                "update":"{{url('/update/plugin/systemSettingById')}}",
                "delete":"{{url('/delete/plugin/systemSettingById')}}",
                "insert":"{{url('/insert/plugin/systemSetting')}}"
            }]
            
        }

        

        function setStatus(id,d) {
            let val = d != null ? 0 : 1;
            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $(`#${id}`).val(val);
            });
            $(`#${id}`).on('switchChange.bootstrapSwitch', function () {
                if ($(`#${id}`).is(':checked')) {
                    $(`#${id}`).val('1')
                } else {
                    $(`#${id}`).val('0');
                }
            })


        }

        function loadPluginTab(type, title, search) {
            console.log(search)
            search == null ? setFilterTab(url, title, type) : '';
            let lowerTitle = title.toLowerCase();
            $(`#table-plugin-${lowerTitle}`).dataTable({
                processing: true,
                language: {
                    "loadingRecords": "Please Wait - loading",
                    'processing': '<div class="se-pre-con"></div>'
                },
                destroy: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: getUrl(type, title),
                    data: makeArrayForData(title)
                },
                order: [[ indexForOrder(lowerTitle), 'asc' ]],
                columns: makeColumns(title)
            });
            setHeader(title);
        }

        function indexForOrder(lowerTitle)
        {
            if(lowerTitle == 'year' || lowerTitle == 'period' || lowerTitle == 'version' || lowerTitle == 'setting'){
                return 1;
            }else{
                return 2;
            }
        }

        function makeArrayForData(title) {
            let label = variable[title];
            var obj = {};
            for (let index = 0; index < label.length; index++) {
                obj[`${label[index].name}`] = $(`#${label[index].name}_filter`).val()
            }
            return obj;
        }

        function setFilterTab(url, title, type) {
            $('#filter-search').empty()
            let label = variable[title];
            let filter = '';
            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    let data = response.data;
                    for (let index = 0; index < label.length; index++) {
                        if (label[index].search == 'true') {
                            filter += `<div class="col form-group" >
                                            <label>${label[index].label}</label>
                                            <input type="text" class="form-control" style="width: 100%" placeholder="${label[index].label}" id="${label[index].id}_filter" name="${label[index].name}_filter" onkeyup="loadPluginTab('${type}','${title}','search')"></input>
                                        </div>`
                        }
                    }
                    $('#filter-search').append(filter);
                }
            })
        }

        function makeColumns(title){
            let data = variable[title];
            let array = [];
            let id = '';
            array.push({
                data:"DT_RowIndex",
                name:"DT_RowIndex",
            })
            for (let index = 0; index < data.length; index++) {
                if (data[index].attribut=='id') {
                    id = data[index].id;
                }
                if(data[index].tables=='true'){
                    array.push({"data":data[index].id,"name":data[index].id});
                }
            }
            array.push({
                            "data":`${id}`,
                            "name":`${id}`,
                            render:function(data,row,type,meta){
                                return `<center>
                                            <badge class="btn btn-sm btn-success" onclick="Modal('edit','${title}','${data}')">
                                                <i class="fas fa-user-edit"></i> Edit
                                            </badge>
                                        </center>`
                            }
                        });
            array.push({
                            "data":`${id}`,
                            "name":`${id}`,
                            render:function(data,row,type,meta){
                                return `<center>
                                            <badge class="btn btn-sm btn-danger" onclick="Modal('delete','${title}','${data}')">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </badge>
                                        </center>`
                            }
                        });
            return array;
        }

       
        function setHeader(title){
            $('#addButton').empty();
            $('#title-plugins').text(`Plugin ${title}`)
            $('#addButton').append(`<i class="fas fa-plus"></i> Add ${title}`)
            $('#addButton').attr('onclick',`Modal('add','${title}')`)
        }

        function Modal(type,title,id){
            
            if(type=='delete'){
                deleteData(type,title,id)
            }else{
                $('#modal').modal('show');
                $('#title-modal').text(`Form Add ${title}`)
                makeForm(type,title,id);
            }
        }

        function makeForm(type,title,id){
            $('#modal').modal('show');
            $('#title-modal').text(`Form ${type} ${title}`)
            $('#button-modal').attr('onclick',`validasi('${type}','${title}')`);
            let data = variable[title]
            let form = `<div class="card-body-modal form-${title}" id="card-body">`;
            let status_name = '';
            for (let index = 0; index < data.length; index++) {
                
                if(type=='edit'&&data[index].attribut=='id'){
                    form += `<div class="form-group" hidden>
                                <label>${data[index].label}</label>
                                <input type="text" class="form-control" id="${data[index].id}" name="${data[index].id}" >
                        </div>`
                }else if(data[index].form_type=='status') {
                    form += `<div class="form-group">
                                <label>${data[index].label}</label><br>
                                <input type="checkbox" class="form-control" name="${data[index].id}" id="${data[index].id}" checked data-bootstrap-switch data-off-color="danger" data-on-color="info" data-on-text="Active" data-off-text="Inactive">
                            </div>`
                    status_name = data[index].id;
                }
                else if(data[index].attribut==''&&data[index].form=='true'){
                    form += `<div class="form-group">
                                <label>${data[index].label}</label>
                                <input type="text" class="form-control" id="${data[index].id}" name="${data[index].id}" >
                        </div>`
                }
            }
            form += `</div>`;
            type=='edit'? GetdataForm(data,id,title,type,status_name) : '';
            $('.modal-body').append(form);
            status_name != '' ? setStatus(status_name) : '';
        }

        function GetdataForm(dataConst,id,title,type,status_name){
            let url = getUrl(type,title);
            $.ajax({
                type:'GET',
                url : url+'/'+id,
                success:function(response){
                    let  data = response.data;
                    Showingdata(dataConst,data,status_name);
                }
            })
        }

        function Showingdata(dataConst,data,status_name){
            for (let index = 0; index < dataConst.length; index++) {
                
                if (status_name == dataConst[index].id) {
                    if (data[dataConst[index].id]!=1) {
                        setStatus(status_name,data[dataConst[index].id]) 
                        $(`#${status_name}`).bootstrapSwitch('state',false)
                    }
                }else{
                    $(`#${dataConst[index].id}`).val(data[dataConst[index].id])
                }
            }
        }

        function closeModal()
        {
            $('#modal').modal('hide');
            $('.card-body-modal').remove();
        }

        function validasi(type,tittle){
            let data = $('#form').serializeArray();
            let result = loopingValidasi(data);
            if(result.length==0){
                let NewType = type == 'add'? 'insert' : 'update';
                let method = type == 'add'? 'post' : 'put';
                SingleAjax(NewType,tittle,method)
                
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

        function sweetError(message){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function SingleAjax(type,title,method,id){
            let url = getUrl(type,title);
            let data = makeData(type,id);
            $.ajax({
                type : method,
                url : url,
                data : data,
                success : function (response){
                    sweetSuccess(response.status,response.message);
                    refreshTable(title);
                    closeModal()
                },
                error : function (response){
                    let fail = response.responseJSON.errors
                    loopingError(fail,title)
                }
            })
        }

        function makeData(type,id){
            if(type=='delete'||type=='edit'){
                return {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id:id
                    };
            }else{
                return $('#form').serialize();
            }
        }

        function getUrl(type,title,id){
            let urlTitle = url[title];
            if(type=='update'){
                return urlTitle[0].update;
            }else if(type=='edit'){
                return urlTitle[0].getById;
            }else if(type=='insert'){
                return urlTitle[0].insert;
            }else if(type=='delete'){
                return `${urlTitle[0].delete}`
            }else if(type=='get'){
                return `${urlTitle[0].getAll}`
            }
        }

        function sweetSuccess(status,message){
            Swal.fire(
                'Good job!',
                message,
                status
            );
        }

        function refreshTable(title)
        {
            $(`#table-plugin-${title.toLowerCase()}`).DataTable().ajax.reload();
        }

        function loopingError(fail,title) {
            let data = variable[title]
            for (let index = 0; index < data.length; index++) {
                if (fail.hasOwnProperty(data[index].id)) {
                    $(`#${data[index].id}`).addClass('is-invalid');
                    sweetError(fail[data[index].id][0])
                }
            }
        }

        function deleteData(type,title,id){
            Swal.fire( {
                title: 'Are you sure to delete?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm : function()  {
                    SingleAjax(type,title,'delete',id)
                }
            })
        }


    </script>
@endsection