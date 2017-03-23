<?php

namespace LBM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbmCountry
 *
 * @ORM\Table(name="lbm_contact_country")
 * @ORM\Entity(repositoryClass="LBM\ContactBundle\Repository\LbmCountryRepository")
 */
class LbmCountry
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
     * @ORM\Column(name="code_country", type="string", length=20, nullable=true)
     */
    private $codeCountry;


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
     * @return LBMCountry
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
     * Set codeCountry
     *
     * @param string $codeCountry
     *
     * @return LBMCountry
     */
    public function setCodeCountry($codeCountry)
    {
        $this->codeCountry = $codeCountry;

        return $this;
    }

    /**
     * Get codeCountry
     *
     * @return string
     */
    public function getCodeCountry()
    {
        return $this->codeCountry;
    }
}

