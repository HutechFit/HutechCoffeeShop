<?php

declare(strict_types=1);

namespace Hutech\Controllers\Api;

use Hutech\Factories\CategoryFactory;
use Hutech\Factories\ProductFactory;
use Hutech\Services\CategoryService;
use Hutech\Services\ProductService;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\Response;

class ApiController extends ApiBaseController
{
    private const FILE_PATH = '/Uploads/';

    public function __construct(
        protected ProductService  $coffeeService,
        protected ProductFactory  $coffeeFactory,
        protected CategoryService $categoryService,
        protected CategoryFactory $categoryFactory
    )
    {
    }

    #[Get(
        path: '/api/v1/products',
        summary: 'Lấy danh sách sản phẩm',
        tags: ['Product'],
        responses: [
            new Response(response: '200', description: 'Thành công'),
            new Response(response: '401', description: 'Chưa xác thực'),
            new Response(response: '403', description: 'Không có quyền truy cập'),
            new Response(response: '405', description: 'Phương thức không hợp lệ')
        ]
    )]
    public function getAllProducts(): void
    {
        $this->validMethod('GET');
        $coffees = $this->coffeeService->getAll();
        echo json_encode($coffees, JSON_UNESCAPED_UNICODE);
    }

    #[Get(
        path: '/api/v1/categories',
        summary: 'Lấy danh sách danh mục',
        tags: ['Category'],
        responses: [
            new Response(response: '200', description: 'Thành công'),
            new Response(response: '401', description: 'Chưa xác thực'),
            new Response(response: '403', description: 'Không có quyền truy cập'),
            new Response(response: '405', description: 'Phương thức không hợp lệ')
        ]
    )]
    public function getAllCategories(): void
    {
        $this->validMethod('GET');
        $categories = $this->categoryService->getAll();
        echo json_encode($categories, JSON_UNESCAPED_UNICODE);
    }

    #[Post(
        path: '/api/v1/products',
        summary: 'Thêm sản phẩm',
        tags: ['Product'],
        responses: [
            new Response(response: '201', description: 'Thêm thành công'),
            new Response(response: '400', description: 'Dữ liệu không hợp lệ'),
            new Response(response: '401', description: 'Chưa xác thực'),
            new Response(response: '403', description: 'Không có quyền truy cập'),
            new Response(response: '405', description: 'Phương thức không hợp lệ')
        ]
    )]
    public function add(): void
    {
        $this->validMethod('POST');
        $input = json_decode(file_get_contents('php://input'), true);
        $imgPath = '';

        if ($_FILES['Image']['name']) {
            $imgPath = $this->uploadImage($_FILES['Image']) ?? '';
            if (!$imgPath) {
                http_response_code(400);
                echo json_encode(['image_error' => $_SESSION['image_error']]);
                unset($_SESSION['image_error']);
                exit;
            }
        }

        $product = $this->coffeeFactory->create(
            id: null,
            name: htmlspecialchars($input['Name'], ENT_QUOTES, 'UTF-8'),
            price: htmlspecialchars($input['Price'], ENT_QUOTES, 'UTF-8'),
            image: $imgPath,
            description: htmlspecialchars($input['Description'], ENT_QUOTES, 'UTF-8') ?? '',
            category_id: htmlspecialchars($input['category_id'], ENT_QUOTES, 'UTF-8')
        );

        if (!$this->validation($product)) {
            http_response_code(400);
            echo json_encode($_SESSION['errors']);
            unset($_SESSION['errors']);
            exit;
        }

        $this->coffeeService->create($product);
        http_response_code(201);
        echo json_encode(['success' => 'Thêm thành công']);
    }

    private function uploadImage(mixed $image): ?string
    {
        if (!is_dir($this::FILE_PATH)) {
            mkdir($this::FILE_PATH, 0777, true);
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
            move_uploaded_file($fileTemp, $this::FILE_PATH . $fileName);
        } else {
            $_SESSION['image_error'] = $errors;
            return null;
        }

        return $this::FILE_PATH . $fileName;
    }

    private function validation($product): bool
    {
        if (!strlen($product->name) || strlen($product->name) > 50) {
            $errors[] = ['name_error' => 'Tên sản phẩm không được để trống và tối đa 50 ký tự'];
        }

        if (!filter_var(
            $product->price,
            FILTER_VALIDATE_INT,
            ['options' => [
                'min_range' => 0,
                'max_range' => 1000000000,
                'default' => 0]
            ])
        ) {
            $errors[] = ['price_error' => 'Giá sản phẩm phải là số và tối đa 1 tỷ'];
        }

        if (!strlen($product->description) > 255) {
            $errors[] = ['description_error' => 'Mô tả sản phẩm tối đa 255 ký tự'];
        }

        if (!strlen($product->image) > 255) {
            $errors[] = ['image_error' => 'Đường dẫn ảnh sản phẩm tối đa 255 ký tự'];
        }

        if (isset($errors)) {
            $_SESSION['errors'] = $errors;
            return false;
        }

        return true;
    }

    #[Delete(
        path: '/api/v1/delete',
        summary: 'Xóa sản phẩm',
        tags: ['Product'],
        responses: [
            new Response(response: '200', description: 'Xóa thành công'),
            new Response(response: '400', description: 'Dữ liệu không hợp lệ'),
            new Response(response: '401', description: 'Chưa xác thực'),
            new Response(response: '403', description: 'Không có quyền truy cập'),
            new Response(response: '405', description: 'Phương thức không hợp lệ')
        ]
    )]
    public function delete(): void
    {
        $this->validMethod('DELETE');
        $input = json_decode(file_get_contents('php://input'), true);
        $coffee = $this->coffeeService->getById(
            (int)htmlspecialchars($input['id'], ENT_QUOTES, 'UTF-8')
        );

        if ($coffee) {
            if ($coffee->image && file_exists($coffee->image)) {
                unlink($coffee->image);
            }
            $this->coffeeService->delete(
                (int)htmlspecialchars($input['id'], ENT_QUOTES, 'UTF-8')
            );
        }

        http_response_code(200);
        echo json_encode(['success' => 'Xóa thành công']);
    }

    #[Get(
        path: '/api/v1/getById',
        summary: 'Lấy danh sách sản phẩm theo id',
        tags: ['Product'],
        responses: [
            new Response(response: '200', description: 'Lấy thành công'),
            new Response(response: '401', description: 'Chưa xác thực'),
            new Response(response: '403', description: 'Không có quyền truy cập'),
            new Response(response: '405', description: 'Phương thức không hợp lệ')
        ]
    )]
    public function getById(): void
    {
        $this->validMethod('GET');
        $coffee = $this->coffeeService->getById(
            (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8')
        );

        if ($coffee) {
            echo json_encode(['coffee' => $coffee], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Không tìm thấy sản phẩm']);
        }
    }

    #[Put(
        path: '/api/v1/update',
        summary: 'Cập nhật sản phẩm',
        tags: ['Product'],
        responses: [
            new Response(response: '200', description: 'Cập nhật thành công'),
            new Response(response: '400', description: 'Dữ liệu không hợp lệ'),
            new Response(response: '401', description: 'Chưa xác thực'),
            new Response(response: '403', description: 'Không có quyền truy cập'),
            new Response(response: '405', description: 'Phương thức không hợp lệ')
        ]
    )]
    public function update(): void
    {
        $this->validMethod('PUT');
        $input = json_decode(file_get_contents('php://input'), true);
        $coffee = $this->coffeeService->getById(
            (int)htmlspecialchars($input['Id'], ENT_QUOTES, 'UTF-8')
        );

        if (!$coffee) {
            http_response_code(404);
            echo json_encode(['error' => 'Không tìm thấy sản phẩm'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $imgPath = $coffee->image;

        if ($_FILES['Image']['name']) {
            if ($imgPath && file_exists($this::FILE_PATH . $coffee->image)) {
                unlink($coffee->image);
            }

            $imgPath = $this->uploadImage($_FILES['Image']) ?? '';

            if (!$imgPath) {
                http_response_code(400);
                echo json_encode(
                    ['image_error' => $_SESSION['image_error']],
                    JSON_UNESCAPED_UNICODE
                );
                unset($_SESSION['image_error']);
                exit;
            }
        }

        $product = $this->coffeeFactory->create(
            id: htmlspecialchars($input['Id'], ENT_QUOTES, 'UTF-8'),
            name: htmlspecialchars($input['Name'], ENT_QUOTES, 'UTF-8'),
            price: htmlspecialchars($input['Price'], ENT_QUOTES, 'UTF-8'),
            image: $imgPath ?? '',
            description: htmlspecialchars($input['Description'], ENT_QUOTES, 'UTF-8') ?? '',
            category_id: htmlspecialchars($input['category_id'], ENT_QUOTES, 'UTF-8')
        );

        if (!$this->validation($product)) {
            http_response_code(400);
            echo json_encode($_SESSION['errors'], JSON_UNESCAPED_UNICODE);
            unset($_SESSION['errors']);
            exit;
        }

        $this->coffeeService->update($product);
        http_response_code(200);
        echo json_encode(['success' => 'Cập nhật thành công'], JSON_UNESCAPED_UNICODE);
    }
}