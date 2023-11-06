<?php

namespace App\Http\Controllers;

use App\Models\Music_Quotes;
use App\Models\Playlists;
use AppHelper;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use function App\Helpers\dumps;
use function App\Helpers\dashboardViewEngine;
use function Symfony\Component\String\s;

class DashboardController extends Controller
{

    public SpotifyController $spotifyController;


    public function __construct()
    {
        $this->spotifyController = new SpotifyController();
    }

    public function index()
    {
        dashboardViewEngine('manage.global.manage');
    }

    public function getView($page)
    {
        $view = "manage." . $page;
        return view($view)->render();
    }

    public function getPlayLists($type)
    {
        if ($type == "spotify") {
            $result['spotifyResult'] = $this->spotifyController->getAllPlaylist();
            if (!isset($result['error'])) {
                foreach ($result['spotifyResult']->items as $r) {
                    $StringID = strval($r->id);
                    $funcCall = 'generatePlayList("' . $StringID . '")';
                    $data[] = array(
                        $r->name,
                        $r->tracks->total,
                        "<button type='button' onclick='$funcCall' class='btn btn-primary'>Generate</button>",

                    );
                }
            } else {
                $data = array();
            }
            $result = array(
                "data" => $data
            );

            echo json_encode($result);
            exit();
        } elseif ($type == "sentisong") {

            $result['sentisongResult'] = Playlists::where('user_id', Auth::id())->get();
            if (count($result['sentisongResult']) > 0) {
                foreach ($result['sentisongResult'] as $r) {
                    $songList = json_decode($r['ActiveSongs']);
                    $data[] = array(
                        $r->name,
                        count($songList),
                        "<button type='button' onclick='editPlayList($r->id)' class='btn btn-primary'>Edit</button>",

                    );
                }
            } else {
                $data = array();
            }
            $result = array(
                "data" => $data
            );

            echo json_encode($result);
            exit();
        }
    }

    public function getplayList($playlist)
    {
        $result['playlistResult'] = $this->spotifyController->getPlayList($playlist);
        if (!isset($result['error'])) {
            foreach ($result['playlistResult']->tracks->items as $r) {
                $time = $this->formatMilliseconds($r->track->duration_ms);
                $minute = explode(":", $time)[0];
                $seconds = explode(":", $time)[1];
                $mID = "idm-" . $r->track->id;
                $sID = "ids-" . $r->track->id;
                $data[] = array(
                    "<button type='button'class='btn btn-success addbtn'>Add</button>",
                    $r->track->name,
                    $r->track->artists[0]->name,
                    $r->track->album->name,
                    $time,
                    "<input id='$mID' type='number' value='0' min='0' max='$minute' class='form-control smallInput' placeholder='M'>:<input id='$sID' type='number' min='0' max='$seconds' value='0' class='form-control smallInput' placeholder='S'>" . "<button type='button'class='btn btn-success addbtn'>Try</button>",
                    $r->track->id,
                );
            }
        } else {
            $data = array();
        }
        $result = array(
            "data" => $data
        );

        echo json_encode($result);
        exit();
    }

    public function saveplaylist(Request $request){
        $results = $request->json()->all();

        $songIDS = array();

        foreach ($results[1] as $result){
            $inputJSON = array($result[6], $result[7], $result[8]);
            $songIDS[] = $inputJSON;
        }

        Playlists::create(
            [
                "user_id" => Auth::id(),
                "name" => $results[0],
                "ActiveSongs" => json_encode($songIDS)
            ]
        );

        return json_encode(array("status" => "success"));

    }

    public function init_spotify()
    {
        $this->spotifyController->authorize();
    }
    function formatMilliseconds($milliseconds) {
        $seconds = floor($milliseconds / 1000);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $milliseconds = $milliseconds % 1000;
        $seconds = $seconds % 60;
        $minutes = $minutes % 60;

        $format = '%u:%02u:%02u';
        $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
        return substr($time, 2);
    }

    public function callback()
    {
        $this->spotifyController->callback($_GET);
        return redirect(route("manage"));
    }

    public function getSpotifyStatus()
    {
        if ($this->spotifyController->testValid()) {
            $status = "connected";
        } else {
            $status = "error";
        }
        return json_encode(array("status" => $status));
    }

    public function getSpotifyInfo()
    {
        $data['AvailableDevices'] = $this->spotifyController->getAvailableDevices();
        $data['CurrentlyPlayingTrack'] = $this->spotifyController->getCurrentlyPlayingTrack();
        $data['CurrentUserProfile'] = $this->spotifyController->getCurrentUserProfile();



        return json_encode($data);
    }


}
