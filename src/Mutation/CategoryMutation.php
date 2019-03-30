<?php
namespace App\Mutation;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

final class CategoryMutation implements MutationInterface, AliasedInterface
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
        $category = new Category();
        $category->setName($name);

        $this->em->persist($category);
        $this->em->flush();

        return ['content' => 'New author created with id ' . $category->getId()];
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
        $category = $this->em->getRepository(Category::class)->find($id);

        if (!$category instanceof Category) {
            throw new \Exception('Unknown category with id ' . $id);
        }

        $category->setName($name);

        $this->em->persist($category);
        $this->em->flush();

        return ['content' => 'Category ' . $category->getId() . ' updated'];
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
        $category = $this->em->getRepository(Category::class)->find($id);

        if (!$category instanceof Category) {
            throw new \Exception('Category not found');
        }

        $this->em->remove($category);
        $this->em->flush();

        return ['content' => 'Category ' . $category->getId() . ' deleted'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'NewCategory',
            'update' => 'UpdateCategory',
            'delete' => 'DeleteCategory'
        ];
    }
}