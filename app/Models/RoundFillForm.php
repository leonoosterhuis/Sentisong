<?php

namespace App\Models;


class RoundFillForm
{

    public $correctYear = "";
    public $correctArtist = "";
    public $correctTrack = "";

    public $tumbnail = "";

    /**
     * @param string $correctYear
     * @param string $correctArtist
     * @param string $correctTrack
     * @param string $tumbnail
     */
    public function __construct(string $correctYear, string $correctArtist, string $correctTrack, string $tumbnail)
    {
        $this->correctYear = $correctYear;
        $this->correctArtist = $correctArtist;
        $this->correctTrack = $correctTrack;
        $this->tumbnail = $tumbnail;
    }


}
