<?php

    function is_relation( $action_relation, $my_agent_id )
    {
        foreach( $action_relation as $rel )
        {
            if ( $rel['agent_id'] == $my_agent_id )
                return true;
        }
        return false;
    }

?>

<div class="agents form">
<?php echo $this->Form->create('Agent'); ?>
    <fieldset>
        <legend><?php echo __('Edit Agent'); ?></legend>

        <?php
            echo $this->Form->input('agent_id');
        
            echo $this->Form->input
            ( 
                'name' ,
                array
                (
                    'title' => 'Fill agent name'
                )
            );
            
            echo $this->Form->input
            ( 
                'note',
                array
                (
                    'title' => 'Fill information about this agent. E.g. expected behavior',
                )
            );

            echo "<fieldset>";
            echo "<legend>Starting values:</legend>";
            
            echo $this->Form->input
            ( 
                'strt_hunger_val',
                array
                (
                    'title' => 'Fill the starting hunger value',
                    'label' => 'Starting hunger'
                )
            );
            echo $this->Form->input
            ( 
                'hunger_deficit_region',
                array
                (
                    'title' => 'If the need value reaches the set value reward for satiating the need is multiplied by deficit reward multiplier',
                    'label' => 'Hunger deficit region'
                )
            );
            echo $this->Form->input
            ( 
                'hunger_deficit_reward',
                array
                (
                    'title' => 'Fill in the reward multiplier - expected value is > 1.0',
                    'label' => 'Hunger deficit reward multiplier'
                )
            );
            echo $this->Form->input
            ( 
                'strt_tiredness_val',
                array
                (
                    'title' => 'Fill the starting Tiredness value',
                    'label' => 'Starting Tiredness'
                )
            );
            echo $this->Form->input
            ( 
                'tiredness_deficit_region',
                array
                (
                    'title' => 'If the need value reaches the set value reward for satiating the need is multiplied by deficit reward multiplier',
                    'label' => 'Tiredness deficit region'
                )
            );
            echo $this->Form->input
            ( 
                'tiredness_deficit_reward',
                array
                (
                    'title' => 'Fill in the reward multiplier - expected value is > 1.0',
                    'label' => 'Tiredness deficit reward multiplier'
                )
            );
            echo $this->Form->input
            ( 
                'strt_pain_val',
                array
                (
                    'title' => 'Fill the starting pain value',
                    'label' => 'Starting Pain'
                )
            );

            echo $this->Form->input
            ( 
                'pain_deficit_region',
                array
                (
                    'title' => 'If the need value reaches the set value reward for satiating the need is multiplied by deficit reward multiplier',
                    'label' => 'Pain deficit region'
                )
            );
            echo $this->Form->input
            ( 
                'pain_deficit_reward',
                array
                (
                    'title' => 'Fill in the reward multiplier - expected value is > 1.0',
                    'label' => 'Pain deficit reward multiplier'
                )
            );
            
            echo $this->Form->input
            ( 
                'strt_boredom_val',
                array
                (
                    'title' => 'Fill the starting boredom value',
                    'label' => 'Starting boredom'
                )
            );
            
            echo $this->Form->input
            ( 
                'strt_playfulness_val',
                array
                (
                    'title' => 'Fill the starting playfulness value',
                    'label' => 'Starting playfulness'
                )
            );
            
            echo $this->Form->input
            ( 
                'eye_sght',
                array
                (
                    'title' => 'Fill the range of sight for the agent',
                    'label' => 'Eye sight range'
                )
            );
            
            echo $this->Form->input
            ( 
                'range',
                array
                (
                    'title' => 'Fill the reach distance of the Agent (distance on which it can perform actions like eat/play)',
                    'label' => 'Reach distance'
                )
            );
            echo "</fieldset>";
            
            echo "<fieldset>";
            echo "<legend>ActorCritic:</legend>";
                echo $this->Form->input
                ( 
                'learning_rate_actor',
                    array
                    (
                        'label' => 'Actor Learning rate'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'learning_rate_critic',
                    array
                    (
                        'label' => 'Critic Learning rate'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'actor_hidden_neuron_count',
                    array
                    (
                        'label' => 'Actor Hidden layer neurons count'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'critic_hidden_neuron_count',
                    array
                    (
                        'label' => 'Critic Hidden layer neurons count'
                    )
                );
                
                echo $this->Form->input
                (
                    'actor_hid_actvt',
                    array
                    (
                        'type' => 'select',
                        'options' => array
                        (
                            'LIN'  => 'LIN',
                            'SGM'  => 'SGM',
                            'TANH' => 'TANH'
                        ),
                        'lable' => 'Actor hidden activation function type',
                        'title' => 'The type of the hidden layer activation function for actor'
                    )
                );
                
                echo $this->Form->input
                (
                    'critic_hid_actvt',
                    array
                    (
                        'type' => 'select',
                        'options' => array
                        (
                            'LIN'  => 'LIN',
                            'SGM'  => 'SGM',
                            'TANH' => 'TANH'
                        ),
                        'lable' => 'Critic hidden activation function type',
                        'title' => 'The type of the hidden layer activation function for actor'
                    )
                );
                
                echo $this->Form->input
                (
                    'actor_out_actvt',
                    array
                    (
                        'type' => 'select',
                        'options' => array
                        (
                            'LIN'  => 'LIN',
                            'SGM'  => 'SGM',
                            'TANH' => 'TANH'
                        ),
                        'lable' => 'Actor output activation function type',
                        'title' => 'The type of the output layer activation function for actor'
                    )
                );
                
                echo $this->Form->input
                (
                    'critic_out_actvt',
                    array
                    (
                        'type' => 'select',
                        'options' => array
                        (
                            'LIN'  => 'LIN',
                            'SGM'  => 'SGM',
                            'TANH' => 'TANH'
                        ),
                        'lable' => 'Critic output activation function type',
                        'title' => 'The type of the output layer activation function for actor'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'ac_p_beta',
                    array
                    (
                        'label' => 'P Beta',
                        'title' => 'P_Beta parameter used in actor critic Beta = Boredom * P_Beta + Q_Beta'
                    )
                );

                echo $this->Form->input
                ( 
                    'ac_q_beta',
                    array
                    (
                        'label' => 'Q Beta',
                        'title' => 'Q_Beta parameter used in actor critic Beta = Boredom * P_Beta + Q_Beta'
                    )
                );

                echo $this->Form->input
                ( 
                    'gama_discount',
                    array
                    (
                        'label' => 'Discount factor &Gamma;'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'surprise_threshold',
                    array
                    (
                        'label' => 'Surprise threshold'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'boredom_increment',
                    array
                    (
                        'label' => 'Boredom inc.'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'boredom_decrement',
                    array
                    (
                        'label' => 'Boredom dec.'
                    )
                );

            echo "</fieldset>";

            echo "<fieldset>";
            echo "<legend>Intensity of playing MLP:</legend>";
            echo $this->Form->input
                ( 
                'play_thr_const',
                    array
                    (
                        'label' => 'Play threshold const',
                        'title' => 'Play threshold for constant decrease - if the playing intensity is more than the set value, the playfulness will descrease in constant (optimal manner set in the play action)'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'play_thr_rand',
                    array
                    (
                        'label' => 'Play threshold random',
                        'title' => 'Play threshold for constant decrease - if the playing intensity is more than the set value, the playfulness will descrease in a random manner (as set in the play action)'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'play_hid_layer',
                    array
                    (
                        'label' => 'Play hidden layer',
                        'title' => 'The hidden layer of the neural network responsible for specifying the intensity of playing'
                    )
                );

                echo $this->Form->input
                ( 
                    'play_learning_rate',
                    array
                    (
                        'label' => 'Play learning rate',
                        'title' => 'The learning rate of the neural network responsible for specifying the intensity of playing'
                    )
                );

                echo $this->Form->input
                (
                    'play_hid_actvt',
                    array
                    (
                        'type' => 'select',
                        'options' => array
                        (
                            'LIN'  => 'LIN',
                            'SGM'  => 'SGM',
                            'TANH' => 'TANH'
                        ),
                        'label' => 'Play Hid Actvt',
                        'title' => 'The activation function for the hidden layer of the neural network responsible for specifying the intensity of playing'
                    )
                );
                echo $this->Form->input
                ( 
                    'play_p_beta',
                    array
                    (
                        'label' => 'P Beta',
                        'title' => 'P_Beta parameter used in play intensity Beta = Boredom * P_Beta + Q_Beta'
                    )
                );

                echo $this->Form->input
                ( 
                    'play_q_beta',
                    array
                    (
                        'label' => 'Q Beta',
                        'title' => 'Q_Beta parameter used in play intensity Beta = Boredom * P_Beta + Q_Beta'
                    )
                );
            echo "</fieldset>";

            echo "<fieldset>";
            echo "<legend>Intensity of crying MLP:</legend>";
            echo $this->Form->input
                ( 
                'cry_thr_eat',
                    array
                    (
                        'label' => 'Cry threshold eat',
                        'title' => 'Cry threshold for being fed - if the crying intensity is more than the set value, the agent is being fed - as if it performed an Eat action'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'cry_thr_danger',
                    array
                    (
                        'label' => 'Cry threshold danger',
                        'title' => 'Cry threshold for being pulled out of harms way - if the crying intensity is more than the set value, the agent will be moved to a location without harmful objects'
                    )
                );
                
                echo $this->Form->input
                ( 
                    'cry_hid_layer',
                    array
                    (
                        'label' => 'Cry hidden layer',
                        'title' => 'The hidden layer of the neural network responsible for specifying the intensity of crying'
                    )
                );

                echo $this->Form->input
                ( 
                    'cry_learning_rate',
                    array
                    (
                        'label' => 'Cry learning rate',
                        'title' => 'The learning rate of the neural network responsible for specifying the intensity of crying'
                    )
                );

                echo $this->Form->input
                (
                    'cry_hid_actvt',
                    array
                    (
                        'type' => 'select',
                        'options' => array
                        (
                            'LIN'  => 'LIN',
                            'SGM'  => 'SGM',
                            'TANH' => 'TANH'
                        ),
                        'label' => 'Cry Hid Actvt',
                        'title' => 'The activation function for the hidden layer of the neural network responsible for specifying the intensity of crying'
                    )
                );
                echo $this->Form->input
                ( 
                    'cry_p_beta',
                    array
                    (
                        'label' => 'P Beta',
                        'title' => 'P_Beta parameter used in cry intensity Beta = Boredom * P_Beta + Q_Beta'
                    )
                );

                echo $this->Form->input
                ( 
                    'cry_q_beta',
                    array
                    (
                        'label' => 'Q Beta',
                        'title' => 'Q_Beta parameter used in cry intensity Beta = Boredom * P_Beta + Q_Beta'
                    )
                );
            echo "</fieldset>";
            
	?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Agent.agent_id')), null, __('Are you sure you want to delete this agents dataset?', $this->Form->value('Agent.agent_id'))); ?></li>
        <li><?php echo $this->Html->link( __( 'Agent Logs' ), array( 'controller' => 'logs', 'action' => 'index', $agent_id ) ); ?></li>
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
                <th> Const play dec. </th>
                <th> Max random play dec. </th>
                <th> Cry hunger dec. </th>
                <th> Max step num. </th>
                <th filter="false"> Active </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $relations as $relation )
                {
                    echo "<tr id=" . $relation['Action']['action_id'] . ">";
                        $id = $relation['Action']['action_id'];
                        echo "<td> <a href='http://actorcritic.sk/actions/edit/" . $id . "'>Update</a> </td>";
                        echo "<td> " . $relation['Action']['name'] . " </td>";
                        echo "<td> " . $relation['Action']['hunger_inc'] . " </td>";
                        echo "<td> " . $relation['Action']['tiredness_inc'] . " </td>";
                        echo "<td> " . $relation['Action']['pain_inc'] . " </td>";
                        echo "<td> " . $relation['Action']['boredom_inc'] . " </td>";
                        echo "<td> " . $relation['Action']['playfulness_inc'] . " </td>";
                        echo "<td> " . $relation['Action']['const_play_dec'] . " </td>";
                        echo "<td> " . $relation['Action']['max_random_play_dec'] . " </td>";
                        echo "<td> " . $relation['Action']['cry_hunger_dec'] . " </td>";
                        echo "<td> " . $relation['Action']['max_step_num'] . " </td>";
                        
                        $check = $this->Form->input( '', array( 'id' => $agent_id, 'class' => 'checkbox_input', 'type' => 'checkbox' ) );
                        if ( isset( $relation['AgentActionRel'] ) )
                        {
                            if ( is_relation( $relation['AgentActionRel'], $agent_id ) )
                            {
                                $check = $this->Form->input( '', array( 'id' => $agent_id, 'class' => 'checkbox_input', 'type' => 'checkbox', 'checked' ) );
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
    echo $this->Html->script( 'data/edit_tables_agent' );
