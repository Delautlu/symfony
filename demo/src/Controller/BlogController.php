<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;


class BlogController extends AbstractController
{
    private $artRepo;

    public function __construct(ArticleRepository $artRepo){
$this->artRepo = $artRepo;
    }
    #[Route('/blog', name:"app_blog")]

    public function index(ArticleRepository $artRepo): Response
    {

        $articles = $this->artRepo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    #[Route('/', name: 'home')]

    public function home(){
        return $this->render('blog/home.html.twig', [
            'title' => "Bienvenue ici les amis !",
            'age' => 31
        ]);
    }

    #[Route('/blog/new', name: 'blog_create')]

    public function create () {
        return$this->render('blog/create.html.twig');
    }

    #[Route('blog/{id}', name: 'blog_show')]
    
    public function show(Article $article) {
    
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);

    }


}

