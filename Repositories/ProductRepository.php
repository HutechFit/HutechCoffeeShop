<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use Doctrine\ORM\EntityRepository;
use Hutech\Models\Product;

include_once './Models/Product.php';

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[] findAll()
 * @method Product[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends EntityRepository
{

}