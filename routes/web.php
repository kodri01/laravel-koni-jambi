<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\AwardsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AtletsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\RegisterAtlet;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ClubsController;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\CaborController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\InfoClubController;
use App\Http\Controllers\Laporan;
use App\Http\Controllers\LaporanController;

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

// Route::get('/', [FrontendController::class, 'index'])->name('login');
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/tologin', [LoginController::class, 'login'])->name('tologin');

Route::get('register', [RegisterAtlet::class, 'index'])->name('register.atlet');
Route::post('register/add', [RegisterAtlet::class, 'add'])->name('register.add');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['permission:dashboards']], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dasboard/event/{slug}', [DashboardController::class, 'eventview']);
        Route::get('dasboard/game/{slug}', [DashboardController::class, 'gameview']);
        Route::get('dasboard/award/{slug}', [DashboardController::class, 'awardview']);
        Route::get('dashboard/joinClub/{slug}', [DashboardController::class, 'joinclub']);
        Route::post('dashboard/joinClub/{slug}/insert', [DashboardController::class, 'joinclubInsert']);
    });

    Route::group(['middleware' => 'role:superadmin'], function () {
        Route::group(['middleware' => ['permission:admins-list|admins-create|admins-edit|admins-delete']], function () {
            Route::get('admins', [UsersController::class, 'index'])->name('admins');
            Route::get('admins/add', [UsersController::class, 'create'])->name('admins.add');
            Route::post('admins/insert', [UsersController::class, 'store'])->name('admins.insert');
            Route::get('admins/{id}/edit', [UsersController::class, 'show'])->name('admins.show');
            Route::put('admins/{id}/update', [UsersController::class, 'update'])->name('admins.update');
            Route::get('admins/{id}/delete', [UsersController::class, 'destroy'])->name('admins.delete');
        });

        Route::group(['middleware' => ['permission:roles-list|roles-create|roles-edit|roles-delete']], function () {
            Route::get('roles', [RolesController::class, 'index'])->name('roles');
            Route::get('roles/add', [RolesController::class, 'create'])->name('roles.add');
            Route::post('roles/insert', [RolesController::class, 'store'])->name('roles.insert');
            Route::get('roles/{id}/edit', [RolesController::class, 'show'])->name('roles.show');
            Route::put('roles/{id}/update', [RolesController::class, 'update'])->name('roles.update');
            Route::get('roles/{id}/delete', [RolesController::class, 'destroy'])->name('roles.delete');
        });
    });

    Route::group(['middleware' => ['permission:events-list|events-create|events-edit|events-delete']], function () {
        Route::resource('events', EventsController::class);
    });

    Route::group(['middleware' => ['permission:news-list|news-create|news-edit|news-delete']], function () {
        Route::resource('news', NewsController::class);
    });

    Route::group(['middleware' => ['permission:games-list|games-create|games-edit|games-delete']], function () {
        Route::get('games', [GamesController::class, 'index'])->name('games');
        Route::get('games/add', [GamesController::class, 'create'])->name('games.add');
        Route::post('games/insert', [GamesController::class, 'store'])->name('games.insert');
        Route::get('games/{id}/edit', [GamesController::class, 'show'])->name('games.show');
        Route::put('games/{id}/update', [GamesController::class, 'update'])->name('games.update');
        Route::get('games/{id}/delete', [GamesController::class, 'destroy'])->name('games.delete');
    });

    Route::group(['middleware' => ['permission:atlets-list|atlets-create|atlets-edit|atlets-delete']], function () {
        Route::get('clubs/{club_id}/atlets/mail', [AtletsController::class, 'mail']);
        Route::post('clubs/{club_id}/atlets/mailsend', [AtletsController::class, 'sendmail']);

        Route::get('clubs/{club_id}/atlets/select', [AtletsController::class, 'selectatlet']);
        Route::post('clubs/{club_id}/atlets/selectadd', [AtletsController::class, 'directjoin']);

        Route::get('clubs/{club_id}/atlets/request', [AtletsController::class, 'requestatlet']);
        Route::post('clubs/{club_id}/atlets/request/approve/{id}', [AtletsController::class, 'requestatletapprove']);
        Route::post('clubs/{club_id}/atlets/request/delete/{id}', [AtletsController::class, 'requestatletdelete']);

        Route::get('clubs/{club_id}/atlets', [AtletsController::class, 'index']);
        Route::get('clubs/{club_id}/atlets/create', [AtletsController::class, 'create']);
        Route::post('clubs/{club_id}/atlets/store', [AtletsController::class, 'store']);
        Route::get('clubs/{club_id}/atlets/edit/{id}', [AtletsController::class, 'edit']);
        Route::put('clubs/{club_id}/atlets/update/{id}', [AtletsController::class, 'update']);
        Route::delete('clubs/{club_id}/atlets/delete/{id}', [AtletsController::class, 'destroy']);
    });

    Route::group(['middleware' => ['permission:teams-list|teams-create|teams-edit|teams-delete']], function () {
        Route::get('clubs/{club_id}/teams', [TeamsController::class, 'index']);
        Route::get('clubs/{club_id}/teams/create', [TeamsController::class, 'create']);
        Route::post('clubs/{club_id}/teams/store', [TeamsController::class, 'store']);
        Route::get('clubs/{club_id}/teams/edit/{id}', [TeamsController::class, 'edit']);
        Route::put('clubs/{club_id}/teams/update/{id}', [TeamsController::class, 'update']);
        Route::delete('clubs/{club_id}/teams/delete/{id}', [TeamsController::class, 'destroy']);
    });

    Route::group(['middleware' => ['permission:awards-list|awards-create|awards-edit|awards-delete']], function () {
        Route::resource('awards', AwardsController::class);
    });

    Route::group(['middleware' => ['permission:clubs-list|clubs-create|clubs-edit|clubs-delete']], function () {
        Route::resource('clubs', ClubsController::class);
    });
    Route::group(['middleware' => ['permission:organizations-event-list|organizations-event-create|organizations-event-edit|organizations-event-delete']], function () {
        Route::get('organizations/{idorg}/event', [PelatihController::class, 'eventindex']);
        Route::get('organizations/{idorg}/event/create', [PelatihController::class, 'eventcreate']);
        Route::get('organizations/{idorg}/event/edit/{id}', [PelatihController::class, 'eventedit']);
        Route::post('organizations/{idorg}/event/store', [PelatihController::class, 'eventstore']);
        Route::put('organizations/{idorg}/event/update/{id}', [PelatihController::class, 'eventupdate']);
        Route::delete('organizations/{idorg}/event/delete/{id}', [PelatihController::class, 'eventdestroy']);
    });

    Route::group(['middleware' => ['permission:pelatih-list|pelatih-create|pelatih-edit|pelatih-delete']], function () {
        Route::get('clubs/{club_id}/pelatih', [PelatihController::class, 'index']);
        Route::get('clubs/{club_id}/pelatih/create', [PelatihController::class, 'create']);
        Route::post('clubs/{club_id}/pelatih/store', [PelatihController::class, 'store']);
        Route::get('clubs/{club_id}/pelatih/edit/{id}', [PelatihController::class, 'edit']);
        Route::put('clubs/{club_id}/pelatih/update/{id}', [PelatihController::class, 'update']);
        Route::delete('clubs/{club_id}/pelatih/delete/{id}', [PelatihController::class, 'destroy']);
    });

    Route::get('profile', [ProfilesController::class, 'index'])->name('profile.show');
    Route::put('profile/{id}/update', [ProfilesController::class, 'update'])->name('profile.update');
    Route::group(['middleware' => 'role:superadmin'], function () {
        Route::resource('cabors', CaborController::class);
    });
    Route::get('infoclub', [InfoClubController::class, 'index']);
    Route::group(['middleware' => ['permission:laporan-list|laporan-create|laporan-edit|laporan-delete']], function () {
        Route::resource('laporan', LaporanController::class);
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/search', [LaporanController::class, 'index'])->name('laporan.search');
        Route::get('/print/{id}/atlet', [LaporanController::class, 'card_atlet'])->name('print.atlet');
        Route::get('/print/{id}/pelatih', [LaporanController::class, 'card_pelatih'])->name('print.pelatih');
    });

    Route::get('/export/atlet', [ExcelController::class, 'exportAtlet']);
    Route::get('/export/team', [ExcelController::class, 'exportTeam']);
    Route::get('/export/pelatih', [ExcelController::class, 'exportPelatih']);
});
