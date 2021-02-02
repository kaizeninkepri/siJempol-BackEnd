<?php

namespace App\Http\Controllers;

use App\Models\roles;
use App\Models\rolesModul;
use App\Models\rolesPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class menuControl extends Controller
{
    public static function menu(Request $r){

    $roleId = $r->get('id');
    $modul =  rolesModul::with(['permission' => function ($m) use ($roleId) {
            $m->where("role_id", $roleId);
        }])->withCount(['permission'])->where("type", "parent")->orderBy("nama", "ASC")->get();

         $collectionParent = collect($modul);
         foreach ($modul as $index => $m) {



            $modulChild = rolesModul::with(['permission' => function ($q)  use ($roleId) {
                $q->where("role_id", $roleId);
            }])->withCount('permission')->where("parent_id", $m->role_modul_id)->orderBy("nama", "ASC")->get();

            $collectionChild = collect($modulChild);
            $collectionChild->each(function ($item, $key) {
                if ($item->permission == null) {
                    $item->crud = array(
                        "create" => false,
                        "read" => false,
                        "update" => false,
                        "delete" => false,
                    );
                } else {

                    $item->crud = array(
                        "create" => json_decode($item->permission->create),
                        "read" => json_decode($item->permission->read),
                        "update" => json_decode($item->permission->update),
                        "delete" => json_decode($item->permission->delete),
                    );
                }
            });


            $data[] = array("parent" => $m, "child" => $modulChild);
        }
        return $data;
    
    }

    
}
