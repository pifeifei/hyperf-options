# hyperf options

```
composer require pifeifei/hyperf-options
```

## 使用

```php
// app/Constants/AbstractConstants.php
namespace App\Constants;
class AbstractConstants extends \Hyperf\Constants\AbstractConstants
{
    use \Pff\HyperfOptions\Concerns\OptionsConstants;
}
// app/Constants/Status.php
class Status extends AbstractConstants
{
    /**
     * @Message("ok")
     * @Info("content 1")
     * @Desc("sequential_array")
     * @GoodsInfoDesc("abcde")
     */
    const SERVER_OK = 1;

    /**
     * @Message("delete")
     * @Info("content -1")
     * @lang("validation.sequential_array")
     */
    const SERVER_DELETE = -1;

    /**
     * @Message("forbid")
     * @Info("content 0")
     */
    const SERVER_FORBID = 0;
}


// app/Model/Model.php
namespace App\Model;
abstract class Model extends \Hyperf\DbConnection\Model\Model 
{
    use \Pff\HyperfOptions\Concerns\Options;
}

namespace App\Model;
class Test extends Model
{
    /* @var array */
    public $options = [
    //    'status' => [Status::class, 'Message'],
    //    'status' => Status::class, // default: Message
        'status' => [\App\Constants\Status::class, 'info']
    ];

    /**
     * @return mixed
     */
    public function getStatusOptionAttribute()
    {
        return $this->getOption('status');
    }

    public function getStatusOptionsAttribute($default = null)
    {
        return $this->getStatusOptions($default);
    }
}


// use
$test = new \App\Model\Test();
$result = $test::query()->orderByDesc('id')->first(); // {"id":1,"status":1}
var_dump($result->status_option); // return：'content 1'
var_dump($result->status_options); // return: [1=>'content 1', 0=>'content 0', -1 => 'content -1']
```
