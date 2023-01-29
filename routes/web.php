<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

/*
Route::get('/', function () {
   return view('welcome');
});
*/

Auth::routes();


Route::get('/', 'HomeController@index')->name('index');
Route::get('home', 'HomeController@index')->name('home');
Route::get('blog', 'ArticleController@blog')->name('blog');
Route::get('api/blog', 'ArticleController@blogJson')->name('blogJson');
Route::get('article/{id}', 'ArticleController@article')->name('article');
Route::get('api/article/{id}', 'ArticleController@articleJson')->name('articleJson');
Route::get('contact', 'ConfigurationController@contact')->name('contact');
Route::get('artists', 'ArtistController@artists')->name('artists');
Route::get('artist/{id}', 'ArtistController@artist')->name('artist');
Route::post('contact', 'ConfigurationController@sendMail');
Route::get('off', 'HomeController@off');

Route::get('exhibition', 'ExhibitionController@exhibition')->name('profile');
Route::post('exhibition', 'ExhibitionController@exhibitionPost');

Route::get('account/profile', 'ProfileController@profile')->middleware("auth");
Route::post('account/profile', 'ProfileController@profileUpdate')->middleware("auth");
Route::post('ka/account/profile', 'ProfileController@profileUpdateKa')->middleware("auth");
Route::get('account/avatar', 'ProfileController@avatar')->name('avatar')->middleware("auth");

Route::get('account/social_profiles', 'ProfileController@social')->middleware("auth");
Route::post('account/social_profiles', 'ProfileController@socialUpdate')->middleware("auth");

Route::get('account/password', 'ProfileController@password')->middleware("auth");
Route::post('account/password', 'ProfileController@passwordUpdate')->middleware("auth");


// projects site
Route::get('projects', 'ProjectController@projects')->name('projects');
Route::get('add-project', 'ProjectController@addGet');
Route::post('add-project', 'ProjectController@addPost');
Route::get('api/projects', 'ProjectController@itemsJson')->name('projectsJson');
Route::get('project/{id}', 'ProjectController@item')->name('project');
Route::get('api/project/{id}', 'ProjectController@itemJson')->name('projectJson');

Route::get('projects2', 'ProjectController@projects2')->name('projects2');


// events
Route::get('events', 'EventController@events')->name('events');
Route::get('api/events', 'EventController@eventsJson')->name('eventsJson');
Route::get('event/{id}', 'EventController@event')->name('event');
Route::get('api/event/{id}', 'EventController@eventJson')->name('eventJson');


// exhibitions
Route::get('exhibitions', 'EventController@events')->name('exhibitions');
Route::get('exhibition/{id}', 'EventController@event')->name('exhibition');


// locations
Route::get('locations', 'LocationController@locations')->name('locations');
Route::get('location/{id}', 'LocationController@location')->name('location');


// admin panel
Route::post('admin/sidebar-switcher', 'HomeController@sidebar')->middleware("SuperAdmin");
Route::get('admin', 'HomeController@admin')->name('home')->middleware("auth","SuperAdmin");
Route::get('admin/last30day', 'HomeController@last30day')->name('last30day')->middleware("SuperAdmin");

Route::get('admin/configuration', 'ConfigurationController@configuration')->name('configuration')->middleware("SuperAdmin");
Route::get('admin/blog_cover', 'ConfigurationController@blog_cover')->name('blog_cover')->middleware("SuperAdmin");
Route::get('admin/event_cover', 'ConfigurationController@event_cover')->name('event_cover')->middleware("SuperAdmin");
Route::post('admin/configuration/{id}', 'ConfigurationController@edit')->middleware("SuperAdmin");

Route::get('admin/contact', 'ConfigurationController@contactGet')->middleware("SuperAdmin");
Route::post('admin/contact/{id}', 'ConfigurationController@contactPost')->middleware("SuperAdmin");


