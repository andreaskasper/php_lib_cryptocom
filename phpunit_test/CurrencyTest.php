<?php
/**
 *
 *
 *
 *
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
namespace cryptocom\Test;

use PHPUnit\Framework\TestCase;


/**
 * crypto.com - Currency tester
 */
final class CurrencyTest extends TestCase {

	public function testcurrencies() {
    $curs = array("BTC", "XRP", "CRO");
    foreach ($curs as $a) {
      $currency = new \cryptocom\Currency($a);
      $this->assertEquals(true, is_string($currency->id));
      $this->assertEquals(true, is_string($currency->string));
    }
	}

	
	
}
