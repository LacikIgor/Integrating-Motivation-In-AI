<?php

App::uses('AppController', 'Controller');

class AgentsController extends AppController
{

    public $components = array('Session');

    public function index()
    {
        $this->Agent->recursive = 0;
        $agents = $this->Agent->find('all');
        $this->set('agents', $agents);
        $this->set('controller_name', 'Agents');
    } // index

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Agent->create();
            if ($this->Agent->save($this->request->data)) {
                $this->Session->setFlash(__('The agent has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The agent could not be saved. Please, try again.'));
            }
        }
    } // add

    public function duplicate( $id )
    {
        $record = $this->Agent->find( 'first', 
            array(
                'conditions' => array(
                    'Agent.agent_id' => $id
                )
            )
        );
        $record['Agent']['agent_id'] = NULL;
        $record['Agent']['active'] = 0;
        if ( $this->Agent->save( $record ) ) {
            $this->Session->setFlash(__('The agent has been duplicated.'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The agent could not be saved. Please, try again.'));
        }
    } // duplicate

    public function edit($id = null)
    {
        if (!$this->Agent->exists($id)) {
            throw new NotFoundException(__('Invalid agent'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Agent->save($this->request->data)) {
                $this->Session->setFlash(__('The agent has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The agent could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Agent.' . $this->Agent->primaryKey => $id));
            $this->request->data = $this->Agent->find('first', $options);
            $this->set('agent_id', $id);
            $this->set('relations', ClassRegistry::init('Action')->find('all'));
        }
    } // edit

    public function delete($id = null)
    {
        $this->Agent->id = $id;
        if (!$this->Agent->exists()) {
            throw new NotFoundException(__('Invalid agent'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Agent->delete()) {
            $this->Session->setFlash(__('The agent has been deleted.'));
        } else {
            $this->Session->setFlash(__('The agent could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    } // delete

    public function simulator()
    {
        $active_scenario = ClassRegistry::init('Scenario')->find
        (
            'first',
            array
            (
                'conditions' => array
                (
                    'Scenario.active' => 1
                ),
                'recursive' => 2
            )
        );

        $this->set
        (
            'active_representation',
            $active_scenario['Scenario']['map_representation']
        );

        $this->set
        (
            'active_objects_titles',
            ClassRegistry::init('Scenario')->getActiveObjects($active_scenario, 'title')
        );

        $this->set
        (
            'active_objects',
            json_encode(ClassRegistry::init('Scenario')->getActiveObjects($active_scenario))
        );

        $this->set
        (
            'active_agent',
            json_encode
            (
                $this->Agent->find
                (
                    'first', array
                    (
                        'conditions' => array
                        (
                            'Agent.active' => 1
                        ),
                        'recursive' => 2
                    )
                )
            )
        );

    } // simulator

    public function setActive()
    {
        $this->autoRender = false;
        if (isset($_POST['id'])) {
            $agents = $this->Agent->find
            (
                'all', array
                (
                    'recursive' => -1
                )
            );

            foreach ($agents as $agent) {
                if ($agent['Agent']['agent_id'] == $_POST['id']) {
                    $agent['Agent']['active'] = 1;
                } else {
                    $agent['Agent']['active'] = 0;
                }
                $this->Agent->save($agent);
            }

        }
    } // setActive

    /**
     * Empty function, view contains changelog info written in pure HTML
     */
    public function changelog(){}

    public function mlp()
    {
        $this->layout = false;
    } // testMLPJS

} // AgentsController
