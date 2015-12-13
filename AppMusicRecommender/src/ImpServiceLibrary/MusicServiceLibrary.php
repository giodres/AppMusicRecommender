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

    public function getSongsByArtist($value, $results = 100)
    {
        return $this->_musicLibraryRepository->getSongsByArtist($value, $results);
    }

    public function getSongsByTitle($value = false, $results = 100)
    {
        return $this->_musicLibraryRepository->getSongsByTitle($value, $results);
    }

    public function getSongBySimilarArtist($value = false, $results = 2)
    {
        $_songs = array();
        $artist = $this->_musicLibraryRepository->searchSongSimilarArtist($value, $results);

        foreach ($artist['artists'] as $row) {
            $_songs = array_merge($_songs, $this->getSongsByArtist($row['name'], 5));
        }
        return $_songs;
    }


    public function getSongsById($value)
    {
        return $this->_musicLibraryRepository->getSongById($value);
    }

    public function getSongsByNameStyle($value)
    {
        return $this->_musicLibraryRepository->getSongsByNameStyle($value);
    }

    public function getAllGenres()
    {
        return $this->_musicLibraryRepository->getAllGenres();
    }




}