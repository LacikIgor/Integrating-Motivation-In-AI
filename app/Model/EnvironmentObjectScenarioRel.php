<?php

App::uses( 'AppModel', 'Model' );

class EnvironmentObjectScenarioRel extends AppModel
{
    public $primaryKey = 'object_scenario_id';
    
    public $belongsTo = array
    (
        'EnvObj' => array
        (
            'className'  => 'EnvironmentObject',
            'foreignKey' => 'environment_object_id'
        )
    );
}
