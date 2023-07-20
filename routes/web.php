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
})->name('home');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('post', [HomeController::class, 'post'])->middleware(['auth', 'adminBazaarLeader']);

//routes for profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/bazaar/addBL', [BazaarController::class, 'createBL'])->name('bazaar.createBL')->middleware(['auth', 'admin']);
Route::get('/bazaar/addBazaar', [BazaarController::class, 'create'])->name('bazaar.addBazaar')->middleware(['auth', 'admin']);
Route::post('/bazaar', [BazaarController::class, 'store'])->name('bazaar.store');
Route::get('/bazaar/bazaarList', [BazaarController::class, 'index'])->name('bazaar.bazaarList')->middleware(['auth', 'admin']);
Route::delete('/bazaar/{bazaarName}', [BazaarController::class, 'destroy'])->name('bazaar.destroy');
Route::get('/bazaar/{bazaarName}/editBazaar', [BazaarController::class, 'edit'])->name('bazaar.editBazaar')->middleware(['auth', 'admin']);
Route::put('/bazaar/{bazaarName}', [BazaarController::class, 'update'])->name('bazaar.update');
Route::get('/bazaar/leaders', [BazaarController::class, 'indexBL'])->name('bazaar.indexBL')->middleware(['auth', 'admin']);
Route::post('/bazaar/storeBL', [BazaarController::class, 'storeBL'])->name('bazaar.storeBL');
Route::get('/bazaar/volunteers', [BazaarController::class, 'indexV'])->name('bazaar.indexV')->middleware(['auth', 'adminBazaarLeader']);
Route::post('/bazaar/assignDuty', [BazaarController::class, 'assignDuty'])->name('bazaar.assignDuty')->middleware(['auth', 'adminBazaarLeader']);
Route::delete('/bazaar/delete/{name}', [BazaarController::class, 'deleteVolunteer'])->name('bazaar.deleteVolunteer');

Route::get('/volunteer/chooseVolunteer', [BazaarController::class, 'chooseVolunteer'])->name('volunteer.chooseVolunteer')->middleware(['auth', 'volunteer']);
Route::post('/volunteer/volunteerToBazaar', [BazaarController::class, 'volunteerToBazaar'])->name('volunteer.volunteerToBazaar');


Route::get('/duty/create', [DutyController::class, 'create'])->name('duty.create')->middleware(['auth', 'admin']);
Route::post('/duty/store', [DutyController::class, 'store'])->name('duty.store');
Route::get('/duty/list', [DutyController::class, 'list'])->name('duty.list')->middleware(['auth', 'admin']);
Route::get('/duty/{duty}/edit', [DutyController::class, 'edit'])->name('duty.edit')->middleware(['auth', 'admin']);
Route::put('/duty/{duty}', [DutyController::class, 'update'])->name('duty.update');
Route::delete('/duty/{duty}', [DutyController::class, 'destroy'])->name('duty.destroy');

Route::get('/foodweights/create', [FoodWeightsController::class, 'create'])->name('foodweights.create')->middleware(['auth', 'adminBazaarLeader']);
Route::get('/foodweight', [FoodWeightsController::class, 'index'])->name('foodweights.foodWeightList')->middleware(['auth', 'bazaarLeader']);
Route::get('/foodweights', [FoodWeightsController::class, 'indexAdmin'])->name('foodweights.foodWeightListAdmin')->middleware(['auth', 'admin']);
Route::put('/foodweights/{foodWeight}', [FoodWeightsController::class, 'update'])->name('foodweights.update')->middleware(['auth', 'adminBazaarLeader']);
Route::post('/foodweights', [FoodWeightsController::class, 'store'])->name('foodweights.store')->middleware(['auth', 'adminBazaarLeader']);
Route::get('/foodweights/analysisByBazaar', [FoodWeightsController::class, 'analysisByBazaar'])->name('foodweights.analysisByBazaar');
Route::get('/foodweights/analysisByYear', [FoodWeightsController::class, 'analysisByYear'])->name('foodweights.analysisByYear');

Route::get('/analysis/analysisByBazaar', [FoodWeightsController::class, 'analysisByBazaar2'])->name('analysis.analysisByBazaar');
Route::get('/analysis/analysisByYear', [FoodWeightsController::class, 'analysisByYear2'])->name('analysis.analysisByYear');

require __DIR__ . '/auth.php';
