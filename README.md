# proxy
Simple PHP Proxy Server for hiding api key. One for many websites.

All you need to do is to create a file websites.php in store directory and add a websites that base on websites.example.php

Notice: Currently supports only GET request

## Requirements:
- PHP 7.4+
- Composer
- Apache server
## Installation:
### Locally:
- Run composer install

### Server:
- composer install --no-dev

## How to use
- Check the websites.example in store directory
- Set "domain" header in your http client (axios, fetch etc...)
- "domain" and "base_url" must have the same value
- When values is matched, key (api_key_name and key_value) will be added to the request


