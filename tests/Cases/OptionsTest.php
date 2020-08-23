<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Pff\HyperfTest\Cases;

use Hyperf\Constants\AnnotationReader;
use Hyperf\Constants\ConstantsCollector;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\Translation\ArrayLoader;
use Hyperf\Translation\Translator;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;
use Mockery;
use Pff\HyperfTest\Cases\Stubs\OptionsConstants;

/**
 * @internal
 * @coversNothing
 */
class OptionsTest extends AbstractTestCase
{

    protected function setUp()
    {
        $reader = new AnnotationReader();

        $ref = new \ReflectionClass(OptionsConstants::class);
        $classConstants = $ref->getReflectionConstants();

        $data = $reader->getAnnotations($classConstants);
        ConstantsCollector::set(OptionsConstants::class, $data);

        Context::set(sprintf('%s::%s', TranslatorInterface::class, 'locale'), null);
    }

    public function testOptionsConstants()
    {
        $this->getContainer();


        $this->assertEquals('ok', OptionsConstants::getMessage(1));
        $this->assertEquals([
            1 => [
                "message"=> "ok",
                "info" => "ok-info",
                "goodsinfodesc"=> "abcde"
            ],
            -1=>
                [
                    "message"=> "delete",
                    "info"=> "delete-info"
                ],
            0=>[
                "message"=> "forbid",
                "info"=> "forbid-info"
            ]
        ], OptionsConstants::options());
    }


    public function testOptions()
    {
        $this->assertTrue(true);
    }

    protected function getContainer($has = false)
    {
        $container = Mockery::mock(ContainerInterface::class);
        ApplicationContext::setContainer($container);

        $container->shouldReceive('get')->with(TranslatorInterface::class)->andReturnUsing(function () {
            $loader = new ArrayLoader();
            $loader->addMessages('en', 'error', [
                'message' => 'Error Message',
                'not_exist' => ':name is not exist.',
            ]);
            $loader->addMessages('zh_CN', 'error', ['message' => '错误信息']);
            return new Translator($loader, 'en');
        });

        $container->shouldReceive('has')->andReturn($has);

        return $container;
    }
}
