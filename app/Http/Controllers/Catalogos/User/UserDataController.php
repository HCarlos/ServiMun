<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Classes\FiltersRules;
use App\Http\Requests\User\UserAlumnoBecasRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdatePasswordRequest;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserDataController extends Controller
{

    protected $tableName = "users";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function showListUser(Request $request)
    {
        ini_set('max_execution_time', 300);
        $this->tableName = 'usuarios';
        $filters = $request->all(['search', 'roles', 'palabras_roles']);
        $items = User::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate();
        $items->appends($filters)->fragment('table');
        $user = Auth::User();
        $roles = Role::all();

        return view('catalogos.catalogo.user.user_list',
            [
                'items' => $items,
                'roles' => $roles,
                'checkedRoles' => collect(request('roles')),
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'user' => $user,
                'searchInList' => 'listUsers',
                'newWindow' => true,
                'tableName' => $this->tableName,
                'showEdit' => 'editUser',
                'newItem' => 'newUser',
                'removeItem' => 'removeUser',
                'showEditBecas' => 'showEditBecas',
                'showProcess1' => 'showFileListUserExcel1A',
            ]
        );
    }

// ***************** EDITA LOS DATOS DEL USUARIO SOLO LECTURA ++++++++++++++++++++ //
    protected function showEditUserData()
    {
        $user = Auth::user();
        return view('catalogos.catalogo.user.user_profile_solo_lectura',
            [
                'user' => $user,
                'items' => $user,
                'titulo_catalogo' => "",
            ]
        );
    }

// ***************** MANDA A LLAMAR LA PANTALLA PARA NUEVO USUARIO ++++++++++++++++++++ //
    protected function newUser()
    {
        return view('catalogos.catalogo.user.user_profile_new',
            [
                'titulo_catalogo' => 'Nuevo',
                'postNew' => 'createUser',
            ]
        );
    }

// ***************** EDITA LOS DATOS DEL USUARIO PARA ESCRITURA ++++++++++++++++++++ //
    protected function showEditUser($Id)
    {
        $user = User::find($Id);
        return view('catalogos.catalogo.user.user_profile_edit',
            [
                'user' => $user,
                'items' => $user,
                'titulo_catalogo' => isset($user->Fullname) ? $user->Fullname : 'Nuevo',
                'putEdit' => 'EditUser',
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS EN EL USUARIO ++++++++++++++++++++ //
    protected function update(UserRequest $request)
    {
        $request->updateUser();
        return redirect()->route('edit');
    }

// ***************** GUARDA LOS CAMBIOS EN EL USUARIO ++++++++++++++++++++ //
    protected function updateUser(UserRequest $request)
    {
        $user = $request->manageUser();
        if (!isset($user)) {
            abort(404);
        }
        return view('catalogos.catalogo.user.user_profile_edit',
            [
                'user' => $user,
                'items' => $user,
                'titulo_catalogo' => $user->Fullname,
                'putEdit' => 'EditUser',
            ]
        );
    }

// ***************** CREAR NUEVO USUARIO ++++++++++++++++++++ //
    protected function createUser(UserRequest $request)
    {
        $user = $request->manageUser();
        if (!isset($user)) {
            abort(404);
        }
        return view('catalogos.catalogo.user.user_profile_edit',
            [
                'user' => $user,
                'items' => $user,
                'titulo_catalogo' => $user->Fullname,
                'putEdit' => 'EditUser',
            ]
        );
    }

// ***************** MUESTRA LA EDICIÓMN DE FOTO ++++++++++++++++++++ //
    protected function showEditProfilePhoto()
    {
        $user = Auth::user();
        $titulo_catalogo = "";
        return view('catalogos.catalogo.user.user_photo_update', [
                "user" => $user,
                "titulo_catalogo" => $titulo_catalogo,
            ]
        );
    }

// ***************** MUESTRA LA EDICIÓN DEL PASSWORD ++++++++++++++++++++ //
    protected function showEditProfilePassword()
    {
        $user = Auth::user();
        $titulo_catalogo = "";
        return view('catalogos.catalogo.user.user_password_edit', [
                "user" => $user,
                "titulo_catalogo" => $titulo_catalogo,
            ]
        );
    }

// ***************** CAMBIA EL PASSWORD ++++++++++++++++++++ //
    protected function changePasswordUser(UserUpdatePasswordRequest $request)
    {
        $request->updateUserPassword();
        $titulo_catalogo = "";
        return view('catalogos.catalogo.user.user_password_edit', [
            "user" => Auth::user(),
            "msg" => 'Password cambiado con éxito!',
            "titulo_catalogo" => $titulo_catalogo,
        ]);
    }

// ***************** ELIMINA AL USUARIO VIA AJAX ++++++++++++++++++++ //
    protected function removeUser($id = 0)
    {
        $user = User::withTrashed()->findOrFail($id);
        if (isset($user)) {
            if (!$user->trashed()) {
                $user->forceDelete();
            } else {
                $user->forceDelete();
            }
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
        }
    }

// ***************** MUESTRA LAS BECAS DEL USUARIO ALUMNO ++++++++++++++++++++ //
    protected function showEditBecas($Id)
    {
        $user = User::find($Id);
        return view('catalogos.catalogo.user.user_becas_edit',
            [
                'items' => $user,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS EN LAS BECAS DEL USUARIO ALUMNO ++++++++++++++++++++ //
    protected function putAluBecas(UserAlumnoBecasRequest $request)
    {
        $becas = $request->updateBecas();
        if (isset($becas)) {
            return Response::json(['mensaje' => 'Registro actualizado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'Error', 'data' => 'Error', 'status' => '422'], 200);
        }

    }

// ***************** MUESTRA EL LISTADO DE ALUMNOS ++++++++++++++++++++ //
//    protected function lstAlumnos(Request $request)
//    {
//        $filters = new FiltersRules();
//
//        $items = User::query()
//            ->filterBy($filters->filterRulesBecasAlumno($request, "ALUMNO"))
//            ->orderByDesc('id')
//            ->paginate();
//        $items->fragment('table');
//        $user = Auth::User();
//
//        return view('catalogos.catalogo.user.user_list',
//            [
//                'items' => $items,
//                'titulo_catalogo' => "Catálogo de Alumnos",
//                'user' => $user,
//                'tableName' => 'Alumnos',
//                'role_user' => 'ALUMNO',
//                'showEdit' => 'editUser',
//                'removeItem' => 'removeUser',
//                'showEditBecas' => 'showEditBecas',
//                'newWindow' => true,
//                'showProcess1' => 'getUserByRoleToXLSX',
//                'searchAluBeca' => 'lstAlumnos',
//            ]
//        );
//    }

// ***************** MUESTRA EL LISTADO DE PROFESOR ++++++++++++++++++++ //
//    protected function lstProfesores(Request $request)
//    {
//        $filters = new FiltersRules();
//
//        $items = User::query()
//            ->filterBy($filters->filterRulesBecasAlumno($request, "PROFESOR"))
//            ->orderByDesc('id')
//            ->paginate();
//        $items->fragment('table');
//        $user = Auth::User();
//
//        return view('catalogos.catalogo.user.user_list',
//            [
//                'items' => $items,
//                'titulo_catalogo' => "Catálogo de Profesores",
//                'user' => $user,
//                'tableName' => 'Profesores',
//                'role_user' => 'PROFESOR',
//                'showEdit' => 'editUser',
//                'removeItem' => 'removeUser',
//                'newWindow' => true,
//                'showProcess1' => 'getUserByRoleToXLSX',
//                'searchEmptyTool' => 'lstProfesores',
//            ]
//        );
//    }

// ***************** MUESTRA EL LISTADO DE TUTORES ++++++++++++++++++++ //
//    protected function lstTutores(Request $request)
//    {
//        $filters = new FiltersRules();
//
//        $items = User::query()
//            ->filterBy($filters->filterRulesBecasAlumno($request, "TUTOR"))
//            ->orderByDesc('id')
//            ->paginate();
//        $items->fragment('table');
//        $user = Auth::User();
//
//        return view('catalogos.catalogo.user.user_list',
//            [
//                'items' => $items,
//                'titulo_catalogo' => "Catálogo de Tutores",
//                'user' => $user,
//                'tableName' => 'Tutores',
//                'role_user' => 'TUTOR',
//                'showEdit' => 'editUser',
//                'removeItem' => 'removeUser',
//                'newWindow' => true,
//                'showProcess1' => 'getUserByRoleToXLSX',
//                'searchEmptyTool' => 'lstTutores',
//            ]
//        );
//    }




}
