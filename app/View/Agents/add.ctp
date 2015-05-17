<div class="agents form">
<?php echo $this->Form->create('Agent'); ?>
    <fieldset>
        <legend><?php echo __('Add Agent'); ?></legend>
	<?php
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
                    'value' => '0',
                    'label' => 'Starting hunger'
                )
            );
            echo $this->Form->input
            ( 
                'hunger_deficit_region',
                array
                (
                    'title' => 'If the need value reaches the set value reward for satiating the need is multiplied by deficit reward multiplier',
                    'value' => '0',
                    'label' => 'Hunger deficit region'
                )
            );
            echo $this->Form->input
            ( 
                'hunger_deficit_reward',
                array
                (
                    'title' => 'Fill in the reward multiplier - expected value is > 1.0',
                    'value' => '1',
                    'label' => 'Hunger deficit reward multiplier'
                )
            );
            echo $this->Form->input
            ( 
                'strt_tiredness_val',
                array
                (
                    'title' => 'Fill the starting Tiredness value',
                    'value' => '0',
                    'label' => 'Starting Tiredness'
                )
            );
            echo $this->Form->input
            ( 
                'tiredness_deficit_region',
                array
                (
                    'title' => 'If the need value reaches the set value reward for satiating the need is multiplied by deficit reward multiplier',
                    'value' => '0',
                    'label' => 'Tiredness deficit region'
                )
            );
            echo $this->Form->input
            ( 
                'tiredness_deficit_reward',
                array
                (
                    'title' => 'Fill in the reward multiplier - expected value is > 1.0',
                    'value' => '1',
                    'label' => 'Tiredness deficit reward multiplier'
                )
            );
            echo $this->Form->input
            ( 
                'strt_pain_val',
                array
                (
                    'title' => 'Fill the starting pain value',
                    'value' => '0',
                    'label' => 'Starting Pain'
                )
            );

            echo $this->Form->input
            ( 
                'pain_deficit_region',
                array
                (
                    'title' => 'If the need value reaches the set value reward for satiating the need is multiplied by deficit reward multiplier',
                    'value' => '0',
                    'label' => 'Pain deficit region'
                )
            );
            echo $this->Form->input
            ( 
                'pain_deficit_reward',
                array
                (
                    'title' => 'Fill in the reward multiplier - expected value is > 1.0',
                    'value' => '1',
                    'label' => 'Pain deficit reward multiplier'
                )
            );
            
            echo $this->Form->input
            ( 
                'strt_boredom_val',
                array
                (
                    'title' => 'Fill the starting boredom value',
                    'value' => '0',
                    'label' => 'Starting boredom'
                )
            );
            
            echo $this->Form->input
            ( 
                'strt_playfulness_val',
                array
                (
                    'title' => 'Fill the starting playfulness value',
                    'value' => '0',
                    'label' => 'Starting playfulness'
                )
            );
            
            echo $this->Form->input
            ( 
                'eye_sght',
                array
                (
                    'title' => 'Fill the range of sight for the agent',
                    'value' => '3',
                    'label' => 'Eye sight range'
                )
            );
            
            echo $this->Form->input
            ( 
                'range',
                array
                (
                    'title' => 'Fill the reach distance of the Agent (distance on which it can perform actions like eat/play)',
                    'value' => '1',
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
                        'title' => 'The type of the hidden layer activation function for actor',
                        'value' => 'SGM'
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
                        'title' => 'The type of the hidden layer activation function for actor',
                        'value' => 'SGM'
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
                        'title' => 'The type of the output layer activation function for actor',
                        'value' => 'LIN'
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
                        'title' => 'The type of the output layer activation function for actor',
                        'value' => 'LIN'
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
                        'title' => 'The activation function for the hidden layer of the neural network responsible for specifying the intensity of playing',
                        'value' => 'SGM'
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
                        'title' => 'The activation function for the hidden layer of the neural network responsible for specifying the intensity of crying',
                        'value' => 'SGM'
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
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>
