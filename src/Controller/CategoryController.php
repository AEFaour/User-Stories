<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @Route("/category")
 * Class CategoryController
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     * @param CategoryRepository $repository
     * @return Response
     */
    public function index(CategoryRepository $repository)
    {
        return $this->render('category/index.html.twig', [
            //'controller_name' => 'CategoryController',
            'categoryList' => $repository->findAll(),
        ]);
    }
}
