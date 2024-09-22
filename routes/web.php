<?php

use App\Http\Controllers\AssignController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
// admin controller
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthSocialLoginController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\InfoWebController;
use App\Http\Controllers\Login;
use App\Http\Controllers\MaintanceController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\DirectorsController;
use App\Http\Controllers\EmbedController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ManageCommentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Assign;

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

Route::middleware('web')->get('/auth/login', [AuthSocialLoginController::class, 'index'])->name('user-login');

//******************* */
Route::middleware('throttle:30,1')->group(function () {
    Route::get('/', [IndexController::class, 'home'])->name('homepage');
    Route::get('/category/{slug}', [IndexController::class, 'category'])->name('category');
    Route::get('/genre/{slug}', [IndexController::class, 'genre'])->name('genre');
    Route::get('/directors/{slug}', [IndexController::class, 'directors'])->name('directors');
    Route::get('/cast/{slug}', [IndexController::class, 'cast'])->name('cast');
    Route::get('/directors/{slug}', [IndexController::class, 'directors'])->name('directors');
    Route::get('/country/{slug}', [IndexController::class, 'country'])->name('country');
    Route::get('/movie/{slug}', [IndexController::class, 'movie'])->name('movie');
    Route::get('/xem-phim/{slug}/{tap}/{server_active}', [IndexController::class, 'watch']);
    Route::get('/episode', [IndexController::class, 'episode'])->name('episode');
    Route::get('/tim-kiem', [IndexController::class, 'timkiem'])->name('tim-kiem');
    Route::get('/nam/{year}', [IndexController::class, 'year']);
    Route::get('/tag/{tag}', [IndexController::class, 'tag']);
    Route::get('/loc-phim', [IndexController::class, 'locphim'])->name('locphim');
    Route::get('/my-list', [IndexController::class, 'my_list'])->name('my_list');
    Route::get('/my-recent', [IndexController::class, 'recent'])->name('my_recent');
    Route::post('/add-rating', [IndexController::class, 'add_rating'])->name('add-rating');
    Route::get('/all-movies', [IndexController::class, 'all_movies'])->name('all-movies');
});
Route::get('/policy', [IndexController::class, 'policy'])->name('policy');
//Route::get('/search', [IndexController::class, 'search'])->name('search');

//Auth::routes();

// route admin

Route::get('logout', [LoginController::class, 'logout']);

Auth::routes(['login' => false]);
Route::get('dashboard-signin', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('dashboard-signin', 'App\Http\Controllers\Auth\LoginController@login')->name('login');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/user-online', [HomeController::class, 'online'])->name('useronline');
    Route::resource('category', CategoryController::class);
    Route::resource('info-web', InfoWebController::class);
    //Route::resource('category', CategoryController::class);
    Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');
    Route::resource('genre', GenreController::class);
    Route::resource('country', CountryController::class);
    Route::resource('movie', MovieController::class);
    Route::resource('episode', EpisodeController::class);
    Route::resource('user', UserController::class);
    Route::get('shutdown', [MaintanceController::class, 'index'])->name('index');
    Route::get('shutdown-down', [MaintanceController::class, 'down'])->name('down');
    Route::get('shutdown-up', [MaintanceController::class, 'up'])->name('up');
    Route::resource('resume', ResumeController::class);
    Route::post('/uploadpage', [ResumeController::class, 'store']);
    Route::get('/show-resume', [ResumeController::class, 'show']);
    Route::get('/download/{file}', [ResumeController::class, 'download']);
    Route::get('/view-resume/{id}', [ResumeController::class, 'view']);
    Route::resource('server-movie', ServerController::class);
    Route::resource('directors', DirectorsController::class);
    Route::resource('cast', CastController::class);
    Route::resource('role', RoleController::class);
    Route::post('permissions', [RoleController::class, 'storePermissions'])->name('permissions');
    Route::get('/assign-permission', [AssignController::class, 'assignPermissions'])->name('assignpermission');
    Route::post('assignPermissionsToRole', [AssignController::class, 'assignPermissionsToRole'])->name('assignPermissionsToRole');
    Route::get('/user/assign-permission-user/{id}', [UserController::class, 'assign'])->name('assignpermissionuser');
    Route::post('assignPermissionsToUser/{id}', [UserController::class, 'updatePermission'])->name('assignPermissionsToUser');
    Route::get('/log', [TrackingController::class, 'index'])->name('log');
    Route::get('/log-error', [TrackingController::class, 'tracking_error'])->name('log-error');
    Route::resource('package', PackageController::class);
    Route::get('comments/comment', [ManageCommentController::class, 'index'])->name('manage-comment');
    Route::get('comments/reply', [ManageCommentController::class, 'reply'])->name('manage-reply');
    Route::get('customers', [UserController::class, 'listCustomer'])->name('listcustomer');
    Route::get('customers/order', [UserController::class, 'listOrder'])->name('listorder');
    Route::delete('destroy-customers/{id}', [UserController::class, 'destroy_customer'])->name('destroycustomer');
    Route::get('customers-status', [UserController::class, 'customer_status'])->name('customersstatus');
    Route::delete('delete-resume/{id}', [ResumeController::class, 'delete'])->name('delete_resume');

    Route::post('auto_create', [MovieController::class, 'auto_create'])->name('auto_create');
    Route::post('auto_update', [MovieController::class, 'auto_update_episode'])->name('auto_update_episode');
});
//route api
Route::get('get_api_ophim', [MovieController::class, 'get_api_ophim'])->name('get_api_ophim');

//route ajax

Route::get('select-role', [AssignController::class, 'select_role'])->name('select-role');
Route::get('select-movie', [EpisodeController::class, 'select_movie'])->name('select-movie');
Route::post('/update-season-phim', [MovieController::class, 'update_season']);
Route::get('/update-year-phim', [MovieController::class, 'update_year']);
Route::get('movie-hot', [MovieController::class, 'movie_hot'])->name('movie-hot-change');
Route::get('movie-status', [MovieController::class, 'movie_status'])->name('movie-status-change');
Route::get('comment-status', [ManageCommentController::class, 'comment_status'])->name('comment-status-change');
Route::get('reply-status', [ManageCommentController::class, 'reply_status'])->name('reply-status-change');
Route::post('/delete-comment', [CommentsController::class, 'destroy'])->name('delete-comment');
Route::post('/edit-comment', [CommentsController::class, 'edit'])->name('edit-comment');
Route::post('/update-imdb', [MovieController::class, 'update_imdb'])->name('update-imdb');
Route::get('/api/embed_vip', [EmbedController::class, 'embed_vip']);
Route::get('/api/embed_ads', [EmbedController::class, 'embed_ads']);
Route::get('/api/embed_m3u8', [EmbedController::class, 'embed_m3u8']);
Route::get('/site-map', function () {
    return Artisan::call('sitemap:create');
});
Route::get('/watch/{slug}', [IndexController::class, 'watches']);
// Clear application cache:

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    toastr()->success("Clear cache success.", 'Success');
    return redirect()->back();
});

Route::post('api/watch/{slug}/{tap}/{server_active}', [IndexController::class, 'ajax_episode']);
Route::get('api/watch/{slug}/{tap}/{server_active}', function(){
    return redirect('/');
});
// Route test link hls
Route::get('/stream', function () {
    return view('admincp.embed_video.hls');
});

// Route::get('/hls', function () {
//     return view('admincp.embed_video.hls');
// });
