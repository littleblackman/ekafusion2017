<?php

namespace LBM\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbmLegalCategory
 *
 * @ORM\Table(name="lbm_organization_legal_category")
 * @ORM\Entity(repositoryClass="LBM\OrganizationBundle\Repository\LbmLegalCategoryRepository")
 */
class LbmLegalCategory
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
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="label_name", type="string", length=255)
     */
    private $labelName;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var int
     *
     * @ORM\Column(name="level_id", type="integer", nullable=true)
     */
    private $levelId;


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
     * Set code
     *
     * @param string $code
     *
     * @return LBMLegalCategory
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set labelName
     *
     * @param string $labelName
     *
     * @return LBMLegalCategory
     */
    public function setLabelName($labelName)
    {
        $this->labelName = $labelName;

        return $this;
    }

    /**
     * Get labelName
     *
     * @return string
     */
    public function getLabelName()
    {
        return $this->labelName;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return LBMLegalCategory
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set levelId
     *
     * @param integer $levelId
     *
     * @return LBMLegalCategory
     */
    public function setLevelId($levelId)
    {
        $this->levelId = $levelId;

        return $this;
    }

    /**
     * Get levelId
     *
     * @return int
     */
    public function getLevelId()
    {
        return $this->levelId;
    }
    
    
    /******** CUSTOM  METHODS **************/

    public function getCodeAndLabel() {
        return $this->getCode().' | '.$this->getLabelName();
    }
}

