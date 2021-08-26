<?php
$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
$resource = openssl_pkey_new($config);

// Extract private key from the pair
openssl_pkey_export($resource, $private_key);

// Extract public key from the pair
$key_details = openssl_pkey_get_details($resource);
$public_key = $key_details["key"];

$keys = array('private' => $private_key, 'public' => $public_key);

$publicKey=$keys['public'];
$privateKey=  $keys['private'];

$plaintext= "this is a good day ";

//encrype data
openssl_public_encrypt($plaintext, $encrypted, 'iG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwTuq9oJwd7KiIAle5lPh 8fIwK5daohOruLRfIhCtX9E9yGY8ez5Ky6kpluwYDxkrMBxdwygeTbJVDGgmFJI1 RknryuoItq0CiCGt7QxF016pmZmc1aHqVyalkOXApQ4l9JuC4rE7Vvr8DbVhq+H3 0yzz1XFdn4wdFxcPfFy7t47fQCgS1cO+OiBnZ7dXxm9m3hDndxkGE1Invax3wz4t kA3Mw9wAFht+YCOOCZlbgFMMHKKj5c/LZMVcEpyBCPmNdQTtgHjF5mKnjKt7ONRR y3MKjakvnbrjqexCkrLOllhuBDeVbIkBVDBKRTqBA5jUoOhXUl3WIC7F0stDCsHN KwIDAQAB -----END PUBLIC KEY----');
// Use base64_encode to make contents viewable/sharable
$message = base64_encode($encrypted);
echo $message."</br></br>";
$ciphertext = base64_decode($message);
  
openssl_private_decrypt($ciphertext, $decrypted, '-----BEGIN PRIVATE KEY----- MIIEvQIB78ANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCi7JD3lD+R/B8Y 27QOeRFN4VV5K1ysWG2em0Gt/kn2vIYSp4Au22W6DBAABD5GvfMZtiR9vtYMbl7X YQoni/4opJ/3Pgp7XQUVeW5QAN3fxdcy9UGXaaQK0Eo3FioViHDyX20yeHSV2sRf KxlNKVUCM4YPa3N+cgQIQ5poCD3x9EXSCkfyJsKRyA0sWJH40mBbuPuMALoijztJ H1KRuQ1VfI6ws7tQxGrJewvmT5WXzG9gIm+AywQ0k0fTQFaci73W2W3qSIIeUwW2 KYwBy+wOsQr3maRpFl6MeYtnCxed6dg2LWQi+uh38HsANbF8auXmodne5W6MCp3k j5OByXtjAgMBAAECggEAVParjwE3uajSisMgfh+y33tweJUdah9fY0QyF0uyRMMB 5D6HwWfXABQEUA3mcDvkx/bNxum7dJYmTYmkowUFkSpw5Z3sF3NmEFHYLk6VZnol BMUT5KNJ0f3Xhiy/26TgyfTr3FMm8XM5zyuJsUypsVEvS2FMxJcu9SRUJIaPz1ov rRYA8KC1ke3HYvUmIrgFjczu2Jg/1/PFsnsl+RhVJpASPumGQC0LN68Tcokuiwv0 gBKsG8gORYA5IbAAhEbwomH8OggXENpr4NQ6QRquC8CG7/cZYaeTlW55fi6WX9w2 lPIYYlHW7dlxgOyr4HXtWuI9jGni7tuLLX0XxNvG0QKBgQDX37oZBaZ61+hmbHGh QXew+ULoCleXpyeU3cY+jAMqQnrCoI9RbHKad/eAUZht2p798i1VoYBmukwjSv3p 9uXODussSa48hx4X1TcgIXDtx69P++EpWM4eXR2ZzeBkOQ7ItXtz5SPtSdrG9qV5 SRECFto4eDB23+EieInKrvQ/SwKBgQDBNT4UKdAS+UjvLxX6u14wRggNVoH2yfee V78newfWe8+wCqGKM0YcWw3v7Or7GCjuBHYKLSkeGz5G3IxSxefvdNt5Ky4zCY1E BixtMyADOa1Q001T4/v1g1Gdci+h/Yk1nslX8XsUUff0yCIcpHFjgntSha8bfHHL Whp+WMHtSQKBgERVHGpZQIZ4G6d4QkvCFmodrNEYnPtzPPNBdEROO54/5u3+tv8W Lfy5Zs3mhjKX1mYaJ8GIWsWpyPoO/er2bW3ZiRW+yPl958exhT6Vd1K9N8BAwdg9 tRklbn5GDfaLnSNpVweri8DL9QWwA1cuCsU3iKIBYY3vditcLnnLAaObAoGAS2Wi py22BGGBw81FL4aE+COsKsBSkWM5nXIyp46MfXftkY5kgdEGkDQ8WR/Eh15jQpc9 FTWQcS5CfFa+7+JJY5nfuAZQzhvxI9Wg6rBj0r5kU0FSUOWMQsAPTnjr+7Q8Ik+n 1QjodgKS19Rt8218zk9yHr8KmZhTs/6ijiHG8/kCgYEAg3en1tq4osGFMVUGjQZc xAjF3riz4yHDWePDVSszwNmdCJslUJ5QLHsA92qYAWTTfcAooQouwp+AeCXKpdT8 pMr3gseUwxg6/NV6T4dHNCvQNkcuhvlMkH8cqJCSeIgmDrm3KVtEKXHqdIjl55tC 8gMNF+LVF4Zbrv+osP9Kg+M= -----END PRIVATE KEY-----');

echo $decrypted;



?>