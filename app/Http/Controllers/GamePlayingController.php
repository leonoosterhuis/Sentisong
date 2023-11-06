<?php


namespace App\Http\Controllers;

use App\Events\GameEnd;
use App\Events\GameEndRound;
use App\Events\GameNewRound;
use App\Models\Games;
use App\Models\GameScores;
use App\Models\RoundFillForm;
use Illuminate\Http\Request;

use function App\Helpers\dumps;


class GamePlayingController extends Controller
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

    public function playRound(Request $request)
    {
        $results = $request->json()->all();
        $gamePin = $results[0];
        $songID = $results[1];
        $songInfo = $this->spotifyController->getSongInformation($songID);
        $year = substr($songInfo->album->release_date, 0, 4);
        $artist = $songInfo->artists[0]->name;
        $track = $songInfo->name;
        $tumbnail = $songInfo->album->images[1]->url;

        $RoundFillForm = new RoundFillForm($year, $artist, $track, $tumbnail);
        event(new GameNewRound($gamePin, $RoundFillForm));
        return json_encode(array("status" => $this->spotifyController->changeTrack($songID, $results[2], $results[3])));
    }

    public function endRound()
    {
        $gamepin = session()->get("gamepin");
        event(new GameEndRound($gamepin));
        return json_encode(array("status" => "success"));
    }

    public function searchInSpotify(Request $request)
    {
        $results = $request->json()->all();
        $searchType = $results[0];
        $searchField = $results[1];
        $spotifyResult = $this->spotifyController->searchOnSpotify($searchType, $searchField);
        return json_encode(array($spotifyResult));
    }

    public function receiveUserScore(Request $request)
    {
        $results = $request->json()->all();
        $score = $results[0];

        $playerID = session()->get("playerID");
        $gamepin = session()->get("gamepin");
        $playerName = session()->get("playerName");

        $possibleResult = GameScores::where(["gamepin" => $gamepin, "player_id" => $playerID]);

        if (!$possibleResult->first()) {
            GameScores::insert(
                ["gamepin" => $gamepin, "player_id" => $playerID, "score" => $score, "player_name" => $playerName]
            );
        } else {
            $newScore = $possibleResult->value("score") + $score;
            GameScores::where(["gamepin" => $gamepin, "player_id" => $playerID])->update(["score" => $newScore]);
        }

        return json_encode(array("status" => "success"));
    }

    public function getPlayerScore()
    {

        $gamepin = session()->get("gamepin");
        $playerID = session()->get("playerID");
        $ranking = 0;


        $rankingResults = GameScores::where(["gamepin" => $gamepin])->orderBy('score', 'DESC')->get()->toArray();
        $rankingOff = count($rankingResults);
        foreach ($rankingResults as $key => $rankingItem) {
            if ($rankingItem['player_id'] == $playerID) {
                $ranking = $key + 1;
            }
        }

        $score = 0;
        $possibleResult = GameScores::where(["gamepin" => $gamepin, "player_id" => $playerID]);

        if ($possibleResult->first()) {
            $score = $possibleResult->value("score");
        }
        return json_encode(array("score" => $score, "ranking" => $ranking, "rankingOff" => $rankingOff));
    }

    public function getAllPLayerScores()
    {
        $gamepin = session()->get("gamepin");
        $rankingResults = GameScores::where(["gamepin" => $gamepin])->orderBy('score', 'DESC')->get()->toArray();
        $rankingList = array();
        foreach ($rankingResults as $key => $rankingItem) {
            $ranking = $key + 1;
            $rankingList[] = [
                "ranking" => $ranking,
                "player_id" => $rankingItem['player_id'],
                "score" => $rankingItem['score'],
                "player_name" => $rankingItem['player_name']
            ];
        }
        return json_encode(array("ranking" => $rankingList));
    }


    public function stopGame()
    {
        $gamepin = session()->get("gamepin");
        $status = GameController::check_game($gamepin);
        if (in_array($status, ["created", "started"])) {
            if (session()->has('gameSessionIDS')) //Setted if user is host
            {
                Games::where("gamepin", $gamepin)->update(["status" => "ended"]);
                event(new GameEnd($gamepin));
            }
        }
    }


}
