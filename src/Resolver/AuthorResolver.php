<?php
namespace App\Resolver;

use App\Entity\Author;
use App\Repository\AuthorRepository;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class AuthorResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var AuthorRepository
     */
    private $articleRepository;

    /**
     * @param AuthorRepository $articleRepository
     */
    public function __construct(AuthorRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param int $id
     *
     * @return Author
     */
    public function resolve(int $id)
    {
        return $this->articleRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Author'
        ];
    }
}