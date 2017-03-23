<?php

namespace LBM\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbmApeCode
 *
 * @ORM\Table(name="lbm_organization_ape_code")
 * @ORM\Entity(repositoryClass="LBM\OrganizationBundle\Repository\LbmApeCodeRepository")
 */
class LbmApeCode
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
     * @return LBMApeCode
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
     * @return LBMApeCode
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


    /****** CUSTOME METHODS ***************/

    /******** CUSTOM  METHODS **************/

    public function getCodeAndLabel() {
        return $this->getCode().' '.$this->getLabelName();
    }
    

}

