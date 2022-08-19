<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\Appraisal\MenuParent;
use App\Model\Appraisal\MenuChild;
use App\Model\Appraisal\MenuGrandChild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class MenuController extends Controller
{
    public function index()
    {
        return view('appraisal.master.menu');
    }

    public function store(Request $request)
    {
        $rules = [
            'menu_type' => 'required'
        ];

        $message = [
            'menu_type.required' => 'Please Select A Menu Type'
        ];

        $this->validate($request, $rules, $message);

        if($request->menu_type == 1) {
            $rules['menu_parent_name'] = 'required';
            $rules['menu_parent_icon'] = 'required';
            $rules['menu_parent_url'] = 'required';

            $message['menu_parent_name.required'] = 'Please Fill Menu Parent Name';
            $message['menu_parent_icon.required'] = 'Please Fill Menu Parent Icon';
            $message['menu_parent_url.required'] = 'Please Fill Menu Parent URL';

            $this->validate($request, $rules, $message);

            DB::transaction(function() use ($request) {
                $parent = new MenuParent();
                $parent->menu_parent_name = $request->menu_parent_name;
                $parent->menu_parent_icon = $request->menu_parent_icon;
                $parent->menu_parent_url = $request->menu_parent_url;
                $parent->menu_parent_status = '1';
                $parent->created_by = Auth::user()->user_name;
                $parent->updated_by = Auth::user()->user_name;
                $parent->save();

                $request->merge([
                    'created_by' => Auth::user()->user_name,
                    'updated_by' => Auth::user()->user_name
                ]);

                \Helper::instance()->log('CREATE', $request, 'App\Model\Appraisal\MenuParent');
            });
        } else if($request->menu_type == 2) {
            $rules['menu_parent_id'] = 'required';
            $rules['menu_child_name'] = 'required';
            $rules['menu_child_icon'] = 'required';
            $rules['menu_child_url'] = 'required';

            $message['menu_parent_id.required'] = 'Please Select A Menu Parent';
            $message['menu_child_name.required'] = 'Please Fill Menu Child Name';
            $message['menu_child_icon.required'] = 'Please Fill Menu Child Icon';
            $message['menu_child_url.required'] = 'Please Fill Menu Child URL';

            $this->validate($request, $rules, $message);

            DB::transaction(function() use ($request) {
                $child = new MenuChild();
                $child->menu_child_name = $request->menu_child_name;
                $child->menu_child_icon = $request->menu_child_icon;
                $child->menu_child_url = $request->menu_child_url;
                $child->menu_parent_id = $request->menu_parent_id;
                $child->created_by = Auth::user()->user_name;
                $child->updated_by = Auth::user()->user_name;
                $child->save();

                 $request->merge([
                    'created_by' => Auth::user()->user_name,
                    'updated_by' => Auth::user()->user_name
                ]);

                \Helper::instance()->log('CREATE', $request, 'App\Model\Appraisal\MenuChild');
            });
        } else if($request->menu_type == 3) {
            $rules['menu_parent_id'] = 'required';
            $rules['menu_child_id'] = 'required';
            $rules['menu_grand_child_name'] = 'required';
            $rules['menu_grand_child_icon'] = 'required';
            $rules['menu_grand_child_url'] = 'required';

            $message['menu_parent_id.required'] = 'Please Select A Menu Parent';
            $message['menu_child_id.required'] = 'Please Select A Menu Child';
            $message['menu_grand_child_name.required'] = 'Please Fill Menu Grand Child Name';
            $message['menu_grand_child_icon.required'] = 'Please Fill Menu Grand Child Icon';
            $message['menu_grand_child_url.required'] = 'Please Fill Menu Grand Child URL';

            $this->validate($request, $rules, $message);

            DB::transaction(function() use ($request) {
                $grand_child = new MenuGrandChild();
                $grand_child->menu_grand_child_name = $request->menu_grand_child_name;
                $grand_child->menu_grand_child_icon = $request->menu_grand_child_icon;
                $grand_child->menu_grand_child_url = $request->menu_grand_child_url;
                $grand_child->menu_child_id = $request->menu_child_id;
                $grand_child->created_by = Auth::user()->user_name;
                $grand_child->updated_by = Auth::user()->user_name;
                $grand_child->save();

                 $request->merge([
                    'created_by' => Auth::user()->user_name,
                    'updated_by' => Auth::user()->user_name
                ]);

                \Helper::instance()->log('CREATE', $request, 'App\Model\Appraisal\MenuGrandChild');
            });
        }

        return response()->json();
    }

    public function update(Request $request)
    {
        if($request->type == 1) {
            $rules['menu_parent_name'] = 'required';
            $rules['menu_parent_icon'] = 'required';
            $rules['menu_parent_url'] = 'required';

            $message['menu_parent_name.required'] = 'Please Fill Menu Parent Name';
            $message['menu_parent_icon.required'] = 'Please Fill Menu Parent Icon';
            $message['menu_parent_url.required'] = 'Please Fill Menu Parent URL';

            $this->validate($request, $rules, $message);

            DB::transaction(function() use ($request) {
                $request->merge([
                    'menu_parent_id' => $request->id,
                    'updated_by' => Auth::user()->user_name
                ]);
                $request->request->remove('id');

                \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\MenuParent');

                $parent = MenuParent::find($request->menu_parent_id);
                $parent->menu_parent_name = $request->menu_parent_name;
                $parent->menu_parent_icon = $request->menu_parent_icon;
                $parent->menu_parent_url = $request->menu_parent_url;
                $parent->menu_parent_status = '1';
                $parent->updated_by = Auth::user()->user_name;
                $parent->save();
            });
        } else if($request->type == 2) {
            $rules['menu_parent_id'] = 'required';
            $rules['menu_child_name'] = 'required';
            $rules['menu_child_icon'] = 'required';
            $rules['menu_child_url'] = 'required';

            $message['menu_parent_id.required'] = 'Please Select A Menu Parent';
            $message['menu_child_name.required'] = 'Please Fill Menu Child Name';
            $message['menu_child_icon.required'] = 'Please Fill Menu Child Icon';
            $message['menu_child_url.required'] = 'Please Fill Menu Child URL';

            $this->validate($request, $rules, $message);

            DB::transaction(function() use ($request) {
                $request->merge([
                    'menu_child_id' => $request->id,
                    'updated_by' => Auth::user()->user_name
                ]);
                $request->request->remove('id');

                \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\MenuChild');

                $child = MenuChild::find($request->menu_child_id);
                $child->menu_child_name = $request->menu_child_name;
                $child->menu_child_icon = $request->menu_child_icon;
                $child->menu_child_url = $request->menu_child_url;
                $child->menu_parent_id = $request->menu_parent_id;
                $child->updated_by = Auth::user()->user_name;
                $child->save();
            });
        } else if($request->type == 3) {
            $rules['menu_parent_id'] = 'required';
            $rules['menu_child_id'] = 'required';
            $rules['menu_grand_child_name'] = 'required';
            $rules['menu_grand_child_icon'] = 'required';
            $rules['menu_grand_child_url'] = 'required';

            $message['menu_parent_id.required'] = 'Please Select A Menu Parent';
            $message['menu_child_id.required'] = 'Please Select A Menu Child';
            $message['menu_grand_child_name.required'] = 'Please Fill Menu Grand Child Name';
            $message['menu_grand_child_icon.required'] = 'Please Fill Menu Grand Child Icon';
            $message['menu_grand_child_url.required'] = 'Please Fill Menu Grand Child URL';

            $this->validate($request, $rules, $message);

            DB::transaction(function() use ($request) {
                $request->merge([
                    'menu_grand_child_id' => $request->id,
                    'updated_by' => Auth::user()->user_name
                ]);
                $request->request->remove('id');

                \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\MenuGrandChild');

                $grand_child = MenuGrandChild::find($request->menu_grand_child_id);
                $grand_child->menu_grand_child_name = $request->menu_grand_child_name;
                $grand_child->menu_grand_child_icon = $request->menu_grand_child_icon;
                $grand_child->menu_grand_child_url = $request->menu_grand_child_url;
                $grand_child->menu_child_id = $request->menu_child_id;
                $grand_child->updated_by = Auth::user()->user_name;
                $grand_child->save();
            });
        }

        return response()->json();
    }

    public function delete(Request $request)
    {
        if($request->type == 1) {
            DB::transaction(function() use ($request) {
                $request->merge([
                    'menu_parent_id' => $request->id
                ]);
                $request->request->remove('id');

                \Helper::instance()->log('DELETE', $request, 'App\Model\Appraisal\MenuParent');

                MenuParent::find($request->menu_parent_id)->delete();
            });
        } else if($request->type == 2) {
            DB::transaction(function() use ($request) {
                $request->merge([
                    'menu_child_id' => $request->id
                ]);
                $request->request->remove('id');

                \Helper::instance()->log('DELETE', $request, 'App\Model\Appraisal\MenuChild');

                MenuChild::find($request->menu_child_id)->delete();
            });
        } else if($request->type == 3) {
            DB::transaction(function() use ($request) {
                $request->merge([
                    'menu_grand_child_id' => $request->id
                ]);
                $request->request->remove('id');

                \Helper::instance()->log('DELETE', $request, 'App\Model\Appraisal\MenuGrandChild');

                MenuGrandChild::find($request->menu_grand_child_id)->delete();
            });
        }

        return response()->json();
    }

    public function getMenuParent(Request $request)
    {
    	$parent = MenuParent::query()
            ->selectRaw('menu_parent_id, menu_parent_name, menu_parent_icon, menu_parent_url, menu_parent_status')
        ->get();

        return datatables()->of($parent)->addIndexColumn()
            ->addColumn('detail', function($parent) {
                return '<a href="javascript:;" class="btn-detail-child" data-id="'.$parent->menu_parent_id.'" data-toggle="tooltip" title="Detail"><i class="fa fa-chevron-down"></i></a>';
            })
            ->addColumn('icon', function($parent) {
                return '<i class="'.$parent->menu_parent_icon.'"></i>';
            })
            ->addColumn('edit', function($parent) {
                return '<a href="javascript:;" class="btn-edit" data-type="1" data-id="'.$parent->menu_parent_id.'" data-name="'.$parent->menu_parent_name.'" data-icon="'.$parent->menu_parent_icon.'" data-url="'.$parent->menu_parent_url.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('delete', function($parent) {
                return '<a href="javascript:;" class="btn-delete" data-type="1" data-id="'.$parent->menu_parent_id.'" data-name="'.$parent->menu_parent_name.'" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['detail', 'icon', 'edit', 'delete'])
        ->toJson();
    }

    public function getMenuChild(Request $request)
    {
        $parent = NULL;
        if($request->has('parent_id')) {
            $parent = $request->get('parent_id');
        }

        $child = MenuChild::query()
            ->selectRaw('menu_child_id,
                menu_child_name,
                menu_child_icon,
                menu_child_url,
                menu_parent_id')
            ->where('menu_parent_id', $parent)
        ->get();

        return datatables()->of($child)->addIndexColumn()
            ->addColumn('detail', function($child) {
                return '<a href="javascript:;" class="btn-detail-grand-child" data-id="'.$child->menu_child_id.'" data-toggle="tooltip" title="Detail"><i class="fa fa-chevron-down"></i></a>';
            })
            ->addColumn('icon', function($child) {
                return '<i class="'.$child->menu_child_icon.'"></i>';
            })
            ->addColumn('edit', function($child) {
                return '<a href="javascript:;" class="btn-edit" data-type="2" data-id="'.$child->menu_child_id.'" data-name="'.$child->menu_child_name.'" data-icon="'.$child->menu_child_icon.'" data-url="'.$child->menu_child_url.'" data-parent="'.$child->menu_parent_id.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('delete', function($child) {
                return '<a href="javascript:;" class="btn-delete" data-type="2" data-id="'.$child->menu_child_id.'" data-name="'.$child->menu_child_name.'" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['detail', 'icon', 'edit', 'delete'])
        ->toJson();
    }

    public function getMenuGrandChild(Request $request)
    {
        $child = NULL;
        if($request->has('child_id')) {
            $child = $request->get('child_id');
        }

        $grand_child = MenuGrandChild::query()
            ->selectRaw('mst_appraisal_menu_grand_child.menu_grand_child_id,
                mst_appraisal_menu_grand_child.menu_grand_child_name,
                mst_appraisal_menu_grand_child.menu_grand_child_icon,
                mst_appraisal_menu_grand_child.menu_grand_child_url,
                mst_appraisal_menu_grand_child.menu_child_id,
                child.menu_parent_id')
            ->leftJoin('mst_appraisal_menu_child AS child', 'child.menu_child_id', 'mst_appraisal_menu_grand_child.menu_child_id')
            ->where('mst_appraisal_menu_grand_child.menu_child_id', $child)
        ->get();

        return datatables()->of($grand_child)->addIndexColumn()
            ->addColumn('icon', function($grand_child) {
                return '<i class="'.$grand_child->menu_grand_child_icon.'"></i>';
            })
            ->addColumn('edit', function($grand_child) {
                return '<a href="javascript:;" class="btn-edit" data-type="3" data-id="'.$grand_child->menu_grand_child_id.'" data-name="'.$grand_child->menu_grand_child_name.'" data-icon="'.$grand_child->menu_grand_child_icon.'" data-url="'.$grand_child->menu_grand_child_url.'" data-parent="'.$grand_child->menu_parent_id.'" data-child="'.$grand_child->menu_child_id.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('delete', function($grand_child) {
                return '<a href="javascript:;" class="btn-delete" data-type="3" data-id="'.$grand_child->menu_grand_child_id.'" data-name="'.$grand_child->menu_grand_child_name.'" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['icon', 'edit', 'delete'])
        ->toJson();
    }
    
}
