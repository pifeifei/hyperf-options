<?php


namespace Pff\HyperfOptions\Concerns;


use Hyperf\Utils\Str;

trait Options
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param $field
     * @param null|array $default
     * @param array $arguments
     * @return array|null
     */
    public function getOptions($field, $default = null, $arguments = [])
    {
        if (! isset($this->options[$field])) {
            return $default;
        }

        $call = $this->getOptionCall($field);
        $options = $call[0]::options($default, array_merge(['attribute' => $field], $arguments));
        $method = Str::lower(Str::after($call[1], 'get'));
        foreach ($options as & $option) {
            $option = $option[$method] ?? null;
        }
        unset($option);
        return $options;
    }

    public function getOption($field, $arguments = [])
    {
        return call(
            $this->getOptionCall($field),
            [$this->getAttribute($field), [array_merge(['attribute' => $field], $arguments)]]
        );
    }

    /**
     * @param string $field
     * @return array
     */
    protected function getOptionCall(string $field)
    {
        $call = is_array($this->options[$field]) ? $this->options[$field] : [$this->options[$field], 'Message'];
        $call[1] = 'get' . Str::after(Str::lower($call[1]), 'get');
        return $call;
    }
}