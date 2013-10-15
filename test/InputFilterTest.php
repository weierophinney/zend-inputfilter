<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_InputFilter
 */

namespace ZendTest\InputFilter;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\Filter;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

class InputFilterTest extends TestCase
{
    public function setUp()
    {
        $this->filter = new InputFilter();
    }

    public function testLazilyComposesAFactoryByDefault()
    {
        $factory = $this->filter->getFactory();
        $this->assertInstanceOf('Zend\InputFilter\Factory', $factory);
    }

    public function testCanComposeAFactory()
    {
        $factory = new Factory();
        $this->filter->setFactory($factory);
        $this->assertSame($factory, $this->filter->getFactory());
    }

    public function testCanAddUsingSpecification()
    {
        $this->filter->add(array(
            'name' => 'foo',
        ));
        $this->assertTrue($this->filter->has('foo'));
        $foo = $this->filter->get('foo');
        $this->assertInstanceOf('Zend\InputFilter\InputInterface', $foo);
    }

    public function testIsValidWhenValuesSetOnFilters()
    {
        $filter = new InputFilter();
        $filter->add(array(
            'name' => 'email',
            'validators' => array(
                array('name' => 'EmailAddress')
            )
        ));

//	$filter->get('email')->setValue('chuck@manchuck.com');
       // $filter->setData(array('email' => 'chuck@manchuck.com'));
        $this->assertTrue($filter->get('email')->isValid(), 'Filtered value is not valid');
        $this->assertTrue($filter->isValid(), 'Input filter did return value from filter');
    }
}
