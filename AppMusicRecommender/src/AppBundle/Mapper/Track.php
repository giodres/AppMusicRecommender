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
    private $previewUrl;

    public function __construct($releaseImage,$id,$previewUrl) {
        $this->id = $id;
        $this->previewUrl = $previewUrl;
        $this->releaseImage = $releaseImage;
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
}