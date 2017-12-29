<?php

namespace EkaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FamilyController extends Controller
{
    /**
     * @Route("/liste-des-familles.html", name="listFamily")
     */
    public function listFamily()
    {
        return $this->render('EkaBundle:Family:index.html.twig');
    }

    /**
     * @Route("/creer-une-famille.html", name="createFamily")
     */
    public function createFamily()
    {
        return $this->render('EkaBundle:Family:index.html.twig');
    }
}
