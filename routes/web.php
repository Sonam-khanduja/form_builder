<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserCodeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;



use App\Http\Controllers\FormsController;
use App\Http\Controllers\UserSubmitFormController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Auth::routes();

Route::get('/', function () {    
    if (auth()->guest()) {
        return view('auth.login');
    }else {
        return view('admin.dashboard');
    }
})->name('login');


Route::get('/logout',  [App\Http\Controllers\LogoutController::class, 'logout'])->name('custom.logout');


Route::group(['middleware' =>  ['auth:web', 'prevent-back-history' ]], function() {
 /**
    * custom Logout Route
 */
Auth::routes();
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('2fa', [App\Http\Controllers\UserCodeController::class, 'index'])->name('2fa.index');
Route::post('2fa', [App\Http\Controllers\UserCodeController::class, 'store'])->name('2fa.post');
Route::get('2fa/reset', [App\Http\Controllers\UserCodeController::class, 'resend'])->name('2fa.resend');

Route::post('/logout',  [App\Http\Controllers\LogoutController::class, 'logout'])->name('custom.logout');  

 });
//  Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
 Route::group(['prefix' => 'admin', 'middleware' => ['auth:web', 'is_active','prevent-back-history:web']], function (){   


    Route::get('/permission', [PermissionController::class, 'index'])->name('permission');
    Route::post('permission/bulk', [PermissionController::class, 'bulkPermission'])->name('bulkPermission');
    Route::post('permission', [PermissionController::class, 'createPermission'])->name('create.permission');
    Route::delete('permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');    
    Route::put('update/{id}', [UsersController::class, 'update'])->name('users.update');  

    Route::resource('/roles', RolesController::class);
    Route::resource('/users', UsersController::class);

    Route::resource('/forms', FormsController::class);
    Route::resource('/usersubmitform',  UserSubmitFormController::class);

   


    
    Route::get('view/{id}', [FormsController::class, 'view'])->name('forms.view');  
    Route::put('update/{id}', [FormsController::class, 'update'])->name('forms.update');  
    Route::post('customfields', [FormsController::class, 'customFields'])->name('forms.customfields');  
    Route::post('additionallogic', [FormsController::class, 'additionallogic'])->name('forms.additionallogic');  
    Route::post('getadditionalLogicOption', [FormsController::class, 'getadditionalLogicOption'])->name('forms.getadditionalLogicOption'); 
    Route::post('updateAdditionalLogic', [FormsController::class, 'updateAdditionalLogic'])->name('forms.updateAdditionalLogic'); 
    Route::post('deleteFormElement', [FormsController::class, 'deleteFormElement'])->name('forms.deleteFormElement'); 
    Route::post('getadditionallogic', [FormsController::class, 'getadditionallogic'])->name('forms.getadditionallogic');  

    // Route::get('submitformView/{id}', [FormsController::class, 'submitformView'])->name('forms.submitformview');
    // Submit Form


    
    Route::get('userSubmitFormsCreate/{id}', [FormsController::class, 'formcreate'])->name('forms.submitForm'); 
    Route::post('userSubmitFormsSubmit', [FormsController::class, 'formSubmit'])->name('forms.formSubmit'); 
   
    
    

    
  
});

Auth::routes();