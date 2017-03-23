<?php

namespace LBM\OrganizationBundle\Controller;

use LBM\OrganizationBundle\Entity\LbmCompany;
use LBM\OrganizationBundle\Form\LbmCompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class CompanyController extends Controller
{
    /**
     * @Route("/societe.html", name="indexCompany")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('LBMOrganizationBundle:LbmCompany');

        $companys = $repository->findAll();

        return $this->render(
            'LBMOrganizationBundle:Company:index.html.twig',
            array(
                'companys' => $companys
            )
        );
    }


    /**
     * @Route("/creer-une-societe.html", name="createCompany")
     * @Route("/modifier-la-societe-{company_id}.html", name="editCompany")
     */
    public function editAction(Request $request, $company_id = null)
    {

        if($company_id)
        {
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('LBMOrganizationBundle:LbmCompany');

            $company = $repository->findOneBy(array('id' => $company_id));
        }
        else
        {
            $company = new LbmCompany() ;
            $company_id = null;
        }

        $form = $this->createForm(
            LbmCompanyType::class, $company,
            array(
                'action' => $this->generateUrl('updateCompany'),
            )
        );

        return $this->render(
            'LBMOrganizationBundle:Company:edit.html.twig',
            array(
                'form' => $form->createView(),
                'company_id' => $company_id
            )
        );
    }


    /**
     * @Route("/sauvegarde-societe.html", name="updateCompany")
     */
    public function updateAction(Request $request)
    {

        if($company_id = $request->get('company_id'))
        {
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('LBMOrganizationBundle:LbmCompany');

            $company = $repository->findOneBy(array('id' => $company_id));

        } else {
            $company = new LbmCompany();
        }

        $form = $this->createForm(LbmCompanyType::class, $company);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request
            );

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($company);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Société bien enregistrée.');
                return $this->redirectToRoute('indexCompany');
            }
        }

        return $this->redirectToRoute('createCompany');

    }



    /**
     * @Route("/details-societe-{company_id}.html", name="showCompany")
     */
    public function showAction($company_id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('LBMOrganizationBundle:LbmCompany');

        $company = $repository->findOneBy(array('id' => $company_id));

        return $this->render(
            'LBMOrganizationBundle:Company:show.html.twig',
            array(
                'company' => $company
            )
        );

    }



    /**
     * @Route("/supprimer-societe-{company_id}.html", name="deleteCompany")
     */
    public function deleteAction($company_id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('LBMOrganizationBundle:LbmCompany');

        $company = $repository->findOneBy(array('id' => $company_id));

        $em = $this->getDoctrine()->getManager();
        $em->remove($company);
        $em->flush();

        return $this->redirectToRoute('indexCompany');

    }


}
