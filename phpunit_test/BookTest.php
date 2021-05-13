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
 * PHPMailer - PHP email transport unit test class.
 */
final class BookTest extends TestCase {

	public function testbook() {
    $instrument = new \cryptocom\Instrument("BTC_USDT");
    
    $this->assertEquals("BTC_USDT", $instrument->id);
    $this->assertEquals(true, $instrument->exists);

	}

	
	
}
