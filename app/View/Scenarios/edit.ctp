<?php

    function is_relation( $action_relation, $agent_id )
    {
        foreach( $action_relation as $rel )
        {
            if ( $rel['scenario_id'] == $agent_id )
                return true;
        }
        return false;
    }

?>

<div class="scenarios form">
<?php echo $this->Form->create('Scenario'); ?>
    <fieldset>
        <legend><?php echo __('Edit Scenario'); ?></legend>
            <?php
                echo $this->Form->input('scenario_id');
                echo $this->Form->input('title');
                echo $this->Form->input('note');
                echo $this->Form->input('map_representation');
            ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Scenario.scenario_id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Scenario.scenario_id'))); ?></li>
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>
<div class="db_relations" id="filtertable2">
    <table> 
        <thead>
            <tr>
                <th> ID </th>
                <th> Title </th>
                <th> Hunger inc. </th>
                <th> Tiredness inc. </th>
                <th> Pain inc. </th>
                <th> Boredom inc. </th>
                <th> Playfulness inc. </th>
                <th> Range </th>
                <th filter="false"> Active </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $relations as $relation )
                {
                    echo "<tr id=" . $relation['EnvironmentObject']['environment_object_id'] . ">";
                        echo "<td> " . $relation['EnvironmentObject']['environment_object_id'] . " </td>";
                        echo "<td> " . $relation['EnvironmentObject']['title'] . " </td>";
                        echo "<td> " . $relation['EnvironmentObject']['hunger_inc'] . " </td>";
                        echo "<td> " . $relation['EnvironmentObject']['tiredness_inc'] . " </td>";
                        echo "<td> " . $relation['EnvironmentObject']['pain_inc'] . " </td>";
                        echo "<td> " . $relation['EnvironmentObject']['boredom_inc'] . " </td>";
                        echo "<td> " . $relation['EnvironmentObject']['playfulness_inc'] . " </td>";
                        echo "<td> " . $relation['EnvironmentObject']['env_obj_range'] . " </td>";
                        
                        $check = $this->Form->input( '', array( 'id' => $scenario_id, 'class' => 'checkbox_input', 'type' => 'checkbox', 'checked' => false ) );
                        if ( isset( $relation['EnvironmentObjectScenarioRel'] ) )
                        {
                            if ( is_relation( $relation['EnvironmentObjectScenarioRel'], $scenario_id ) )
                            {
                                $check = $this->Form->input( '', array( 'id' => $scenario_id, 'class' => 'checkbox_input', 'type' => 'checkbox', 'checked' => true ) );
                            }
                        }
                        echo "<td> " . $check . " </td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<?php
    echo $this->Html->script( 'data/edit_tables_scenario' );