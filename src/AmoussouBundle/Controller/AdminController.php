<?php

namespace AmoussouBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminController extends Controller
{
    /**
     * @Route("/admin/festivalier",name="admin.festivalier")
     */
    public function festivalierAction(Request $request)
	{
        $user = new User();
        $form = $this->createFormBuilder($user)
                    ->add('username', TextType::class)
                    ->add('grant', SubmitType::class, array('label' => 'Autoriser'))
                    ->add('fire', SubmitType::class, array('label' => 'Interdire'))                    
                    ->getForm();
        $form->handleRequest($request);

        return $this->render('AmoussouBundle:Admin:festivalier.html.twig', array(
            "form" => $form->createView()
        	
        ));
    }

    /**
     * @Route("/admin/role/festivalier",name="admin.role_festivalier")
     * @Method({"POST"})
     */
    public function roleFestivalierAction(Request $request)
	{
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("AppBundle:User");
        if (null !== $request->request->get('form')) {
        // utiliser les services pour récupérer la liste
            $data = $request->request->get('form');
            
            $name = $data['username'];
            
            if (preg_match('/[a-zA-Z]{3,15}/', $name) == 1) {
            	// le nom est coherent
            	$user = $repository->findOneByUsername($name);
            	
            	if ($user) {
                    // die(var_dump($data));
                    if (array_key_exists("grant", $data)){
                		$user->addRole("ROLE_FESTIVALIER");
                    } elseif ($user->hasRole("ROLE_FESTIVALIER")) {
                        $user->removeRole("ROLE_FESTIVALIER");
                    }
                    $em->persist($user);
            		$em->flush();
            	} else {
            		var_dump("plantage");
            	}

            } else {
            	die(var_dump("erreur de match"));
            }
        }

        return $this->redirectToRoute('indexMain');
        
    }

    /**
     * @Route("/admin/role/regression",name="admin.role_regression")
     * @Method({"POST"})
     */
    public function roleRegressionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("AppBundle:User");
        if (null !== $request->request->get('form')) {
        // utiliser les services pour récupérer la liste
            $data = $request->request->get('form');
            
            $name = $data['username'];
            
            if (strlen($name) > 3) {
                // le nom est coherent
                $user = $repository->findOneByUsername($name);
                // die(var_dump("on y va"));
                if ($user) {
                    $user->removeRole("ROLE_FESTIVALIER");
                    $em->persist($user);
                    $em->flush();
                } else {
                    var_dump("plantage");
                }

            } else {
                die(var_dump("erreur de match"));
            }
        }

        return $this->redirectToRoute('indexMain');
        
    }

    /**
     * @Route("/admin/users",name="admin.users")
     */
    public function usersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("AppBundle:User");
        $users = $repository->findAll();

        return $this->render('AmoussouBundle:Admin:users.html.twig', array(
            "users" => $users
            
        ));
    }

     /**
     * @Route("/admin/promote/festivalier/{id}",name="admin.promote.festivalier")
     */
    public function promoteFestivalierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("AppBundle:User");
        $user = $repository->findOneById($id);
        if ($user) {
            $user->addRole("ROLE_FESTIVALIER");
            $em->persist($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin.users');
    }

     /**
     * @Route("/admin/finish/festivalier/{id}",name="admin.finish.festivalier")
     */
    public function finishFestivalierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("AppBundle:User");
        $user = $repository->findOneById($id);
        if ($user) {
            $user->removeRole("ROLE_FESTIVALIER");
            $em->persist($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin.users');
    }

}
