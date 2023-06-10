<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use Doctrine\ORM\EntityRepository;
use Hutech\Models\Category;

include_once './Models/Category.php';

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[] findAll()
 * @method Category[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends EntityRepository
{

}