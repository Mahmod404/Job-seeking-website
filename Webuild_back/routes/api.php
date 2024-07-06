<?php

use App\Http\Controllers\ApplyJopController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//                      ---Registration---
Route::controller(RegisterController::class)->group(function () {
    Route::post('/register', 'register'); // done
    Route::post('/login', 'login'); // done
}); // done
Route::get('/logout', [RegisterController::class, 'logout'])->middleware(['auth:sanctum']); // done
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum']); // done
Route::get('/job/employerJobs', [JobController::class, 'employerJobs'])->middleware(['auth:sanctum', 'isEmployer']); // done
Route::post('/job/StoreJob', [JobController::class, 'store'])->middleware(['auth:sanctum', 'isEmployer']); // done
Route::get('/job/delete/{id}', [JobController::class, 'destroy'])->middleware(['auth:sanctum', 'isEmployer']); // done
Route::get('/job/employer/jobApplactions', [ApplyJopController::class, 'showEmployerApplications'])->middleware(['auth:sanctum', 'isEmployer']); // done
Route::post('/job/employer/jobApplaction/accept/{id}', [ApplyJopController::class, 'applicationAccept'])->middleware(['auth:sanctum', 'isEmployer']); // done
Route::post('/job/employer/jobApplaction/reject/{id}', [ApplyJopController::class, 'applicationReject'])->middleware(['auth:sanctum', 'isEmployer']); // done
Route::get('/job/jobApplaction/delete/{id}', [ApplyJopController::class, 'applicationdelete'])->middleware(['auth:sanctum']); // done
Route::get('/job/apply/allRequests', [ApplyJopController::class, 'allRequests'])->middleware(['auth:sanctum', 'isWorker']); // done
Route::post('/worker/criminal_record/upload', [UserController::class, 'storeRecord'])->middleware(['auth:sanctum', 'isWorker']); // yet
Route::post('/user/image/upload', [UserController::class, 'store'])->middleware(['auth:sanctum']); //yet
Route::get('/allWorkers', [UserController::class, 'index'])->middleware(['auth:sanctum']); //find worker yet
Route::get('/job/allJobs', [JobController::class, 'index']); // done
Route::post('/job/apply/{id}', [ApplyJopController::class, 'apply'])->middleware(['auth:sanctum', 'isWorker']); // done
Route::get('/worker/rating', [RatingController::class, 'showWorkerRating'])->middleware(['auth:sanctum', 'isWorker']);
Route::get('/job/Employer/rating/store/{Rating}/{id}', [RatingController::class, 'storeRating'])->middleware(['auth:sanctum', 'isEmployer']);

Route::get('/AI/Workers', [UserController::class, 'find']); //find workers that have approved criminal record

Route::post('/AI/check/{id}', [UserController::class, 'post_AI']); 




// Route::post('/user/edit', [UserController::class, 'update'])->middleware(['auth:sanctum']);//yet
// Route::get('/job/show/{id}',[JobController::class, 'show']); // show work yet
// Route::post('/job/update/{id}',[JobController::class, 'update'])->middleware(['auth:sanctum', 'isEmployer']);
// Route::get('/job/createdBy/{id}',[ApplyJopController::class, 'showUser']);
// Route::get('/job/employer/jobApplaction/{id}',[ApplyJopController::class, 'showApplication'])->middleware(['auth:sanctum', 'isEmployer']);
// Route::get('/job/worker/Applactions/accepted',[ApplyJopController::class, 'workerAcceptedApplications'])->middleware(['auth:sanctum', 'isWorker']); // same of data
// Route::get('/job/Employer/ratingList',[RatingController::class, 'index'])->middleware(['auth:sanctum', 'isEmployer']);
// Route::get('/job/Employer/ratingList/{id}',[RatingController::class, 'show'])->middleware(['auth:sanctum', 'isEmployer']);