<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

use function App\Helpers\dumps;

class SpotifyController
{
    private string $client_id = "dd1625b26a594f38aa5b8c7f4dab4986";
    private string $client_secret = "c6f67ffcaffc41da94412c090e82cc1d";


    private function getCallback()
    {
        if (App::environment('local')) {
            return "http://localhost:8000";
        }
        if (App::environment('production')) {
            return "https://sentisong.nl";
        }
    }

    public function authorize($js = true)
    {
        $url = "https://accounts.spotify.com/authorize?";
        $response_type = "code";
        $redirect_uri = $this->getCallback() . "/manage/spotify_init/callback";
        $scope = 'user-read-playback-state user-modify-playback-state user-read-currently-playing
        user-read-currently-playing streaming playlist-read-private playlist-read-collaborative playlist-modify-private
        playlist-modify-public user-follow-modify user-follow-read user-read-playback-position
        user-top-read user-read-recently-played user-library-modify user-library-read user-read-email user-read-private';

        $fullURI = $url . "response_type=" . $response_type . "&client_id=" . $this->client_id . "&scope=" . $scope . "&redirect_uri=" . $redirect_uri;
        if ($js) {
            echo $fullURI;
        } else {
            return ($fullURI);
        }
    }

    private function refreshToken(): bool
    {
        $curl = curl_init();
        $refresh_token = session()->get("spotify.refresh_token");
        $base64 = $this->getApplicationAuth();
        if (!isset($refresh_token)) {
            return false;
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://accounts.spotify.com/api/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=' . $refresh_token,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $base64,
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $stdConvert = json_decode($response);
        if (!isset($stdConvert->access_token)) {
            return false;
        }
        session()->put("spotify.access_token", $stdConvert->access_token);
        session()->put("spotify.expires_in", $this->calculateExpireTime($stdConvert->expires_in));
        return true;
    }

    private function calculateExpireTime($seconds)
    {
        return date('H:i', strtotime('+15 minutes'));
    }

    public function callback($callback): bool
    {
        if (isset($callback['error'])) {
            return false;
        } elseif (isset($callback['code'])) {
            return $this->getAccessToken($callback['code']);
        } else {
            return false;
        }
    }

    private function getApplicationAuth()
    {
        return "Basic " . base64_encode($this->client_id . ':' . $this->client_secret);
    }

    public function getUserAuth()
    {
        $UserAccessCode = session()->get("spotify.access_token");
        return "Bearer {$UserAccessCode}";
    }

    public function getSongInformation($songID)
    {
        $endpoint = "tracks/{$songID}";
        return $this->makeGETRequest($endpoint);
    }

    public function getMySpotifyID()
    {
        if (session()->get("spotify.id") !== null) {
            return session()->get("spotify.id");
        }
        $me = $this->getCurrentUserProfile();
        session()->put("spotify.id", $me->id);
        return $me->id;
    }

    public function getAllPlaylist()
    {
        $spotifyID = $this->getMySpotifyID();
        $endpoint = "users/{$spotifyID}/playlists";
        return $this->makeGETRequest($endpoint);
    }

    public function getPlayList($playListID)
    {
        $endpoint = "playlists/{$playListID}";
        return $this->makeGETRequest($endpoint);
    }


    public function getPlayBackState()
    {
        $endpoint = "me/player";
        return $this->makeGETRequest($endpoint);
    }

    public function testValid()
    {
        $endpoint = "me/player";
        $result = $this->makeGETRequest($endpoint, false);
        if (isset($result->error)) {
            $this->refreshToken();
            $result = $this->makeGETRequest($endpoint, false);
            if (isset($result->error)) {
                return false;
            }
        }
        return true;
    }

    public function changeTrack($songID, $minute, $seconds)
    {
        $track = "spotify:track:{$songID}";
        $milliseconds = 0;
        $milliseconds += ($minute * 60000);
        $milliseconds += ($seconds * 1000);
        $songJSON = json_encode(array("uris" => array($track), "position_ms" => $milliseconds));
        $this->testValid();


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.spotify.com/v1/me/player/play',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $songJSON,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->getUserAuth(),
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function searchOnSpotify($type, $search){
        $endpoint = "search?q={$search}&type={$type}&limit=5";
        return $this->makeGETRequest($endpoint);
    }


    public function getAvailableDevices()
    {
        $endpoint = "me/player/devices";
        return $this->makeGETRequest($endpoint);
    }

    public function getCurrentlyPlayingTrack()
    {
        $endpoint = "me/player/currently-playing";
        return $this->makeGETRequest($endpoint);
    }

    public function getCurrentUserProfile()
    {
        $endpoint = "me";
        return $this->makeGETRequest($endpoint);
    }


    private function makeGETRequest($endPoint, $check = true)
    {
        if ($check) {
            $this->testValid();
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.spotify.com/v1/' . $endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->getUserAuth(),
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }


    private function getAccessToken($code)
    {
        $callbackURI = $this->getCallback() . "/manage/spotify_init/callback";
        $base64 = $this->getApplicationAuth();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://accounts.spotify.com/api/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code=' . $code . '&redirect_uri=' . $callbackURI,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $base64,
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));


        $response = curl_exec($curl);
        curl_close($curl);

        $stdConvert = json_decode($response);
        if (!isset($stdConvert->access_token)) {
            return false;
        }
        session()->put("spotify.access_token", $stdConvert->access_token);
        session()->put("spotify.expires_in", $this->calculateExpireTime($stdConvert->expires_in));
        session()->put("spotify.refresh_token", $stdConvert->refresh_token);
        return true;
    }
}




