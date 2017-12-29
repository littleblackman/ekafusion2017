<?php

namespace LBM\UserBundle\Controller;

use LBM\UserBundle\Entity\LbmUser;
use LBM\UserBundle\Entity\User;
use LBM\UserBundle\Form\LbmUserType;
use LBM\UserBundle\Form\UserType;
use LBM\UserBundle\LBMUserBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

    /**
     * @Route("/utilisateur.html", name="indexUser")
     */
    public function indexAction(Request $request)
    {

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('LBMUserBundle:LbmUser');

        $users = $repository->findAll();

        return $this->render(
            'LBMUserBundle:Default:index.html.twig',
            array(
                'users' => $users
            )
        );
    }

    /**
     * @Route("/creer-un-utilisateur.html", name="editUser")
     *
    public function editAction(Request $request)
    {
        $user = new LbmUser() ;
        $form = $this->createForm(
                                    LbmUserType::class, $user,
                                    array(
                                        'action' => $this->generateUrl('updateUser'),
                                    )
                                );

        return $this->render(
            'LBMUserBundle:Default:edit.html.twig',
                                                    array(
                                                        'form' => $form->createView()
                                                    )
        );
    }*/



    /**
     * @Route("/creer-un-utilisateur.html", name="createUser")
     * @Route("/modification-utilisateur-{user_id}.html", name="editUser")
    */
    public function editAction(Request $request, $user_id = null)
    {

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('LBMUserBundle:LbmUser');

        $user = $repository->findOneBy(array('id' => $user_id));

        $form = $this->createForm(LbmUserType::class, $user);

        return $this->render(
            'LBMUserBundle:Default:edit.html.twig',
            array(
                'form' => $form->createView(), 'user_id' => $user_id
            )
        );
    }

    /**
     * @Route("/mise-a-jour-utilisateur-{user_id}.html", name="updateUser")
     */
    public function updateAction(Request $request, $user_id = null)
    {

        if($user_id) {
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('LBMUserBundle:LbmUser');

            $user = $repository->findOneBy(array('id' => $user_id));
        } else {
            $user = new LbmUser();
        }


        $form = $this->createForm(LbmUserType::class, $user);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'User ajouté.');
echo 'yes';
                return $this->redirectToRoute('indexUser');
            //}
        } else {
            echo "no";
        }

echo 'echec'; exit;
        return $this->redirectToRoute('editUser');


    }



    /**
     * @Route("/suppression-utilisateur.html", name="deleteUser")
     */
    public function deleteAction(Request $request)
    {


    }


    /**
     * @Route("/profile-statut.html", name="profileStatus")
     */
    public function profileStatusAction()
    {
        $user = $this->getUser();
        return $this->render(
                                'LBMUserBundle:Default:profileStatus.html.twig',
                                array(
                                    'user' => $user
                                )
                            );
    }


    /**
     * @Route("/profile-utilisateur.html", name="showProfile")
     */
    public function showProfilAction(Request $request)
    {
        $user = $this->getUser();

        return $this->render(
            'LBMUserBundle:Default:show.html.twig',
            array(
                'user' => $user
            )
        );
    }


    /**
     * @Route("/profile-settings.html", name="settingsProfile")
     */
    public function settingsAction()
    {
        $user = $this->getUser();

        $form = $this->createForm(LbmUserType::class, $user);

        return $this->render(
            'LBMUserBundle:Default:settings.html.twig',
            array(
                'user' => $user,
                'myForm' => $form->createView()
            )
        );
    }
}
