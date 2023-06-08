<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Models\Product;
use Hutech\Services\ProductService;

include_once './Services/ProductService.php';

readonly class CoffeeController
{
    public function __construct(protected ProductService $coffeeService)
    {}

    public function getAll() : void
    {
        $coffees = $this->coffeeService->getAll();
        require_once './Views/Coffee/Manager.php';
    }

    public function add(): void
    {
        require_once './Views/Coffee/Add.php';
    }

    public function insert(): void
    {
        if (isset($_POST['submit'])) {
            $this->coffeeService->create(new Product(
                id: $_POST['Id'],
                name: $_POST['Name'],
                price: (float) $_POST['Price'],
                image: $this->uploadImage($_POST['Image']) ?? '',
                description: $_POST['Description'],
                category: $_POST['Category']
            ));
        }

        header('Location: /hutech-coffee/manager');
    }

    private function uploadImage(mixed $image): ?string
    {
        $uniqueFileName = null;

        if (isset($image)) {
            if (!file_exists('./Files')) {
                mkdir('./Files', 0777, true);
            }

            if (getimagesize($_FILES["Image"]["tmp_name"]) === false) {
                print_r('File không phải là hình ảnh');
                exit;
            }

            $fileName = $image['name'];
            $fileSize = $image['size'];
            $fileTemp = $image['tmp_name'];
            $tmp = explode('.', $fileName);
            $fileExtension = strtolower(end($tmp));
            $extensions = array("jpeg", "jpg", "png");

            if (in_array($fileExtension, $extensions) === false) {
                $errors[] = "Phần mở rộng không được hỗ trợ, vui lòng chọn file có phần mở rộng là jpg, jpeg, png";
            }

            if ($fileSize > 2097152) {
                $errors[] = 'Tệp của bạn phải nhỏ hơn 2MB';
            }

            $uniqueFileName = uniqid() . '.' . $fileExtension;

            if (empty($errors)) {
                move_uploaded_file($fileTemp, "./Files/" . $uniqueFileName);
            } else {
                print_r($errors);
                exit;
            }
        }

        return './Files/' . $uniqueFileName;
    }

    public function delete(): void
    {
        $coffee = $this->coffeeService->getById((int) $_GET['id']);

        if ($coffee) {
            $imageFile = $coffee->image;

            if (file_exists($imageFile)) {
                unlink($imageFile);
            }

            $this->coffeeService->delete((int) $_GET['id']);
        }

        header('Location: /hutech-coffee/manager');
    }
}
