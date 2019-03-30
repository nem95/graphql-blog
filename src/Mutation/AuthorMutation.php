<?php
namespace App\Mutation;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class AuthorMutation implements MutationInterface, AliasedInterface
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
     * @param string $name
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(string $name)
    {
        $author = new Author();
        $author->setName($name);

        $this->em->persist($author);
        $this->em->flush();

        return ['content' => 'New author created with id ' . $author->getId()];
    }

    /**
     * @param int $id
     * @param string $name
     *
     * @return array
     *
     * @throws \Exception
     */
    public function update(int $id, string $name)
    {
        $author = $this->em->getRepository(Author::class)->find($id);

        if (!$author instanceof Author) {
            throw new \Exception('Unknown author with id ' . $id);
        }

        $author->setName($name);

        $this->em->persist($author);
        $this->em->flush();

        return ['content' => 'Author ' . $id . ' updated'];
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
        $author = $this->em->getRepository(Author::class)->find($id);

        if (!$author instanceof Author) {
            throw new \Exception('Unknown author with id ' . $id);
        }

        $this->em->remove($author);
        $this->em->flush();

        return ['content' => 'Author ' . $id . ' deleted'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'NewAuthor',
            'update' => 'UpdateAuthor',
            'delete' => 'DeleteAuthor'
        ];
    }
}