Route::get('admin/articles', 'ArticleController@index')->middleware("SuperAdmin");
Route::get('admin/articles/add', 'ArticleController@addGet')->middleware("SuperAdmin");
Route::post('admin/articles/add', 'ArticleController@addPost')->middleware("SuperAdmin");
Route::get('admin/articles/new', 'ArticleController@newItem')->middleware("SuperAdmin");
Route::get('admin/articles/update/{id}', 'ArticleController@updateGet')->middleware("SuperAdmin");
Route::post('admin/articles/update/{id}', 'ArticleController@updatePost')->middleware("SuperAdmin");
Route::post('admin/articles/delete', 'ArticleController@delete')->middleware("SuperAdmin");


Route::get('admin/articles/categories', 'ArticleCategoryController@index')->middleware("SuperAdmin");
Route::get('admin/articles/categories/add', 'ArticleCategoryController@addGet')->middleware("SuperAdmin");
Route::post('admin/articles/categories/add', 'ArticleCategoryController@addPost')->middleware("SuperAdmin");
Route::get('admin/articles/categories/update/{id}', 'ArticleCategoryController@updateGet')->middleware("SuperAdmin");
Route::post('admin/articles/categories/update/{id}', 'ArticleCategoryController@updatePost')->middleware("SuperAdmin");
Route::post('admin/articles/categories/delete', 'ArticleCategoryController@delete')->middleware("SuperAdmin");


Route::get('admin/artists', 'ArtistController@index')->middleware("SuperAdmin");
Route::get('admin/artists/add', 'ArtistController@addGet')->middleware("SuperAdmin");
Route::post('admin/artists/add', 'ArtistController@addPost')->middleware("SuperAdmin");
Route::get('admin/artists/update/{id}', 'ArtistController@updateGet')->middleware("SuperAdmin");
Route::post('admin/artists/update/{id}', 'ArtistController@updatePost')->middleware("SuperAdmin");
Route::post('admin/artists/delete', 'ArtistController@delete')->middleware("SuperAdmin");


Route::get('admin/projects', 'ProductController@index')->middleware("SuperAdmin");
Route::get('admin/projects/add', 'ProductController@addGet')->middleware("SuperAdmin");
Route::post('admin/projects/add', 'ProductController@addPost')->middleware("SuperAdmin");
Route::get('admin/projects/new', 'ProductController@new')->middleware("SuperAdmin");
Route::get('admin/projects/update/{id}', 'ProductController@updateGet')->middleware("SuperAdmin");
Route::post('admin/projects/update/{id}', 'ProductController@updatePost')->middleware("SuperAdmin");
Route::post('admin/projects/delete', 'ProductController@delete')->middleware("SuperAdmin");


Route::get('admin/projects/categories', 'ProductCategoryController@index')->middleware("SuperAdmin");
Route::get('admin/projects/categories/add', 'ProductCategoryController@addGet')->middleware("SuperAdmin");
Route::post('admin/projects/categories/add', 'ProductCategoryController@addPost')->middleware("SuperAdmin");
Route::get('admin/projects/categories/update/{id}', 'ProductCategoryController@updateGet')->middleware("SuperAdmin");
Route::post('admin/projects/categories/update/{id}', 'ProductCategoryController@updatePost')->middleware("SuperAdmin");
Route::post('admin/projects/categories/delete', 'ProductCategoryController@delete')->middleware("SuperAdmin");


Route::get('admin/groups', 'GroupController@index')->middleware("SuperAdmin");
Route::get('admin/groups/add', 'GroupController@addGet')->middleware("SuperAdmin");
Route::post('admin/groups/add', 'GroupController@addPost')->middleware("SuperAdmin");
Route::get('admin/groups/update/{id}', 'GroupController@updateGet')->middleware("SuperAdmin");
Route::post('admin/groups/update/{id}', 'GroupController@updatePost')->middleware("SuperAdmin");
Route::post('admin/groups/delete', 'GroupController@delete')->middleware("SuperAdmin");


