<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LanguageController;
use Spatie\Analytics\Period;
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
Route::get('/data', function () {
    //fetch the most visited pages for today and the past week
    
    $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
    dd($analyticsData);
});
// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
});

// // // Demo routes
Route::get('/datatables', 'PagesController@datatables');
Route::get('/ktdatatables', 'PagesController@ktDatatables');
Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');

Route::get('rooms_pieces_detail/{slug}/{id}','HomeController@pieces_detail')->name('rooms_pieces_detail');
Route::get('rooms_pieces_lists/{slug}','HomeController@pieces_lists')->name('rooms_pieces_lists');
Route::post('rooms_protection','HomeController@rooms_protection')->name('rooms_protection');
Route::post('pieces_inquiry','HomeController@pieces_inquiry')->name('pieces_inquiry');

//Profile Link 
Route::get('profile/{slug}','HomeController@profile_view')->name('profile');
Route::get('profile/{profile_slug}/artwork/{piece_slug}','HomeController@profile_pieces_detail')->name('profile.pieces_detail');
Route::post('pieces_profile_inquiry','HomeController@pieces_profile_inquiry')->name('pieces_profile_inquiry');
Route::get('profile/{profile_slug}/news/{post_slug}','HomeController@profile_post_detail')->name('profile.post_detail');

Route::get('/', 'PagesController@homepage')->name('/');

//Route::get('login', [LoginController::class, 'authenticate']);

Route::group(['middleware' => ['auth:sanctum','verified'],'namespace' => 'Admin'], function() {
    Route::get('/dashboard', 'PagesController@index')->name('dashboard');
    Route::get('/user/{id}/profile', 'PagesController@profile')->name('user.profile');
    Route::get('/user/{id}/about', 'PagesController@about')->name('user.about');
    Route::get('/user/{id}/integrations', 'PagesController@integrations')->name('user.integrations');
    Route::get('/user/{id}/my_posts/{filter}', 'PagesController@my_posts')->name('user.my_posts');
    Route::get('/user/{id}/public_pieces', 'PagesController@public_pieces')->name('user.public_pieces');
    Route::get('/user/{id}/public_setting', 'PagesController@public_setting')->name('user.public_setting');

    //Profile
    Route::post('user_profile','UsersController@userProfile')->name('admin.user_profile');
    //About
    Route::post('user_about','UsersController@userAbout')->name('admin.user_about');
    //Profile Setting
    Route::post('change_make_my_profile_public','UsersController@changeMakeMyProfilePublic')->name('admin.change_make_my_profile_public');
    Route::get('get_user_profile','UsersController@getUserProfile')->name('admin.get_user_profile');
    Route::post('change_public_profile_option','UsersController@changePublicProfileOption')->name('admin.change_public_profile_option');
    Route::post('change_public_profile_option_select','UsersController@changePublicProfileOptionSelect')->name('admin.change_public_profile_option_select');

    //Profile Pieces
    Route::resource('pieces','PiecesController');
    Route::post('pieces/images','PiecesController@uploadPiecesImage')->name('pieces.images');
    Route::post('pieces/remove_images','PiecesController@removePiecesImage')->name('pieces.remove_images');
    Route::post('change_pieces_status','PiecesController@changePiecesStatus')->name('admin.change_pieces_status');
    Route::post('change_pieces_public','PiecesController@changePiecesPublic')->name('admin.change_pieces_public');
    Route::get('getRuWork-By-PinecesId','PiecesController@getRunWork_By_PiecesId')->name('admin.getRunWork_By_PiecesId');
    Route::get('getEdition-By-PiecesId','PiecesController@getEdition_By_PiecesId')->name('admin.getEdition_By_PiecesId');
    Route::get('getLocation-By-PiecesId','PiecesController@getLocation_By_PiecesId')->name('admin.getLocation_By_PiecesId');


    //Profile Post
    Route::resource('posts', 'MyPostController');
    Route::post('change_published','MyPostController@change_published')->name('admin.change_published');
    //CKEDITOR Image Upload
    Route::post('ckeditor/mypost/upload', 'MyPostController@CkEditorImageUpload')->name('ckeditor.mypost.upload');

    //Collection
    Route::resource('collections','CollectionController');
    //Location
    Route::resource('locations','LocationController');


    //Runs
    Route::resource('runs','RunsController');

    //Works
    Route::resource('works','WorksController');
    Route::post('get_run_works','WorksController@getRunWorks')->name('admin.get_run_works');
    Route::post('assign_inventory_location','WorksController@assignInventoryLocation')->name('admin.assign_inventory_location');

    //Editions
    Route::resource('editions','EditionsController');
    Route::get('remove_editions_image/{id?}','EditionsController@removeEditionsImage')->name('admin.remove_editions_image');

    //Edition Works
    Route::resource('edition_works','EditionWorksController');
    Route::post('get_edition_works','EditionWorksController@getEditionWorks')->name('admin.get_edition_works');
    Route::post('assign_edition_inventory_location','EditionWorksController@assignInventoryLocation')->name('admin.assign_edition_inventory_location');

    //Private Rooms
    Route::resource('private_rooms','PrivateRoomsController');
    Route::post('change_room_status','PrivateRoomsController@changeRoomStatus')->name('admin.change_room_status');
    Route::post('shareUrl','PrivateRoomsController@shareURL')->name('admin.shareUrl');

    //Contact
    Route::resource('contact','ContactController');
    //Group
    Route::resource('group','groupController');


    //Inbox
    Route::resource('inbox', 'InboxController');
    Route::post('inboxs', 'InboxController@archive')->name('archive');
    Route::get('inboxs', 'InboxController@unarchivess')->name('inbox.inboxex');

    //Documents
    Route::resource('documents','MyDocumentController');
    Route::post('shareDocumentUrl','MyDocumentController@shareDocumentUrl')->name('admin.shareDocumentUrl');
    Route::get('document_download/{id?}', 'MyDocumentController@getDownload')->name('document.download');


    // Exhibitions
    Route::resource('exhibitions','ExhibitionController');
    Route::post('assign_pieces','ExhibitionController@assignPieces')->name('admin.assign_pieces');
    Route::post('change_exhibitions_pieces_status','ExhibitionController@changeExhibitionsPiecesStatus')->name('admin.change_exhibitions_pieces_status');
    Route::post('remove_exhibitions_pieces','ExhibitionController@removeExhibitionsPieces')->name('admin.remove_exhibitions_pieces');
    Route::post('copy_exhibitions','ExhibitionController@copyExhibitions')->name('admin.copy_exhibitions');
    Route::get('get_assign_pieces_by_exhibitions/{exhibitions_id?}','ExhibitionController@getAssignPiecesByExhibitions')->name('admin.get_assign_pieces_by_exhibitions');

    // Schedule
    Route::resource('schedule','ScheduleController');
    Route::post('change_schedule_status', 'ScheduleController@changeScheduleStatus')->name('admin.change_schedule_status');

});
