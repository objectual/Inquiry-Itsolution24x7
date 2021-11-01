<?php

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

// Images Resize Route
Route::get('/resize/{img}', function ($img) {

    ob_end_clean();
    try {
        $w = request()->get('w');
        $h = request()->get('h');
        if ($h && $w) {
            // Image Handler lib
            return Image::make(asset("storage/app/$img"))->resize($h, $w, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->response('png');
        } else {
            return response(file_get_contents(storage_path("/app/$img")))
                ->header('Content-Type', 'image/png');
        }

    } catch (\Exception $e) {
//        dd($e->getMessage());
        return abort(404, $e->getMessage());
    }
})->name('resize')->where('img', '(.*)');


/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

## No Token Required

Route::get('v1/nexmo/{email}/{phone}', 'UserAPIController@nexmocheckout');

Route::post('v1/register', 'AuthAPIController@register')->name('register');

Route::post('v1/login', 'AuthAPIController@login')->name('login');
Route::post('v1/social_login', 'AuthAPIController@socialLogin')->name('socialLogin');

Route::get('v1/forget-password', 'AuthAPIController@getForgetPasswordCode')->name('forget-password'); 
//Route::post('v1/resend-code', 'AuthAPIController@resendCode');
Route::post('v1/verify-reset-code', 'AuthAPIController@verifyCode')->name('verify-code');
Route::post('v1/reset-password', 'AuthAPIController@updatePassword')->name('reset-password');
Route::post('v1/popup', 'ContactUsAPIController@popup')->name('popup');
Route::post('v1/contacts', 'ContactUsAPIController@contacts')->name('contact');
Route::post('v1/contacts-pkg', 'ContactUsAPIController@contactForPkg')->name('contact_pkg');
Route::post('v1/review', 'ContactUsAPIController@ReviewPopup')->name('review');
Route::post('v1/ecommercequote', 'ContactUsAPIController@ecommercestore')->name('ecommercequote');
Route::post('v1/career', 'ContactUsAPIController@career')->name('career');
Route::get('v1/timelogger', 'ContactUsAPIController@updateTimelogger')->name('timelogger');
Route::resource('v1/contactus', 'ContactUsAPIController');
Route::post('v1/shoppy-contact', 'ContactUsAPIController@shoppyContact');
Route::post('v1/shoppy-contact2', 'ContactUsAPIController@shoppyContact2');


if (is_object(JWTAuth::getToken())) {
    ## Token Required to below APIs
    Route::middleware('auth:api')->group(function () {
        ## Token Required to below APIs
        Route::post('v1/logout', 'AuthAPIController@logout');

        Route::post('v1/change-password', 'AuthAPIController@changePassword');
        Route::post('v1/users/{id}', 'UserAPIController@update');

        Route::post('v1/refresh', 'AuthAPIController@refresh');
        Route::post('v1/me', 'AuthAPIController@me');

        Route::resource('v1/users', 'UserAPIController');

        Route::resource('v1/roles', 'RoleAPIController');
        Route::resource('v1/permissions', 'PermissionAPIController');

        Route::resource('v1/languages', 'LanguageAPIController');

        Route::resource('v1/pages', 'PageAPIController');


        Route::resource('v1/notifications', 'NotificationAPIController');

        Route::resource('v1/menus', 'MenuAPIController');

        Route::resource('v1/settings', 'SettingAPIController');


        Route::resource('v1/projects', 'ProjectAPIController');

        Route::resource('v1/descriptions', 'DescriptionAPIController');

        Route::resource('v1/project-types', 'ProjectTypeAPIController');

        Route::resource('v1/project-attributes', 'ProjectAttributeAPIController');

        Route::resource('v1/questions', 'QuestionAPIController');

        Route::resource('v1/expertises', 'ExpertiseAPIController');

        Route::resource('v1/budgets', 'BudgetAPIController');

        Route::resource('v1/categories', 'CategoryAPIController');

        Route::get('v1/reviews/{id}', 'ProjectAPIController@review');

        Route::resource('v1/orders', 'OrderAPIController');

        Route::get('v1/order', 'OrderAPIController@order');

        Route::resource('v1/customers', 'CustomerAPIController');
    });
} else {
    ## routes for
}


Route::resource('v1/estimates', 'EstimateAPIController');

Route::resource('v1/estimate-details', 'EstimateDetailAPIController');

Route::resource('v1/invoices', 'InvoiceAPIController');

Route::resource('v1/mailers', 'MailerAPIController');

Route::resource('v1/receivers', 'ReceiverAPIController');

Route::resource('v1/templates', 'TemplateAPIController');