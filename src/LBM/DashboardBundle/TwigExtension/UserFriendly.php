<?php
namespace LBM\DashboardBundle\TwigExtension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

class UserFriendly extends \Twig_Extension
{

    protected $routeNameArray        = array(
                                                'indexUser'    => 'Utilisateurs',
                                                'newUser'      => 'Utilisateur',
                                                'indexCompany' => 'Société'
                                            );
    protected $routeDetailsArray = array(
                                                'indexUser'    => 'Gestion et administration',
                                                'newUser'      => 'Création',
                                                'indexCompany' => 'Gestion et administration'
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

        if(array_key_exists($routeName, $this->routeNameArray )) {
            $routeName = $this->routeNameArray[$routeName];
        }

        return $routeName;
    }


    public function routeDetails($routeDetail)
    {

        if(array_key_exists($routeDetail, $this->routeDetailsArray )) {
            $routeDetail = $this->routeDetailsArray[$routeDetail];
        }

        return $routeDetail;
    }

    public function getName()
    {
        return 'app_extension';
    }
}