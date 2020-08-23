# component-creater

```
composer create-project hyperf/component-creater
```

## 使用

```php
// App\Constants/AbstractConstants.php
namespace App\Constants;
use Hyperf\Constants\AbstractConstants as BaseAbstractConstants;
use Pff\HyperfOptions\Concerns\OptionsConstants;
class AbstractConstants extends BaseAbstractConstants
{
    use OptionsConstants;
}

// app/Model/Model.php
namespace App\Model;

use Pff\HyperfOptions\Concerns\Options;
use Hyperf\DbConnection\Model\Model as BaseModel;
abstract class Model extends BaseModel 
{
    use Options;
}

namespace App\Model;
class Test extends Model
{
        /* @var array */
        public $options = [
    //        'status' => [Status::class, 'Message'],
    //        'status' => Status::class, // 默认 Message
            'status' => [\App\Constants\ErrorCode::class, 'info']
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


// 使用
$test = new \App\Model\Test();
$result = $test::query()->orderByDesc('id')->first();
var_dump($result->status_option);
var_dump($result->status_options);
```
