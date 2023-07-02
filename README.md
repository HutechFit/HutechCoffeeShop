# HutechCoffeeShop

<p align="justify">
This project is a coffee shop management system developed using PHP 8.2. It incorporates the Repository pattern and Factory pattern to enhance code organization and maintainability. The project is authored by Nguyen Xuan Nhan.
</p>

## Technology

<p align="justify">
The project is built using PHP 8.2, a popular server-side scripting language known for its flexibility and wide range of features. PHP 8.2 introduces several improvements and enhancements over previous versions, making it an ideal choice for this project.
</p>

## Repository pattern

<p align="justify">
The Repository pattern is a software design pattern that separates the data access logic from the business logic in an application. It provides a consistent and unified interface to interact with data sources, such as databases, APIs, or file systems. By implementing the Repository pattern, the project achieves better separation of concerns and promotes easier testing and maintenance.
</p>

## Factory pattern

<p align="justify">
The Factory pattern is another software design pattern utilized in this project. It provides an interface for creating objects without exposing the underlying creation logic. By employing the Factory pattern, the project achieves encapsulation and abstraction, allowing for more flexible object creation and decoupling from specific implementations.
</p>

## Composer packages

<p align="justify">
The project includes several Composer packages to enhance its functionality and simplify development. These packages are listed below:
</p>

- `psr/container`: This package implements the PSR-11 Container Interface, which provides a standard interface for dependency injection containers.
- `ext-intl`: This package provides internationalization functions for PHP, enabling the project to handle multilingual features effectively.
- `ext-pdo`: This package enables the use of the PDO (PHP Data Objects) extension, which provides a consistent interface for accessing databases.
- `vlucas/phpdotenv`: This package allows the project to load environment variables from a `.env` file, simplifying the configuration process.
- `ext-sodium`: This package provides the Sodium cryptographic library for PHP, enabling secure encryption and decryption operations.
- `firebase/php-jwt`: This package implements JSON Web Token (JWT) support for PHP, facilitating token-based authentication and authorization.
- `zircote/swagger-php`: This package enables the generation of Swagger/OpenAPI documentation for the project's APIs, enhancing interoperability and developer experience.

## Getting Started

To get started with the HutechCoffeeShop project, follow these steps:

1. Clone the repository to your local machine.
2. Ensure that you have PHP 8.2 or a compatible version installed.
3. Run `composer install` to install the required dependencies.
4. Create a `.env` file based on the provided `.env.example` file and set the necessary configuration variables.
5. Set up a web server (such as Apache or Nginx) to serve the project.
6. Access the project in your web browser and start exploring the coffee shop management system.

## Contribution

<p align="justify">
Contributions to the HutechCoffeeShop project are welcome. If you encounter any issues, have suggestions, or want to contribute improvements, please feel free to submit a pull request or open an issue on the project's repository.
</p>

## License

The HutechCoffeeShop project is licensed under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.en.html). You are free to use, modify, and distribute the project as per the terms of this license.
