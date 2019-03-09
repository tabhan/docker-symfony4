<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PizzaController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('lucky_number', ['max' => 5]));
    }
}
