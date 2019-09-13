<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     * @param ArticleRepository $repo
     * @return Response
     */
    public function index(ArticleRepository $repo)
    {
        /*repo =$this->getDoctrine()->getRepository(Article :: class);*/

        $article = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $article
        ]);
    }
    /**
     * @Route("/", name="home") 
     */
    public function home(){
        return $this->render('blog/home.html.twig');
    }

     /**
     *@Route("/blog/contact", name="blog_contact")
     */
    
    public function contact()
    {
        return $this->render('blog/contact.html.twig');
    }

         /**
         *@Route("/blog/faq", name="blog_faq")
         */

        public function faq (){
            return $this->render('blog/faq.html.twig');

        }

        /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */

    public function form( Article $article = null, Request $request, ObjectManager $manager){
        if(!$article){
            $article = new Article();
        }
            // $article = new Article();

          // $form = $this->createFormBuilder($article)
          // ->add('title')
          // ->add('content')
          // ->add('image')
          // ->getForm();

          $form =$this->createForm(ArticleType::class, $article);

          $form->handleRequest($request);

          if($form->isSubmitted()&& $form->isValid()){
              if(!$article->getid()){

              }
              $article->setCreatedAt(new \ DateTime());

              $manager->persist($article);
              $manager->flush();

              return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
            }
          
          return $this->render('blog/create.html.twig',[
              'formArticle' => $form->createView(),
              'editMode' => $article->getId() !== null //est ce que l'article est different de nul
          ]);

        

        $article->setTitle("")
            ->setContent("");

    }
    


        

    /**
     * @Route("/blog/{id}", name="blog_show")
     * @param ArticleRepository $repo
     * @param $id
     * @return Response
     */
        public function show (ArticleRepository $repo, $id, Request $request, objectManager $manager, Article $article){
            $comment = new Comment();
            $form = $this->createForm(CommentType::class, $comment);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $comment->setCreatedAt(new \DateTime())
                        ->setArticle($article);
                        $manager->persist($comment);
                        $manager->flush();
                        return $this->redirectToRoute('blog_show', ['id' => $article ->getId()]);
            }
            
            /* $repo = $this->getDoctrine()->getRepository(Article :: class);*/

            $article = $repo->find($id);
            return $this->render('blog/show.html.twig', [
                'article' => $article, 
                'commentForm' => $form->createView()
            ]);
        }

        
        
 
     }





