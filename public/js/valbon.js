/**
 * use this class 
 * after jquery
 * 
 * Created by Muhammad Bona Rizki
 * Date: 01/07/21 
 * Mail: bonarizki.br@gmail.com
 * 
 */
class valbon 
{
    constructor(url=null) {
        if (url != null) {
            this.id_name = url.id_name;
            this.create = url.create;
            this.update = url.update;
            this.delete = url.delete;
            this.get = url.edit;
        }
        
    }

    chekNik = (nik) => {
        let superAdmin = [ 
            "76112008", // Muhammad Bona Rizki
            "65161410", // Chris Simon	
            "75862004", // Husin
            "77222108", // Adi Sumarno	
            "72031703", // 	Ardhini Retno Putri
            "73121801", // Nurul Amaliyah
            "75441911", // Viola Nursally Putri
        ];
        
        if (superAdmin.includes(nik)) {
            return true; // jika nik tersebut terdaftar sebagai admin
        } else {
            return false; // jika nik tersebut tidak terdaftar sebagai admin
        }
    }

    modal = (typeModal,id,form_name,formType = 'old') => {
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').empty();
        $('#modalLabel').text(`${this.capitalize(typeModal)} ${form_name}`)
        $('#btn-save').attr('onclick',`validasi('${typeModal}')`)
        if(typeModal == 'add') {
            this.add()
        }else{
            this.edit(id,formType)
        }
    }

    add = () => {
        
        $('#modal').modal('show')
    }


    edit = (id,formType) => {
        return Promise.resolve(
            $.ajax({
                type: `${this.get.method}`,
                url: `${this.get.url}/`+id,
                success: (response) => {
                    //field define by using as const
                    let data = field;
                    if(formType == 'new') data = ShowForm(response);
                    this.createIdForm(response)
                    for (let index = 0; index < data.length; index++) {
                        $(`#${data[index]}`).val(response.data[data[index]]);
                    }
                    $('#modal').modal('show');
                    if(formType == 'new') customSelect(response)
                },
                error:  (response) => {
                    this.errorHandle(response);
                }
            })
        )
    }

    insert = (params = null) => {
        let data = params == null 
            ? $('#form').serialize() 
            : params
        return Promise.resolve(
            $.ajax({
                type: `${this.create.method}`,
                url: `${this.create.url}`,
                data: data,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (response) => {
                    this.sweetSuccess(response.message, response.data.message);
                    $(`#table`).DataTable().ajax.reload();
                    this.closeModal();
                },
                error: (response) => {
                    this.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })
        );
    }

    insertImage = (params = null) => {
        let data = params == null 
            ? $('#form').serialize() 
            : params
        return Promise.resolve(
            $.ajax({
                type: `${this.create.method}`,
                url: `${this.create.url}`,
                data: data,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (response) => {
                    this.sweetSuccess(response.message, response.data.message);
                    $(`#table`).DataTable().ajax.reload();
                    this.closeModal();
                },
                error: (response) => {
                    this.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })
        );
    }

    updateData = (params = null) => {
        let data = params == null 
            ? $('#form').serialize()
            : params
        return Promise.resolve(
            $.ajax({
                type:this.update.method,
                url:this.update.url,
                data:data,
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success:(response) => {
                    this.sweetSuccess(response.message,response.data.message);
                    $(`#table`).DataTable().ajax.reload();
                    this.closeModal();
                },
                error:  (response) => {
                    this.errorHandle(response);
                },
                complete : () => {
                    $('.se-pre-con').hide();
                }
            })
        )
    }

    updateDataImage = (params = null) => {
        let data = params == null 
            ? $('#form').serialize()
            : params
        return Promise.resolve(
            $.ajax({
                type:this.update.method,
                url:this.update.url,
                data:data,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success:(response) => {
                    this.sweetSuccess(response.message,response.data.message);
                    $(`#table`).DataTable().ajax.reload();
                    this.closeModal();
                },
                error:  (response) => {
                    this.errorHandle(response);
                },
                complete : () => {
                    $('.se-pre-con').hide();
                }
            })
        )
    }

    modalDelete = (id) => {
        Swal.fire({
            title: 'Are you sure to delete?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: () => {
                this.prosesDelete(id)
            }
        })

    }

    prosesDelete = (id) => {
        return Promise.resolve(
            $.ajax({
                type: this.delete.method,
                url: this.delete.url,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    [`${this.id_name}`]: id
                },
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success: (response) => {
                    this.sweetSuccess(response.message,response.data.message);
                    $(`#table`).DataTable().ajax.reload();
                    this.closeModal();
                },
                error:  (response) => {
                    this.errorHandle(response);
                },
                complete : () => {
                    $('.se-pre-con').hide();
                }
            })
        )
    }

    validasi = (type,credentials = null) => {
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').empty();
        let data = credentials == null 
            ? $('#form').serializeArray()
            : credentials;
        let result = this.loopingValidasi(data)
        if (result.length == 0) {
            if (type == 'edit') {
                this.updateData(credentials)
            } else {
                this.insert()
            }
            return Promise.resolve(true);
        } else {
            this.loopingErrorEmpty(result);
        }
    }

    loopingValidasi = (data) => {
        let dataArray = [];
        for (let index = 0; index < data.length; index++) {
            if (data[index]['value'] == '') {
                dataArray.push(data[index]['name'])
            }
        }
        return dataArray;
    }

    loopingError = (fail,key) => {
        for (let index = 0; index < key.length; index++) {
            if (fail.hasOwnProperty(`${key[index]}`)) {
                $(`#${key[index]}`).addClass('is-invalid');
                $(`#${key[index]}_alert`).text(fail[`${key[index]}`][0]);
                this.sweetError(fail[`${key[index]}`][0]);
            }
        }
    }

    loopingErrorEmpty = (result) => {
        let matchIndex = null;
        for (let index = 0; index < result.length; index++) {
            let form_id = result[index];
            if (form_id.match(/[[\]]/)) {
                matchIndex = matchIndex == null ? 0 : matchIndex + 1;
                form_id = form_id.slice(0, -2)+ '_' + matchIndex
            }
            $(`#${form_id}`).addClass('is-invalid');
            $(`#${form_id}_alert`).text('Form cannot be empty');
            this.sweetError('Form cannot be empty');
        }
    }

    createIdForm = (response) => {
        $('#form').append(`<div class="${this.id_name}" hidden>
                                        <input type="text" id="${this.id_name}" name="${this.id_name}">
                                    </div>`);
        $(`#${this.id_name}`).val(response.data[this.id_name]);
    }

    closeModal = () => {
        $('#modal').modal('hide');
        $(`.${this.id_name}`).remove();
        $(`.option option[selected]`).removeAttr("selected");;
        $('#form')[0].reset()
    }

    sweetError = (message) => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    }

    sweetSuccess = (status,message) => {
        Swal.fire(
            'Good job!',
            message,
            status
        );
    }

    errorHandle = (response) => {
        if(response.responseJSON.errors==null){
            this.sweetError(response.responseJSON.message)
        }else{
            let fail = response.responseJSON.errors;
            let key = Object.keys(fail)
            this.loopingError(fail,key)
        }
    }

    capitalize = (s) => {
        return s && s[0].toUpperCase() + s.slice(1);
    }

    capitalizeFirstWords = (words) => {
        let data = words.split('_');
        let new_word = ''
        for (let index = 0; index < data.length; index++) {
            new_word += data[index].charAt(0).toUpperCase() + data[index].slice(1) + ' ';
        }
        return new_word;
    }

    backTomin = (id) =>{ // merubah backslah to min
        return id.replace('/','-');
    }

    
}