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

    public function getSongsByArtist($value, $results = 100);

    public function getSongsByNameStyle($value);

    public function getSongsByTitle($value, $results = 100);

    public function getAllGenres();

    public function getSongById($id);

    public function searchSongs($value, $results = 100);

    public function searchSongSimilarArtist($value, $results = 2);

    public function searchSongsByTitle($value = false, $results = 100);

    public function searchSongStyle($value);
    public function searchTrack($id);



}