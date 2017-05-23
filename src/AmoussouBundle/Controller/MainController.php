<?php

namespace AmoussouBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/index",name="indexMain")
     */
    public function indexAction()
    {
        return $this->render('AmoussouBundle:Main:presentation.html.twig', array(
            // ...
        ));
    }

     /**
     * @Route("/presentation",name="presentation")
     */
    public function presentationAction()
    {
        return $this->render('AmoussouBundle:Main:presentation.html.twig', array(
            // ...
        ));
    }

     /**
     * @Route("/bande_annonce",name="annonce")
     */
    public function annonceAction()
    {
        return $this->render('AmoussouBundle:Main:bande_annonce.html.twig', array(
            // ...
        ));
    }

     /**
     * @Route("/film",name="film")
     */
    public function filmAction()
    {
        return $this->render('AmoussouBundle:Main:film.html.twig', array(
            // ...
        ));
    }

}
