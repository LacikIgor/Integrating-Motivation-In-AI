<?php

App::uses('AppController', 'Controller');

class LogsController extends AppController
{

    public function index($agent_id)
    {
        $logs = $this->Log->find
        (
            'all', array
            (
                'conditions' => array
                (
                    'Log.agent_id' => $agent_id
                )
            )
        );
        $this->set('logs', $logs);
        $this->set('agent_id', $agent_id);
    } // index

    public function view($log_id)
    {
        $log = $this->Log->find
        (
            'first', array
            (
                'conditions' => array
                (
                    'Log.log_id' => $log_id
                )
            )
        );
        $this->set('log', $log);
        $this->set('time_steps', json_decode($log['Log']['log_json'], true));
    } // view

    public function add()
    {
        $this->autoRender = false;
        $this->Log->add($_POST['agent_logs']);
    } // add

    public function delete($id = null)
    {
        $this->autoRender = false;
        $this->Log->id = $id;
        $tmpLog = $this->Log->find( 'first', array( 'conditions' => array( 'log_id' => $id ) ) );
        if (!$this->Log->exists()) {
            throw new NotFoundException(__('Invalid Log'));
        }
        if ($this->Log->delete()) {
            $this->Session->setFlash(__('The Log has been deleted.'));
        } else {
            $this->Session->setFlash(__('The Log could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index/' . $tmpLog['Log']['agent_id'] ));
    } // delete


}
