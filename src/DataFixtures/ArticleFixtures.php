<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Créer 3 categorie fakees
        for($i = 1; $i <= 4; $i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
            ->setDescription($faker->paragraph());

            $manager->persist($category);

            //creer entre 4 et 6 articles
        }

        for($j =2; $j <= mt_rand( 6,6 ); $j++){
            $article = new Article();

            $content = '<p>' . join($faker->paragraphs(3), '</p><p>') . '</p>';

            $article->setTitle($faker->sentence())
                ->setContent($content)
                ->setImage($faker->imageUrl($width = 1150, $height = 760))
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setCategory($category);

            $manager->persist($article);

            // on donne des commentaires a l'atricle
            for ($k = 1; $k <= mt_rand(7,10); $k++){
                $comment = new Comment();
                $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';


               $interval = (new \DateTime())->diff($article->getCreatedAt());
               $days = $interval->days;

                $comment->setAuthor($faker ->name)
                    ->setContent($content)
                ->setCreatedAt($faker->dateTimeBetween('-' .$days . 'days'))
                    ->setArticle($article);
                $manager->persist($comment);
            }
        }
        $manager->flush();
    }
}
