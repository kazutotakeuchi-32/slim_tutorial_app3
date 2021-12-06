## Installation
  ### インストール
  ``` bash
    git clone https://github.com/kazutotakeuchi-32/slim_tutorial_app3.git
  ```
## Usage

  ### ローカルサーバ構築
  ```bash
    #初回
    composer install
    composer start
    php -S localhost:8080 -t  ./src/public
  ```

 ### デバック
 ```bash
  # GET
  curl http://localhost:8080/api/v1/users

  # POST
  curl -X POST \
  -d "firstname=kazuto&lastname=takeuchi&age=22&email=tes@test.com&location=JP" \  
  http://localhost:8080/users

  # PUT
  curl -X PUT  \
  -d "firstname=kazu&lastname=satou&age=10&email=tes@test10.com&location=E" \ 
  http://localhost:8080/users/:id

  # DELETE 
  curl -X DELETE  http://localhost:8080/:id
 ```

## Requirement

  - slim
    - [公式リファレンス](https://www.slimframework.com/docs/v3/tutorial/first-app.html)
    - [php-view](https://github.com/slimphp/PHP-View)
    - [slim](https://github.com/slimphp/Slim)

  - [http-message](https://github.com/php-fig/http-message/blob/master/docs/PSR7-Interfaces.md)
    - [ServerRequestInterface](https://www.php-fig.org/psr/psr-7/#psrhttpmessageserverrequestinterface)
    - [ResponseInterface](https://www.php-fig.org/psr/psr-7/#psrhttpmessageresponseinterface)

  - [monolog](https://github.com/Seldaek/monolog)

