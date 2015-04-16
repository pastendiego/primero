<?php

namespace Diego\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DiegoUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
