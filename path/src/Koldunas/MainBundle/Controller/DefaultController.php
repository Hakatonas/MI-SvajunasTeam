<?php

namespace Koldunas\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("KoldunasMainBundle:Filling");
        $filling1 = $repo->find(1)->getName();
        $filling2 = $repo->find(2)->getName();
        $simple = new SimpleDumpling();
        $other = new DumplingWithFilling($simple, $filling1);
        $other2 = new DumplingWithFilling($simple, $filling2);
        return $this->render('KoldunasMainBundle:Default:index.html.twig', array('koldunai' => $simple->getDescription(), 'koldunai2' => $other->getTitle(), 'koldunai3' => $other2->getTitle()));
    }
}


interface Dumpling
{
    public function cook();
    public function getDescription();
}

class SimpleDumpling implements Dumpling
{
    public function cook()
    {
        // Cook dumpling
    }

    public function getDescription()
    {
        return "simple dumpling";
    }
}

class DumplingWithFilling extends SimpleDumpling
{
    private $dumpling;
    private $filling = "";
    public function __construct(SimpleDumpling $btd_in, $filling) {
        $this->dumpling = $btd_in;
        $this->filling = $filling;
    }

    public function getTitle()
    {
        return $this->dumpling->getDescription() . " su ". $this->filling;
    }
}