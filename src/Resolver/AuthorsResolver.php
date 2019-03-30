<?php
namespace App\Resolver;

use App\Entity\Author;
use App\Repository\AuthorRepository;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

final class AuthorsResolver implements ResolverInterface, AliasedInterface
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
     * @return Author[]
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
            'resolve' => 'Authors'
        ];
    }
}