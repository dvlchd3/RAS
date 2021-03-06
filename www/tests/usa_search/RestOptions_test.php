<?php
require_once '../simpletest/autorun.php';
require_once '../../usa_search/RestApi.php';

class RestOptionsTests extends UnitTestCase {
	private $options = NULL;
	
	function setUp() {
		$this->options = new RestOptions('http://www.google.com');
	}
	
	function testUrlCannotBeNull() {
		$this->expectException(new InvalidArgumentException('The URL must be provided.'));
		new RestOptions(NULL);
	}
	
	function testUrlCannotBeEmptyString() {
		$this->expectException(new InvalidArgumentException('The URL must be provided.'));
		new RestOptions('     ');
	}
	
	function testUrlIsSet() {
		$this->assertEqual($this->options->getUrl(), 'http://www.google.com');
	}
	
	function testContentTypeDefaultIs() {
		$this->assertEqual($this->options->getContentType(), RestOptions::PlainTextContentType);
	}
	
	function testJsonArrayIsJson() {
		$input = array(
			'foo' => 'bar',
			'pie' => 'cherry',
			'v' => 6
		);
		
		$this->options->json($input);
		$this->assertEqual($this->options->getParams(), '{"foo":"bar","pie":"cherry","v":6}');
	}
	
	function testJsonArrayReturnsRestOptionsInstance() {
		$instance = $this->options->json(array("a" => "b"));
		$this->assertIdentical($instance, $this->options);
	}
	
	function testJsonSetsContentType() {
		$contentType = $this->options->json(array("c" => "d"))->getContentType();
		$this->assertEqual($contentType, RestOptions::JsonContentType);
	}
	
	function testRequestTimeoutIsSet() {
		$this->options->timeout(585);
		$this->assertEqual($this->options->getRequestTimeout(), 585);
	}
	
	function testRequestTimeoutReturnsInstance() {
		$instance = $this->options->timeout(5);
		$this->assertIdentical($this->options, $instance);
	}
	
	function testRequestTimeoutCannotBeNegative() {
		$this->expectException(new InvalidArgumentException('Timeout must be a positive, non-zero value.'));
		$this->options->timeout(-234);
	}
	
	function testRequestTimeoutCannotBeZero() {
		$this->expectException(new InvalidArgumentException('Timeout must be a positive, non-zero value.'));
		$this->options->timeout(0);
	}
	
	function testHttpGetSetsParams() {
		$this->options->httpGet(array("foo" => "foo bar"));
		$this->assertEqual($this->options->getParams(), "foo=foo+bar");
	}
	
	function testHttpGetReturnsInstance() {
		$instance = $this->options->httpGet(array("q" => "r"));
		$this->assertIdentical($this->options, $instance);
	}
}
?>