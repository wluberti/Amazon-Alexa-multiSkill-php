# Amazon Alexa multiSkill PHP Library

This library is an addition to https://github.com/jakubsuchy/amazon-alexa-php

It adds the ability to use multiple Amazon skills in a single web application just by adding configurationfiles that hold your application id and a mapping of which skill should be mapped to which PHP-function in you script.

## About this script

- Point you webserver to '/public'
- Put your Amazon skills in '/Skills' under the name of your Amazone Endpoint (as configured on https://developer.amazon.com -> YourSkill -> Configuration -> HTTPS -> 'https://yourdomain.tld/ENDPOINT')
- Put your config in '/Skills/ENDPOINT/ENDPOINT.json' (see '/Skills/skillname.json_example' for structure)
- Put your PHP logic/functions in '/Skills/ENDPOINT/ENDPOINT.php'. The functions you use must exist in your .json config

## Todo
- Making the script run the PHP functions ;)


## Pre requisites
- A running Apache or Nginx webserver capable of accepting https requests on port 443
- Composer, php7.0 and php7.0-curl installed (should work on older PHP-versions, but then remove the typehinting I used in the scripts)
- Run composer to add the files needed for this script:
 ```
 composer require jakubsuchy/amazon-alexa-php
 ```
 
##### Apache conf snippet
```
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```

##### Nginx conf snippet
```
if (!-e $request_filename) {
    rewrite ^/(.*)$ /index.php?/$1 last;
    break;
}
```

##### Some usefull links on setting up Nginx, PHP7.0 and a https certificate
https://www.digitalocean.com/community/tutorials/how-to-secure-nginx-with-let-s-encrypt-on-ubuntu-16-04
https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-in-ubuntu-16-04 (just use the Nginx and PHP7 parts)