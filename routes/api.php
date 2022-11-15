<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Authentication menggunakan sanctum
Route::middleware(['auth:sanctum'])->group(function(){

# Get All Resource
Route::get('/patients', [PatientController::class, 'index']);

# Add Resource
Route::post('/patients',[PatientController::class, 'store']);

# Get detail Resource
Route::get('/patients/{id}', [PatientController::class,'show']);

# Edit Resource
Route::put('/patients/{id}', [PatientController::class,'update']);

# Delete Resource
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

# Search resource by name
Route::get('patients/search/{name}',[PatientController::class, 'search']);

# Get Positive Resource
Route::get('patients/status/{positive}',[PatientController::class, 'positive']);

# Get Recovered Resource
Route::get('patients/status/{recovered}',[PatientController::class, 'recovered']);

# Get Dead Resource
Route::get('patients/status/{dead}',[PatientController::class, 'dead']);
});



# Auth Register
Route::post('/register', [AuthController::class, 'register']);

# Auth Login 
Route::post('/login', [AuthController::class, 'login']);
