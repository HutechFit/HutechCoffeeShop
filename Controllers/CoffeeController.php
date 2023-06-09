<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Factories\ProductFactory;
use Hutech\Services\ProductService;

include_once './Services/ProductService.php';
include_once './Factories/ProductFactory.php';

readonly class CoffeeController
{
    private const FILE_PATH = './Files/';

    public function __construct(protected ProductService $coffeeService, protected ProductFactory $coffeeFactory)
    {
    }

    public function getAll(): void
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
            $this->coffeeService->create(
                $this->coffeeFactory->create(
                    id: (int) $_POST['Id'],
                    name: $_POST['Name'],
                    price: (float) $_POST['Price'],
                    image: isset($_FILES['Image']) ? $this->uploadImage($_FILES['Image']) ?? '' : '',
                    description: $_POST['Description'],
                    category: $_POST['Category']
                )
            );
        }

        header('Location: /hutech-coffee/manager');
    }

    private function uploadImage(mixed $image): ?string
    {
        $uniqueFileName = null;

        if (isset($image)) {
            if (!file_exists($this::FILE_PATH)) {
                mkdir($this::FILE_PATH, 0777, true);
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
            $extensions = array("jpeg", "jpg", "png", "webp");

            if (in_array($fileExtension, $extensions) === false) {
                $errors[] = "Phần mở rộng không được hỗ trợ, vui lòng chọn file có phần mở rộng là jpg, jpeg, png, webp";
            }

            if ($fileSize > 2097152) {
                $errors[] = 'Tệp của bạn phải nhỏ hơn 2MB';
            }

            $uniqueFileName = uniqid() . '.' . $fileExtension;

            if (empty($errors)) {
                move_uploaded_file($fileTemp, $this::FILE_PATH . $uniqueFileName);
            } else {
                print_r($errors);
                exit;
            }
        }

        return $uniqueFileName != null ? $this::FILE_PATH . $uniqueFileName : $uniqueFileName;
    }

    private function removeImage($image): void
    {
        if (file_exists($image)) {
            unlink($image);
        }
    }

    public function delete(): void
    {
        $coffee = $this->coffeeService->getById((int) $_GET['id']);

        if ($coffee) {

            if ($coffee->image) {
                $this->removeImage($coffee->image);
            }

            $this->coffeeService->delete((int) $_GET['id']);
        }

        header('Location: /hutech-coffee/manager');
    }
}
