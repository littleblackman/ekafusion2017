<?php
namespace LBM\ExtensionBundle\TwigExtension;

use LBM\ExtensionBundle\Service\LbmStringTools;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;



use LBM\OrganizationBundle\Entity\LbmBusinessEntity;

class UserFriendly extends \Twig_Extension
{

    use LbmStringTools;

    protected $routeNameArray        = array(
                                                'user'    => 'utilisateurs',
                                                'company' => 'société',
                                                'family'    => 'famille'
                                            );
    protected $routeDetailsArray = array(
                                                'index'  => 'accueil',
                                                'edit'   => 'modification',
                                                'create' => 'création',
                                                'list'  => 'liste'
                                            );


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('getTitlePageName', array($this, 'routeName')),
            new \Twig_SimpleFilter('getDetailsPageName', array($this, 'routeDetails')),

        );
    }

    public function routeName($routeName)
    {


        $elements = $this->convertCamelCaseToArray($routeName);

        foreach($elements as $element)
        {
            if(array_key_exists($element, $this->routeNameArray)) {
                $routeName = $this->routeNameArray[$element];
            }
        }

        return $routeName;
    }


    public function routeDetails($routeDetail)
    {
        $elements = $this->convertCamelCaseToArray($routeDetail);

        foreach($elements as $element)
        {
            if(array_key_exists($element, $this->routeDetailsArray)) {
                $routeDetail = $this->routeDetailsArray[$element];
            }
        }

        return $routeDetail;

    }



    public function getName()
    {
        return 'app_extension';
    }
}