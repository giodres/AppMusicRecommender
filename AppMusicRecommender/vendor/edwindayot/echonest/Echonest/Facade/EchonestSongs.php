<?php
/**
 * EchonestSongs Facade
 */

namespace Echonest\Facade;


use Echonest\QueryBuilder;

class EchonestSongs extends Echonest {

    /**
     * Query Builder
     *
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * Construct
     *
     * @param $api_key
     * @param $remote
     */
    public function __construct(Echonest $echonest)
    {
        $this->queryBuilder = new QueryBuilder($echonest->api_key, $echonest->remote);
        $this->queryBuilder->setApi('song');
    }

    /**
     * Get Artist songs
     *
     * @param string $name
     * @return $this
     */
    public function getArtistSongs($name)
    {
        return $this->queryBuilder
            ->setCommand('search')
            ->setOption('artist', $name)
            ->setOption('results', '100')
            ->setOption('bucket', 'tracks')
            ->setOption('sort', 'song_hotttnesss-desc');
    }

    /**
     * Search songs by name or not
     *
     * @param bool $title
     * @return $this
     */
    public function searchSongs($title = false)
    {
        $query = $this->queryBuilder
            ->setCommand('search')
            ->setOption('results', '100')
            ->setOption('bucket', 'tracks')
            ->setOption('sort', 'song_hotttnesss-desc');

        if ($title) {
            $query->setOption('title', $title);
        }

        return $query;
    }

    public function searchSongStyle($style = false, $title = false)
    {
        $query = $this->queryBuilder
            ->setCommand('search')
            ->setOption('results', '100')
            ->setOption('bucket', 'tracks')
            ->setOption('sort', 'song_hotttnesss-desc');
        if ($style) {
            $query->setOption('style', $style);
        }
        if ($title) {
            $query->setOption('title', $title);
        }
        return $query;
    }

    /**
     * Get Song Profile
     *
     * @param $id
     * @return $this
     */
    public function getSongProfile($id)
    {
        return $this->queryBuilder
            ->setCommand('profile')
            ->setOption('id', $id);

    }
}