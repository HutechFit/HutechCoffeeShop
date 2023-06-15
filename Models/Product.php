<?php

declare(strict_types=1);

namespace Hutech\Models;

use Symfony\Component\Validator\Constraints as Assert;

class Product extends BaseModel
{
    #[Assert\NotBlank(message: 'Tên sản phẩm không được để trống')]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Độ dài tên sản phẩm phải lớn hơn {{ limit }} ký tự',
        maxMessage: 'Độ dài tên sản phẩm phải nhỏ hơn {{ limit }} ký tự')]
    public string $name;

    #[Assert\NotBlank(message: 'Giá sản phẩm không được để trống')]
    #[Assert\Range(
        minMessage: 'Giá sản phẩm phải lớn hơn {{ limit }}',
        maxMessage: 'Giá sản phẩm phải nhỏ hơn {{ limit }}',
        min: 0,
        max: 1000000)]
    public int|float $price;

    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Đường dẫn ảnh phải lớn hơn {{ limit }} ký tự',
        maxMessage: 'Đường dẫn ảnh phải nhỏ hơn {{ limit }} ký tự')]
    public ?string $image;

    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Độ dài mô tả phải lớn hơn {{ limit }} ký tự',
        maxMessage: 'Độ dài mô tả phải nhỏ hơn {{ limit }} ký tự')]
    public ?string $description;

    public ?int $category_id;

    public function __construct($id, $name, $price, $image, $description, $category_id)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->description = $description;
        $this->category_id = $category_id;
    }

    public function __destruct()
    {
        parent::__destruct();
        $this->name = '';
        $this->price = 0;
        $this->image = null;
        $this->description = null;
        $this->category_id = null;
    }
}
