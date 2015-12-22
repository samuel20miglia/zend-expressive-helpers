<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-helpers for the canonical source repository
 * @copyright Copyright (c) 2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-helpers/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Expressive\Helper\BodyParams;

use PHPUnit_Framework_TestCase as TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Helper\BodyParams\FormUrlEncodedStrategy;

class FormUrlEncodedStrategyTest extends TestCase
{
    public function setUp()
    {
        $this->strategy = new FormUrlEncodedStrategy();
    }

    public function formContentTypes()
    {
        return [
            ['application/x-www-form-urlencoded'],
            ['application/x-www-form-urlencoded; charset=utf-8'],
            ['application/x-www-form-urlencoded;charset=utf-8'],
            ['application/x-www-form-urlencoded;Charset="utf-8"'],
        ];
    }

    /**
     * @dataProvider formContentTypes
     */
    public function testMatchesFormUrlencodedTypes($contentType)
    {
        $this->assertTrue($this->strategy->match($contentType));
    }

    public function invalidContentTypes()
    {
        return [
            ['application/x-www-form-urlencoded2'],
            ['application/x-www-form-urlencoded-too'],
            ['form/multipart'],
            ['application/json'],
        ];
    }

    /**
     * @dataProvider invalidContentTypes
     */
    public function testDoesNotMatchNonFormUrlencodedTypes($contentType)
    {
        $this->assertFalse($this->strategy->match($contentType));
    }

    public function testParseReturnsOriginalRequest()
    {
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        $this->assertSame($request, $this->strategy->parse($request));
    }
}
