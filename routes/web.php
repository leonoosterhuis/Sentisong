<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GamePlayingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StartController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', [StartController::class, 'index'])->name('/');

Route::middleware('auth')->group(function () {
    Route::get('/manage', [DashboardController::class, 'index'])->name('manage');
    Route::get('/manage/getView{view}', [DashboardController::class, 'getView'])->name('manage.getView');

    Route::get('/manage/getplaylists{type}', [DashboardController::class, 'getPlayLists'])->name('manage.getplaylists');
    Route::get('/manage/getplaylist{playlist}', [DashboardController::class, 'getplayList'])->name('manage.getplaylist');
    Route::post('/manage/playlist', [DashboardController::class, 'saveplaylist'])->name('manage.saveplaylist');

    Route::get('/manage/spotify_init', [DashboardController::class, 'init_spotify'])->name('manage.spotify_init');
    Route::get('/manage/spotify_init/callback', [DashboardController::class, 'callback'])->name('manage.spotify_init.callback');

    Route::get('/manage/spotify/check', [DashboardController::class, 'getSpotifyStatus'])->name('manage.spotify.check');
    Route::get('/manage/spotify/getData', [DashboardController::class, 'getSpotifyInfo'])->name('manage.spotify.getData');



    Route::get('/game/lobby/host', [GameController::class, 'lobby_host'])->name('game.lobby.host');




    Route::post('/game/add', [GameController::class, 'add_player_to_session'])->name('game.add.player');


    Route::get('/game/create', [GameController::class, 'create'])->name('game.create');
    Route::post('/game/create/post', [GameController::class, 'createSession'])->name('game.create.post');
    Route::get('/game/host', [GameController::class, 'inGame_host'])->name('game.ingame.host');


//In game
    Route::get('/game/ready', [GameController::class, 'gameRoomReady'])->name('game.ready');
    Route::get('/game/info', [GameController::class, 'getGameInfo'])->name('game.info');
    Route::post('/game/info/track', [GameController::class, 'getTrackInfoByIds'])->name('game.info.track');
//In game


//GamePlayingControls
    Route::put('/game/playRound', [GamePlayingController::class, 'playRound'])->name('game.control.playRound');
    Route::GET('/game/endRound', [GamePlayingController::class, 'endRound'])->name('game.control.endRound');

    Route::get('/game/allplayerResult', [GamePlayingController::class, 'getAllPLayerScores'])->name('game.allplayerresult');

    Route::get('/game/stop', [GamePlayingController::class, 'stopGame'])->name('game.stop');

});


Route::get('/game/join', [GameController::class, 'join'])->name('game.join');
Route::get('/game/playerResult', [GamePlayingController::class, 'getPlayerScore'])->name('game.playerresult');

Route::get('/game/getView{view}', [GameController::class, 'getView'])->name('game.getView');
Route::get('/game/lobby/player', [GameController::class, 'lobby_player'])->name('game.lobby.player');
Route::post('/game/join/post', [GameController::class, 'join_game'])->name('game.join.post');
Route::get('/game', [GameController::class, 'inGame_player'])->name('game.ingame.player');
Route::post('/game/result', [GamePlayingController::class, 'receiveUserScore'])->name('game.result');

Route::post('/game/store', [GameController::class, 'save_spotifyToken_User'])->name('game.store');
Route::post('/game/search', [GamePlayingController::class, 'searchInSpotify'])->name('game.search');



//Route::get('/dashboard', function () {
//    return view('dashboard');
//}))->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
