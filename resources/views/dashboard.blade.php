@extends('master/master')
@section('title','Dahsboard')
<style>
    .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='red' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
    }

    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='red' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
    }

    .inner {
        overflow: hidden;
    }

    .inner img {
        transition: all 1.5s ease;
    }

    .inner:hover img {
        transform: scale(1.5)
    }

    .carousel .carousel-indicators li {
        background-color: grey;
        background-color: black;
    }
    
</style>
@section('content')
    <div class="dashboard-body">
    </div>
@endsection

@section('script')
    <script>    
        $(document).ready(function () {
            $.ajax({
                url:"{{url('/get/moduleAccess')}}",
                type:"GET",
                success:function(response){
                    let array = response;
                    let data = '<div class="row">';
                    
                    let x = 1;
                    for (let index = 0; index < array.length; index++) {
                        let str = anotherFor(JSON.parse(array[index].module_image),array[index].module_url,array[index].module_name)
                        data += `<div class="col-12 col-sm-3 mb-3">
                                <div class="card shadow" style="width: 15rem; width:auto; height:auto">
                                        <div id="${array[index].module_name}" class="carousel slide carousel-fade"
                                            data-ride="carousel">
                                            ${str}
                                            <a class="carousel-control-prev" href="#${array[index].module_name}" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#${array[index].module_name}" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                        <div class="card-footer">
                                            <h5 class="text-center">${array[index].module_name}</h5>
                                        </div>
                                    </div>
                                </div>`
                        if (x == 4) {
                            data += `</div>
                                    <div class="row">`;
                            x=0;
                        }
                        x++;
                    }
                    data +=`</div>`
                    $('.dashboard-body').append(data);
                }
            })
        });

        function anotherFor(url_image,url,name){
            let str = '<ol class="carousel-indicators">'
            let carousel = '<div class="carousel-inner" role="listbox">';
            for (let index = 0; index <url_image.length; index++) {
                let active = index == 0 ? 'active' : '';
                str += `<li data-target="#${name}" data-slide-to="${index}" class="${active}"></li>`
                carousel +=`<div class="carousel-item ${active}" >
                                <a href="{{url('${url}')}}" style="text-decoration:none">
                                    <div class="">
                                        <img class="d-block" src="{{asset('file_uploads/images/module/${url_image[index]}')}}" alt="${name}" width="100%" height="250">
                                    </div>
                                </a>
                            </div>`
            }
            carousel += '</div>' ;
            str += '</ol>';
            return str += carousel;
        }
    </script>
@endsection