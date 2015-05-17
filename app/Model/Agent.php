<?php

App::uses( 'AppModel', 'Model' );

class Agent extends AppModel
{

    public $primaryKey = 'agent_id';

    public $displayField = 'name';

    public $hasMany = array 
    (
        'AgentActionRel' => array 
        (
            'className'    => 'AgentActionRel',
            'foreignKey'   => 'agent_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        )
    );

}
