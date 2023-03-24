<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use symfony\Doctrine\common\Persistence\ObjectManager;
use symfony\component\Form\Extension\Core\Type\TextType;
use symfony\component\Form\Extension\Core\Type\TextaeraType;
use symfony\component\Form\Extension\Core\Type\SubmitType;
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
    #[Route('/blog/{id}/edit', name: 'blog_edit')]

    public function form(Articel $article = null, Request $request, ObjectManager $manager) {
        if(!$article) {
            $article = new Article();
        }
    
        $form = $this->createFormBuilder($article)
                ->add('title')                
                ->add('content') 
                ->add('image')
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($article->getId()){
                $article->setCreatedAt(new \DateTime()); 
            }
        
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        return $this->render('blog/create.html.twig' [
            'formArticle' => $form->createView(),
            'editMode' => $artile ->getId() !==null
        ]);
    }

    #[Route('blog/{id}', name: 'blog_show')]
    
    public function show(Article $article) {
    
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);

    }


}

