<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param $page
     * @return Response
     */
    public function index($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('Page "' . $page . '" inexistante');
        }

        return $this->render('advert/index.html.twig');
    }

    /**
     * @Route("/view/{id}", name="advert_view", requirements={"id" = "\d+"})
     * @param $id
     * @return Response
     */
    public function view($id)
    {

        return $this->render('advert/view.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/add", name="advert_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {

        if ($request->isMethod('POST')) {
            $this->addFlash('notice', 'Annonce est bien enregistrée');

            return $this->redirectToRoute('advert_view', [
                'id' => 5
            ]);
        }

        return $this->render('advert/add.html.twig');


    }

    /**
     * @Route("/edit/{id}", name="advert_edit", requirements={"id" = "\d+"})
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit($id, Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->addFlash('notice', 'Annonce est bien modifiée');

            return $this->redirectToRoute('advert_view', [
                'id' => 5
            ]);
        }

        return $this->render('advert/edit.html.twig');
    }

    /**
     * @Route("/delete/{id}", name="advert_delete", requirements={"id" = "\d+"})
     * @param $id
     * @return Response
     */
    public function delete($id)
    {
        return $this->render('advert/delete.html.twig');
    }
}
