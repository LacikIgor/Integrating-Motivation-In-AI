<?php
App::uses('EnvironmentObjectScenarioRel', 'Model');

/**
 * EnvironmentObjectScenarioRel Test Case
 *
 */
class EnvironmentObjectScenarioRelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.environment_object_scenario_rel',
		'app.environment_object',
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
		$this->EnvironmentObjectScenarioRel = ClassRegistry::init('EnvironmentObjectScenarioRel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EnvironmentObjectScenarioRel);

		parent::tearDown();
	}

}
