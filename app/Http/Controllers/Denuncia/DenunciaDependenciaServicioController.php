<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Requests\Denuncia\DenunciaDependenciaServicioRequest;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia;
use App\Http\Controllers\Controller;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DenunciaDependenciaServicioController extends Controller
{




    protected $tableName = "denuncia_dependencia_servicio";
    protected $Id = 0;

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index($Id)
    {
        ini_set('max_execution_time', 300);

        $items = Denuncia_Dependencia_Servicio::query()->where('denuncia_id',$Id)->orderBy('id')->paginate();
        $items->appends('id')->fragment('table');

        $user = Auth::User();
        $this->Id = $Id;

        return view('denuncia.denuncia_dependencia_servicio.denuncia_dependencia_servicio_list',
            [
                'items' => $items,
                'Id' => $this->Id,
                'titulo_catalogo' => ucwords($this->tableName),
                'titulo_header'   => '',
                'user' => $user,
                'newWindow' => true,
                'newItem' => 'addDenunciaDependenciaServicio',
                'tableName' => $this->tableName,
                'showEdit' => 'editDenunciaDependenciaServicio',
                'showProcess1' => 'showDataListDenunciaExcel1A',
                'postNew'         => 'postAddDenunciaDependenciaServicio',
//                'putEdit' => 'updateDenuncia',
                'addItem' => 'addDenunciaDependenciaServicio',
                'removeItem' => 'removeDenunciaDependenciaServicio',
                'imprimirDenuncia'=> "imprimirDenuncia/",
            ]
        );
    }

// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItem($Id)
    {
//        dd($Id);
        $items        = Denuncia_Dependencia_Servicio::find($Id);
//        dd($items->dependencia_id);
        $Dependencias = Dependencia::all()->sortBy('dependencia');
        $Estatus      = Estatu::all()->sortBy('estatus');
        $Servicios    = $this->getQueryServiciosFromDependencias($items->dependencia_id);
        dd($Servicios);
        return view('denuncia.denuncia_dependencia_servicio.denuncia_dependencia_servicio_edit',
            [
                'user'            => Auth::user(),
                'items' => $items,
                'Id' => $Id,
                'dependencias'    => $Dependencias,
                'servicios'       => $Servicios,
                'estatus'         => $Estatus,
                'editItemTitle'   => "Agregando servicio a la denuncia ".$Id,
                'postNew'         => 'putAddDenunciaDependenciaServicio',
                'titulo_catalogo' => "Cat??logo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //
    protected function putEdit(DenunciaDependenciaServicioRequest $request){
        $Id = $request->manage();
        if  (!isset($Id)) {
            return '<script type="text/javascript">alert("'.$Id.'");</script>';
        }
        return Redirect::to('editDenunciaDependenciaServicio/'.$Id);
    }


    protected function addItem($Id){
        $items         = Denuncia::find($Id);
        $Dependencias = Dependencia::all()->sortBy('dependencia');
        $Estatus      = Estatu::all()->sortBy('estatus');
        return view('denuncia.denuncia_dependencia_servicio.denuncia_dependencia_servicio_new',
            [
                'user'              => Auth::user(),
                'items' => $items,
                'Id' => $Id,
                'editItemTitle'     => 'Nuevo',
                'dependencias'      => $Dependencias,
                'estatus'           => $Estatus,
                'postNew'           => 'postAddDenunciaDependenciaServicio',
                'titulo_catalogo'   => "Mi " . ucwords($this->tableName),
                'titulo_header'     => 'Agregar dependencia',
                'exportModel' => 23,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function postNew(DenunciaDependenciaServicioRequest $request)
    {
        $Id = $request->manage();
        //dd($item);
        if (!isset($Id)) {
            return '<script type="text/javascript">alert("'.$Id.'");</script>';
        }
        return Redirect::to('editDenunciaDependenciaServicio/'.$Id);
    }

    // ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
        protected function removeItem($id = 0)
        {
            $item = Denuncia_Dependencia_Servicio::withTrashed()->findOrFail($id);
            if (isset($item)) {
                if (!$item->trashed()) {
                    $item->forceDelete();
                } else {
                    $item->forceDelete();
                }
                return Response::json(['mensaje' => 'Registro eliminado con ??xito', 'data' => 'OK', 'status' => '200'], 200);
            } else {
                return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
            }
        }

    private function getQueryServiciosFromDependencias($id=0){
        return Servicio::whereHas('subareas', function($p) use ($id) {
            $p->whereHas("areas", function($q) use ($id){
                $q->whereHas("dependencias", function ($r) use ($id){
                    return $r->where("dependencia_id",$id);
                });
            });
        })->get();
    }




}
