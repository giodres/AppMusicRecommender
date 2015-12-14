<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 22/11/15
 * Time: 17:34
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="Activity")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ActivityRepository")
 */
class Activity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="activities")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idSong;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idSinger;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idGenere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idAlbum;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;


    public function __construct($user, $idSong, $idSinger, $idAlbum, $idGenere)
    {
        $this->dateCreated = new \DateTime('now');
        $this->user = $user;
        $this->idSong = $idSong;
        $this->idSinger = $idSinger;
        $this->idAlbum = $idAlbum;
        $this->idGenere = $idGenere;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdSong()
    {
        return $this->idSong;
    }

    public function setIdSong($id)
    {
        $this->idSong = $id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getIdSinger()
    {
        return $this->idSinger;
    }

    public function setIdSinger($idSinger)
    {
        $this->idSinger = $idSinger;
    }

    public function getIdGenere()
    {
        return $this->idGenere;
    }

    public function setIdGenere($idGenere)
    {
        $this->idGenere = $idGenere;
    }

    public function getIdAlbum()
    {
        return $this->idAlbum;
    }

    public function setIdAlbum($idAlbum)
    {
        $this->idAlbum = $idAlbum;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated)
    {
        return $this->dateCreated = $dateCreated;
    }



}