Route::get('admin/slides', 'SlideController@index')->middleware("SuperAdmin");
Route::get('admin/slides/add', 'SlideController@addGet')->middleware("SuperAdmin");
Route::post('admin/slides/add', 'SlideController@addPost')->middleware("SuperAdmin");
Route::get('admin/slides/update/{id}', 'SlideController@updateGet')->middleware("SuperAdmin");
Route::post('admin/slides/update/{id}', 'SlideController@updatePost')->middleware("SuperAdmin");
Route::post('admin/slides/delete', 'SlideController@delete')->middleware("SuperAdmin");


Route::get('admin/banners', 'BannerController@index')->middleware("SuperAdmin");
Route::get('admin/banners/add', 'BannerController@addGet')->middleware("SuperAdmin");
Route::post('admin/banners/add', 'BannerController@addPost')->middleware("SuperAdmin");
Route::get('admin/banners/update/{id}', 'BannerController@updateGet')->middleware("SuperAdmin");
Route::post('admin/banners/update/{id}', 'BannerController@updatePost')->middleware("SuperAdmin");
Route::post('admin/banners/delete', 'BannerController@delete')->middleware("SuperAdmin");


Route::get('admin/navigation', 'NavigationController@index')->middleware("SuperAdmin");
Route::get('admin/navigation/add', 'NavigationController@addGet')->middleware("SuperAdmin");
Route::post('admin/navigation/add', 'NavigationController@addPost')->middleware("SuperAdmin");
Route::get('admin/navigation/update/{id}', 'NavigationController@updateGet')->middleware("SuperAdmin");
Route::post('admin/navigation/update/{id}', 'NavigationController@updatePost')->middleware("SuperAdmin");
Route::post('admin/navigation/delete', 'NavigationController@delete')->middleware("SuperAdmin");


Route::get('admin/notifications', 'NotificationController@index')->middleware("SuperAdmin");
Route::get('admin/notifications/modal/{id}', 'NotificationController@modal')->middleware("SuperAdmin");
Route::get('admin/notifications/add', 'NotificationController@addGet')->middleware("SuperAdmin");
Route::post('admin/notifications/add', 'NotificationController@addPost')->middleware("SuperAdmin");
Route::get('admin/notifications/update/{id}', 'NotificationController@updateGet')->middleware("SuperAdmin");
Route::post('admin/notifications/update/{id}', 'NotificationController@updatePost')->middleware("SuperAdmin");
Route::post('admin/notifications/delete', 'NotificationController@delete')->middleware("SuperAdmin");
Route::get('admin/notifications/modal/{id}', 'NotificationController@modal')->middleware("SuperAdmin");

Route::get('admin/logs', 'LogController@index')->middleware("SuperAdmin");
Route::get('admin/logs/modal/{id}', 'LogController@modal')->middleware("SuperAdmin");
Route::post('admin/logs/delete', 'LogController@delete')->middleware("SuperAdmin");


Route::get('admin/sms', 'SmsController@index')->middleware("SuperAdmin");
Route::get('admin/sms/modal/{id}', 'SmsController@modal')->middleware("SuperAdmin");
Route::post('admin/sms/delete', 'SmsController@delete')->middleware("SuperAdmin");

Route::get('admin/transactions', 'TransactionController@index')->middleware("SuperAdmin");
Route::get('admin/transactions/{id}', 'TransactionController@modal')->middleware("SuperAdmin");
Route::post('admin/transactions/delete', 'TransactionController@delete')->middleware("SuperAdmin");
Route::get('admin/transactions/modal/{id}', 'TransactionController@modal')->middleware("SuperAdmin");


