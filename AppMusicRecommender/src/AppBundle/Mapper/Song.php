<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 25/11/15
 * Time: 19:01
 */


namespace AppBundle\Mapper;

Use AppBundle\Mapper\Track;

class Song
{
    private $nameArtist;
    private $nameSong;
    private $track;

    function __construct($nameArtist, $nameSong, Track $track) {
        $this->nameArtist = $nameArtist;
        $this->track = $track;
        $this->nameSong = $nameSong;
    }

    public function getNameArtist() {
        return $this->nameArtist;
    }
    public function getNameSong() {
        return $this->nameSong;
    }
    public function getTrack() {
        return $this->track;
    }


}