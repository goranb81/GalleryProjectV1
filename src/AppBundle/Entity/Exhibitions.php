<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exhibitions
 *
 * @ORM\Table(name="exhibitions")
 * @ORM\Entity
 */
class Exhibitions
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime1", type="datetime", nullable=false)
     */
    private $datetime1;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set datetime1
     *
     * @param \DateTime $datetime1
     * @return Exhibitions
     */
    public function setDatetime1($datetime1)
    {
        $this->datetime1 = $datetime1;

        return $this;
    }

    /**
     * Get datetime1
     *
     * @return \DateTime 
     */
    public function getDatetime1()
    {
        return $this->datetime1;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Exhibitions
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Exhibitions
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
