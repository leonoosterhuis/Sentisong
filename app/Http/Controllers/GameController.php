<?php

namespace App\Http\Controllers;

use App\Events\Game_joined;
use App\Events\GameJoin;
use App\Events\GameReady;
use App\Events\GameStart;
use App\Models\Games;
use App\Models\Music_Quotes;
use App\Models\Playlists;
use AppHelper;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Event;

use function App\Helpers\dumps;
use function App\Helpers\dashboardViewEngine;
use function App\Helpers\gameHostViewEngine;
use function Symfony\Component\String\s;

class GameController extends Controller
{


    public SpotifyController $spotifyController;


    public function __construct()
    {
        $this->spotifyController = new SpotifyController();
    }

    public function getView($page)
    {
        $view = "Game." . $page;
        return view($view)->render();
    }

    public function join()
    {
        $data['view'] = "Player.lobby.join";
        $data['gamepin'] = "";
        gameHostViewEngine("Game.Player.lobby.base", $data);
    }

    public function lobby_player()
    {
        $gamepin = session()->get("gamepin");


        if ($gamepin !== null) {
            $status = $this->check_game($gamepin);
            if ($status === "started") {
                return redirect(route("game.ingame.player"));
            } elseif ($status === "created") {
                $data['view'] = "Player.lobby.lobby_player";
                $data['gamepin'] = $gamepin;
                gameHostViewEngine("Game.Player.lobby.base", $data);
            } else {
                return redirect(route("game.join"));
            }
        } else {
            return redirect(route("game.join"));
        }
    }

    public function lobby_host()
    {
        $gamepin = session()->get("gamepin");
        if (session()->has('spotify.access_token')) {
            if ($gamepin !== null) {
                $status = $this->check_game($gamepin);
                if ($status === "started") {
                    return redirect(route("game.ingame.host"));
                } elseif ($status === "created") {
                    if (session()->has('gameSessionIDS')) //Setted if user is host
                    {
                        $data['view'] = "Host.lobby.lobby_host";
                        $data['gamepin'] = $gamepin;
                        gameHostViewEngine("Game.Host.lobby.base", $data);
                    } else {
                        return redirect(route("game.lobby.player"));
                    }
                }
            } else {
                return redirect(route("game.lobby.player"));
            }
        } else {
            return redirect(route("manage"));
        }
    }

    public function getGameInfo()
    {
        $gameInfo = Games::where("gamepin", session()->get("gamepin"))->first();
        $playListSongs = Playlists::where("id", $gameInfo->playlist_id)->first();

        return json_encode(array($gameInfo, $playListSongs));
    }

    public function getTrackInfoByIds(Request $request)
    {
        $results = $request->json()->all()[0];

        $newList = array();
        foreach (json_decode($results) as $songID) {
            $apiResult = $this->spotifyController->getSongInformation($songID[0]);
            $compressedResult = array($apiResult->name, $apiResult->id, $songID[1], $songID[2]);
            $newList[] = $compressedResult;
        }
        return json_encode($newList);
    }

    public function create()
    {
        if (session()->has('spotify.access_token')) {
            $data['gamepin'] = "";
            $data['view'] = "Host.lobby.create";
            gameHostViewEngine("Game.Host.lobby.base", $data);
        } else {
            return redirect(route("manage"));
        }
    }

    public function createSession(Request $request)
    {
        $gamepin = $this->createRandomString();
        $results = $request->json()->all();
        $playListID = Playlists::select('id')->where(["user_id" => Auth::id(), "name" => $results[0]])->get()[0]->id;
        session()->put("gamepin", $gamepin);
        session()->put("gameSessionIDS", []);

        Games::create(
            [
                "gamepin" => $gamepin,
                "user_id" => Auth::id(),
                "playlist_id" => $playListID,
                "gm" => $results[1],
                "tips" => $results[2],
                "status" => "created"
            ]
        );

//        event(new GameJoin($gamepin));
        return $gamepin;
    }

    public static function check_game(string $gamepin)
    {
        $game = Games::select('id', "status")->where("gamepin", $gamepin)->get();
        if (count($game) > 0) {
            return $game->value("status");
        } else {
            return "invalid";
        }
    }

    public function join_game(Request $request)
    {
        $result = $request->json()->all()[0];
        $game = Games::select('id')->where("gamepin", $result)->get();
        if (count($game) > 0) {
            $result = $request->json()->all();
            $playerID = $this->createRandomString(false);
            session()->put("gamepin", $result[0]);
            session()->put("playerName", $result[1]);
            session()->put("playerID", $playerID);
            event(new GameJoin($result[0], $result[1], $playerID));
            return json_encode(array("status" => "success"));
        } else {
            return json_encode(array("status" => "error"));
        }
    }

    public function add_player_to_session(Request $request)
    {
        $result = $request->json()->all();
        session()->put("gameSessionIDS", $result);
        return json_encode(array("status" => "success"));
    }

    public function save_spotifyToken_User(Request $request)
    {
        $result = $request->json()->all();
        session()->put("spotify.access_token", $result[0]);
        session()->put("spotify.refresh_token", $result[1]);
        return json_encode(array("status" => "success"));
    }

    public function inGame_player()
    {
        $gamepin = session()->get("gamepin");
        if ($gamepin !== null) {
            $status = $this->check_game($gamepin);

            if (in_array($status, ["created", "started"])) {
                $data['gamepin'] = session()->get("gamepin");
                event(new GameReady($data['gamepin'], session()->get("playerID"), session()->get("playerName")));
                gameHostViewEngine("Game.Player.game.base", $data);
            } else { //Game not found or ended
                return redirect(route("game.join"));
            }
        } else {
            return redirect(route("game.join"));
        }
    }

    public function inGame_host()
    {
        $gamepin = session()->get("gamepin");
        if (session()->has('spotify.access_token')) {
            if ($gamepin !== null) {
                $status = $this->check_game($gamepin);
                if (in_array($status, ["created", "started"])) {
                    if (session()->has('gameSessionIDS')) //Setted if user is host
                    {
                        $data['gamepin'] = session()->get("gamepin");
                        gameHostViewEngine("Game.Host.game.base", $data);
                    } else {
                        return redirect(route("game.ingame.player")); //geen host
                    }
                } else { //Game not found or ended
                    return redirect(route("game.join"));
                }
            } else {
                return redirect(route("game.join"));
            }
        } else {
            return redirect(route("game.lobby.player"));
        }
    }

    public
    function gameRoomReady()
    {
        $gamepin = session()->get("gamepin");
        $status = $this->check_game($gamepin);

        if (in_array($status, ["created"])) {
            Games::where("gamepin", $gamepin)->update(["status" => "started"]);
            event(
                new GameStart(
                    $gamepin,
                    $this->spotifyController->getUserAuth(),
                    session()->get("spotify.refresh_token")
                )
            );
        }
        return json_encode(session()->get("gameSessionIDS"));
    }

    function createRandomString($gamePin = true)
    {
        $characters = '123456789ABCDEFGHJKMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        if ($gamePin) {
            for ($i = 0; $i < 3; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
            $randomString .= "-";
            for ($i = 0; $i < 3; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
        } else {
            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
        }
        return $randomString;
    }
}
