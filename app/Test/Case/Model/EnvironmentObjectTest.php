<?php
App::uses('EnvironmentObject', 'Model');

/**
 * EnvironmentObject Test Case
 *
 */
class EnvironmentObjectTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.environment_object',
		'app.environment_object_scenario_rel',
		'app.scenario',
		'app.object_scenario_rel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EnvironmentObject = ClassRegistry::init('EnvironmentObject');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EnvironmentObject);

		parent::tearDown();
	}

}
