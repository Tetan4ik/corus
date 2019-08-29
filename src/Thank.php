<?php

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="thank")
 */
Class Thank{

    /**
     * @id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="userFromId", referencedColumnName="id")
     */
    protected $userFromId;

    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="userToId", referencedColumnName="id")
     */
    protected $userToId;

    /**
     * @OneToOne(targetEntity="User")
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $date;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserFromId()
    {
        return $this->userFromId;
    }

    /**
     * @param mixed $userFromId
     */
    public function setUserFromId($userFromId)
    {
        $this->userFromId = $userFromId;
    }

    /**
     * @return mixed
     */
    public function getUserToId()
    {
        return $this->userToId;
    }

    /**
     * @param mixed $userToId
     */
    public function setUserToId($userToId)
    {
        $this->userToId = $userToId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }



}
