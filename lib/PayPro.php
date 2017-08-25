<?php

namespace PayPro;

/**
 * Class PayPro
 *
 * @package PayPro
 */
class PayPro {
    // @var string Base url of the API
    public static $apiUrl = 'https://www.paypro.nl/post_api';

    // @var string File location of the certificate bundle
    public static $caBundleFile = '../data/ca-bundle.crt';

    const VERSION = '0.0.1';
    const API_VERSION = 'v1';
}
