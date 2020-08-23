<?php

namespace Pff\HyperfOptions\Concerns;


use Hyperf\Constants\ConstantsCollector;
use Hyperf\Utils\Str;

trait OptionsConstants
{
    /**
     * Retrieve the metadata via key.
     * @param null|mixed $default
     * @param array $arguments
     * @return null|mixed
     */
    public static function options($default = null, $arguments = [])
    {
        $options = ConstantsCollector::get(get_called_class(), $default);
        foreach ($options as & $option) {
            foreach ($option as & $item) {
                if (Str::contains($item, '.')) {
                    $item = self::translate($item, [$arguments]);
                }
            }
        }

        unset($item, $option);
        return $options;
    }
}