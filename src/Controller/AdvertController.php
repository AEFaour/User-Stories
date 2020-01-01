<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Category;
//use App\Entity\User;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/advert")
 * Class AdvertController
 * @package App\Controller
 */
class AdvertController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * AdvertController constructor.
     * @param $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * @Route("/", name="advert_index", methods={"GET"})
     * @param AdvertRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(AdvertRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $advertList = $paginator->paginate(
            $repository->getAllAdverts(),
            $request->query->getInt('page', 1),
            10
        );
        dump($advertList);
        $params = $this->getTwigParametersWithAside(
            [
                'advertList' => $advertList, 'pagetitle' => ''
            ]
        );
        return $this->render('advert/index.html.twig', $params);
    }

    /**
     * @Route("/by-category/{id}", name="advert-by-category")
     * @param Category $category
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param AdvertRepository $repository
     * @return Response
     */
    public function showByCategory(Category $category, Request $request, PaginatorInterface $paginator, AdvertRepository $repository){
        $advertList = $paginator->paginate(
            $repository->getAllByCategory($category),
            $request->query->getInt('page', 1),
            10
        );
        $params = $this->getTwigParametersWithAside(
            ['advertList' => $advertList, 'pageTitle' => "de la catégorie : ". $category->getCategory()]
        );
        return $this->render('advert/index.html.twig', $params);
    }

    /**
     * @param $data
     * @return array
     */
    private function getTwigParametersWithAside($data){
        $asideData =[
            'categoryList' => $this->getDoctrine()
                ->getRepository(Category::class)
                ->findAll()
        ];
        return array_merge($data, $asideData);
    }

    /**
     * @Route("/add", name="advert-add", methods={"GET","POST"})
     * @param Request $request
     * @param null $id
     * @return RedirectResponse|Response
     */
    public function addOrEdit(Request $request, $id=null)
    {

        if($id == null){
            $advert = new Advert();
        } else {
            $advert = $this   ->getDoctrine()
                ->getRepository(advert::class)
                ->find($id);
        }

        $this->denyAccessUnlessGranted('ROLE_USER');

        $advert->setUser($this->security->getUser());


        $form = $this->createForm(AdvertType::class, $advert);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Gestion de l'upload des photos
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['photo']->getData();

            if ($uploadedFile){
                //Definition de nouveau nom de fichier
                $newFileName = uniqid('photo_').'.'. $uploadedFile->guessExtension();
                //Déplacement de l'upload dans son dossier de destination
                $uploadedFile->move(
                    $this->getParameter('advert.photo.path'),
                    $newFileName
                );
                //Ecrire du nom de fichier dans l'entité
                $advert->setPhoto($newFileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();

            $this->addFlash("sucess", "Votre annonce a été ajouté");

            return $this->redirectToRoute('advert_index');
        }

        return $this->render('advert/add.html.twig', [
            'advertForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/view/{id}", name="advert_view", requirements={"id" = "\d+"})
     * @param $id
     * @return Response
     */
    public function view($id)
    {
        $repository = $this ->getDoctrine()->getManager()
            ->getRepository(Advert::class);

        $advert = $repository->find($id);

        if($advert===null){
            throw new NotFoundHttpException("L'annonce d'id ". $id . " n'existe pas.");
        }


        return $this->render('advert/view.html.twig', [
                'advert' => $advert,
            ]

        );
    }


    /**
     * @Route("/{id}/edit", name="advert_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Advert $advert
     * @return Response
     */
    public function edit(Request $request, Advert $advert): Response
    {
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('advert_index');
        }

        return $this->render('advert/edit.html.twig', [
            'advert' => $advert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="advert_delete", requirements={"id" = "\d+"})
     * @param $id
     * @return Response
     */
    public function deleteAd($id){
        $repository = $this->getDoctrine()->getRepository(Advert::class);
        $advert = $repository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if($advert){
            $entityManager->remove($advert);
            $entityManager->flush();
        }
        return $this->redirectToRoute("advert_index");
    }


}
