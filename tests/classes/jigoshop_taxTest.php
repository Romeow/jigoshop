<?php

require_once dirname(__FILE__) . '/../../classes/jigoshop_tax.class.php';

/**
 * Test class for jigoshop_tax.
 * Generated by PHPUnit on 2012-04-14 at 15:15:01.
 */
class jigoshop_taxTest extends PHPUnit_Framework_TestCase {

    /**
     * @var jigoshop_tax
     */
    protected $object_no_divisor;
    protected $object_with_divisor;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object_no_divisor = new jigoshop_tax();
        $this->object_with_divisor = new jigoshop_tax(100);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

	/**
	 * Test returns a tax array as a string using 1 tax class in the array
	 *
	 */
    public function testArray_implode_one_tax_class() {
        
        $expected = 'tax_class:amount^100,rate^5.0000,compound^,display^Tax,shipping^20';
        $array['tax_class']['amount'] = '100';
        $array['tax_class']['rate'] = '5.0000';
        $array['tax_class']['compound'] = false;
        $array['tax_class']['display'] = 'Tax';
        $array['tax_class']['shipping'] = '20';
        $result = jigoshop_tax::array_implode($array);
        
        $this->assertEquals($expected, $result);
    }

	/**
	 * Test returns a tax array as a string using multiple tax classes in the array
	 *
	 */
    public function testArray_implode_more_than_one_tax_class() {
        
        $expected = 'tax_class:amount^100,rate^5.0000,compound^,display^Tax,shipping^20|tax_class2:amount^110,rate^5.5000,compound^1,display^Tax,shipping^10';
        $array['tax_class']['amount'] = '100';
        $array['tax_class']['rate'] = '5.0000';
        $array['tax_class']['compound'] = false;
        $array['tax_class']['display'] = 'Tax';
        $array['tax_class']['shipping'] = '20';
        $array['tax_class2']['amount'] = '110';
        $array['tax_class2']['rate'] = '5.5000';
        $array['tax_class2']['compound'] = true;
        $array['tax_class2']['display'] = 'Tax';
        $array['tax_class2']['shipping'] = '10';
        
        $result = jigoshop_tax::array_implode($array);
        
        $this->assertEquals($expected, $result);
    }
    
	/**
	 * Test to verify that when a non-array is passed in as a parameter, the same value
     * that is passed into the function is returned.
	 *
	 */
    public function testArray_implode_non_array_parameter() {
        $expected = 'noarray';
        
        $this->assertEquals($expected, jigoshop_tax::array_implode('noarray'));
    }
    
	/**
	 * Test to see that an empty array passed in returns empty string
	 *
	 */
    public function testArray_implode_empty_array() {
        $expected = '';
        
        $this->assertEquals($expected, jigoshop_tax::array_implode(array()));
    }
    
    /**
     * tests the custom tax string including divisor
     */
    public function testCreate_custom_tax_with_divisor() {
        
        $expected = 'jigoshop_custom_rate:amount^9000,rate^10.0000,compound^,display^Tax,shipping^1000';
        $this->assertEquals($expected, jigoshop_tax::create_custom_tax(1000, 100, 10, 100));
    }
    
    /**
     * tests the custom tax string excluding the divisor
     */
    public function testCreate_custom_tax_without_divisor() {
        
        $expected = 'jigoshop_custom_rate:amount^90,rate^10.0000,compound^,display^Tax,shipping^10';
        $this->assertEquals($expected, jigoshop_tax::create_custom_tax(1000, 100, 10));
    }
    

    /**
     */
    public function testGet_taxes_as_array_one_tax_class() {
        
        $expected['tax_class']['amount'] = '100';
        $expected['tax_class']['rate'] = '5.0000';
        $expected['tax_class']['compound'] = false;
        $expected['tax_class']['display'] = 'Tax';
        $expected['tax_class']['shipping'] = '20';
        
        $this->assertEquals($expected, jigoshop_tax::get_taxes_as_array('tax_class:amount^100,rate^5.0000,compound^,display^Tax,shipping^20'));
    }

    /**
     */
    public function testGet_taxes_as_array_multiple_tax_classes() {
        
        $expected['tax_class']['amount'] = '100';
        $expected['tax_class']['rate'] = '5.0000';
        $expected['tax_class']['compound'] = false;
        $expected['tax_class']['display'] = 'Tax';
        $expected['tax_class']['shipping'] = '20';
        $expected['tax_class2']['amount'] = '110';
        $expected['tax_class2']['rate'] = '5.5000';
        $expected['tax_class2']['compound'] = true;
        $expected['tax_class2']['display'] = 'Tax';
        $expected['tax_class2']['shipping'] = '10';
        
        $this->assertEquals($expected, jigoshop_tax::get_taxes_as_array('tax_class:amount^100,rate^5.0000,compound^,display^Tax,shipping^20|tax_class2:amount^110,rate^5.5000,compound^1,display^Tax,shipping^10'));
    }
    
