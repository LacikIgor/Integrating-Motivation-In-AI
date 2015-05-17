<?php
/**
 * ActionFixture
 *
 */
class ActionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'action_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'hunger_inc' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'tiredness_inc' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'pain_inc' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'boredom_inc' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'playfulness' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'action_id', 'unique' => 1)
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
			'action_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'hunger_inc' => 1,
			'tiredness_inc' => 1,
			'pain_inc' => 1,
			'boredom_inc' => 1,
			'playfulness' => 1,
			'created' => '2014-04-06 09:27:00',
			'modified' => '2014-04-06 09:27:00'
		),
	);

}
