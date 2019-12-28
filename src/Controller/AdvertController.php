<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
     * @throws \Exception
     */
    public function index($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page "' . $page . '" inexistante.');
        }
        // Notre liste d'annonce en dur
        $listAdverts = [
            [
                'title' => 'Recherche développpeur Symfony',
                'id' => 1,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date' => new \Datetime()
            ],
            [
                'title' => 'Mission de webmaster',
                'id' => 2,
                'author' => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date' => new \Datetime()],
            [
                'title' => 'Offre de stage webdesigner',
                'id' => 3,
                'author' => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date' => new \Datetime()
            ]
        ];
        return $this->render('advert/index.html.twig', [
            'listAdverts' => $listAdverts,
        ]);
    }

    /**
     * @Route("/view/{id}", name="advert_view", requirements={"id" = "\d+"})
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function view($id)
    {

        $advert = [
            'title' => 'Recherche développpeur Symfony',
            'id' => $id,
            'author' => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date' => new \Datetime()
        ];
        return $this->render('advert/view.html.twig', [
                'advert' => $advert,
            ]

        );
    }

    /**
     * @Route("/add", name="advert_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {

        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce est bien enregistrée');

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
     * @throws \Exception
     */
    public function edit($id, Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            return $this->redirectToRoute('advert_view', ['id' => 5]);
        }
        $advert =
            [
                'title' => 'Recherche développpeur Symfony',
                'id' => $id,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date' => new \Datetime()
            ];
        return $this->render('advert/edit.html.twig', [
            'advert' => $advert,
        ]);
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

    /**
     * @Route("/menu", name="advert_menu")
     * @param $limit
     * @return Response
     */
    public function menu($limit)
    {

        $listAdverts = [
            ['id' => 2, 'title' => 'Recherche développeur Symfony'],
            ['id' => 5, 'title' => 'Mission de webmaster'],
            ['id' => 9, 'title' => 'Offre de stage webdesigner']
        ];
        return $this->render('advert/menu.html.twig', [
                'listAdverts' => $listAdverts
            ]
        );
    }
}
