<?php
App::uses('AgentActionRel', 'Model');

/**
 * AgentActionRel Test Case
 *
 */
class AgentActionRelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.agent_action_rel',
		'app.agent',
		'app.action'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AgentActionRel = ClassRegistry::init('AgentActionRel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AgentActionRel);

		parent::tearDown();
	}

}
