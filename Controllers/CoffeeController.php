<?php

declare(strict_types=1);

namespace Hutech\Controllers;

use Hutech\Factories\ProductFactory;
use Hutech\Services\ProductService;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use Symfony\Component\Validator\Validation;

include_once './Services/ProductService.php';
include_once './Factories/ProductFactory.php';

session_start();

readonly class CoffeeController
{
    private const FILE_PATH = './Upload/';

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
                name: $_POST['Name'],
                price: $_POST['Price'],
                image: $imgPath,
                description: $_POST['Description'],
                category: $_POST['Category']
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
        $coffee = $this->coffeeService->getById($_GET['id']);

        if ($coffee) {
            require_once './Views/Coffee/Edit.php';
        } else {
            header('Location: /hutech-coffee/manager');
        }
    }

    /**
     * @throws ImageException
     * @throws UnknownImageFileException
     */
    public function update(): void
    {
        if (isset($_POST['submit'])) {
            $coffee = $this->coffeeService->getById($_POST['Id']);

            if ($coffee) {
                $imgPath = $coffee->image;

                if ($_FILES['Image']['name']) {
                    $this->removeImage($coffee->image);
                    $imgPath = $this->uploadImage($_FILES['Image']) ?? '';
                    if (!$imgPath) {
                        header('Location: /hutech-coffee/edit?id=' . $_POST['Id']);
                        exit;
                    }
                }

                $product = $this->coffeeFactory->update(
                    id: $_POST['Id'],
                    name: $_POST['Name'],
                    price: $_POST['Price'],
                    image: $imgPath,
                    description: $_POST['Description'],
                    category: $_POST['Category']
                );

                if (!$this->validation($product)) {
                    header('Location: /hutech-coffee/edit?id=' . $_POST['Id']);
                    exit;
                }

                $this->coffeeService->update($product);
            }
        }

        header('Location: /hutech-coffee/manager');
    }

    public function delete(): void
    {
        $coffee = $this->coffeeService->getById($_GET['id']);

        if ($coffee) {
            if ($coffee->image) {
                $this->removeImage($coffee->image);
            }
            $this->coffeeService->delete($_GET['id']);
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
        $extensions = ["jpeg", "jpg", "png", "webp"];

        if (in_array($fileExtension, $extensions) === false) {
            $errors[] = "Phần mở rộng không được hỗ trợ, vui lòng chọn file có phần mở rộng là jpg, jpeg, png, webp";
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

    private function removeImage($image): void
    {
        if (file_exists($image)) {
            FileSystem::delete($image);
        }
    }

    private function validation($product): bool
    {
        $errors = Validation::createValidator()->validate($product);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $_SESSION[$error->getPropertyPath() . '_error'] = $error->getMessage();
            }
            return false;
        }

        return true;
    }
}
