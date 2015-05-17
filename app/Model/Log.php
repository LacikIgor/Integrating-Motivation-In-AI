<?php

App::uses( 'AppModel', 'Model' );

class Log extends AppModel
{

    public $primaryKey = 'log_id';
    
    public function add( $data )
    {
        debug( $data );
        $tmp = array();
        $tmp['Log'] = array();
        $tmp['Log']['log_id'];
        $tmp['Log']['name']     = $data[0]['name'];
        $tmp['Log']['note']     = $data[0]['note'];
        $tmp['Log']['agent_id'] = $data[0]['agent_id'];
        $tmp['Log']['log_json'] = $data[0]['log_json'];
        $this->save( $tmp );
    } // add
    
}