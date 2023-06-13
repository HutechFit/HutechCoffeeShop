<?php

declare(strict_types=1);

namespace Hutech\Models;

use Symfony\Component\Validator\Constraints as Assert;

include_once './Models/BaseModel.php';

class Category extends BaseModel
{
    #[Assert\NotBlank(message: 'Name is required')]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Name must be at least {{ limit }} characters long',
        maxMessage: 'Name cannot be longer than {{ limit }} characters')]
    public string $name;

    public function __construct(?int $id, string $name)
    {
        parent::__construct($id);
        $this->name = $name;
    }
}