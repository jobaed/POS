<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionalMailController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AfterLoginMiddleware;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Mail\PromotionalMail;
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


// User Authentication Pages
Route::get( '/login', [UserController::class, 'loginPage'] );

Route::get( '/registration', [UserController::class, 'regiPage'] );

Route::get( '/otp', [UserController::class, 'otpPage'] );

Route::get( '/verify', [UserController::class, 'verifyotpPage'] )
->middleware([AfterLoginMiddleware::class]);

Route::get( '/reset', [UserController::class, 'resetPassPage'] )
    ->middleware( [TokenVerificationMiddleware::class] );






// Dashboard Pages
Route::get( '/dashboard', [UserController::class, 'dashboardPage'] )
    ->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/profile', [UserController::class, 'ProfilePage'] )
    ->middleware( [TokenVerificationMiddleware::class] );











// For Api Call

// User Registration
Route::post( '/userApiData', [UserController::class, 'storeAPIData'] );

// User Login
Route::post( '/userLogin', [UserController::class, 'userLogin'] );

// Send Otp To reset Password
Route::post( '/sendOTPCode', [UserController::class, 'SendOTPCode'] );

// Verified Otp
Route::post( '/verifiedOTP', [UserController::class, 'VerifiedOTP'] );

// TOken Verification
Route::post( '/pass-reset', [UserController::class, 'ResetPass'] );

// Log Out User
Route::get( '/logout', [UserController::class, 'logOut'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// User Profile Data
Route::get( '/user-profile', [UserController::class, 'UserProfile'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// User Profile Update
Route::post( '/userUdate', [UserController::class, 'userUdate'] )
    ->middleware( [TokenVerificationMiddleware::class] );













// Customer Module

Route::get( '/customerDash', [CustomerController::class, 'customerDash'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Create
Route::post( '/create-customer', [CustomerController::class, 'CreateCustomer'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Read
Route::get( '/list-customer', [CustomerController::class, 'CustomerList'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Update
Route::post( '/update-customer', [CustomerController::class, 'UpdateCustomer'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Delete
Route::post( '/delete-customer', [CustomerController::class, 'DeleteCustomer'] )
    ->middleware( [TokenVerificationMiddleware::class] );














// TODO Module


Route::get('/todo', [TodoController::class, 'showPage'])
->middleware( [TokenVerificationMiddleware::class] );

// Create
Route::post( '/create-todo', [TodoController::class, 'CreateToDo'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Read
Route::get( '/list-todo', [TodoController::class, 'TodoList'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Update
Route::post( '/update-todo', [TodoController::class, 'UpdateTodo'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Delete
Route::post( '/delete-todo', [TodoController::class, 'DeleteTodo'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Category Module

Route::get( '/categoriesDash', [CategoryController::class, 'categoryPage'] )
    ->middleware( [TokenVerificationMiddleware::class] );








// Category Module

// Create 

Route::post( '/create-category', [CategoryController::class, 'CreateCategory'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Read
Route::get( '/list-category', [CategoryController::class, 'CategoryList'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Update
Route::post( '/update-category', [CategoryController::class, 'UpdateCategory'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Delete
Route::post( '/delete-category', [CategoryController::class, 'DeleteCategory'] )
    ->middleware( [TokenVerificationMiddleware::class] );


    




// Product Module

Route::get( '/productDash', [ProductController::class, 'productDash'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Create Product

Route::post( '/create-product', [ProductController::class, 'CreateProduct'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Read
Route::get( '/list-product', [ProductController::class, 'ProductList'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Update
Route::post( '/update-product', [ProductController::class, 'UpdateCustomer'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Delete
Route::post( '/delete-product', [ProductController::class, 'DeleteProduct'] )
    ->middleware( [TokenVerificationMiddleware::class] );








// Promotional Email Controller

// Promotional Email PAge

Route::get('/send-mail',[PromotionalMailController::class, 'promotionlMailPage']);

Route::post('/prom-mail', [PromotionalMailController::class, 'sendPromotionalMail'])
    ->middleware( [TokenVerificationMiddleware::class] );
