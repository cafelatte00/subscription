<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

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
// Route::get('subscriptions/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
// Route::get('subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
// Route::post('subscriptions/', [SubscriptionController::class, 'store'])->name('subscriptions.store');
// Route::get('subscriptions/{id}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
// Route::edit('subscriptions/{id}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
// Route::post('subscriptions/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
// Route::post('subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

Route::prefix('subscriptions')->middleware(['auth'])
->controller(subscriptionController::class)
->name('subscriptions.')
->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/add-subscription', 'addSubscription')->name('add.subscription');  // 新規保存モーダル
    Route::post('/', 'store')->name('store');
    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}', 'update')->name('update');
    Route::post('/{id}/delete', 'delete')->name('delete');
    Route::post('/{id}/cancel', 'cancel')->name('cancel');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/image', [ProfileController::class, 'destroyImage'])->name('profile.destroyImage');
});

require __DIR__.'/auth.php';
