<?php


namespace Library;


use Echonest\Facade\Echonest;
use Echonest\Facade\EchonestSongs;
use Echonest\Facade\EchonestTracks;
use Symfony\Component\DependencyInjection\Container;

Class MusicRepository implements IMusicRepository
{
    private $params;
    private $apiMusic;
    Private $keyApi;
    private $SongsLibrary;
    private $TrackLibrary;

    public function __construct() {
        $this->params = new Container();
        $this->keyApi  = "MDORNCSRVVWZJVJFN";
        $this->apiMusic = Echonest::init($this->keyApi);
        $this->SongsLibrary = new EchonestSongs($this->apiMusic);
        $this->TrackLibrary = new EchonestTracks($this->apiMusic);
    }

    public function searchSongs($value) {

        $listSongs = $this->SongsLibrary->getArtistSongs($value)->get(null,true);

        return  $listSongs;
    }

    public function searchTrack($id) {

        $track = $this->TrackLibrary->getTrackProfile($id)->get();
        return  $track;
    }

    public function searchTrackWithArtist() {
        //http://developer.echonest.com/api/v4/song/search?api_key=MDORNCSRVVWZJVJFN&format=json&results=4&artist=cosculluela&bucket=id:7digital-US&bucket=audio_summary&bucket=tracks
    }


}