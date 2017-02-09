<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videos
 *
 * @ORM\Table(name="videos")
 * @ORM\Entity
 */
class Videos
{
    /**
     * @var string
     *
     * @ORM\Column(name="guest", type="string", length=70, nullable=false)
     */
    private $guest;

    /**
     * @var string
     *
     * @ORM\Column(name="video_id", type="string", length=100, nullable=false)
     */
    private $videoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set guest
     *
     * @param string $guest
     * @return Videos
     */
    public function setGuest($guest)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get guest
     *
     * @return string 
     */
    public function getGuest()
    {
        return $this->guest;
    }

    /**
     * Set videoId
     *
     * @param string $videoId
     * @return Videos
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get videoId
     *
     * @return string 
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
