<?php
/**
 * EnvironmentObjectScenarioRelFixture
 *
 */
class EnvironmentObjectScenarioRelFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'object_scenario_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'environment_object_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'scenario_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'object_scenario_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_slovak_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'object_scenario_id' => 1,
			'environment_object_id' => 1,
			'scenario_id' => 1,
			'created' => '2014-04-06 12:56:11',
			'modified' => '2014-04-06 12:56:11'
		),
	);

}
