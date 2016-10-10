# VideoSharing
It is project for me to start with [laravel](https://laravel.com/).
`VideoSharing` is a simple website to share videos with other people like youtube.

### Features of VideoSharing
* Authentication
    * Register
    * Login
    * Logout
    * Remember me
* Sharing videos
    * Show top ten videos on home page
    * Upload videos
    * Delete vodeos
    * Search videos

### Requirements
* PHP >= 5.6.4
* [Composer](https://getcomposer.org/)
* [elasticsearch 2.4]()

### Quickstart
* Set file `.env` like [offical laravel example](https://github.com/laravel/laravel/blob/master/.env.example).
* Dependency installation and database setting.
    ```bash
    cd VideoSharing
    composer install
    php artisan migrate
    php es_index_setting.php
    ```
* Start server.
    * Use PHP ClI
    ```
    php artisan serve
    ```
    * Use your own server environment like apache2, nginx.

* Connect server through browser http://localhost:8000.

### TODOs
 - A better method to provide the appropriate videos to clients on VideoSharing home page.
 - Screenshot of every uploaded video.
 - Functionality of forgetting password.
 - Fix some bugs.
 
License
----
MIT