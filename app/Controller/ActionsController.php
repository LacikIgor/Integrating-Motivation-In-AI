<?php

App::uses('AppController', 'Controller');

class ActionsController extends AppController
{

    public function index()
    {
        $this->Action->recursive = 0;
        $actions = $this->Action->find('all');
        $this->set('actions', $actions);
        $this->set('controller_name', 'actions');
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Action->create();
            if ($this->Action->save($this->request->data)) {
                $this->Session->setFlash(__('The action has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The action could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null)
    {
        if (!$this->Action->exists($id)) {
            throw new NotFoundException(__('Invalid action'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Action->save($this->request->data)) {
                $this->Session->setFlash(__('The action has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The action could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Action.' . $this->Action->primaryKey => $id));
            $this->request->data = $this->Action->find('first', $options);
        }
    }

    public function delete($id = null)
    {
        $this->Action->id = $id;
        if (!$this->Action->exists()) {
            throw new NotFoundException(__('Invalid action'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Action->delete()) {
            $this->Session->setFlash(__('The action has been deleted.'));
        } else {
            $this->Session->setFlash(__('The action could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
