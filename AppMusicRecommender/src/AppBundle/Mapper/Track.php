<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 25/11/15
 * Time: 20:40
 */

namespace AppBundle\Mapper;


class Track
{
    private $releaseImage;
    private $id;
    private $foreign_id;
    private $previewUrl;
    private $idAlbum;
    private $nameAlbum;


    public function __construct()
    {

    }


    public static function constructTrack($params)
    {
        $instance = new self();
        $instance->id = $params['id'];
        $split = explode(":", $params['foreign_id']);
        $instance->foreign_id = $split[2];
        return $instance;
    }

    public static function createTrack($id)
    {
        $instance = new self();
        $instance->foreign_id = $id;
        return $instance;
    }

    public function getReleaseImage(){
        return $this->releaseImage;
    }

    public function getId(){
        return $this->id;
    }

    public function getPreviewUrl(){
        return $this->previewUrl;
    }

    public function getForeignId()
    {
        return $this->foreign_id;
    }

    public function getIdAlbum()
    {
        return $this->idAlbum;
    }

    public function getNameAlbum()
    {
        return $this->nameAlbum;
    }

    public function getData()
    {
        $json = file_get_contents('https://api.spotify.com/v1/tracks/' . $this->foreign_id);
        $obj = json_decode($json);
        $this->releaseImage = $obj->album->images[0]->url;
        $this->previewUrl = $obj->preview_url;
        $this->nameAlbum = $obj->album->name;
        $split = explode(":", $obj->uri);
        $this->idAlbum = $split[2];
    }
}