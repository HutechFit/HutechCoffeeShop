<?php

namespace Hutech\Repositories;

use Hutech\Factories\CoffeeFactory;

include_once './Factories/CoffeeFactory.php';

class CoffeeRepository
{
    private CoffeeFactory $coffeeFactory;

    public function __construct()
    {
        $this->coffeeFactory = new CoffeeFactory();
    }

    public function getAll(): array
    {
        return [
            $this->coffeeFactory->create(1, 'Cà phê đen', 20000, '', 'Cà phê đen', 'Cà phê'),
            $this->coffeeFactory->create(2, 'Cà phê sữa', 25000, '', 'Cà phê sữa', 'Cà phê'),
            $this->coffeeFactory->create(3, 'Trà mãng cầu', 20000, '', 'Trà mãng cầu', 'Trà'),
            $this->coffeeFactory->create(4, 'Xá xị', 20000, '', 'Xá xị', 'Nước ngọt')
        ];
    }

    public function getById($id): object
    {
        $coffees = $this->getAll();
        foreach ($coffees as $coffee) {
            if ($coffee->getId() === $id) {
                return $coffee;
            }
        }
        return $this->coffeeFactory->create(0, '', 0, '', '', '');
    }
}