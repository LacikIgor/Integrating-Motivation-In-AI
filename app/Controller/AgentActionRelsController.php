<?php

App::uses('AppController', 'Controller');

class AgentActionRelsController extends AppController
{

    public function add_relation()
    {
        $this->autoRender = false;
        if (isset($_POST['agent_id']) && (isset($_POST['action_id']))) {
            $tmpRelation['AgentActionRel']['agent_id'] = $_POST['agent_id'];
            $tmpRelation['AgentActionRel']['action_id'] = $_POST['action_id'];
            $this->AgentActionRel->save($tmpRelation);
            return;
        }
        echo "POST NOT SET ERROR";
    } // addRelation

    public function delete_relation()
    {
        $this->autoRender = false;
        if (isset($_POST['agent_id']) && (isset($_POST['action_id']))) {
            echo $_POST['agent_id'];
            echo $_POST['action_id'];
            $tmp = $this->AgentActionRel->find
            (
                'first',
                array
                (
                    'conditions' => array
                    (
                        'AgentActionRel.agent_id' => $_POST['agent_id'],
                        'AgentActionRel.action_id' => $_POST['action_id']
                    )
                )
            );
            var_dump($tmp);
            var_dump($this->AgentActionRel->delete($tmp['AgentActionRel']['agent_action_rel_id']));
            return;
        }
        echo "POST NOT SET ERROR";
    } // delete_relation
}
