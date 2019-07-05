<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class MyEntity
 *
 * @ORM\Entity
 */
class MyEntity implements \Somnambulist\Domain\Events\Contracts\RaisesDomainEvents
{

    use \Somnambulist\Domain\Events\Traits\RaisesDomainEvents;

    /** @ORM\Id @ORM\Column(type="string", name="id") */
    protected $id;

    /** @ORM\Column(type="string", name="name") */
    protected $name;

    /** @ORM\Column(type="string", name="another") */
    protected $another;

    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;

    /** @ORM\OneToMany(targetEntity="MyOtherEntity", mappedBy="myEntity", cascade={"persist", "remove", "merge"}, orphanRemoval=true) */
    protected $related;

    /**
     * Constructor.
     *
     * @param $id
     * @param $name
     * @param $another
     * @param $createdAt
     */
    public function __construct($id, $name, $another, $createdAt)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->another   = $another;
        $this->createdAt = $createdAt;
        $this->related   = new ArrayCollection();

        $this->raise(new MyEntityCreatedEvent(['id' => $id, 'name' => $name, 'another' => $another]));
    }

    public function updateName($name)
    {
        $this->name = $name;

        $this->raise(new MyEntityNameUpdatedEvent(['id' => $this->id, 'new' => $name, 'previous' => $this->name]));
    }

    public function addRelated($name, $another, $createdAt)
    {
        $this->related->add(new MyOtherEntity($this, $name, $another, $createdAt));

        $this->raise(new MyEntityAddedAnotherEntity([
            'id'    => $this->id,
            'name'  => $this->name,
            'other' => [
                'name'       => $name,
                'another'    => $another,
                'created_at' => $createdAt,
            ],
        ]));
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

    /**
     * @return ArrayCollection
     */
    public function getRelated()
    {
        return $this->related;
    }
}
