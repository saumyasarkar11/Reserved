<?php
//php vendor/bin/phpunit tests/ExampleAssertionsTest.php --color
require 'includes/functions.php';

class InitialAssertionsTest extends \PHPUnit\Framework\TestCase{
    
    public function testDuplicacy(){
        $phone = 9830110244;
        $this->assertEquals(1, checkDuplicacy($phone));
    }

    public function testLocations_TermsReturned(){
        $this->assertIsString(fetchLocations()) && assertIsString(fetchTerms());
    }

}

?>