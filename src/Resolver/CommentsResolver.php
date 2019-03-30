<?php
namespace App\Resolver;

use App\Entity\Comment;
use App\Repository\CommentRepository;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class CommentsResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var CommentRepository
     */
    private $articleRepository;

    /**
     * @param CommentRepository $articleRepository
     */
    public function __construct(CommentRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return Comment[]
     */
    public function resolve()
    {
        return $this->articleRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Comments'
        ];
    }
}