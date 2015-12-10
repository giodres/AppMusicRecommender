<?php


namespace Library;


use Echonest\Facade\Echonest;
use Echonest\Facade\EchonestGenres;
use Echonest\Facade\EchonestSongs;
use Echonest\Facade\EchonestTracks;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Mapper\Song;
use AppBundle\Mapper\Track;

Class MusicRepository implements IMusicRepository
{
    private $params;
    private $apiMusic;
    Private $keyApi;
    private $SongsLibrary;
    private $TrackLibrary;
    private $GenresLibrary;

    public function __construct() {
        $this->params = new Container();
        $this->keyApi  = "MDORNCSRVVWZJVJFN";
        $this->apiMusic = Echonest::init($this->keyApi);
        $this->SongsLibrary = new EchonestSongs($this->apiMusic);
        $this->TrackLibrary = new EchonestTracks($this->apiMusic);
        $this->GenresLibrary = new EchonestGenres($this->apiMusic);
    }

    public function searchSongs($value) {

        $listSongs = $this->SongsLibrary->getArtistSongs($value)->get(null,true);
        return  $listSongs;
    }

    public function searchSongStyle($value)
    {

        $listSongs = $this->SongsLibrary->searchSongStyle($value)->get(null, true);

        return $listSongs;
    }

    public function searchTrack($id) {

        $track = $this->TrackLibrary->getTrackProfile($id)->get();
        return  $track;
    }

    public function getSongById($id)
    {

        $song = $this->SongsLibrary->getSongProfile($id)->get(null, true);
        return new Song($song['songs'][0]);
    }


    public function getSongsByArtist($value)
    {
        $songTrack = array();
        $songs = $this->searchSongs($value);
        foreach ($songs['songs'] as $rot) {
            if (count($rot['tracks']) == 0) continue;
            $track = Track::constructTrack($rot['tracks'][0]);
            $rotSong = new Song($rot);
            $rotSong->setTrack($track);
            $songTrack[] = $rotSong;
        }
        return $songTrack;
    }

    public function getSongsByNameStyle($value)
    {
        $songTrack = array();
        $songs = $this->searchSongStyle($value);
        foreach ($songs['songs'] as $rot) {
            if (count($rot['tracks']) == 0) continue;
            $track = Track::constructTrack($rot['tracks'][0]);
            $rotSong = new Song($rot);
            $rotSong->setTrack($track);
            $songTrack[] = $rotSong;
        }
        return $songTrack;

    }

    public function getAllGenres()
    {
        return $this->GenresLibrary->getList()->get();
    }

    public function searchTrackWithArtist() {
        //http://developer.echonest.com/api/v4/song/search?api_key=MDORNCSRVVWZJVJFN&format=json&results=4&artist=cosculluela&bucket=id:7digital-US&bucket=audio_summary&bucket=tracks
    }


}