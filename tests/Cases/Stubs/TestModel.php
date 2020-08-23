<?php


namespace Pff\HyperfTest\Cases\Stubs;

use Hyperf\DbConnection\Model\Model as BaseModel;
use Pff\HyperfOptions\Concerns\Options;


class TestModel extends BaseModel
{
    use Options;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test';

    /**
     * @var array
     */
    public $options = [
//        'status' => [Status::class, 'Message'],
//        'status' => Status::class, // default Message
        'status' => [OptionsConstants::class, 'info']
    ];

    /**
     * @return mixed
     */
    public function getStatusOptionAttribute()
    {
        return $this->getOption('status');
    }

    /**
     * @param null|array $default
     * @return array|null
     */
    public function getStatusOptions($default = null)
    {
        return $this->getOptions('status', $default);
    }

    public function getStatusOptionsAttribute($default = null)
    {
        return $this->getStatusOptions($default);
    }
}
