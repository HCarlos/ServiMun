<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
Auth::routes(['verify' => true]);

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');
//$this->post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
/*
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
*/

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');


    // USUARIOS
    Route::get('edit', 'Catalogos\User\UserDataController@showEditUserData')->name('edit');
    Route::put('Edit', 'Catalogos\User\UserDataController@update')->name('Edit');
    Route::get('showEditProfilePhoto/', 'Catalogos\User\UserDataController@showEditProfilePhoto')->name('showEditProfilePhoto/');
    Route::get('editUser/{Id}', 'Catalogos\User\UserDataController@showEditUser')->name('editUser');
    Route::put('EditUser', 'Catalogos\User\UserDataController@updateUser')->name('EditUser');
    Route::get('newUser', 'Catalogos\User\UserDataController@newUser')->name('newUser');
    Route::post('createUser', 'Catalogos\User\UserDataController@createUser')->name('createUser');
    Route::get('removeUser/{id}', 'Catalogos\User\UserDataController@removeUser')->name('removeUser');
    Route::get('showEditProfilePassword/', 'Catalogos\User\UserDataController@showEditProfilePassword')->name('showEditProfilePassword/');
    Route::put('changePasswordUser/', 'Catalogos\User\UserDataController@changePasswordUser')->name('changePasswordUser/');
    Route::post('subirFotoProfile/', 'Storage\StorageProfileController@subirArchivoProfile')->name('subirArchivoProfile/');
    Route::get('quitarFotoProfile/', 'Storage\StorageProfileController@quitarArchivoProfile')->name('quitarArchivoProfile/');
    Route::get('list-users/', 'Catalogos\User\UserDataController@showListUser')->name('listUsers');

    // Catálogo de Categorías
    Route::get('listCategorias/', 'Catalogos\User\CategoriaController@index')->name('listCategorias');
    Route::get('editCategoria/{Id}', 'Catalogos\User\CategoriaController@editCategoria')->name('editCategoria');
    Route::put('updateCategoria', 'Catalogos\User\CategoriaController@updateCategoria')->name('updateCategoria');
    Route::get('newCategoria', 'Catalogos\User\CategoriaController@newCategoria')->name('newCategoria');
    Route::post('createCategoria', 'Catalogos\User\CategoriaController@createCategoria')->name('createCategoria');
    Route::get('removeCategoria/{id}', 'Catalogos\User\CategoriaController@removeCategoria')->name('removeCategoria');

    // Catálogo de Dependencias
    Route::get('listDependencias/', 'Catalogos\Dependencia\DependenciaController@index')->name('listDependencias');
    Route::get('editDependencia/{Id}', 'Catalogos\Dependencia\DependenciaController@editDependencia')->name('editDependencia');
    Route::put('updateDependencia', 'Catalogos\Dependencia\DependenciaController@updateDependencia')->name('updateDependencia');
    Route::get('newDependencia', 'Catalogos\Dependencia\DependenciaController@newDependencia')->name('newDependencia');
    Route::post('createDependencia', 'Catalogos\Dependencia\DependenciaController@createDependencia')->name('createDependencia');
    Route::get('removeDependencia/{id}', 'Catalogos\Dependencia\DependenciaController@removeDependencia')->name('removeDependencia');

    // Catálogo de Areas
    Route::get('listAreas/', 'Catalogos\Dependencia\AreaController@index')->name('listAreas');
    Route::get('editArea/{Id}', 'Catalogos\Dependencia\AreaController@editArea')->name('editArea');
    Route::put('updateArea', 'Catalogos\Dependencia\AreaController@updateArea')->name('updateArea');
    Route::get('newArea', 'Catalogos\Dependencia\AreaController@newArea')->name('newArea');
    Route::post('createArea', 'Catalogos\Dependencia\AreaController@createArea')->name('createArea');
    Route::get('removeArea/{id}', 'Catalogos\Dependencia\AreaController@removeArea')->name('removeArea');

    // Catálogo de Subareas
    Route::get('listSubareas/', 'Catalogos\Dependencia\SubareaController@index')->name('listSubareas');
    Route::get('editSubarea/{Id}', 'Catalogos\Dependencia\SubareaController@editSubarea')->name('editSubarea');
    Route::put('updateSubarea', 'Catalogos\Dependencia\SubareaController@updateSubarea')->name('updateSubarea');
    Route::get('newSubarea', 'Catalogos\Dependencia\SubareaController@newSubarea')->name('newSubarea');
    Route::post('createSubarea', 'Catalogos\Dependencia\SubareaController@createSubarea')->name('createSubarea');
    Route::get('removeSubarea/{id}', 'Catalogos\Dependencia\SubareaController@removeSubarea')->name('removeSubarea');

    // Catálogo de Estatus
    Route::get('listEstatus/', 'Catalogos\EstatuController@index')->name('listEstatus');
    Route::get('editEstatu/{Id}', 'Catalogos\EstatuController@editItem')->name('editEstatu');
    Route::put('updateEstatu', 'Catalogos\EstatuController@updateItem')->name('updateEstatu');
    Route::get('newEstatu', 'Catalogos\EstatuController@newItem')->name('newEstatu');
    Route::post('createEstatu', 'Catalogos\EstatuController@createItem')->name('createEstatu');
    Route::get('removeEstatu/{id}', 'Catalogos\EstatuController@removeItem')->name('removeEstatu');
    Route::get('addDepEstatu/{Id}/{IdDep}', 'Catalogos\EstatuController@addDepEstatu')->name('addDepEstatu');
    Route::get('removeDepEstatu/{Id}/{IdDep}', 'Catalogos\EstatuController@removeDepEstatu')->name('removeDepEstatu');

    // Catálogo de Medidas
    Route::get('listMedidas/', 'Catalogos\MedidaController@index')->name('listMedidas');
    Route::get('editMedida/{Id}', 'Catalogos\MedidaController@editItem')->name('editMedida');
    Route::put('updateMedida', 'Catalogos\MedidaController@updateItem')->name('updateMedida');
    Route::get('newMedida', 'Catalogos\MedidaController@newItem')->name('newMedida');
    Route::post('createMedida', 'Catalogos\MedidaController@createItem')->name('createMedida');
    Route::get('removeMedida/{id}', 'Catalogos\MedidaController@removeItem')->name('removeMedida');

    // Catálogo de Origenes
    Route::get('listOrigenes/', 'Catalogos\OrigenController@index')->name('listOrigenes');
    Route::get('editOrigen/{Id}', 'Catalogos\OrigenController@editItem')->name('editOrigen');
    Route::put('updateOrigen', 'Catalogos\OrigenController@updateItem')->name('updateOrigen');
    Route::get('newOrigen', 'Catalogos\OrigenController@newItem')->name('newOrigen');
    Route::post('createOrigen', 'Catalogos\OrigenController@createItem')->name('createOrigen');
    Route::get('removeOrigen/{id}', 'Catalogos\OrigenController@removeItem')->name('removeOrigen');

    // Catálogo de Prioridades
    Route::get('listPrioridades/', 'Catalogos\PrioridadController@index')->name('listPrioridades');
    Route::get('editPrioridad/{Id}', 'Catalogos\PrioridadController@editItem')->name('editPrioridad');
    Route::put('updatePrioridad', 'Catalogos\PrioridadController@updateItem')->name('updatePrioridad');
    Route::get('newPrioridad', 'Catalogos\PrioridadController@newItem')->name('newPrioridad');
    Route::post('createPrioridad', 'Catalogos\PrioridadController@createItem')->name('createPrioridad');
    Route::get('removePrioridad/{id}', 'Catalogos\PrioridadController@removeItem')->name('removePrioridad');

    // Catálogo de Servicios
    Route::get('listServicios/', 'Catalogos\ServicioController@index')->name('listServicios');
    Route::get('editServicio/{Id}', 'Catalogos\ServicioController@editItem')->name('editServicio');
    Route::put('updateServicio', 'Catalogos\ServicioController@updateItem')->name('updateServicio');
    Route::get('newServicio', 'Catalogos\ServicioController@newItem')->name('newServicio');
    Route::post('createServicio', 'Catalogos\ServicioController@createItem')->name('createServicio');
    Route::get('removeServicio/{id}', 'Catalogos\ServicioController@removeItem')->name('removeServicio');

    // Catálogo de Afiliaciones
    Route::get('listAfiliaciones/', 'Catalogos\AfiliacionController@index')->name('listAfiliaciones');
    Route::get('editAfiliacion/{Id}', 'Catalogos\AfiliacionController@editItem')->name('editAfiliacion');
    Route::put('updateAfiliacion', 'Catalogos\AfiliacionController@updateItem')->name('updateAfiliacion');
    Route::get('newAfiliacion', 'Catalogos\AfiliacionController@newItem')->name('newAfiliacion');
    Route::post('createAfiliacion', 'Catalogos\AfiliacionController@createItem')->name('createAfiliacion');
    Route::get('removeAfiliacion/{id}', 'Catalogos\AfiliacionController@removeItem')->name('removeAfiliacion');

    // Catálogo de Asentamientos
    Route::get('listAsentamientos/', 'Catalogos\Domicilio\AsentamientoController@index')->name('listAsentamientos');
    Route::get('editAsentamiento/{Id}', 'Catalogos\Domicilio\AsentamientoController@editItem')->name('editAsentamiento');
    Route::put('updateAsentamiento', 'Catalogos\Domicilio\AsentamientoController@updateItem')->name('updateAsentamiento');
    Route::get('newAsentamiento', 'Catalogos\Domicilio\AsentamientoController@newItem')->name('newAsentamiento');
    Route::post('createAsentamiento', 'Catalogos\Domicilio\AsentamientoController@createItem')->name('createAsentamiento');
    Route::get('removeAsentamiento/{id}', 'Catalogos\Domicilio\AsentamientoController@removeItem')->name('removeAsentamiento');

    // Catálogo de Calles
    Route::get('listCalles/', 'Catalogos\Domicilio\CalleController@index')->name('listCalles');
    Route::get('editCalle/{Id}', 'Catalogos\Domicilio\CalleController@editItem')->name('editCalle');
    Route::put('updateCalle', 'Catalogos\Domicilio\CalleController@updateItem')->name('updateCalle');
    Route::get('newCalle', 'Catalogos\Domicilio\CalleController@newItem')->name('newCalle');
    Route::post('createCalle', 'Catalogos\Domicilio\CalleController@createItem')->name('createCalle');
    Route::get('removeCalle/{id}', 'Catalogos\Domicilio\CalleController@removeItem')->name('removeCalle');

    // Catálogo de Ciudades
    Route::get('listCiudades/', 'Catalogos\Domicilio\CiudadController@index')->name('listCiudades');
    Route::get('editCiudad/{Id}', 'Catalogos\Domicilio\CiudadController@editItem')->name('editCiudad');
    Route::put('updateCiudad', 'Catalogos\Domicilio\CiudadController@updateItem')->name('updateCiudad');
    Route::get('newCiudad', 'Catalogos\Domicilio\CiudadController@newItem')->name('newCiudad');
    Route::post('createCiudad', 'Catalogos\Domicilio\CiudadController@createItem')->name('createCiudad');
    Route::get('removeCiudad/{id}', 'Catalogos\Domicilio\CiudadController@removeItem')->name('removeCiudad');

    // Catálogo de Localidades
    Route::get('listLocalidades/', 'Catalogos\Domicilio\LocalidadController@index')->name('listLocalidades');
    Route::get('editLocalidad/{Id}', 'Catalogos\Domicilio\LocalidadController@editItem')->name('editLocalidad');
    Route::put('updateLocalidad', 'Catalogos\Domicilio\LocalidadController@updateItem')->name('updateLocalidad');
    Route::get('newLocalidad', 'Catalogos\Domicilio\LocalidadController@newItem')->name('newLocalidad');
    Route::post('createLocalidad', 'Catalogos\Domicilio\LocalidadController@createItem')->name('createLocalidad');
    Route::get('removeLocalidad/{id}', 'Catalogos\Domicilio\LocalidadController@removeItem')->name('removeLocalidad');

    // Catálogo de Municipios
    Route::get('listMunicipios/', 'Catalogos\Domicilio\MunicipioController@index')->name('listMunicipios');
    Route::get('editMunicipio/{Id}', 'Catalogos\Domicilio\MunicipioController@editItem')->name('editMunicipio');
    Route::put('updateMunicipio', 'Catalogos\Domicilio\MunicipioController@updateItem')->name('updateMunicipio');
    Route::get('newMunicipio', 'Catalogos\Domicilio\MunicipioController@newItem')->name('newMunicipio');
    Route::post('createMunicipio', 'Catalogos\Domicilio\MunicipioController@createItem')->name('createMunicipio');
    Route::get('removeMunicipio/{id}', 'Catalogos\Domicilio\MunicipioController@removeItem')->name('removeMunicipio');

    // Catálogo de Estados
    Route::get('listEstados/', 'Catalogos\Domicilio\EstadoController@index')->name('listEstados');
    Route::get('editEstado/{Id}', 'Catalogos\Domicilio\EstadoController@editItem')->name('editEstado');
    Route::put('updateEstado', 'Catalogos\Domicilio\EstadoController@updateItem')->name('updateEstado');
    Route::get('newEstado', 'Catalogos\Domicilio\EstadoController@newItem')->name('newEstado');
    Route::post('createEstado', 'Catalogos\Domicilio\EstadoController@createItem')->name('createEstado');
    Route::get('removeEstado/{id}', 'Catalogos\Domicilio\EstadoController@removeItem')->name('removeEstado');

    // Catálogo de Codigopostales
    Route::get('listCodigopostales/', 'Catalogos\Domicilio\CodigopostalController@index')->name('listCodigopostales');
    Route::get('editCodigopostal/{Id}', 'Catalogos\Domicilio\CodigopostalController@editItem')->name('editCodigopostal');
    Route::put('updateCodigopostal', 'Catalogos\Domicilio\CodigopostalController@updateItem')->name('updateCodigopostal');
    Route::get('newCodigopostal', 'Catalogos\Domicilio\CodigopostalController@newItem')->name('newCodigopostal');
    Route::post('createCodigopostal', 'Catalogos\Domicilio\CodigopostalController@createItem')->name('createCodigopostal');
    Route::get('removeCodigopostal/{id}', 'Catalogos\Domicilio\CodigopostalController@removeItem')->name('removeCodigopostal');

    // Catálogo de Tipoasentamientos
    Route::get('listTipoasentamientos/', 'Catalogos\Domicilio\TipoasentamientoController@index')->name('listTipoasentamientos');
    Route::get('editTipoasentamiento/{Id}', 'Catalogos\Domicilio\TipoasentamientoController@editItem')->name('editTipoasentamiento');
    Route::put('updateTipoasentamiento', 'Catalogos\Domicilio\TipoasentamientoController@updateItem')->name('updateTipoasentamiento');
    Route::get('newTipoasentamiento', 'Catalogos\Domicilio\TipoasentamientoController@newItem')->name('newTipoasentamiento');
    Route::post('createTipoasentamiento', 'Catalogos\Domicilio\TipoasentamientoController@createItem')->name('createTipoasentamiento');
    Route::get('removeTipoasentamiento/{id}', 'Catalogos\Domicilio\TipoasentamientoController@removeItem')->name('removeTipoasentamiento');

    // Catálogo de Tipocomunidades
    Route::get('listTipocomunidades/', 'Catalogos\Domicilio\TipocomunidadController@index')->name('listTipocomunidades');
    Route::get('editTipocomunidad/{Id}', 'Catalogos\Domicilio\TipocomunidadController@editItem')->name('editTipocomunidad');
    Route::put('updateTipocomunidad', 'Catalogos\Domicilio\TipocomunidadController@updateItem')->name('updateTipocomunidad');
    Route::get('newTipocomunidad', 'Catalogos\Domicilio\TipocomunidadController@newItem')->name('newTipocomunidad');
    Route::post('createTipocomunidad', 'Catalogos\Domicilio\TipocomunidadController@createItem')->name('createTipocomunidad');
    Route::get('removeTipocomunidad/{id}', 'Catalogos\Domicilio\TipocomunidadController@removeItem')->name('removeTipocomunidad');










    // ROLES
    Route::get('asignaRole/{Id}','Catalogos\User\RoleController@index')->name('asignaRole');
    Route::get('assignRoleToUser/{Id}/{nameRoles}','Catalogos\User\RoleController@asignar')->name('assignRoleToUser');
    Route::get('unAssignRoleToUser/{Id}/{nameRoles}','Catalogos\User\RoleController@desasignar')->name('unAssignRoleToUser');
    // PERMISSIONS
    Route::get('asignaPermission/{Id}','Catalogos\User\PermissionController@index')->name('asignaPermission');
    Route::get('assignPermissionToUser/{Id}/{namePermissions}','Catalogos\User\PermissionController@asignar')->name('assignPermissionToUser');
    Route::get('unAssignPermissionToUser/{Id}/{namePermissions}','Catalogos\User\PermissionController@desasignar')->name('unAssignPermissionToUser');

    // EXTERNAL FILES
    Route::get('archivosConfig','Storage\StorageExternalFilesController@archivos_config')->name('archivosConfig');
    Route::post('subirArchivoBase/', 'Storage\StorageExternalFilesController@subirArchivoBase')->name('subirArchivoBase/');
    Route::get('quitarArchivoBase/{driver}/{archivo}', 'Storage\StorageExternalFilesController@quitarArchivoBase')->name('quitarArchivoBase/');
