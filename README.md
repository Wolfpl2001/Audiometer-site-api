# Quantum MVC Framework 
### Version 1.0

## Goal
Quantum MVC is a PHP-based MVC framework focusing on object-oriented programming and efficient routing.

## Key Features
- Routing
- Object-oriented programming (OOP)
- MVC architecture

## System Requirements
This framework requires a web server with PHP support. The exact version requirements are not specified.

## Installation
1. Place the framework in the `htdocs` directory of your localhost.
2. Create a `.htaccess` file in the `htdocs` directory and add the following code:
    ```
    RewriteEngine On
    RewriteRule ^(.*)$ quantum-mvc/ [L]
    ```
3. Start the web server.
4. Go to `localhost` in your browser to use the framework.

## Usage and Examples

### Routing Configuration
Routes should be defined in the `web.php` file within your Quantum MVC project. This file serves as the central location for route definitions.

Example of route definitions in `web.php`:
```php
// Define routes using the Quantum MVC syntax
$app::get('/', 'HomeController', 'test');
$app::post('/test', 'HomeController', 'test');
```
## Contact Information

For questions, comments, or support, you can contact via Discord: timba1329.