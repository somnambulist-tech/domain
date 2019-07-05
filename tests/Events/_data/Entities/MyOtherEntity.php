<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MyOtherEntity
 *
 * @ORM\Entity
 */
class MyOtherEntity
{

    /** @ORM\Id @ORM\Column(type="string", name="id") */
    protected $id;

    /** @ORM\@ManyToOne(targetEntity="MyEntity", cascade={"all"}) */
    protected $myEntity;

    /** @ORM\Column(type="string", name="name") */
    protected $name;

    /** @ORM\Column(type="string", name="another") */
    protected $another;

    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;

    /**
     * Constructor.
     *
     * @param MyEntity $myEntity
     * @param          $name
     * @param          $another
     * @param          $createdAt
     */
    public function __construct(MyEntity $myEntity, $name, $another, $createdAt)
    {
        $this->myEntity  = $myEntity;
        $this->name      = $name;
        $this->another   = $another;
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getAnother()
    {
        return $this->another;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
