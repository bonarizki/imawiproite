@extends('training/master/master')
@section('title','Menu')
@section('breadcumb','List Menu Training')

@section('content')
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="col mt-2">
                        <button class="btn btn-success" onclick="modalShow('add')"><i class="feather icon-plus"></i> Add Menu</button>
                    </div>
                    <div class="card-body card-dashboard">
                        {{-- <p class="card-text">DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</p> --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="table" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu ID</th>
                                        <th>Menu Name</th>
                                        <th>Menu URL</th>
                                        <th>Menu Icon</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu ID</th>
                                        <th>Menu Name</th>
                                        <th>Menu URL</th>
                                        <th>Menu Icon</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="button-modal">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/ Zero configuration table -->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var table = $('#table').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>'
                },
                ajax: "{{url('training/all/menu')}}",
                columns: [{
                        className: 'details-control',
                        orderable: false,
                        data: '',
                        defaultContent: '',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="badge badge-sm badge-info details-control" data-toggle="tooltip"><i class="fa fa-chevron-down"></i></badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'menu_parent_name',
                        name: 'menu_parent_name'
                    },
                    {
                        data: 'menu_parent_url',
                        name: 'menu_parent_url'
                    },
                    {
                        data: 'menu_parent_icon',
                        name: 'menu_parent_icon',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge>
                                            <i class="${data}"></i> - ${data==null ? '' : data}
                                        </badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'menu_parent_id',
                        name: 'menu_parent_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-success" onclick="modalShow('edit','menu_parent','${data}')"><i class="fas fa-user-edit"></i> Edit</badge>
                                    </center>`
                        }
                    },
                    {
                        data: 'menu_parent_id',
                        name: 'menu_parent_id',
                        render: function (data, row, type, meta) {
                            return `<center>
                                        <badge class="btn btn-sm btn-danger" onclick="deleteMenu('menu_parent','${data}')"><i class="fas fa-trash-alt"></i> Delete</badge>
                                    </center>`
                        }
                    }
                ],
                "order": [
                    [1, 'asc']
                ]
            });

            $('#table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
                } else {
                    $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
                    let data = row.child(format(row.data(), 'child')).show();
                    let id = row.data().menu_parent_id;
                    tr.addClass('shown');
                    var table_child = $(`#table_child_${id}`).DataTable({
                        paging: false,
                        info: false,
                        serverSide: true,
                        sDom: 'lrtip',
                        destroy: true,
                        ajax: "{{url('training/all/menuChild')}}/" + id,
                        columns: [{
                                className: 'details-control-child',
                                orderable: false,
                                data: '',
                                defaultContent: '',
                                render: function (data, row, type, meta) {
                                    return `<center>
                                                <badge class="badge badge-sm badge-info details-control"><i class="fa fa-chevron-down"></i></badge>
                                            </center>`
                                }
                            },
                            {
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
                                data: 'menu_child_name',
                                name: 'menu_child_name'
                            },
                            {
                                data: 'menu_child_url',
                                name: 'menu_child_url'
                            },
                            {
                                data: 'menu_child_icon',
                                name: 'menu_child_icon',
                                render: function (data, row, type, meta) {
                                    return `<center>
                                                <badge>
                                                    <i class="${data}"></i> - ${data==null ? '' : data}
                                                </badge>
                                            </center>`
                                }
                            },
                            {
                                data: 'menu_child_id',
                                name: 'menu_child_id',
                                render: function (data, row, type, meta) {
                                    return `<center>
                                                <badge class="btn btn-sm btn-success" onclick="modalShow('edit','menu_child','${data}')"><i class="fas fa-user-edit"></i> Edit</badge>
                                            </center>`
                                }
                            },
                            {
                                data: 'menu_child_id',
                                name: 'menu_child_id',
                                render: function (data, row, type, meta) {
                                    return `<center>
                                                <badge class="btn btn-sm btn-danger" onclick="deleteMenu('menu_child','${data}')"><i class="fas fa-trash-alt"></i> Delete</badge>
                                            </center>`
                                }
                            }
                        ],
                        "order": [
                            [2, 'asc']
                        ]
                    });
                }

                $(`#table_child_${row.data().menu_parent_id} tbody`).on('click', 'td.details-control-child', function () {
                    var tr = $(this).closest('tr');
                    var row = table_child.row(tr);
                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                        $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
                    } else {
                        $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
                        let data = row.child(format(row.data(), 'grand_child')).show();
                        let id = row.data().menu_child_id;
                        tr.addClass('shown');
                        $(`#table_grand_child_${id}`).DataTable({
                            paging: false,
                            info: false,
                            serverSide: true,
                            destroy: true,
                            sDom: 'lrtip',
                            ajax: "{{url('training/all/menuGrandChild')}}/" + id,
                                        columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex'
                                },
                                {
                                    data: 'menu_grand_child_name',
                                    name: 'menu_grand_child_name'
                                },
                                {
                                    data: 'menu_grand_child_url',
                                    name: 'menu_grand_child_url'
                                },
                                {
                                    data: 'menu_grand_child_icon',
                                    name: 'menu_grand_child_icon',
                                    render: function (data, row, type, meta) {
                                        return `<center>
                                                    <badge>
                                                        <i class="${data}"></i> - ${data==null ? '' : data}
                                                    </badge>
                                                </center>`
                                    }
                                },
                                {
                                    data: 'menu_grand_child_id',
                                    name: 'menu_grand_child_id',
                                    render: function (data, row, type, meta) {
                                        return `<center>
                                                    <badge class="btn btn-sm btn-success" onclick="modalShow('edit','menu_grand_child','${data}')"><i class="fas fa-user-edit"></i> Edit</badge>
                                                </center>`
                                    }
                                },
                                {
                                    data: 'menu_grand_child_id',
                                    name: 'menu_grand_child_id',
                                    render: function (data, row, type, meta) {
                                        return `<center>
                                                    <badge class="btn btn-sm btn-danger" onclick="deleteMenu('menu_grand_child','${data}')"><i class="fas fa-trash-alt"></i> Delete</badge>
                                                </center>`
                                    }
                                }
                            ],
                            "order": [
                                [1, 'asc']
                            ]
                        });
                    }
                });
            });
        });

        function format(d, type) {
            let data = make_table(d, type);
            return data;
        }

        function make_table(d, type) {
            let table = ''
            let data = type == 'child' ? d.menu_parent_id : d.menu_child_id;
            let field = type == 'grand_child' ? '' : '<th>#</th>';
            let newType = explodeType(type);
            table = `<table class="table table-hover table-striped table-sm table-bordered display table_${type}" style="width: 100%" id="table_${type}_${data}">
                            <thead>
                                <tr>
                                    ${field}
                                    <th>Menu ${newType} ID</th>
                                    <th>Menu ${newType} Name</th>
                                    <th>Menu ${newType} URL</th>
                                    <th>Menu ${newType} Icon</th>
                                    <th>Edit ${newType}</th>
                                    <th>Delete ${newType}</th>
                                </tr>
                            </thead>
                        </table>`;
            return table;
        }

        function explodeType(type) {
            let data = type.split('_');
            let dataReturn = '';
            if (data.length > 1) {
                for (let index = 0; index < data.length; index++) {
                    dataReturn += capitalizeFirstLetter(data[index]);
                    dataReturn += " ";
                }
            } else {
                dataReturn += capitalizeFirstLetter(data[0]);
            }
            return dataReturn;
        }

        function capitalizeFirstLetter(string) {
            return string.replace(/^./, string[0].toUpperCase());
        }

        function modalShow(type, typeParameter, id) {
            $('.is-invalid').removeClass('is-invalid');
            $('.headerForm').remove();
            $('.modal-body').append(`<div class="form-group headerForm">
                                    <label>Type Menu</label>
                                    <select id="type_menu" class="form-control select2bs4" onchange="TypeMenuForm()">
                                        <option value="" selected>Choose</option>
                                        <option value="menu_parent" >Parent Menu</option>
                                        <option value="menu_child" >Child Menu</option>
                                        <option value="menu_grand_child" >Grand Child Menu</option>
                                    </select>
                                </div>`);
            $('#title-modal').text('Add Menu');
            if (type == 'edit') {
                (async function () {
                    await TypeMenuForm(type, typeParameter);
                    $("#type_menu").prop("disabled", true);
                    $('#type_menu').val(typeParameter).select2({
                        theme: 'bootstrap4'
                    });
                    modalEdit(type, typeParameter, id)
                })()
            } else {
                modalAdd()
            }
        }

        function deleteMenu(typeParameter, id) {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm: function () {
                    prosesDelete(typeParameter, id)
                }
            })

        }

        function prosesDelete(typeMenu, id) {
            $.ajax({
                type: "delete",
                url: "{{url('training/delete/menu')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    TypeMenu: typeMenu
                },
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    refreshTables(typeMenu)
                    closeModal();
                }
            })
        }

        function modalEdit(type, typeParameter, id) {
            $.ajax({
                asyn: false,
                type: "get",
                url: "{{url('training/detail/menu')}}/",
                data: {
                    _token: "{{ csrf_token() }}",
                    TypeMenu: typeParameter,
                    id: id
                },
                success: function (response) {
                    $('#title-modal').text('Edit Menu');
                    $('.modal-body').append(`<div class="${typeParameter}_id hidden_field" hidden>
                                            <input type="text" id="${typeParameter}_id" name="${typeParameter}_id">
                                        </div>`);
                    $(`#${typeParameter}_id`).val(response.data[`${typeParameter}_id`]);
                    $(`#${typeParameter}_name`).val(response.data[`${typeParameter}_name`]);
                    $(`#${typeParameter}_url`).val(response.data[`${typeParameter}_url`]);
                    $(`#${typeParameter}_icon`).val(response.data[`${typeParameter}_icon`]);
                    if (typeParameter == 'menu_child' || typeParameter == 'menu_grand_child') {
                        if (typeParameter == 'menu_child') {
                            $('#menu_parent_id').val(response.data.menu_parent_id).select2({
                                theme: 'bootstrap4'
                            });
                        } else if (typeParameter == 'menu_grand_child') {
                            $('#menu_parent_id').val(response.data.menu_child.menu_parent_id).select2({
                                theme: 'bootstrap4'
                            });
                        }
                    }
                },
                complete: function (response) {
                    let d = response.responseJSON
                    if (typeParameter == 'menu_grand_child') {
                        optionChild(d);
                    }
                }
            }).done($('#modal').modal('show'));
        }

        function updateData(typeMenu) {
            let data = $('#form').serialize();
            data += `&TypeMenu=${typeMenu}`
            $.ajax({
                type: "PUT",
                url: "{{url('training/update/menu')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.status, response.message);
                    refreshTables(typeMenu)
                    closeModal();
                },
                error: function (response) {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
                }
            })
        }

        function modalAdd() {
            $('#modal').modal('show');
        }

        async function TypeMenuForm(type1, typeParameter) {
            $('.type_menu').remove();
            let type = typeParameter == null ? $('#type_menu').val() : typeParameter;
            let type2 = type1 == null ? 'add' : type1;
            let label = explodeType(type);
            let data = '<div class="type_menu">';
            if (type == 'menu_child' || type == 'menu_grand_child') {
                let change = type == 'menu_grand_child' ? 'onchange="optionChild()"' : '';
                data += `   <div class="form-group">
                                <label>Parent Menu</label>
                                <select id="menu_parent_id" name="menu_parent_id" class="form-control select2bs4" ${change}>
                                    <option value="" selected>Choose</option>
                                </select>
                            </div>`;
                if (type == 'menu_grand_child') {
                    data += `<div class="form-group">
                                <label>Child Menu</label>
                                <select id="menu_child_id" name="menu_child_id" class="form-control select2bs4">
                                    <option value="" selected>Choose</option>
                                </select>
                            </div>`;
                }
                optionParent();
            }
                data += `   <div class="form-group">
                                <label>${label} Name</label>
                                <input type="text" class="form-control" id="${type}_name" name="${type}_name">
                            </div>
                            <div class="form-group">
                                <label>${label} Icon</label>
                                <input type="text" class="form-control" id="${type}_icon" name="${type}_icon">
                            </div>
                            <div class="form-group">
                                <label>${label} URL</label>
                                <input type="text" class="form-control" id="${type}_url" name="${type}_url">
                            </div> 
                        </div>`;
            $('.modal-body').append(data);
            $('#button-modal').attr('onclick', `validasi('${type2}','${type}')`);
        }

        async function optionParent() {
            $.ajax({
                url: "{{url('training/all/menu')}}",
                type: "GET",
                success: function (response) {
                    let data = response.data;
                    let option = '';
                    for (let index = 0; index < data.length; index++) {
                        $('#menu_parent_id').append(`<option value="${data[index].menu_parent_id}">${data[index].menu_parent_name}</option>`);
                    }
                    $('#menu_parent_id').append(option);
                }
            })
        }

        function optionChild(d) {
            $('.child_menu_option').remove();
            let id = $('#menu_parent_id').val() != '' ? $('#menu_parent_id').val() : '';
            if (id != '') {
                $.ajax({
                    url: "{{url('training/all/menuChild')}}/" + id,
                    type: "GET",
                    success: function (response) {
                        let data = response.data;
                        let option = '';
                        for (let index = 0; index < data.length; index++) {
                            $('#menu_child_id').append(`<option value="${data[index].menu_child_id}" class="child_menu_option">${data[index].menu_child_name}</option>`);
                        }
                        if (d != null) {
                            $('#menu_child_id').val(d.data.menu_child_id).select2({
                                theme: 'bootstrap4'
                            });
                        }
                    },
                })
            }

        }

        function closeModal() {
            $('#modal').modal('hide');
            $('.type_menu').remove();
            $('.hidden_field').remove();
            $('#form')[0].reset()
        }

        function validasi(type, typeMenu) {
            let data = $('#form').serializeArray();
            let result = loopingValidasi(data)
            if (result[0] == 'menu_parent_icon' || result[0] == 'menu_child_icon' || result[0] == 'menu_grand_child_icon' || result.length == 0) {
                if (type == 'edit') {
                    updateData(typeMenu)
                } else {
                    insert(typeMenu)
                }
            } else {
                for (let index = 0; index < result.length; index++) {
                    $(`#${result[index]}`).addClass('is-invalid');
                    sweetError('Form cannot be empty');
                }
            }
        }

        function insert(typeMenu) {
            let data = $('#form').serialize();
            data += `&TypeMenu=${typeMenu}`
            $.ajax({
                type: "POST",
                url: "{{url('training/insert/menu')}}",
                data: data,
                success: function (response) {
                    refreshTables(typeMenu)
                    closeModal();
                    sweetSuccess(response.status, response.message);
                },
                error: function (response) {
                    let fail = response.responseJSON.errors;
                    let key = Object.keys(fail)
                    loopingError(fail, key)
                }
            })
        }

        function loopingError(fail, key) {
            if (fail.hasOwnProperty(key)) {
                $(`#${key}`).addClass('is-invalid');
                sweetError(fail[key][0]);
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

        function sweetError(message) {
            Swal.fire({
                backdrop: false,
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function sweetSuccess(status, message) {
            Swal.fire({
                backdrop: false,
                title: 'Good job!',
                text: message,
                icon: status
            })
        }

        function refreshTables(typeMenu) {
            let table = '';
            if (typeMenu == 'menu_parent') {
                table = '#table'
            } else if (typeMenu == 'menu_child') {
                table = '.table_child'
            } else if (typeMenu == 'menu_grand_child') {
                table = '.table_grand_child'
            }
            $(`${table}`).DataTable().ajax.reload();
        }

    </script>
@endsection
