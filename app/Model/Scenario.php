<?php

App::uses( 'AppModel', 'Model' );

class Scenario extends AppModel
{

    public $primaryKey = 'scenario_id';
    public $displayField = 'title';
    public $hasMany = array
    (
        'ObjSceRel' => array
        (
            'className' => 'EnvironmentObjectScenarioRel'
        )
    );

    /**
     * @param mixed data $Scenario
     * @param String $attribute
     * @return array of Strings containing $attribute values
     */
    public function getActiveObjects( $Scenario, $attribute = null )
    {
        $res = array ();
        foreach ( $Scenario[ 'ObjSceRel' ] as $rel )
        {
            $res[] = ( $attribute != null ) ? $rel[ 'EnvObj' ][ $attribute ] : $rel[ 'EnvObj' ];
        }
        return $res;
    }

// getActiveObjects

}
