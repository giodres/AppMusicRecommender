<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 24/11/15
 * Time: 21:41
 */
namespace ImpServiceLibrary;

use Infrastructure\MusicBuilderRepository;
use Library\MusicRepository;

class MusicServiceLibrary
{
    protected $_musicBuilderRepository;

    /**
     * @InjectParams({
     *    "_musicLibraryRepository" = @Inject("music.library.repository")
     * })
     */
    function __construct(MusicRepository $musicLibraryRepository)
    {
        $this->_musicLibraryRepository = $musicLibraryRepository;
    }

    public function getSongsByArtist($value)
    {
        return $this->_musicLibraryRepository->getSongsByArtist($value);
    }

    public function getSongsById($value)
    {
        return $this->_musicLibraryRepository->getSongById($value);
    }

    public function getSongsByNameStyle($value)
    {
        return $this->_musicLibraryRepository->getSongsByNameStyle($value);
    }




}