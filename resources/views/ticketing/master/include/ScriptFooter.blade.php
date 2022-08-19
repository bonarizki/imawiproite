<!-- Core -->
<script type="text/javascript" src="{{asset('assets_argon/vendor/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets_argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets_argon/vendor/js-cookie/js.cookie.js')}}"></script>
<script type="text/javascript" src="{{asset('assets_argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets_argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
<!-- Optional JS -->
<script type="text/javascript" src="{{asset('assets_argon/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets_argon/vendor/chart.js/dist/Chart.extension.js')}}"></script>

{{-- select2 --}}
<script type="text/javascript" src="{{asset('assets_argon/vendor/select2/dist/js/select2.min.js')}}"></script>

<!-- Argon JS -->
<script type="text/javascript" src="{{asset('assets_argon/js/argon.min.js?v=1.2.0')}}"></script>

{{-- sweetalert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{asset('js/time.js')}}"></script>

<script src="https://kit.fontawesome.com/ce65f02a1a.js" crossorigin="anonymous"></script>

<script>
    $(window).on('load', function () {
        setTimeout(function () {
            $('.se-pre-con').fadeOut()
        }, 2000)
    })

    $(document).ready(function () {
        getBreadcum();
    });

    getBreadcum = () => {
        let path = window.location.pathname
        path = path.substring(1)
        $.ajax({
            type: "get",
            url: "{{url('breadcumTicketing')}}",
            data: {
                path: path
            },
            success: function (response) {
                let data = response.data;
                let breadcumb = `<li class="breadcrumb-item"><a href="{{url('/ticketing')}}"><i class="fa fa-home"></i></a></li>`
                if (path != 'ticketing') {
                    if (data != null) {
                        if (data.menu_parent_name != null) breadcumb += `<li class="breadcrumb-item">${data.menu_parent_name}</li>`
                        if (data.menu_child_name != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${data.menu_child_url}')}}">${data.menu_child_name}</a></li>`
                        if (data.menu_grand_child_name != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${data.menu_grand_child_url}')}}">${data.menu_grand_child_name}</a></li>`
                    } else {
                        let pathsplit = path.split('/')
                        let parent = minToSpace(pathsplit[0])
                        let child = minToSpace(pathsplit[1])
                        let grand_child = minToSpace(pathsplit[2])
                        if (parent != null) breadcumb += `<li class="breadcrumb-item">${parent}</li>`
                        if (child != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${path}')}}">${child}</a></li>`
                        if (grand_child != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${path}')}}">${grand_child}</a></li>`
                    }
                    $('.breadcrumb').append(breadcumb);
                    $('#breadcumbs').attr('hidden', false);
                    
                } else {
                    $('#breadcumbs').attr('hidden', true);
                }
                
                $(`.parent-${data.menu_parent_id}`).addClass('active-navbar');
            },
            error:()=>{
                getBreadcum()
            }
        });
    }
</script>
@yield('footer')
