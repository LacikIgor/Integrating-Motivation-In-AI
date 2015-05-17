<?php

App::uses( 'AppModel', 'Model' );

class EnvironmentObject extends AppModel
{

    public $primaryKey = 'environment_object_id';
    public $displayField = 'title';
    public $validate = array
    (
        'title' => array
        (
            'alphaNumeric' => array
            (
                'rule' => array ( 'alphaNumeric' ),
            ),
        ),
        
        'hunger_inc' => array
        (
            'numeric' => array
            (
                'rule' => array ( 'numeric' ),
            ),
        ),
        
        'tiredness_inc' => array
        (
            'numeric' => array
            (
                'rule' => array ( 'numeric' ),
            ),
        ),
        
        'pain_inc' => array
        (
            'numeric' => array
            (
                'rule' => array ( 'numeric' ),
            ),
        ),
        
        'boredom_inc' => array
        (
            'numeric' => array
            (
                'rule' => array ( 'numeric' ),
            ),
        ),
        'playfulness_inc' => array
        (
            'numeric' => array
            (
                'rule' => array ( 'numeric' ),
            ),
        ),
        'env_obj_range' => array
        (
            'numeric' => array
            (
                'rule' => array ( 'numeric' ),
            ),
        ),
    );
    
    public $hasMany = array
    (
        'EnvironmentObjectScenarioRel' => array
        (
            'className' => 'EnvironmentObjectScenarioRel',
            'foreignKey' => 'environment_object_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

}
