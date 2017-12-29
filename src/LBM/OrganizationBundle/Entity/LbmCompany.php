<?php

namespace LBM\OrganizationBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use LBM\ExtensionBundle\Entity\LbmExtensionEntity;

/**
 * LbmCompany
 *
 * @ORM\Table(name="lbm_organization_company")
 * @ORM\Entity(repositoryClass="LBM\OrganizationBundle\Repository\LbmCompanyRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class LbmCompany extends LbmExtensionEntity
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
     * @ORM\Column(name="corporate_name", type="string", length=255)
     */
    private $corporateName;

    /**
     * @var string
     *
     * @ORM\Column(name="trade_name", type="string", length=255, nullable=true)
     */
    private $tradeName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="siren", type="string", length=255, nullable=true)
     */
    private $siren;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255, nullable=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="tva_intra", type="string", length=255, nullable=true)
     */
    private $tvaIntra;

    /**
     * @var int
     *
     * @ORM\Column(name="legal_category_id", type="integer", nullable=true)
     */
    private $legalCategoryId;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="immatriculation_rcs_date", type="date", nullable=true)
     */
    private $immatriculationRcsDate;

    /**
     * @ORM\ManyToOne(targetEntity="LBM\OrganizationBundle\Entity\LbmApeCode")
     * @ORM\JoinColumn(name="ape_code_id", referencedColumnName="id")
     */
    private $apeCode;


    /**
     * @ORM\ManyToOne(targetEntity="LBM\OrganizationBundle\Entity\LbmLegalCategory")
     * @ORM\JoinColumn(name="legal_category_id", referencedColumnName="id")
     */
    private $legalCategory;
    

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
     * Set corporateName
     *
     * @param string $corporateName
     *
     * @return LbmCompany
     */
    public function setCorporateName($corporateName)
    {
        $this->corporateName = $corporateName;

        return $this;
    }

    /**
     * Get corporateName
     *
     * @return string
     */
    public function getCorporateName()
    {
        return $this->corporateName;
    }

    /**
     * Set tradeName
     *
     * @param string $tradeName
     *
     * @return LbmCompany
     */
    public function setTradeName($tradeName)
    {
        $this->tradeName = $tradeName;

        return $this;
    }

    /**
     * Get tradeName
     *
     * @return string
     */
    public function getTradeName()
    {
        return $this->tradeName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return LbmCompany
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
     * Set siren
     *
     * @param string $siren
     *
     * @return LbmCompany
     */
    public function setSiren($siren)
    {
        $this->siren = $siren;

        return $this;
    }

    /**
     * Get siren
     *
     * @return string
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return LbmCompany
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set tvaIntra
     *
     * @param string $tvaIntra
     *
     * @return LbmCompany
     */
    public function setTvaIntra($tvaIntra)
    {
        $this->tvaIntra = $tvaIntra;

        return $this;
    }

    /**
     * Get tvaIntra
     *
     * @return string
     */
    public function getTvaIntra()
    {
        return $this->tvaIntra;
    }

    /**
     * Set legalCategoryId
     *
     * @param integer $legalCategoryId
     *
     * @return LbmCompany
     */
    public function setLegalCategoryId($legalCategoryId)
    {
        $this->legalCategoryId = $legalCategoryId;

        return $this;
    }

    /**
     * Get legalCategoryId
     *
     * @return int
     */
    public function getLegalCategoryId()
    {
        return $this->legalCategoryId;
    }


    /**
     * Set immatriculationRcsDate
     *
     * @param \DateTime $immatriculationRcsDate
     *
     * @return LbmCompany
     */
    public function setImmatriculationRcsDate($immatriculationRcsDate)
    {

       // $immatriculationRcsDate = $this->dateToSql($immatriculationRcsDate);
        $this->immatriculationRcsDate = $immatriculationRcsDate;
        return $this;
    }

    /**
     * Get immatriculationRcsDate
     *
     * @return \DateTime
     */
    public function getImmatriculationRcsDate()
    {
        return $this->immatriculationRcsDate;
    }

   
    /**
     *
     * set ApeCode Object
     * @param LbmApeCode $apeCode
     * @return $this
     */
    public function setApeCode(LbmApeCode $apeCode)
    {
        $this->apeCode = $apeCode;

        return $this;
    }


    /**
     * Return LbmApeCode Object
     * @return mixed
     */
    public function getApeCode()
    {
        return $this->apeCode;
    }


    /**
     *
     * set LbmLegalCategory Object
     * @param LbmLegalCategory $legalCategory
     * @return $this
     */
    public function setLegalCategory(LbmLegalCategory $legalCategory)
    {
        $this->legalCategory = $legalCategory;
        return $this;
    }
    
    /**
     * Return LbmLegalCategory Object
     * @return mixed
     */
    public function getLegalCategory()
    {
        return $this->legalCategory;
    }


}

