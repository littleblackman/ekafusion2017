<?php

namespace LBM\ReferencielBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbmGlobalRef
 *
 * @ORM\Table(name="lbm_referentiel_global_ref")
 * @ORM\Entity(repositoryClass="LBM\ReferencielBundle\Repository\LbmGlobalRefRepository")
 */
class LbmGlobalRef
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="constant_key", type="string", length=255, nullable=true, unique=true)
     */
    private $constantKey;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


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
     * @return LBMGlobalRef
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
     *
     * @return LBMGlobalRef
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
     * Set constantKey
     *
     * @param string $constantKey
     *
     * @return LBMGlobalRef
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return LBMGlobalRef
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
}

