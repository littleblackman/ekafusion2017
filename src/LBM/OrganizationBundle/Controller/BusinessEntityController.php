<?php

namespace LBM\OrganizationBundle\Controller;


use LBM\OrganizationBundle\Entity\LbmBusinessEntity;
use LBM\OrganizationBundle\Form\LbmBusinessEntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class BusinessEntityController extends Controller
{
    /**
     * @Route("/entites-societe-{company_id}.html", name="showBusinessEntitys")
     */
    public function showAction($company_id)
    {

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('LBMOrganizationBundle:LbmBusinessEntity');

        $business_entitys = $repository->findBy(array('company' => $company_id));

        return $this->render(
            'LBMOrganizationBundle:BusinessEntity:show.html.twig',
            array(
                'business_entitys' => $business_entitys
            )
        );
    }

    /**
     * @Route("/creer-entite-{company_id}.html", name="createBusinessEntity")
     */
    public function editAction(Request $request, $company_id, $business_entity_id = null)
    {

        if($business_entity_id)
        {
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('LBMOrganizationBundle:LbmBusinessEntity');

            $business_entity = $repository->findOneBy(array('id' => $business_entity_id));
        }
        else
        {
            $business_entity = new LbmBusinessEntity() ;
            $business_entity_id = null;

        }

        $form = $this->createForm(
            LbmBusinessEntityType::class, $business_entity,
            array(
                'action' => $this->generateUrl('updateBusinessEntity'),
            )
        );

        return $this->render(
            'LBMOrganizationBundle:BusinessEntity:edit.html.twig',
                                                                array(
                                                                    'form' => $form->createView(),
                                                                    'business_entity_id' => $business_entity_id,
                                                                    'company_id' => $company_id
                                                                )
        );
    }




    /**
     * @Route("/sauvegarde-entite.html", name="updateBusinessEntity")
     */
    public function updateAction(Request $request)
    {

        $businessEntity = new LbmBusinessEntity();

        $form = $this->createForm(LbmBusinessEntityType::class, $businessEntity);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($businessEntity);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Entité Business bien enregistrée.');
                return $this->redirectToRoute('showCompany',  array('company_id' => $businessEntity->getCompany()->getId()));
            }
        }

        return $this->redirectToRoute('createBusinessEntity');

    }


    /**
     * @Route("/supprimer-entite.html", name="deleteBusinessEntity")
     */
    public function deleteAction()
    {

        $id = $_GET['id'];

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('LBMOrganizationBundle:LbmBusinessEntity');

        $businessEntity = $repository->findOneBy(array('id' => $id));

        $businessEntity->setIsArchived(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($businessEntity);
        $em->flush();

        return $this->redirectToRoute('showCompany',  array('company_id' => $businessEntity->getCompany()->getId()));
    }



}
