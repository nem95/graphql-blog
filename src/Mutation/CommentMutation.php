<?php
namespace App\Mutation;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

use Exception;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class CommentMutation implements MutationInterface, AliasedInterface
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
     * @param string $content
     *
     * @param int $article_id
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(string $content, int $article_id)
    {
        $comment = new Comment();
        $comment->setContent($content);

        $article = $this->em->getRepository(Article::class)->find($article_id);

        if (!$article instanceof Article) {
            throw new Exception('Unknown article with id ' . $article_id);
        }

        $comment->setArticle($article);

        $this->em->persist($comment);
        $this->em->flush();

        return ['content' => 'New author created with id ' . $comment->getId()];
    }

    /**
     * @param int $id
     * @param string $content
     *
     * @return array
     *
     * @throws \Exception
     */
    public function update(int $id, string $content)
    {
        $comment = $this->em->getRepository(Comment::class)->find($id);

        if ($comment instanceof Comment) {

            $comment->setContent($content);

            $this->em->persist($comment);
            $this->em->flush();

            return ['content' => 'Comment ' . $id . ' updated'];
        }
        else {
            throw new Exception('Unknown comment with id ' . $id);
        }

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
        $comment = $this->em->getRepository(Comment::class)->find($id);

        if ($comment instanceof Comment) {

            $this->em->remove($comment);
            $this->em->flush();

            return ['content' => 'Comment ' . $id . ' deleted'];
        }
        else {
            throw new Exception('Unknown comment with id ' . $id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'NewComment',
            'update' => 'UpdateComment',
            'delete' => 'DeleteComment'
        ];
    }
}