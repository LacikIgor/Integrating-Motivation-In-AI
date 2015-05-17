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

<div class="myactions form">
<?php echo $this->Form->create('Action'); ?>
    <fieldset>
        <legend><?php echo __('Add Action'); ?></legend>
	<?php
		echo $this->Form->input
            (
                'name',
                array
                (
                    'type' => 'select',
                    'options' => array
                    (
                        'Move'  => 'Move',
                        'Eat'   => 'Eat',
                        'Sleep' => 'Sleep',
                        'Play'  => 'Play',
                        'Cry'   => 'Cry'
                    )
                )
            );
		echo $this->Form->input( 'note' );
		echo $this->Form->input
            ( 
                'hunger_inc', 
                array 
                (
                    'value' => 0
                )
            );
		echo $this->Form->input
            ( 
                'tiredness_inc', 
                array 
                (
                    'value' => 0
                )
            );
		echo $this->Form->input
            ( 
                'pain_inc', 
                array 
                (
                    'value' => 0
                )
            );
		echo $this->Form->input
            ( 
                'boredom_inc', 
                array 
                (
                    'value' => 0
                )
            );
		echo $this->Form->input
            ( 
                'playfulness_inc', 
                array 
                (
                    'value' => 0
                )
            );
        echo $this->Form->input
            ( 
                'const_play_dec', 
                array 
                (
                    'value' => 0
                )
            );
        echo $this->Form->input
            ( 
                'max_random_play_dec', 
                array 
                (
                    'value' => 0
                )
            );
        echo $this->Form->input
        ( 
            'max_step_num', 
            array 
            (
                'value' => 0
            )
        );
        echo $this->Form->input
        ( 
            'cry_hunger_dec',
            array 
            (
                'value' => 0
            )
        );
	?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
