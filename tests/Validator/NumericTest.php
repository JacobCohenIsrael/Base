<?php
use JCI\Base\Validator\Numeric;

class NumericTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Numeric
     */
    private $numeric;

    protected function setUp()
    {
        $this->numeric = new Numeric();
    }

    protected function tearDown()
    {
        $this->numeric = null;
    }

    public function testValidateOk()
    {
        $this->assertTrue($this->numeric->validate(2));
    }
    
    public function testValidateNotOk()
    {
        $this->assertFalse($this->numeric->validate('asdasdsads'));
    }
    
    
}

