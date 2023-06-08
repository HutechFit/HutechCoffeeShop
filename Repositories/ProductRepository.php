<?php

declare(strict_types=1);

namespace Hutech\Repositories;

use Hutech\Factories\ProductFactory;
use Hutech\Models\Product;

include_once './Factories/ProductFactory.php';
include_once './Models/Product.php';

class ProductRepository
{
    public array $coffees = [];

    public function __construct(private ProductFactory $coffeeFactory)
    {
        $this->coffeeFactory = new ProductFactory();

        $this->coffees = [
            $this->coffeeFactory->create(1, 'Cà phê đen', 20000, '', 'Cà phê nâu', 'Cà phê'),
            $this->coffeeFactory->create(2, 'Cà phê muối', 25000, '', '', 'Cà phê'),
            $this->coffeeFactory->create(3, 'Trà mãng cầu', 20000, '', 'Trà mãng cầu', 'Trà'),
            $this->coffeeFactory->create(4, 'Xá xị', 20000, '', 'Xá xị', 'Nước ngọt'),
        ];
    }

    public function getAll(): array
    {
        return $this->coffees;
    }

    public function getById(int $id): Product|null
    {
        foreach ($this->coffees as $coffee) {
            if ($coffee->id === $id) {
                return $coffee;
            }
        }

        return null;
    }

    public function create(Product $coffee): void
    {
        $this->coffees[] = $coffee;
    }

    public function update(Product $coffee): void
    {
        foreach ($this->coffees as $key => $value) {
            if ($value->id === $coffee->id) {
                $this->coffees[$key] = $coffee;
            }
        }
    }

    public function delete(int $id): void
    {
        foreach ($this->coffees as $key => $value) {
            if ($value->id === $id) {
                unset($this->coffees[$key]);
            }
        }
    }
}