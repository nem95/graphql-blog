<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [];

        for ($i = 0; $i < 10; $i++)
        {
            $category = new Category();
            $category->setName('Category' . $i);

            $categories[] = $category;
            $manager->persist($category);
        }

        $authors = [];

        for ($i = 0; $i < 10; $i++)
        {
            $author = new Author();
            $author->setName('Author' . $i);

            $authors[] = $author;
            $manager->persist($author);
        }

        $articles = [];

        for ($i = 0; $i < 25; $i++)
        {
            $article = new Article();
            $article->setTitle('Article' . $i);
            $article->setContent("Content" . $i);
            $article->setCategory($categories[rand(0,9)]);
            $article->setAuthor($authors[rand(0,9)]);

            $articles[] = $article;
            $manager->persist($article);
        }

        for ($i = 0; $i < 100; $i++)
        {
            $article = new Comment();
            $article->setContent('Comment' . $i);
            $article->setArticle($articles[rand(0,24)]);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
