<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Factories\ProductFactory;
use Hutech\Services\CategoryService;
use Hutech\Services\ProductService;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Nette\Utils\Validators;

include_once './Services/ProductService.php';
include_once './Services/CategoryService.php';

session_start();

readonly class CoffeeController
{
    private const FILE_PATH = './Upload/';

    public function __construct(
        protected ProductService $coffeeService,
        protected ProductFactory $coffeeFactory,
        protected CategoryService $categoryService
    )
    {
    }

    public function getAll(): void
    {
        $coffees = $this->coffeeService->getAll();
        $categories = $this->categoryService->getAll();
        require_once './Views/Coffee/Manager.php';
    }

    public function add(): void
    {
        $categories = $this->categoryService->getAll();
        require_once './Views/Coffee/Add.php';
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function insert(): void
    {
        if (isset($_POST['submit'])) {
            $imgPath = '';

            if ($_FILES['Image']['name']) {
                $imgPath = $this->uploadImage($_FILES['Image']) ?? '';
                if (!$imgPath) {
                    header('Location: /hutech-coffee/add');
                    exit;
                }
            }

            $product = $this->coffeeFactory->create(
                id: null,
                name: $_POST['Name'],
                price: $_POST['Price'],
                image: $imgPath,
                description: $_POST['Description'] ?? '',
                category_id: $_POST['category_id']
            );

            if (!$this->validation($product)) {
                header('Location: /hutech-coffee/add');
                exit;
            }

            $this->coffeeService->create($product);
        }

        header('Location: /hutech-coffee/manager');
    }

    public function edit(): void
    {
        $coffee = $this->coffeeService->getById((int) $_GET['id']);

        if ($coffee) {
            $categories = $this->categoryService->getAll();
            require_once './Views/Coffee/Edit.php';
        } else {
            require_once './Views/Home/404.php';
        }
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function update(): void
    {
        if (!isset($_POST['submit'])) {
            header('Location: /hutech-coffee/manager');
            return;
        }

        $coffee = $this->coffeeService->getById((int) $_POST['Id']);

        if (!$coffee) {
            require_once './Views/Home/404.php';
            return;
        }

        $imgPath = $coffee->image;

        if ($_FILES['Image']['name']) {
            if ($imgPath && file_exists($this::FILE_PATH . $coffee->image)) {
                FileSystem::delete($this::FILE_PATH . $coffee->image);
            }

            $imgPath = $this->uploadImage($_FILES['Image']) ?? '';

            if (!$imgPath) {
                header('Location: /hutech-coffee/edit?id=' . $_POST['Id']);
                exit;
            }
        }

        $product = $this->coffeeFactory->create(
            id: $_POST['Id'],
            name: $_POST['Name'],
            price: $_POST['Price'],
            image: $imgPath ?? '',
            description: $_POST['Description'] ?? '',
            category_id: $_POST['category_id']
        );

        if (!$this->validation($product)) {
            header('Location: /hutech-coffee/edit?id=' . $_POST['Id']);
            exit;
        }

        $this->coffeeService->update($product);
        header('Location: /hutech-coffee/manager');
    }

    public function delete(): void
    {
        $coffee = $this->coffeeService->getById((int) $_GET['id']);

        if ($coffee) {
            if ($coffee->image && file_exists($this::FILE_PATH . $coffee->image)) {
                FileSystem::delete($this::FILE_PATH . $coffee->image);
            }
            $this->coffeeService->delete((int) $_GET['id']);
        }

        header('Location: /hutech-coffee/manager');
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    private function uploadImage(mixed $image): ?string
    {
        if (!is_dir($this::FILE_PATH)) {
            FileSystem::createDir($this::FILE_PATH);
        }

        if (!getimagesize($_FILES["Image"]["tmp_name"])) {
            $_SESSION['image_error'] = 'File không phải là hình ảnh';
            return null;
        }

        $fileName = $image['name'];
        $fileSize = $image['size'];
        $fileTemp = $image['tmp_name'];
        $tmp = explode('.', $fileName);
        $fileExtension = strtolower(end($tmp));
        $extensions = ["jpeg", "jpg", "png"];

        if (!in_array($fileExtension, $extensions)) {
            $errors[] = "Phần mở rộng không được hỗ trợ, vui lòng chọn file có phần mở rộng là jpg, jpeg, png";
        }

        if ($fileSize > 2097152) {
            $errors[] = 'Tệp của bạn phải nhỏ hơn 2MB';
        }

        $fileName = uniqid('hutech-', true) . '.' . $fileExtension;

        if (empty($errors)) {
            $image = Image::fromFile($fileTemp);
            $image->resize(250, 250, Image::ShrinkOnly);
            $image->save($this::FILE_PATH . $fileName, 70);
        } else {
            $_SESSION['image_error'] = $errors;
            return null;
        }

        return $this::FILE_PATH . $fileName;
    }

    private function validation($product): bool
    {
        if (!Validators::isInRange($product->price, [0, 100000000]) || Validators::isNone($product->price)) {
            $_SESSION['price_error'] = 'Giá sản phẩm không được để trống và phải nhỏ hơn 100000000';
        }

        if (!Validators::isInRange(strlen($product->name), [1, 50])) {
            $_SESSION['name_error'] = 'Tên sản phẩm không được để trống và phải nhỏ hơn 50';
        }

        if (!Validators::isInRange(strlen($product->image), [0, 255])) {
            $_SESSION['description_error'] = 'Đường dẫn ảnh sản phẩm phải nhỏ hơn 255';
        }

        if (!Validators::isInRange(strlen($product->description), [0, 255])) {
            $_SESSION['description_error'] = 'Mô tả sản phẩm phải nhỏ hơn 255';
        }

        if (isset($_SESSION['price_error'])
            || isset($_SESSION['name_error'])
            || isset($_SESSION['image_error'])
            || isset($_SESSION['description_error'])) {
            return false;
        }

        return true;
    }
}
