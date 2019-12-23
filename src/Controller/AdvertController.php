<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AdvertController extends AbstractController
{

    public function index(Environment $environment)
    {
        $content = $environment->render("Advert/index.html.twig", ['name' => 'Ayatollah TAGUEULE']);
        return new Response($content);
    }
    public function close(Environment $environment)
    {
        $content = $environment->render("Advert/close.html.twig", ['name' => 'Ayatollah TAGUEULE']);
        return new Response($content);
    }
}
