<?php
namespace ZulipTest\Request;

class SimpleParamTraitTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        if (!class_exists('\SimpleParamTraitClass')) {
            include ZULIP_TEST_DIR . '/fixtures/SimpleParamTraitClass.php';
        }

        if (!class_exists('\EmptyParamTraitClass')) {
            include ZULIP_TEST_DIR . '/fixtures/EmptyParamTraitClass.php';
        }
    }

    public function testGetData()
    {
        $traitClass = new \SimpleParamTraitClass();
        $data = $traitClass->getData();
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('from', $data);
        $this->assertArrayHasKey('to', $data);
        $this->assertEquals('this is a test', $data['from']);
    }

    /**
     * @depends testGetData
     */
    public function testCallMagicMethod()
    {
        $traitClass = new \SimpleParamTraitClass();
        $traitClass->setFrom('test123');
        $data = $traitClass->getData();
        $this->assertEquals('test123', $data['from']);
    }

    public function testCallMagicMethodOnNonExistentParam()
    {
        $this->setExpectedException('\RuntimeException');
        $traitClass = new \SimpleParamTraitClass();
        $traitClass->setNonExistentParam('rawr');
    }

    public function testCallMagicMethodWithoutGetPrefix()
    {
        $this->setExpectedException('\BadMethodCallException');
        $traitClass = new \SimpleParamTraitClass();
        $traitClass->callFooMethod();
    }

    public function testCallMagicMethodWithEmptyMethods()
    {
        $this->setExpectedException('RuntimeException');
        $traitClass = new \EmptyParamTraitClass();
        $traitClass->getInfo();
    }
}