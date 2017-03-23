<?php

namespace LBM\ExtensionBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * Class LbmExtensionEntity
 * Add commons methods to all entities
 *
 * @package LBM\ExtensionBundle\Entity
 */
class LbmExtensionEntity
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="created_by", type="string", length=255)
     */
    protected $createdBy;

    /**
     * @var string
     *
     * @ORM\Column(name="updated_by", type="string", length=255)
     */
    protected $updatedBy;


    /**
     * @var string
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $is_active;
    
    /**
     * @var string
     *
     * @ORM\Column(name="is_archived", type="boolean")
     */
    protected $is_archived;


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LbmCompany
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return LbmCompany
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return LbmCompany
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     *
     * @return LbmCompany
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     *
     * set is_active value
     *
     * @param $is_active
     * @return $this
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     *
     * get is_active value
     * @return int
     */
    public function getIsActive()
    {
        return $this->is_active;
    }


    /**
     *
     * set is_archived value
     *
     * @param $is_archived
     * @return $this
     */
    public function setIsArchived($is_archived)
    {
        $this->is_archived = $is_archived;
        return $this;
    }

    /**
     *
     * get is_archived value
     * @return int
     */
    public function getIsArchived()
    {
        return $this->is_archived;
    }


    /********* PRE PERSIST ************/

    /**
     * @ORM\PrePersist
     */
    public function updateAt()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    /**
     * @ORM\PrePersist
     */
    public function createdAt()
    {
        if($this->createdAt == null) $this->setCreatedAt(new \Datetime());
    }

    /**
     * @ORM\PrePersist
     */
    public function isActive()
    {
        if(!$this->is_active) $this->is_active = 1;
    }

    /**
     * @ORM\PrePersist
     */
    public function isArchived()
    {
        if(!$this->is_archived) $this->is_archived = 0;
    }



}