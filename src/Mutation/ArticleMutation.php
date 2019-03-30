<?php
namespace App\Mutation;

use App\Entity\Author;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

use App\Entity\Article;

final class ArticleMutation implements MutationInterface, AliasedInterface
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $title
     * @param string $content
     * @param int $categoryId
     *
     * @param int $authorId
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(string $title, string $content, int $categoryId, int $authorId)
    {
        $article = new Article();
        $article->setTitle($title);
        $article->setContent($content);

        $category = $this->em->getRepository(Category::class)->find($categoryId);

        if (!$category instanceof Category) {
            throw new \Exception('Unknown category with id ' . $categoryId);
        }

        $article->setCategory($category);

        $author = $this->em->getRepository(Author::class)
          ->find($authorId);

        if (!$author instanceof Author) {
            throw new \Exception('Unknown category with id ' . $authorId);
        }

        $article->setAuthor($author);

        $this->em->persist($article);
        $this->em->flush();

        return ['content' => 'New author created with id ' . $article->getId()];
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @param int $categoryId
     *
     * @param int $authorId
     *
     * @return array
     *
     * @throws \Exception
     */
    public function update(int $id, string $title, string $content, int $categoryId, int $authorId)
    {
        $article = $this->em->getRepository(Article::class)->find($id);

        if (!$article instanceof Article) {
            throw new \Exception('Unknown article with id ' . $id);
        }

        $article->setTitle($title);
        $article->setContent($content);

        $category = $this->em->getRepository(Category::class)
          ->find($categoryId);

        if (!$category instanceof Category) {
            throw new \Exception('Unknown category with id ' . $categoryId);
        }

        $article->setCategory($category);

        $author = $this->em->getRepository(Author::class)
          ->find($authorId);

        if (!$author instanceof Author) {
            throw new \Exception('Unknown author with id ' . $authorId);
        }

        $article->setAuthor($author);

        $this->em->persist($article);
        $this->em->flush();

        return ['content' => 'Article ' . $id . ' updated'];
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $article = $this->em->getRepository(Article::class)->find($id);

        if (!$article instanceof Article) {
            throw new \Exception('Unknown article with id ' . $id);
        }

        $this->em->remove($article);
        $this->em->flush();

        return ['content' => 'Article ' . $id . '  deleted.'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'NewArticle',
            'update' => 'UpdateArticle',
            'delete' => 'DeleteArticle'
        ];
    }
}