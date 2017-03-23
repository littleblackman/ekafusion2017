<?php

namespace LBM\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use LBM\ExtensionBundle\Entity\LbmExtensionEntity;

/**
 * LbmBusinessEntity
 *
 * @ORM\Table(name="lbm_organization_business_entity")
 * @ORM\Entity(repositoryClass="LBM\OrganizationBundle\Repository\LbmBusinessEntityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class LbmBusinessEntity extends LbmExtensionEntity
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="LBM\OrganizationBundle\Entity\LbmCompany")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;


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
     * @return LbmBusinessEntity
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
     * @return LbmBusinessEntity
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
     *
     * set LbmCompany Object
     * @param LbmCompany $company
     * @return $this
     */
    public function setCompany(LbmCompany $company)
    {
        $this->company = $company;
        return $this;
    }


    /**
     * Return LbmCompany Object
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }



}

