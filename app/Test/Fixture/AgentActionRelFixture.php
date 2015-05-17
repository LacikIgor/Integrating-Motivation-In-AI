<?php
/**
 * AgentActionRelFixture
 *
 */
class AgentActionRelFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'agent_action_rel_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'agent_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'action_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'agent_action_rel_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'agent_action_rel_id' => 1,
			'agent_id' => 1,
			'action_id' => 1,
			'created' => '2014-04-06 09:28:49',
			'modified' => '2014-04-06 09:28:49'
		),
	);

}