    public function testGet_taxes_as_array_with_divisor() {
        
        $expected['tax_class']['amount'] = '1';
        $expected['tax_class']['rate'] = '5.0000';
        $expected['tax_class']['compound'] = false;
        $expected['tax_class']['display'] = 'Tax';
        $expected['tax_class']['shipping'] = '0.2';
        
        $this->assertEquals($expected, jigoshop_tax::get_taxes_as_array('tax_class:amount^100,rate^5.0000,compound^,display^Tax,shipping^20', 100));
    }
    
    public function testGet_taxes_as_array_empty_string() {
        
        $expected = array();
        $this->assertEquals($expected, jigoshop_tax::get_taxes_as_array(''));
    }
    
    /**
     * @covers jigoshop_tax::get_taxes_as_string
     * @todo Implement testGet_taxes_as_string().
     */
    public function testGet_taxes_as_string() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_tax_divisor
     * @todo Implement testGet_tax_divisor().
     */
    public function testGet_tax_divisor() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_total_tax_rate
     * @todo Implement testGet_total_tax_rate().
     */
    public function testGet_total_tax_rate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_tax_classes
     * @todo Implement testGet_tax_classes().
     */
    public function testGet_tax_classes() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_tax_rates
     * @todo Implement testGet_tax_rates().
     */
    public function testGet_tax_rates() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_tax_classes_for_base
     * @todo Implement testGet_tax_classes_for_base().
     */
    public function testGet_tax_classes_for_base() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::is_compound_tax
     * @todo Implement testIs_compound_tax().
     */
    public function testIs_compound_tax() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::set_is_shipable
     * @todo Implement testSet_is_shipable().
     */
    public function testSet_is_shipable() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_total_shipping_tax_amount
     * @todo Implement testGet_total_shipping_tax_amount().
     */
    public function testGet_total_shipping_tax_amount() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_non_compounded_tax_amount
     * @todo Implement testGet_non_compounded_tax_amount().
     */
    public function testGet_non_compounded_tax_amount() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_compound_tax_amount
     * @todo Implement testGet_compound_tax_amount().
     */
    public function testGet_compound_tax_amount() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::calculate_tax_amounts
     * @todo Implement testCalculate_tax_amounts().
     */
    public function testCalculate_tax_amounts() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::calculate_total_tax_rate
     * @todo Implement testCalculate_total_tax_rate().
     */
    public function testCalculate_total_tax_rate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_shipping_tax_classes
     * @todo Implement testGet_shipping_tax_classes().
     */
    public function testGet_shipping_tax_classes() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::update_tax_amount_with_shipping_tax
     * @todo Implement testUpdate_tax_amount_with_shipping_tax().
     */
    public function testUpdate_tax_amount_with_shipping_tax() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::update_tax_amount
     * @todo Implement testUpdate_tax_amount().
     */
    public function testUpdate_tax_amount() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_applied_tax_classes
     * @todo Implement testGet_applied_tax_classes().
     */
    public function testGet_applied_tax_classes() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_tax_class_for_display
     * @todo Implement testGet_tax_class_for_display().
     */
    public function testGet_tax_class_for_display() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_tax_amount
     * @todo Implement testGet_tax_amount().
     */
    public function testGet_tax_amount() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_tax_rate
     * @todo Implement testGet_tax_rate().
     */
    public function testGet_tax_rate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::is_tax_non_compounded
     * @todo Implement testIs_tax_non_compounded().
     */
    public function testIs_tax_non_compounded() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_shop_base_rate
     * @todo Implement testGet_shop_base_rate().
     */
    public function testGet_shop_base_rate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::get_shipping_tax_rate
     * @todo Implement testGet_shipping_tax_rate().
     */
    public function testGet_shipping_tax_rate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::calc_tax
     * @todo Implement testCalc_tax().
     */
    public function testCalc_tax() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::calc_shipping_tax
     * @todo Implement testCalc_shipping_tax().
     */
    public function testCalc_shipping_tax() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jigoshop_tax::calculate_shipping_tax
     * @todo Implement testCalculate_shipping_tax().
     */
    public function testCalculate_shipping_tax() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>
