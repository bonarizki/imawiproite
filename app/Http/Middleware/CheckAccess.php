<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Repository\Dashboard\Module\Interfaces\ModuleInterfaces;
class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $user_id;
    private $ModuleInterfaces;

    public function __construct(ModuleInterfaces $ModuleInterfaces)
    {
        $this->user_id = Auth::user()->user_id;
        $this->ModuleInterfaces = $ModuleInterfaces;
    }

    public function handle($request, Closure $next)
    {
        $routeAccess = $this->getAccess($request);        //melakukan pengecekan apkah url saat ini 
        // ada didalam routeAccess(route yg bisa diakses oleh user)
        if(in_array($request->path(),$routeAccess))
        {
            return $next($request);
        }else{
            return response()->view('error/403');
        }
    }

    public function getAccess($request)
    {
        $routeAccess = [];
        $array = $this->ArrayModelAccess();
        $module = \App\Model\UserAccess::select('module')->where('user_id',$this->user_id)->first(); //mendapatkan data module access user
        
        //mengecek apakah user memiliki akses module atau tidak
        if( $module != null){
            $moduleId = explode('#',$module->module);
            $moduleName = $this->ModuleInterfaces->getModuleWhereIn($moduleId) // mendapatkan module berdasarkan akses module user dan pilih module active
                ->pluck('module_name','module_id')
                ->toArray();

            // $moduleName = array_push($moduleName,"Dashboard"); // merge array dashboard cause dashboard not in module_name
            
            $moduleNow = $this->ChooseModuleNow($request,$moduleName,$array); // mendapat module saat ini
            //proses perulangan array untuk mengambil tiap access dari modul
                if(in_array($moduleNow,$moduleName) || $moduleNow == "Dashboard"){ // check apakah module saat ini ada dalam module yang dapat  di akses user
                        // get access user pada module saat ini
                        $access = $array[$moduleNow]['access']::select('menu')->where('user_id',$this->user_id)->first();
                        if ($access != null) {
                            
                            $menu = explode('#',$access->menu);
                            
                            //get access route name
                            $accesRoute = $this->MakeArrayRoute($menu,$array[$moduleNow]);
                            
                            //set session module active
                            // session module active digunakan untuk mendapatkan module aktif saat ini
                            // dan digunakan oleh helper checkNIK()
                            if(in_array($request->path(),$accesRoute) && $array[$moduleNow]['module'] != "Dashboard") {
                                $keyIndex = array_search($moduleNow,$moduleName); // mendapatkan index array dari module
                                session()->put('module_active',$keyIndex);
                            }

                            $routeAccess = array_unique(array_merge($accesRoute,$routeAccess));
                        }
                }
            }
             
        return $routeAccess;
    }

    public function ArrayModelAccess()
    {
        //usahaka setiap array module itu datanya harus sesuai dengan nama module
        // yang ada di db
        return [
            "Dashboard" => [
                "module" => 'Dashboard',
                "access" => 'App\Model\UserAccess',
                "menu_parent" => 'App\Model\Menu\Menu',
                "menu_child" => 'App\Model\Menu\MenuChild',
                "menu_grand_child" => 'App\Model\Menu\MenuGrandChild'
            ],
            "Resignation" => [
                "module" => 'Resignation',
                "access" => 'App\Model\Resignation\Access',
                "menu_parent" => 'App\Model\Resignation\Menu\Menu',
                "menu_child" => 'App\Model\Resignation\Menu\MenuChild',
                "menu_grand_child" => 'App\Model\Resignation\Menu\MenuGrandChild'
            ],
            "COBC" => [
                "module" => 'COBC',
                "access" => 'App\Model\COBC\Access',
                "menu_parent" => 'App\Model\COBC\MenuParent',
                "menu_child" => 'App\Model\COBC\MenuChild',
                "menu_grand_child" => 'App\Model\COBC\MenuGrandChild'
            ],
            "Recruitment" => [
                "module" => 'Recruitment',
                "access" => 'App\Model\Recruitment\Access',
                "menu_parent" => 'App\Model\Recruitment\MenuParent',
                "menu_child" => 'App\Model\Recruitment\MenuChild',
                "menu_grand_child" => 'App\Model\Recruitment\MenuGrandChild'
            ],
            "Training" => [
                "module" => 'Training',
                "access" => 'App\Model\Training\Access',
                "menu_parent" => 'App\Model\Training\Menu\Menu',
                "menu_child" => 'App\Model\Training\Menu\MenuChild',
                "menu_grand_child" => 'App\Model\Training\Menu\MenuGrandChild'
            ],
            "Appraisal" => [
                "module" => 'Appraisal',
                "access" => 'App\Model\Appraisal\Access',
                "menu_parent" => 'App\Model\Appraisal\MenuParent',
                "menu_child" => 'App\Model\Appraisal\MenuChild',
                "menu_grand_child" => 'App\Model\Appraisal\MenuGrandChild'
            ],
            "Ticketing" => [
                "module" => 'Ticketing',
                "access" => 'App\Model\Ticketing\Access',
                "menu_parent" => 'App\Model\Ticketing\Menu\Menu',
                "menu_child" => 'App\Model\Ticketing\Menu\MenuChild',
                "menu_grand_child" => 'App\Model\Ticketing\Menu\MenuGrandChild'
            ],
            "Koperasi" => [
                "module" => 'Koperasi',
                "access" => 'App\Model\Koperasi\Access',
                "menu_parent" => 'App\Model\Koperasi\Menu\Menu',
                "menu_child" => 'App\Model\Koperasi\Menu\MenuChild',
                "menu_grand_child" => 'App\Model\Koperasi\Menu\MenuGrandChild'
            ],
            "Awards" => [
                "module" => 'Awards',
                "access" => 'App\Model\Awards\Access',
                "menu_parent" => 'App\Model\Awards\Menu\Menu',
                "menu_child" => 'App\Model\Awards\Menu\MenuChild',
                "menu_grand_child" => 'App\Model\Awards\Menu\MenuGrandChild'
            ],
        ];
    }

    public function MakeArrayRoute($menu,$item)
    {
        $route = [];
        //proses pembentukan route parent
        $parent = explode(',',$menu[0]);
        $parentRoute = $item['menu_parent']::select('menu_parent_url')
            ->whereIn('menu_parent_id',$parent)
            ->get()
            ->pluck('menu_parent_url');
        $route = array_merge($parentRoute->all(),$route);

        //proses pembuntukan route child
        $child = explode(',',$menu[1]);
        $childRoute = $item['menu_child']::select('menu_child_url')
            ->whereIn('menu_child_id',$child)
            ->get()
            ->pluck('menu_child_url');
        $route = array_merge($childRoute->all(),$route);
        
        //proses pembentukan route grand child
        $grandChild = explode(',',$menu[2]);
        $grandChildRoute = $item['menu_grand_child']::select('menu_grand_child_url')
            ->whereIn('menu_grand_child_id',$grandChild)
            ->get()
            ->pluck('menu_grand_child_url');
        $route = array_merge($grandChildRoute->all(),$route);

        return $route;
    }

    public function ChooseModuleNow($request,$moduleName)
    {
        $url = $request->path(); // mendapatkan url saat ini 
        $moduleNow = explode('/',$url); // melakukan explode agar menjadi array dan di explode menggunakan "/"
        $moduleNow = $moduleNow[0] == 'cobc' ? strtoupper($moduleNow[0]) : ucfirst($moduleNow[0]); // ambil index kesatu karena itu sudah pasti nama module dan gunakan ucfirst untuk membesarkan huruf pertama
        if (!in_array($moduleNow,$moduleName)) { // jika add moduleNow yang tidak ada dalam module user maka set dashboard
            $moduleNow = "Dashboard";
        }

        return $moduleNow;
    }

}