Route::get('admin/users',"UserController@AllUsers")->middleware("SuperAdmin");
Route::get('admin/users/new',"UserController@newItem")->middleware("SuperAdmin");
Route::get('admin/users/update/{id}',"UserController@updateGet")->middleware("SuperAdmin");
Route::post('admin/users/update/{id}',"UserController@updatePost")->middleware("SuperAdmin");
Route::post('admin/users/updateAddress/{id}',"UserController@updateAddress")->middleware("SuperAdmin");
Route::post('users/update/password/{id}',"UserController@password")->middleware("SuperAdmin");
Route::get('admin/users/add',"UserController@addGet")->middleware("SuperAdmin");
Route::post('admin/users/add',"UserController@addPost")->middleware("SuperAdmin");
Route::post('admin/users/delete',"UserController@delete")->middleware("SuperAdmin");


Route::get('admin/countries', 'CountryController@index')->middleware("SuperAdmin");
Route::get('admin/countries/add', 'CountryController@addGet')->middleware("SuperAdmin");
Route::post('admin/countries/add', 'CountryController@addPost')->middleware("SuperAdmin");
Route::get('admin/countries/update/{id}', 'CountryController@updateGet')->middleware("SuperAdmin");
Route::post('admin/countries/update/{id}', 'CountryController@updatePost')->middleware("SuperAdmin");
Route::post('admin/countries/delete', 'CountryController@delete')->middleware("SuperAdmin");


Route::get('admin/states', 'StateController@index')->middleware("SuperAdmin");
Route::get('admin/states/add', 'StateController@addGet')->middleware("SuperAdmin");
Route::post('admin/states/add', 'StateController@addPost')->middleware("SuperAdmin");
Route::get('admin/states/update/{id}', 'StateController@updateGet')->middleware("SuperAdmin");
Route::post('admin/states/update/{id}', 'StateController@updatePost')->middleware("SuperAdmin");
Route::post('admin/states/delete', 'StateController@delete')->middleware("SuperAdmin");
Route::get('api/states/{country_id}', 'StateController@getStates')->middleware("SuperAdmin");


Route::get('admin/cities', 'CityController@index')->middleware("SuperAdmin");
Route::get('admin/cities/add', 'CityController@addGet')->middleware("SuperAdmin");
Route::post('admin/cities/add', 'CityController@addPost')->middleware("SuperAdmin");
Route::get('admin/cities/update/{id}', 'CityController@updateGet')->middleware("SuperAdmin");
Route::post('admin/cities/update/{id}', 'CityController@updatePost')->middleware("SuperAdmin");
Route::post('admin/cities/delete', 'CityController@delete')->middleware("SuperAdmin");
Route::get('api/cities/{state_id}', 'CityController@getCities')->middleware("SuperAdmin");


Route::get('admin/locations', 'LocationController@index')->middleware("SuperAdmin");
Route::get('admin/locations/add', 'LocationController@addGet')->middleware("SuperAdmin");
Route::post('admin/locations/add', 'LocationController@addPost')->middleware("SuperAdmin");
Route::get('admin/locations/update/{id}', 'LocationController@updateGet')->middleware("SuperAdmin");
Route::post('admin/locations/update/{id}', 'LocationController@updatePost')->middleware("SuperAdmin");
Route::post('admin/locations/delete', 'LocationController@delete')->middleware("SuperAdmin");
Route::get('api/locations/{state_id}', 'LocationController@getCities')->middleware("SuperAdmin");


Route::get('admin/events', 'EventController@index')->middleware("SuperAdmin");
Route::get('admin/events/add', 'EventController@addGet')->middleware("SuperAdmin");
Route::post('admin/events/add', 'EventController@addPost')->middleware("SuperAdmin");
Route::get('admin/events/new', 'EventController@newItem')->middleware("SuperAdmin");
Route::get('admin/events/update/{id}', 'EventController@updateGet')->middleware("SuperAdmin");
Route::post('admin/events/update/{id}', 'EventController@updatePost')->middleware("SuperAdmin");
Route::post('admin/events/delete', 'EventController@delete')->middleware("SuperAdmin");


Route::get('admin/exhibitions', 'ExhibitionController@index')->middleware("SuperAdmin");
Route::get('admin/exhibitions/update/{id}', 'ExhibitionController@updateGet')->middleware("SuperAdmin");
Route::post('admin/exhibitions/update/{id}', 'ExhibitionController@updatePost')->middleware("SuperAdmin");
Route::post('admin/exhibitions/delete', 'ExhibitionController@delete')->middleware("SuperAdmin");



