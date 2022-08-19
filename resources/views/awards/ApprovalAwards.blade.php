@extends('awards/master/master')
@section('title','Approval')
@section('breadcumb','Approval Awards')
@section('content')
<style>
    table tbody:nth-child(even) {
        background-color: white;
    }
</style>
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
                                        <th rowspan="2" style="vertical-align: middle; width: 5% !important;">#</th>
                                        <th rowspan="2" style="vertical-align: middle; width: 15% !important;">NIK</th>
                                        <th rowspan="2" style="vertical-align: middle; width: 20% !important;">Name</th>
                                        <th rowspan="2" style="vertical-align: middle; width: 20% !important;">Title</th>
                                        <th rowspan="2" style="vertical-align: middle; width: 20% !important;">Status</th>
                                        <th colspan="2" style="vertical-align: middle;"><center>Action<center></th>
                                    </tr>
                                    <tr>
                                        <th><center>Approve</center></th>
                                        <th><center>View</center></th>
                                    </tr>
                                </thead>
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
                    <h4 class="modal-title" id="modalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="user_nik" hidden>
                    <p><i><b>
                        “Performance & Leadership Survey” merupakan indikator penilaian dari Sales & Skincare Awards 2021-2022.<br>
                        Kami telah menyediakan 20 pertanyaan yang harus Bapak/Ibu isi sesuai dengan kondisi dari karyawan ybs pada FY 2021-2022.<br>
                        Kami menyediakan 4 pilihan jawaban yang mana masing-masing angka memiliki indikator penilaian sebagai berikut:<br>
                        1= Sangat tidak setuju <br>
                        2= Tidak Setuju<br>
                        3= Setuju<br>
                        4= Sangat setuju <br>
                    </b></i></p>
                    <table class="table table-striped table-hover" width="100%">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Question</td>
                                <td><center>Answer L1</center></td>
                                <td><center>Answer L2</center></td>
                            </tr>
                        </thead>
                        <tbody id="survey_question">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script src="{{asset('js/script.js')}}"></script>
    <script>
        const data = {
            id_name : "approval_id",
            url:"{{url('sales-awards/approval')}}"
        }

        const Helper = new valbon (data)
        const field = [
            "question_no_1",
            "question_no_2",
            "question_no_3",
            "question_no_4",
            "question_no_5",
            "question_no_6",
            "question_no_7",
            "question_no_8",
            "question_no_9",
            "question_no_10",
            "question_no_11",
            "question_no_12",
            "question_no_13",
            "question_no_14",
            "question_no_15",
            "question_no_16",
            "question_no_17",
            "question_no_18",
            "question_no_19",
            "question_no_20",
            "question_no_21"
        ];

        $(document).ready(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{url('sales-awards/approval')}}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user_nik',
                        name: 'user_nik',
                    },
                    {
                        data: 'user.user_name',
                        name : 'user.user_name',
                    },
                    {
                        data: 'user.title.title_name',
                        name : 'user.title.title_name',
                    },
                    {
                        data: 'user_nik',
                        name: 'user_nik',
                        render : (data,meta,row) => {
                            if (row.answer_l1 == null) {
                                return '<badge class="badge badge-secondary">Pending</badge>'
                            }else if (row.answer_l1 != null && row.answer_l2 != null) {
                                return '<badge class="badge badge-success">Done</badge>'
                            } else {
                                return '<badge class="badge badge-primary">Process</badge>'
                            }
                        }
                    },
                    {
                        data: 'user_nik',
                        data : 'user_nik',
                        render: function (data,meta,row) {
                            if (row.answer_l1 != null && row.answer_l2 != null) {
                                return `<center>
                                            <i class="fa fa-lock" title="lock"></i>
                                        </center>`
                            }else if (row.answer_l1 == null && row.answer_l2 == null) {
                                return `<center>
                                            <i class="fa fa-lock" title="lock"></i>
                                        </center>`
                            } else {
                                return `<center>
                                            <a onclick="modal('edit','${data}')"><i class="fa fa-pencil-square-o" title="edit"></i></a>
                                        </center>`
                            }
                        }
                    },
                    {
                        data: 'user_nik',
                        data : 'user_nik',
                        render: function (data,meta,row) {
                            if (row.answer_l1 != null && row.answer_l2 != null) {
                                return `<center>
                                            <a onclick="modal('view','${data}')"><i class="fa fa-eye" title="view"></i></a>
                                        </center>`
                            }else if (row.answer_l1 == null && row.answer_l2 == null) {
                                return `<center>
                                            <i class="fa fa-eye-slash"></i>
                                        </center>`
                            }else{
                                return `<center>
                                            <i class="fa fa-eye-slash"></i>
                                        </center>`
                            }
                        }
                    }

                ],
                columnDefs: [{
                        orderable: false,
                        targets: []
                    },
                    {
                        searchable: false,
                        targets: []
                    },
                ]
            })

        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        modal = (type,id = null) => {
            $('#user_nik').val();
            $('#modalLabel').text(`Survey Questions`);
            $('#btn-save').attr('onclick',`validasi('add')`);
            $('#btn-save').attr('enable', 'enable');
            add(id)
            
        }

        add = (id) => {
            $('#survey_question').empty();
            $('#user_nik').val(id);
            $.ajax({
                type: "get",
                url: `${data.url}/`+id+`/edit`,
                success: (res) => {
                    let data = res.data;
                    let question = ''
                    data.forEach((item,index) => {
                        question += `
                            <tr>
                                <td>${index + 1}. </td>
                                <td>
                                    ${item.question}
                                    <p><small id='question_no_${index + 1 }_alert' class="ml-2 form-text text-danger"></small></p>
                                </td>
                                <td>
                                    <select type="text" class="form-control select2bs4" id='question_no_${index + 1 }_l1' name='question_no_${index + 1}_l1' placeholder="First Name">
                                        <option value=''>Select Point</option>
                                        <option value='1-${item.question_id}'>1</option>
                                        <option value='2-${item.question_id}'>2</option>
                                        <option value='3-${item.question_id}'>3</option>
                                        <option value='4-${item.question_id}'>4</option>
                                    </select>
                                </td>
                                <td>
                                    <select type="text" class="form-control select2bs4" id='question_no_${index + 1 }' name='question_no_${index + 1}' placeholder="First Name">
                                        <option value=''>Select Point</option>
                                        <option value='1-${item.question_id}'>1</option>
                                        <option value='2-${item.question_id}'>2</option>
                                        <option value='3-${item.question_id}'>3</option>
                                        <option value='4-${item.question_id}'>4</option>
                                    </select>
                                </td>
                            </tr>`
                    });

                    question += `
                        <tr>
                            <td rowspan="2">21.</td>
                            <td colspan="3">Komentar keseluruhan bagi karyawan yang bersangkutan :</td>
                        </tr>
                        <tr style="background-color:#f4f4f4;">
                            <td colspan="3">
                                <div class="row">
                                    <div class="col-6">
                                        <textarea type="text" id="question_no_21_l1" class="form-control" name='question_no_21'></textarea>
                                        <small id='question_no_21_l1_alert' class="ml-2 form-text text-danger"></small>
                                    </div>
                                    <div class="col-6">
                                        <textarea type="text" id="question_no_21" class="form-control" name='question_no_21'></textarea>
                                        <small id='question_no_21_alert' class="ml-2 form-text text-danger"></small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        `
                    
                    $('#survey_question').append(question);
                    $('#question_no_21_l1').val();
                },
                error:  (response) => {
                    Helper.errorHandle(response);
                },
                complete : () => {
                    edit(id)
                }
            })

            $('#modal').modal('show');
        }

        edit = (id) => {
            $.ajax({
                type:"get",
                url : data.url + "/" + id,
                success : (res)=> {
                    let dataL1 = res.data.l1;
                    let dataL2 = res.data.l2;
                    for (let index = 1; index <= 20; index++) {
                        let id = 'question_no_' + (index);
                        let id_question = id + '_id';
                        $(`#${id+'_l1'}`).val(`${dataL1[id]}-${dataL1[id_question]}`);
                        $(`#${id+'_l1'}`).attr('disabled', 'disabled');
                    }
                    $('#question_no_21_l1').val(dataL1.question_no_21);
                    $(`#question_no_21_l1`).attr('disabled', 'disabled');

                    if (res.data.l2 != null) {
                        for (let index = 1; index <= 20; index++) {
                            let id = 'question_no_' + (index);
                            let id_question = id + '_id';
                            $(`#${id}`).val(`${dataL2[id]}-${dataL2[id_question]}`);
                            $(`#${id}`).attr('disabled', 'disabled');
                        }
                        $('#question_no_21').val(dataL2.question_no_21);
                        $(`#question_no_21`).attr('disabled', 'disabled');
                    }
                }
            })
        }

        validasi = (type) => {
            let credentials = $('#form').serializeArray();
            if (type == 'add') {
                credentials.push({name: "user_nik", value: $('#user_nik').val()});
                Helper.validasi(type,credentials);
            }
        }

        deleteData = (id) => {
            Helper.modalDelete(id);
        }

        closeModal = () => {
            Helper.closeModal();
        }

    </script>
@endsection