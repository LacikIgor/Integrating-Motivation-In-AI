<?php

App::uses( 'AppModel', 'Model' );

class Action extends AppModel
{

    public $primaryKey = 'action_id';
    public $displayField = 'name';
    
    public $hasMany = array 
    (
        'AgentActionRel' => array 
        (
            'className'    => 'AgentActionRel',
            'foreignKey'   => 'action_id',
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
