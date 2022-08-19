<!-- Footer -->
    @php
        $version =  App\Model\Plugin\PluginVersion::select('version_name','version_code')->where('version_status', '1')->first()
    @endphp
    <footer class="footer pt-3">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6">
                <div class="copyright text-center  text-lg-left  text-muted">
                    {{ $version->version_name }}
                    <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">
                        Wipro Unza
                    </a>All Rights Reserved
                </div>
            </div>
            <div class="col-lg-6">
                <span class="float-md-right d-none d-md-block">
                    <b>Version</b> {{ $version->version_code }}
                </span>
            </div>
        </div>
    </footer>