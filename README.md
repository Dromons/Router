# Router
PHP Simple Router
###### Простой маршрутизатор на PHP

The router supports groups of routes, has a division into POST and GET requests, passes GET parameters directly to the PHP class.

In index.php file

```
// message/save
// message/add/123 in PHP class $id = 123
// message/user/@id123 in PHP class $id = 123

Router::group ('/message', function (){
    Router::post ('/save', new App\Controller\Save);
    Router::get ('/add/{:id}', new App\Controller\Add);
    Router::get ('/user/@id{:id}', [new App\Controller\User, 'Views']);
});

Router::group ('/message', function (){
    Router::group ('/add', function (){
        Router::get ('/{:id}', new App\Controller\Add);
        Router::get ('/id{:id}', new App\Controller\AddId);
    });
});

// OR

Router::get ('/', function () {
    return "Index File View";
});

```
Next String

```
echo Router::run ();
```
