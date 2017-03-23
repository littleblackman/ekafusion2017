<?php

namespace LBM\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;



class DefaultController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @Route("/dashboard.html")
     */
    public function indexAction()
    {
        return $this->render('LBMDashboardBundle:Default:index.html.twig');
    }
    
}
