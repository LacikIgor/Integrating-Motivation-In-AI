<?php

App::uses('AppController', 'Controller');

class EnvironmentObjectsController extends AppController
{

    public function index()
    {
        $this->EnvironmentObject->recursive = 0;
        $env_objs = $this->EnvironmentObject->find('all');
        $this->set('environmentObjects', $env_objs);
        $this->set('controller_name', 'EnvironmentObjects');
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->EnvironmentObject->create();
            if ($this->EnvironmentObject->save($this->request->data)) {
                $this->Session->setFlash(__('The environment object has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The environment object could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null)
    {
        if (!$this->EnvironmentObject->exists($id)) {
            throw new NotFoundException(__('Invalid environment object'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->EnvironmentObject->save($this->request->data)) {
                $this->Session->setFlash(__('The environment object has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The environment object could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('EnvironmentObject.' . $this->EnvironmentObject->primaryKey => $id));
            $this->request->data = $this->EnvironmentObject->find('first', $options);
        }
    }

    public function delete($id = null)
    {
        $this->EnvironmentObject->id = $id;
        if (!$this->EnvironmentObject->exists()) {
            throw new NotFoundException(__('Invalid environment object'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->EnvironmentObject->delete()) {
            $this->Session->setFlash(__('The environment object has been deleted.'));
        } else {
            $this->Session->setFlash(__('The environment object could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
