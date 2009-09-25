<?php
/**
 * PHPTAL templating engine
 *
 * PHP Version 5
 *
 * @category HTML
 * @package  PHPTAL
 * @author   Laurent Bedubourg <lbedubourg@motion-twin.com>
 * @author   Kornel Lesiński <kornel@aardvarkmedia.co.uk>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version  SVN: $Id: $
 * @link     http://phptal.org/
 */

require_once dirname(__FILE__)."/config.php";

PHPTAL::setIncludePath();
require_once 'PHPTAL/Dom/DocumentBuilder.php';
PHPTAL::restoreIncludePath();

class DOMTest extends PHPTAL_TestCase
{
    private function newElement($name = 'foo',$ns = '')
    {
        $xmlns = new PHPTAL_Dom_XmlnsState(array(),'');
        return new PHPTAL_Dom_Element($name,$ns,array(),$xmlns);
    }
    
    function testAppendChild()
    {
        $el1 = $this->newElement();
        $el2 = $this->newElement();
        
        $this->assertType('array',$el1->childNodes);
        $this->assertNull($el2->parentNode);
        
        $el1->appendChild($el2);
        $this->assertNull($el1->parentNode);
        $this->assertSame($el1,$el2->parentNode);
        $this->assertEquals(1,count($el1->childNodes));
        $this->assertTrue(isset($el1->childNodes[0]));
        $this->assertSame($el2,$el1->childNodes[0]);
    }

    function testRemoveChild()
    {
        $el1 = $this->newElement();
        $el2 = $this->newElement();
        $el3 = $this->newElement();
        $el4 = $this->newElement();

        $el1->appendChild($el2);
        $el1->appendChild($el3);
        $el1->appendChild($el4);

        $this->assertEquals(3,count($el1->childNodes));
        $this->assertTrue(isset($el1->childNodes[2]));
        $this->assertFalse(isset($el1->childNodes[3]));

        $this->assertSame($el1,$el4->parentNode);

        $el1->removeChild($el4);   
        
        $this->assertNull($el4->parentNode);       
        
        $this->assertEquals(2,count($el1->childNodes));
        $this->assertTrue(isset($el1->childNodes[1]));
        $this->assertFalse(isset($el1->childNodes[2]));
        $this->assertSame($el3,end($el1->childNodes));
        
        $el1->removeChild($el2);
        
        $this->assertEquals(1,count($el1->childNodes));
        $this->assertTrue(isset($el1->childNodes[0]));
        $this->assertFalse(isset($el1->childNodes[1]));
        
    }
}