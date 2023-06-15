<?php

declare(strict_types=1);

namespace Hutech\Models;

use Symfony\Component\Validator\Constraints as Assert;

class Category extends BaseModel
{
    #[Assert\NotBlank(message: 'Tên loại sản phẩm không được để trống')]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Độ dài tên loại sản phẩm phải lớn hơn {{ limit }} ký tự',
        maxMessage: 'Độ dài tên loại sản phẩm phải nhỏ hơn {{ limit }} ký tự')]
    public string $name;

    public function __construct(?int $id, string $name)
    {
        parent::__construct($id);
        $this->name = $name;
    }

    public function __destruct()
    {
        parent::__destruct();
        $this->name = '';
    }
}