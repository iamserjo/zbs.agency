This is a test assignment, it is based on laravel framework, no additional libraries used. 
PHP version: 8.3.3
Docker: PHP-fpm, nginx, mysql 8

Project contains 5 endpoints
``````
    Method  Path                  Controller@action
    GET     api/v1/positions .... PositionController@index
    GET     api/v1/token ........ UserController@generateToken
    POST    api/v1/users ........ UserController@register
    GET     api/v1/users ........ UserController@getUsers
    GET     api/v1/users/{user} . UserController@getUserById
```````
In order to create those endpoints I used AI assistant in PhpStorm.\
AI assistant helped me to create the most code and docker env, but there were many complicated places in the code so AI assistant usually cannot handle. AI speeds up writing code very well, so productivity is on a high level. 
