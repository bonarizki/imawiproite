@extends('resignation/master/master')
@section('title','Access Position')
@section('breadcumb','Access Postion')
@section('content')
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" width="100%" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Department</th>
                                        <th>Access</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Department</th>
                                        <th>Access</th>
                                        <th>Edit</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade text-left" data-backdrop="static" data-keyboard="false" id="modal" role="dialog" >
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="form">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="edit">
                        <div class="row">
                            <div class="col-3">Department</div>
                            <div class="col-1">:</div>
                            <div class="col-8 department-name"></div>
                        </div>
                    </div>
                    <br>
                    <h5 class="font-bold mb-2">Access</h5>
                    <form id="form">
                        <div class="row" id="form-body">
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal" hidden >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('/resgination/all/access-position/data')}}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'department.department_name',
                        name: 'department_name',
                    },
                    {
                        data: 'access_position_id',
                        name : 'access_position_id',
                        render: function (data, type, row, meta) {
                            return `<a onclick="Access('${data}','view')"><i class="fa fa-eye" title="view"></i></a>`
                        }
                    },
                    {
                        data: 'access_position_id',
                        data : 'access_position_id',
                        render: function (data, type, row, meta) {
                            return `<a onclick="Access('${data}','edit')"><i class="fa fa-pencil-square-o" title="edit"></i></a>`
                        }
                    }

                ],
                columnDefs: [{
                        orderable: false,
                        targets: [0, 2, 3]
                    },
                    {
                        searchable: false,
                        targets: [0, 2, 3]
                    },
                ],
                "order": [[ 1, "desc" ]]
            })
            GetMenuAll();
        });

        function Access(access_id,type){
            type == 'edit' ? $('#button-modal').attr('hidden',false) : $('#button-modal').attr('hidden',true) ;
            type == 'edit' ? $('#button-modal').attr('onclick',`update(${access_id})`) : '' ;
            let title = type == 'edit' ? 'Edit Access' : 'View Access';
            $('#form')[0].reset()
            $("input").removeAttr('disabled');
            $.ajax({
                type:"get",
                url:"{{url('resgination/all/access-position')}}/"+access_id,
                success:function(response){
                    let data = response.data.data
                    $('.department-name').text(data.department.department_name);
                    showdata(data)
                    type == 'view' ? $("#form input").attr('disabled','disabled') : ''
                    $('#title-modal').text(title);
                    $('#modal').modal('show');
                }
            })
        }

        function showdata(data) {
            let moduleMenu = data.menu
            console.log(moduleMenu)
            let menu = moduleMenu.split('#');
            let menu_parent = menu[0].split(',');
            let menu_child = menu[1].split(',');
            let menu_grand_child = menu[2].split(',');

            for (let index = 0; index < menu_parent.length; index++) {
                $(`#menu_parent_${menu_parent[index]}`).prop('checked', true);
            }
            for (let index = 0; index < menu_child.length; index++) {
                $(`#menu_child_${menu_child[index]}`).prop('checked', true);
            }
            for (let index = 0; index < menu_grand_child.length; index++) {
                $(`#menu_grand_child_${menu_grand_child[index]}`).prop('checked', true);
            }

        }

        function GetMenuAll()
        {
            $.ajax({
                type:"get",
                url:"{{url('/resignation/menu/access')}}/",
                success:function(response){
                    let form = '';
                    let data = response.data
                    for (let index = 0; index <data.length; index++) {
                        form += `<div class="col-4 mb-2">
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-info">
                                            <input type="checkbox" value="${data[index].menu_parent_id}" name="menu_parent[]" id="menu_parent_${data[index].menu_parent_id}">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">${data[index].menu_parent_name}</span>
                                        </div>
                                    </fieldset>
                                    <div style="padding-left: 30px;"> `
                        
                        if(data[index].menu_child.length > 0) {
                            let menu_child = data[index].menu_child;
                            for (let i = 0; i < menu_child.length; i++) {
                                form += ` <fieldset>
                                            <div class="vs-checkbox-con vs-checkbox-info">
                                                <input type="checkbox" value="${menu_child[i].menu_child_id}" name="menu_child[]" id="menu_child_${menu_child[i].menu_child_id}">
                                                <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">${menu_child[i].menu_child_name}</span>
                                            </div>
                                        </fieldset>`
                                if (menu_child[i].hasOwnProperty('menu_grand_child')) {
                                    let menu_grand_child = menu_child[i].menu_grand_child
                                    form += `<div style="padding-left: 30px;">`
                                    for (let a = 0; a <menu_grand_child.length; a++) {
                                        form += `<fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-info">
                                                        <input type="checkbox" value="${menu_grand_child[a].menu_grand_child_id}" name="menu_grand_child[]" id="menu_grand_child_${menu_grand_child[a].menu_grand_child_id}">
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">${menu_grand_child[a].menu_grand_child_name}</span>
                                                    </div>
                                                </fieldset>`
                                    }
                                    form += '</div>'
                                }
                            }
                        }

                        form += `</div>
                                </div>`
                    }
                    $('#form-body').append(form);
                }
            })
        } 

        function update(access_id){
            let data = $('#form').serialize();
            data += `&access_position_id=${access_id}`;
            $.ajax({
                type:'PUT',
                url:"{{url('resgination/all/access-position')}}",
                data:data,
                success:function(response){
                    sweetSuccess(response.message,response.data.message);
                    $('#modal').modal('hide')
                }
            })
        }

        function sweetSuccess(status, message) {
            Swal.fire({
                title: 'Good job!',
                text: message,
                icon: status
            })
        }
    </script>
@endsection