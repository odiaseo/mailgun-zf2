<?php
namespace MailgunZf2Test\Options;

use MailgunZf2Test\UnitTest;
use MailgunZf2\Options\MailgunOptions;

class MailgunOptionsTest extends UnitTest
{
    /**
     *
     * @var MailgunOptions
     */
    private $options;

    protected function setUp()
    {
        parent::setUp();

        $this->options = $this->sm->get('MailgunOptions');
    }

    public function testExists()
    {
        $this->assertInstanceOf('MailgunZf2\Options\MailgunOptions', $this->options);

        $this->assertEquals(getenv('TEST_MAILGUNZF2_APIKEY'), $this->options->getApiKey());
        $this->assertEquals(getenv('TEST_MAILGUNZF2_DOMAIN'), $this->options->getDomain());
    }
}
