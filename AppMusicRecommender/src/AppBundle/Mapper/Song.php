<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 25/11/15
 * Time: 19:01
 */


namespace AppBundle\Mapper;

Use AppBundle\Mapper\Track;
use Symfony\Component\CssSelector\Exception\ExpressionErrorException;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Symfony\Component\Security\Acl\Exception\Exception;

class Song
{
    private $id;
    private $nameArtist;
    private $nameSong;
    private $duration;
    private $track;
    private $idArtist;
    private $genere;

    function __construct($params)
    {
        $this->id = $params['id'];
        $this->nameArtist = $params['artist_name'];
        $this->nameSong = $params['title'];
        $this->idArtist = $params['artist_name'];
        $this->duration = gmdate("i:s", $params['audio_summary']['duration']);
    }

    public function setTrack($track)
    {
        $this->track = $track;
    }

    public function getId()
    {
        return $this->id;
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

    public function getIdArtist()
    {
        return $this->idArtist;
    }

    public function getIdGenere()
    {
        return $this->genere;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function loadData()
    {
        try {
            $json = file_get_contents('http://developer.echonest.com/api/v4/artist/profile?api_key=MDORNCSRVVWZJVJFN&id=' . $this->idArtist . '&bucket=genre&format=json');

            $obj = json_decode($json);
            $this->genere = $obj->response->artist->genres[0];
        } catch (ContextErrorException $e) {
            $this->genere = 0;
        }
    }

}