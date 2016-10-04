<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Http\Request;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function __construct(Application $app, Encrypter $encrypter) {
        $this->_maxUploadFileSize();

        parent::__construct($app, $encrypter);
    }

    /**
     * Max Upload File Size filter
     * 
     * Check if a user uploaded a file larger than the max size limit.
     * This filter is used when we also use a CSRF filter and don't want
     * to get a TokenMismatchException due to $_POST and $_GET being cleared.
     */
    private function _maxUploadFileSize() {
        if(!(request()->isMethod('POST') || request()->isMethod('PUT'))) {
            return;
        }

        // Get the max upload size (in Mb, so convert it to bytes)
        $maxUploadSize = 1024 * 1024 * ini_get('post_max_size');
        $contentSize = 0;

        if(isset($_SERVER['HTTP_CONTENT_LENGTH'])) {
            $contentSize = $_SERVER['HTTP_CONTENT_LENGTH'];
        } else if(isset($_SERVER['CONTENT_LENGTH'])) {
            $contentSize = $_SERVER['CONTENT_LENGTH'];
        }

        if($contentSize > $maxUploadSize) {
            throw new \Exception('Max file upload size exceeded.');
        }
    }
}
