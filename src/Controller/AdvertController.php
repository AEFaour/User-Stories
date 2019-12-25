<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;


/**
 * @Route("/advert")
 * Class AdvertController
 * @package App\Controller
 */
class AdvertController extends AbstractController
{
    /**
     * @Route("/{page}", name="advert_index", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @return Response
     */
    public function index()
    {
        $url = $this->generateUrl(
            "advert_view",
            ['id' => 5]
        );

        return new Response("L'URL de l'annonce 5 est: " . $url);
    }

    /**
     * @Route("/view/{id}", name="advert_view", requirements={"id" = "\d+"})
     * @param $id
     * @return Response
     */
    public function view($id)
    {
        return new Response("Affichage de l'annonce d'id: " . $id);
    }

    /**
     * @Route("/add", name="advert_add")
     */
    public function  add(){

    }

    /**
     * @Route("/edit/{id}", name="advert_edit", requirements={"id" = "\d+"})
     */
    public function  edit(){

    }

    /**
     * @Route("/delete/{id}", name="advert_delete", requirements={"id" = "\d+"})
     */
    public function  delete(){

    }


}