//
    Route::post('showFileListUserExcel1A','External\User\ListUserXLSXController@getListUserXLSX')->name('showFileListUserExcel1A');
//    Route::post('showFileListNivelExcel','External\Nivel\ListNivelXLSXController@getListNivelXLSX')->name('showFileListNivelExcel');
//    Route::post('showFileListParentescoExcel','External\Parentesco\ListParentescoXLSXController@getListParentescoXLSX')->name('showFileListParentescoExcel');
//    Route::post('showFileListFamiliaExcel','External\Familia\ListFamiliaXLSXController@getListFamiliaXLSX')->name('showFileListFamiliaExcel');
//    Route::post('showFileListRegFisExcel','External\Registros_Fiscales\ListaRegFisXLSXController@getListRegFisXLSX')->name('showFileListRegFisExcel');
    Route::post('getUserByRoleToXLSX','External\User\ListUserXLSXController@getUserByRoleToXLSX')->name('getUserByRoleToXLSX');

    // END FILES EXTERNAL



});

Route::get('enviar', ['as' => 'enviar', function () {
    $data = ['link' => 'http://atemun.mx'];
    Mail::send('emails.notificacion', $data, function ($message) {
        $message->from('manager@logydes.com.mx', 'Logydes.com.mx');
        $message->to('logydes@gmail.com')->subject('Notificación');
    });
    return "Se envío el email";
}]);

