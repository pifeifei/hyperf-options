<?php


namespace Pff\HyperfTest\Cases\Stubs;

use Hyperf\Constants\AbstractConstants;

/**
 * Class Options
 * @package Pff\HyperfTest\Cases\Stubs
 * @method static string getMessage(int $status, array $arguments = null)
 * @method static string getInfo(int $status, array $arguments = null)
 */
class OptionsConstants extends AbstractConstants
{
    use \Pff\HyperfOptions\Concerns\OptionsConstants;

    /**
     * @Message("ok")
     * @Info("ok-info")
     * @GoodsInfoDesc("abcde")
     */
    const SERVER_OK = 1;

    /**
     * @Message("delete")
     * @Info("delete-info")
     */
    const SERVER_DELETE = -1;

    /**
     * @Message("forbid")
     * @Info("forbid-info")
     */
    const SERVER_FORBID = 0;
}