//subscribers
Route::get('admin/subscribers', 'SubscriberController@index')->middleware("auth");
Route::get('admin/subscribers/add', 'SubscriberController@addGet')->middleware("auth");
Route::post('admin/subscribers/add', 'SubscriberController@addPost')->middleware("auth");
Route::get('admin/subscribers/update/{id}', 'SubscriberController@updateGet')->middleware("auth");
Route::post('admin/subscribers/update/{id}', 'SubscriberController@updatePost')->middleware("auth");
Route::post('admin/subscribers/delete', 'SubscriberController@delete')->middleware("auth");

Route::post('/subscribe',"SubscriberController@subscribe");
Route::get('/unsubscribe/',"SubscriberController@unsubscribeForm");
Route::post('/unsubscribe',"SubscriberController@unsubscribe");

//Route::get('/admin/subscribers/export',"SubscriberController@export")->middleware("auth");
//Route::get('/admin/subscribers/exportCSV',"SubscriberController@exportCSV")->middleware("auth");
Route::get('/admin/subscribers/export2CSV',"SubscriberController@export2CSV")->middleware("auth");
//subscribers



// other image
Route::post('upload-file', ['as' => 'upload-file', 'uses' =>'ImageController@fileUpload'])->middleware("SuperAdmin");
Route::post('upload/delete', ['as' => 'upload-remove', 'uses' =>'ImageController@deleteUpload'])->middleware("SuperAdmin");


// article images
Route::get('upload-article', ['as' => 'upload-article', 'uses' =>'ImageController@articleUpload'])->middleware("SuperAdmin");
Route::post('upload-article', ['as' => 'upload-article', 'uses' =>'ImageController@articleUpload'])->middleware("SuperAdmin");
Route::post('upload-article-content', ['as' => 'upload-article-content', 'uses' =>'ImageController@articleContentUpload'])->middleware("SuperAdmin");
Route::post('article/delete-image', ['as' => 'article-image-remove', 'uses' =>'ImageController@deleteArticle'])->middleware("SuperAdmin");

// user images
Route::post('upload-user', ['as' => 'upload-user', 'uses' =>'ImageController@userUpload'])->middleware("SuperAdmin");
Route::post('user/delete-image', ['as' => 'user-image-remove', 'uses' =>'ImageController@deleteUser'])->middleware("SuperAdmin");


// avatar images
Route::post('upload-avatar', ['as' => 'upload-avatar', 'uses' =>'ImageController@avatarUpload'])->middleware("SuperAdmin");
Route::post('delete-avatar', ['as' => 'delete-avatar', 'uses' =>'ProfileController@deleteAvatar'])->middleware("SuperAdmin");

// product images
Route::post('upload-product', ['as' => 'upload-product', 'uses' =>'ImageController@productUpload'])->middleware("SuperAdmin");
Route::post('upload-product-content', ['as' => 'upload-product-content', 'uses' =>'ImageController@productContentUpload'])->middleware("SuperAdmin");
Route::post('product/delete-image', ['as' => 'product-image-remove', 'uses' =>'ImageController@deleteProduct'])->middleware("SuperAdmin");

// event images
Route::post('upload-event', ['as' => 'upload-event', 'uses' =>'ImageController@eventUpload'])->middleware("SuperAdmin")->middleware("SuperAdmin");
Route::post('upload-event-content', ['as' => 'upload-event-content', 'uses' =>'ImageController@eventContentUpload'])->middleware("SuperAdmin");
Route::post('event/delete-image', ['as' => 'event-image-remove', 'uses' =>'ImageController@deleteEvent'])->middleware("SuperAdmin");


Route::get('/lang/{key}', function ($key) {
    session()->put('locale', $key);
    return redirect()->back();
})->middleware('lang');
