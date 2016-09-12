<?php
use JCI\Base\Validator\Email;
/**
 * Email test case.
 */
class EmailTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Email
     */
    private $email;

    protected function setUp()
    {
        $this->email = new Email(/* parameters */);
    }

    protected function tearDown()
    {
        $this->email = null;
        
        parent::tearDown();
    }

    public function testValidateOk()
    {
        $this->assertTrue($this->email->validate('jacob@JCI.com'));
    }

    public function testValidateNotOk()
    {
        $this->assertFalse($this->email->validate('jacob'));
    }
}

