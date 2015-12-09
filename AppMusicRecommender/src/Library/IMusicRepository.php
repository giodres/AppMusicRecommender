<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 22/11/15
 * Time: 14:17
 */
namespace Library;

interface IMusicRepository
{

    public function searchSongs($value);

    public function searchTrack($id);

    public function getSongsByArtist($value);

    public function searchTrackWithArtist();

}