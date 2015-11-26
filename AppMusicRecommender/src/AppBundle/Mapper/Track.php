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

    public function __construct($params)
    {
        $this->id = $params['id'];
        $split = explode(":", $params['foreign_id']);
        $this->foreign_id = $split[2];
        $this->getData();
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

    public function getData()
    {
        $json = file_get_contents('https://api.spotify.com/v1/tracks/' . $this->foreign_id);
        $obj = json_decode($json);
        $this->releaseImage = $obj->album->images[0]->url;
        $this->previewUrl = $obj->preview_url;
    }
}