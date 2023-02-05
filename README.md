# Router
--
use System\Router;

use App\Controllers\Message\IndexController as Main;
use App\Controllers\Message\SaveController as Save;
use App\Controllers\Message\Add as Add;


Router::group ('/message', function (){
    Router::post ('/save', new Save);
    Router::get ('/add/{:id}', new Add);
    Router::get ('/', new Main);
});
--
