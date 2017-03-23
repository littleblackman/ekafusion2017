<?php

namespace LBM\ReferencielBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbmDetailRef
 *
 * @ORM\Table(name="lbm_referentiel_detail_ref")
 * @ORM\Entity(repositoryClass="LBM\ReferencielBundle\Repository\LbmDetailRefRepository")
 */
class LbmDetailRef
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="constant_key", type="string", length=255, nullable=true, unique=true)
     */
    private $constantKey;

    /**
     * @var int
     *
     * @ORM\Column(name="global_id", type="integer")
     */
    private $globalId;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer", nullable=true)
     */
    private $orderNumber;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return LBMDetailRef
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
     * Set constantKey
     *
     * @param string $constantKey
     *
     * @return LBMDetailRef
     */
    public function setConstantKey($constantKey)
    {
        $this->constantKey = $constantKey;

        return $this;
    }

    /**
     * Get constantKey
     *
     * @return string
     */
    public function getConstantKey()
    {
        return $this->constantKey;
    }

    /**
     * Set globalId
     *
     * @param integer $globalId
     *
     * @return LBMDetailRef
     */
    public function setGlobalId($globalId)
    {
        $this->globalId = $globalId;

        return $this;
    }

    /**
     * Get globalId
     *
     * @return int
     */
    public function getGlobalId()
    {
        return $this->globalId;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return LBMDetailRef
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set orderNumber
     *
     * @param integer $orderNumber
     *
     * @return LBMDetailRef
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return int
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }
}

