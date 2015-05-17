<?php

App::uses('AppController', 'Controller');

class ScenariosController extends AppController
{

    public function index()
    {
        $this->Scenario->recursive = 0;
        $scenarios = $this->Scenario->find('all');
        $this->set('scenarios', $scenarios);
        $this->set('controller_name', 'Scenarios');
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Scenario->create();
            if ($this->Scenario->save($this->request->data)) {
                $this->Session->setFlash(__('The scenario has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The scenario could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null)
    {
        if (!$this->Scenario->exists($id)) {
            throw new NotFoundException(__('Invalid scenario'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Scenario->save($this->request->data)) {
                $this->Session->setFlash(__('The scenario has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The scenario could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Scenario.' . $this->Scenario->primaryKey => $id));
            $this->request->data = $this->Scenario->find('first', $options);
            $this->set('scenario_id', $id);
            $this->set('relations', ClassRegistry::init('EnvironmentObject')->find('all'));
        }
    }

    public function delete($id = null)
    {
        $this->Scenario->id = $id;
        if (!$this->Scenario->exists()) {
            throw new NotFoundException(__('Invalid scenario'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Scenario->delete()) {
            $this->Session->setFlash(__('The scenario has been deleted.'));
        } else {
            $this->Session->setFlash(__('The scenario could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function saveMapChanges()
    {
        $this->autoRender = false;
        $tmp = $this->Scenario->find
        (
            'first', array
            (
                'conditions' => array
                (
                    'Scenario.active' => 1
                )
            )
        );

        $tmp['Scenario']['map_representation'] = $_POST['representation'];

        $this->Scenario->save($tmp);
    }

    public function setActive()
    {
        $this->autoRender = false;
        if (isset($_POST['id'])) {
            $scenarios = $this->Scenario->find
            (
                'all', array
                (
                    'recursive' => -1
                )
            );

            foreach ($scenarios as $scenario) {
                if ($scenario['Scenario']['scenario_id'] == $_POST['id']) {
                    $scenario['Scenario']['active'] = 1;
                } else {
                    $scenario['Scenario']['active'] = 0;
                }
                $this->Scenario->save($scenario);
            }

        }
    }

}
