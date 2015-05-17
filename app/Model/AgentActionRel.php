<?php

App::uses( 'AppModel', 'Model' );

class AgentActionRel extends AppModel
{
    public $primaryKey = 'agent_action_rel_id';
    
    public $belongsTo = array
    (
        'Action' => array
        (
            'className'  => 'Action',
            'foreignKey' => 'action_id'
        )
    );
}
