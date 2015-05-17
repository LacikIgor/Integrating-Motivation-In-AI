<?php
App::uses('Object', 'Model');

/**
 * Object Test Case
 *
 */
class ObjectTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Object = ClassRegistry::init('Object');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Object);

		parent::tearDown();
	}

}
