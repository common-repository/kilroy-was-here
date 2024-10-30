<?php
/**
 * Test reading and writing of content
 */
class contentTest extends WP_UnitTestCase {
	/**
	 * @dataProvider defaultContentProvider
	 */
	public function testInstallContent( $content ) {
		Kilroy_Was_Here::install();
		$this->assertEquals( $content, Kilroy_Was_Here::init()->content() );
	}

	/**
	 * @depends testInstallContent
	 * @dataProvider newContentProvider
	 */
	public function testWriteContent( $content ) {
		$this->assertTrue( update_option( 'kilroywashere-content', $content ) );
		$this->assertEquals( $content, Kilroy_Was_Here::init()->content() );
	}

	/**
	 * @depends testInstallContent
	 * @dataProvider newContentProvider
	 */
	public function testWriteComment( $content ) {
		$this->assertTrue( update_option( 'kilroywashere-content', $content ) );

		ob_start();
		Kilroy_Was_Here::init()->html_comment();
		$html_content = ob_get_contents();
		ob_end_clean();

		$this->assertEquals( "\n<!--\n" . $content . "\n-->\n\n", $html_content );
	}

	public function defaultContentProvider() {
		return array(
			array( "`     ,,,\n     (o o)\n--ooO-(_)-Ooo---" )
		);
	}

	public function newContentProvider() {
		return array(
			array( "TEST  TEST  TEST" )
		);
	}
}
