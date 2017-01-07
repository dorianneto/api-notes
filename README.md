# api-notes
[![Travis](https://img.shields.io/travis/rust-lang/rust.svg)](https://travis-ci.org/dorianneto/api-notes)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d7b8471cf3b6477a9e8a056ed633c293)](https://www.codacy.com/app/doriansampaioneto/api-notes?utm_source=github.com&utm_medium=referral&utm_content=dorianneto/api-notes&utm_campaign=badger)

It is a simple api authenticated to get notes assigned an user.

## Highlights

* Simple API
* Fully documented
* Fully unit tested
* Utilizes JWT to Authentication
* Developed in Lumen v5.3

## System Requirements

You need **PHP >= 5.6.4** to use this API, but the latest stable version of PHP is recommended.

api-notes is verified and tested on PHP 5.6 and 7.0.

It's necessary have installed OpenSSL, PDO and Mbstring PHP Extension.

## Installation

...

## API

This api is authenticated by JWT, then, it's interesting that you read the [JWT Auth wiki](https://github.com/tymondesigns/jwt-auth/wiki)

Route | Description
------|------------
`POST` api/auth | Generates an JWT token to enable an user to use the API
`POST` api/logout | Invalidates the JWT token (**require JWT token to authorize access**)
`GET` api/notes | Returns all notes from an user (**require JWT token to authorize access**)
`GET` api/notes/{id} | Returns only one note from an user (**require JWT token to authorize access**)
`POST` api/notes | Stores an note assigned an user (**require JWT token to authorize access**)
`PUT` api/notes/{id} | Updates an note assigned an user (**require JWT token to authorize access**)
`DELETE` api/notes/{id} | Deletes an note assigned an user (**require JWT token to authorize access**)
`POST` api/sign_up | Stores an new user
`POST` api/reset | Sends email to reset password from an user
`PUT` api/reset/{token} | Resets the user password

*I'm suggest you to use Postman to test the API*

## Documentation

See the full documentation through this [link](http://hsa.dorianneto.com.br).

## License

api-notes is open-sourced software licensed under the MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
