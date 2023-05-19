<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\HelmetController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::get("/workers", [WorkerController::class, 'getAll']);

    Route::get("/workers/without-helmets", [WorkerController::class, 'getWorkersWithoutHelmets']);

    Route::get("/workers/{id}", [WorkerController::class, 'getWorkerById']);

    Route::get("/workers/helmet/{id}", [WorkerController::class, 'getWorkerByHelmetId']);

    Route::post("/workers/create", [WorkerController::class, 'createWorker']);

    Route::put("/workers/update/{id}", [WorkerController::class, 'updateWorker']);

    Route::delete("/workers/delete/{id}", [WorkerController::class, 'deleteWorker']);

    Route::get('/workers/export/excel', [WorkerController::class, 'exportExcel']);
    
    Route::post('/workers/import/excel', [WorkerController::class, 'importExcel']);

    

    Route::get("/sensors", [SensorController::class, 'getAll']);

    Route::get("/sensors/all", [SensorController::class, 'getAllSensors']);

    Route::get("/sensors/{id}", [SensorController::class, 'getSensorById']);

    Route::post("/sensors/create", [SensorController::class, 'createSensor']);

    Route::put("/sensors/update/{id}", [SensorController::class, 'updateSensor']);

    Route::delete("/sensors/delete/{id}", [SensorController::class, 'deleteSensor']);

    Route::get('/sensors/export/excel', [SensorController::class, 'exportExcel']);
   
    Route::post('/sensors/import/excel', [SensorController::class, 'importExcel']);



    Route::get("/readings", [ReadingController::class, 'getReadings']);

    Route::get("/readings/statistics", [ReadingController::class, 'getStatistics']);

    Route::get("/readings/{id}", [ReadingController::class, 'getReadingById']);

    Route::put("/readings/update/{id}", [ReadingController::class, 'updateReading']);

    Route::delete("/readings/delete/{id}", [ReadingController::class, 'deleteReading']);

    Route::get('/readings/export/excel', [ReadingController::class, 'exportExcel']);
    
    Route::get('/readings/getlastcoordinates', [ReadingController::class, 'getLastCoordinates']);





    Route::get("/helmets", [HelmetController::class, 'getAll']);

    Route::get("/helmets/all", [HelmetController::class, 'getAllHelmets']);

    Route::get("/helmets/without-workers", [HelmetController::class, 'getHelmetsWithoutWorkers']);

    Route::get("/helmets/{id}", [HelmetController::class, 'getHelmetById']);

    Route::get("/helmets/worker/{id}", [HelmetController::class, 'getHelmetByWorkerId']);

    Route::post("/helmets/create", [HelmetController::class, 'createHelmet']);

    Route::put("/helmets/update/{id}", [HelmetController::class, 'updateHelmet']);

    Route::put("/helmets/set-worker/{id}", [HelmetController::class, 'setWorker']);

    Route::delete("/helmets/delete/{id}", [HelmetController::class, 'deleteHelmet']);

    Route::get('/helmets/export/excel', [HelmetController::class, 'exportExcel']);



    Route::put("/update-info/{id}", [UserController::class, 'updateUser']);

    Route::get('/users/export/excel', [UserController::class, 'exportExcel']);

    Route::get('/users/{id}', [UserController::class, 'getUser']);

});

    
Route::post("/readings/create", [ReadingController::class, 'createReading']);

Route::post("/workers/login", [WorkerController::class, 'loginWorker']);


//Route::post("/workers/logout", [WorkerController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/workers/logout', [WorkerController::class, 'logout']);


Route::post("/notifications", [NotificationController::class, 'notify']);

