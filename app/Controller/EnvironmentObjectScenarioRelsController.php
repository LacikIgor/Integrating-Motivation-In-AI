<?php

App::uses('AppController', 'Controller');

class EnvironmentObjectScenarioRelsController extends AppController
{
    public function add_relation()
    {
        $this->autoRender = false;
        if (isset($_POST['scenario_id']) && (isset($_POST['environment_object_id']))) {
            $tmpRelation['EnvironmentObjectScenarioRel']['scenario_id'] = $_POST['scenario_id'];
            $tmpRelation['EnvironmentObjectScenarioRel']['environment_object_id'] = $_POST['environment_object_id'];
            $this->EnvironmentObjectScenarioRel->save($tmpRelation);
            return;
        }
        echo "POST NOT SET ERROR";
    }

    /*
     * TODO MAZ PODLA REL ID, NIE ALL
     */
    public function delete_relation()
    {
        $this->autoRender = false;
        if (isset($_POST['scenario_id']) && (isset($_POST['environment_object_id']))) {
            $tmp = $this->EnvironmentObjectScenarioRel->find
            (
                'first',
                array
                (
                    'conditions' => array
                    (
                        'EnvironmentObjectScenarioRel.scenario_id' => $_POST['scenario_id'],
                        'EnvironmentObjectScenarioRel.environment_object_id' => $_POST['environment_object_id']
                    )
                )
            );
            var_dump($this->EnvironmentObjectScenarioRel->delete($tmp['EnvironmentObjectScenarioRel']['object_scenario_id']));
            return;
        }
        echo "POST NOT SET ERROR";
    }
}
