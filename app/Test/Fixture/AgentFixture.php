<?php
/**
 * AgentFixture
 *
 */
class AgentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'agent_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'strt_hunger_val' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'strt_tiredness_val' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'strt_pain_val' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'strt_boredom_val' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'strt_playfulness_val' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'eye_sght' => array('type' => 'integer', 'null' => false, 'default' => '3'),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'agent_id', 'unique' => 1)
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
			'agent_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'strt_hunger_val' => 1,
			'strt_tiredness_val' => 1,
			'strt_pain_val' => 1,
			'strt_boredom_val' => 1,
			'strt_playfulness_val' => 1,
			'eye_sght' => 1,
			'active' => 1,
			'created' => '2014-04-06 09:29:11',
			'modified' => '2014-04-06 09:29:11'
		),
	);

}
