<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BazaarController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\FoodWeightsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('post', [HomeController::class, 'post'])->middleware(['auth', 'adminBazaarLeader']);

//authorization
require __DIR__ . '/auth.php';

//routes for profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//add bazaar leader
Route::get('/bazaar/addBL', [BazaarController::class, 'createBL'])->name('bazaar.createBL');
Route::get('/bazaar/leaders', [BazaarController::class, 'indexBL'])->name('bazaar.indexBL');
Route::post('/bazaar/storeBL', [BazaarController::class, 'storeBL'])->name('bazaar.storeBL');

//add bazaar
Route::get('/bazaar/addBazaar', [BazaarController::class, 'create'])->name('bazaar.addBazaar');
Route::post('/bazaar', [BazaarController::class, 'store'])->name('bazaar.store');

//display bazaar list
Route::get('/bazaar/bazaarList', [BazaarController::class, 'index'])->name('bazaar.bazaarList');

//delete and edit bazaar
Route::delete('/bazaar/{bazaarName}', [BazaarController::class, 'destroy'])->name('bazaar.destroy');
Route::get('/bazaar/{bazaarName}/editBazaar', [BazaarController::class, 'edit'])->name('bazaar.editBazaar');
Route::put('/bazaar/{bazaarName}', [BazaarController::class, 'update'])->name('bazaar.update');

//create and store duty
Route::get('/duty/create', [DutyController::class, 'create'])->name('duty.create');
Route::post('/duty/store', [DutyController::class, 'store'])->name('duty.store');

//edit or delete duty
Route::get('/duty/{duty}/edit', [DutyController::class, 'edit'])->name('duty.edit');
Route::put('/duty/{duty}', [DutyController::class, 'update'])->name('duty.update');
Route::delete('/duty/{duty}', [DutyController::class, 'destroy'])->name('duty.destroy');

//view duty list
Route::get('/duty/list', [DutyController::class, 'list'])->name('duty.list');

//food weight data list
Route::get('/foodweights', [FoodWeightsController::class, 'index'])->name('foodweights.foodWeightList')->middleware(['auth', 'adminBazaarLeader']);

//update food weight
Route::put('/foodweights/{foodWeight}', [FoodWeightsController::class, 'update'])->name('foodweights.update')->middleware(['auth', 'adminBazaarLeader']);
Route::post('/foodweights', [FoodWeightsController::class, 'store'])->name('foodweights.store')->middleware(['auth', 'adminBazaarLeader']);

//volunteer List and admin or bazaar leader assign duties
Route::get('/bazaar/volunteers', [BazaarController::class, 'indexV'])->name('bazaar.indexV')->middleware(['auth', 'adminBazaarLeader']);
Route::post('/bazaar/assignDuty', [BazaarController::class, 'assignDuty'])->name('bazaar.assignDuty')->middleware(['auth', 'adminBazaarLeader']);
Route::delete('/bazaar/delete/{name}', [BazaarController::class, 'deleteVolunteer'])->name('bazaar.deleteVolunteer');

//volunteer choose to volunteer on bazaar
Route::get('/volunteer/chooseVolunteer', [BazaarController::class, 'chooseVolunteer'])->name('volunteer.chooseVolunteer');
Route::post('/volunteer/volunteerToBazaar', [BazaarController::class, 'volunteerToBazaar'])->name('volunteer.volunteerToBazaar');


//generate analysis
Route::get('/foodweights/analysisByBazaar', [FoodWeightsController::class, 'analysisByBazaar'])->name('foodweights.analysisByBazaar');
Route::get('/foodweights/analysisByYear', [FoodWeightsController::class, 'analysisByYear'])->name('foodweights.analysisByYear');

require __DIR__ . '/auth.php';