<?php

use App\Http\Controllers\AdminController;
use Mailgun\Mailgun;
use Illuminate\Support\Facades\Route;
use Mailgun\Message\MessageBuilder;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\TamamCompleteRegistration;
use App\Jobs\BeforeCourseMail;
use App\Jobs\ManualRegistraionAccept;
use App\Jobs\CartRemindMail;
use App\Jobs\AfterCourseMail;
use App\Permission;
use App\Http\Controllers\CvTemplateController;
use App\Http\Controllers\RatingController;
use App\Trainee;
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

Route::get('/check-settings', function () {
  // phpinfo();
});
$HomePage = 'HomeController';
$customerController = 'CustomerController';
Route::get('/search', $HomePage . "@search");
Route::get('/linkstorage', function () {
  // Artisan::call('storage:link');
});
Route::get('/permissions/store', function () {
  // Artisan::call('storage:link');

  $jsonData = file_get_contents(storage_path('app/permissions.json'));

  // Convert JSON data to an array
  $permissions = json_decode($jsonData, true);

  // Loop through each record and insert into the database
  foreach ($permissions as $permission) {
    Permission::create([
      'name' => $permission['name'],
      'guard_name' => $permission['guard_name'],
    ]);
  }

  return response()->json(['message' => 'Data imported successfully']);
});

Route::get('/', $HomePage . "@index")->name('index');
// Route::get('/view/pdf/{id}', $HomePage . "@showDocument")->name('showDocument');
// // })->middleware('auth');
// Route::get('/viewer/{id}', function ($id) {
//   return view('showDocument', ['id' => $id]);
// });
Route::get('/category/services/{id}/{sub?}', $HomePage . "@categoryServices")->name('category.services');
Route::get('/category/{id}/{slug?}', $HomePage . "@categoryShow")->name('category.show');
Route::get('/service/{id}', $HomePage . "@service")->name('service.show');
Route::get('/sitemap.xml', $HomePage . "@sitemap")->name('sitemap');
Route::get('/login',  "CustomerController@login")->name('customer.login');
Route::get('/loginInst',  "CustomerController@loginInst")->name('customer.loginInst');
Route::get('/saveCountries',  $HomePage . "@saveCountries")->name('saveCountries');
Route::post('/cart_update', $customerController . "@cart_update")->name('customer.cart.update')->middleware('throttle:30,1');
Route::post('/cart_add', $customerController . "@cart_apply_post")->name('customer.cart_add')->middleware('throttle:30,1');
Route::get('/createMeeting', $customerController . "@createMeeting")->name('customer.createMeeting');
Route::get('customer/cart', $customerController . '@cart')->name('customer.cart');
Route::get('/cartRemove/{service}/', $customerController . '@cartRemove')->name('cart.remove');
Route::post('/code_id', $customerController . "@code_id")->name('code_id');
Route::get('/manualLogin', $customerController . "@manualLogin")->name('manualLogin');
Route::get('/check',  $customerController . "@check")->name('tap.check');
Route::middleware('auth.customer')->group(function () use ($customerController) {
  Route::get('/payment/moyasar/{paymentRequest}', $customerController . '@moyasarForm')->name('moyasar.form');
  Route::get('/payment/moyasar/callback/{paymentRequest}', $customerController . '@moyasarCallback')->name('moyasar.callback');
});
Route::post('/logout',  "CustomerController@logout")->name('customer.logout');
Route::post('/login',  "CustomerController@loginPost")->name('customer.login.post')->middleware('throttle:10,1');
Route::post('/login/code',  "CustomerController@loginCode")->name('customer.login.access_code')->middleware('throttle:10,1');
Route::get('/register',  "CustomerController@login")->name('customer.register');
Route::post('/register',  "CustomerController@registerPost")->name('customer.register.post')->middleware('throttle:5,1');
Route::get('/page/{id}/', $HomePage . "@post")->name('pages');
Route::get('/contacts', $HomePage . "@contacts")->name('contact');
Route::post('/contacts', $HomePage . "@contacts_post")->middleware('throttle:5,1');
Route::prefix('admin')->middleware(['web', 'auth.web'])->group(function () {
  Route::get('/pdfInvoice/{invoices}', "AdminController@pdfInvoice")->name('admin.pdfInvoice');
  Route::get('invoice/{id}/{detail?}', "CustomerController@invoice")->name('admin.invoice');
});
Route::prefix('admin')->middleware('auth.web')->group(function () {

  Route::get('/upload-chunk/{id?}', [AdminController::class, 'showUpload'])->name('admin.chunkUpload.get');
  Route::post('/upload-chunk/post', [AdminController::class, 'upload'])->name('admin.chunkUpload.post');
});
Route::prefix('customer')->middleware('auth.customer')->group(function () {
  $customerController = 'CustomerController';
  Route::get('/cv/create', [CvTemplateController::class, 'create'])->name('cv.create');
  Route::get('/cv', [CvTemplateController::class, 'index'])->name('cv.index');
  Route::post('/cv/store', [CvTemplateController::class, 'store'])->name('cv.store');
  Route::post('/rating/store', [RatingController::class, 'ratingStore'])->name('rating');
  Route::get('/cv/{id}/edit', [CvTemplateController::class, 'edit'])->name('cv.edit');
  Route::get('/cv/template/{id}/{temp}', [CvTemplateController::class, 'pdfDownload'])->name('cv.pdfDownload');
  Route::get('/cv/{id}/delete', [CvTemplateController::class, 'destroy'])->name('cv.delete');
  Route::put('/cv/{id}/update', [CvTemplateController::class, 'update'])->name('cv.update');
  Route::get('/download/{media}', $customerController . '@download')->name('media.download');
  Route::post('/cartSubmit', $customerController . '@cartSubmit')->name('cart.submit');
  Route::get('/dashboard', $customerController . "@dashboard")->name('customer.dashboard');
  Route::get('/notifications', $customerController . "@notifications")->name('customer.notifications');
  Route::get('/notifications/{id}/read', $customerController . "@notificationRead")->name('customer.notifications.read');
  Route::get('/allAddress', $customerController . "@allAddress")->name('customer.allAddress');
  Route::get('/address/{id}', $customerController . "@address")->name('customer.address');
  Route::get('/address/delete/{id}', $customerController . "@addressDelete")->name('customer.address.delete');
  Route::get('/newAddress', $customerController . "@newAddress")->name('customer.newAddress');
  Route::post('/newAddress/post', $customerController . "@newAddressPost")->name('customer.newAddress.post');
  Route::post('/address/update', $customerController . "@addressUpdate")->name('customer.address.update');

  Route::get('/services', $customerController . "@dashboard")->name('customer.services');
  Route::get('/info', $customerController . "@info")->name('customer.info');
  Route::get('/invoice/{id}', $customerController . "@invoice")->name('customer.invoice');
  Route::post('/info', $customerController . "@infoPost")->name('customer.info.post');
  Route::post('/item/details/{id}', $customerController . "@itemDetails")->name('customer.itemDetails');
});
