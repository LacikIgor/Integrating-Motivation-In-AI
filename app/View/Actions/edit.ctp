<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink( __( 'Delete'), array( 'action' => 'delete', $this->Form->value( 'Action.action_id' ) ), null, __( 'Are you sure you want to delete # %s?', $this->Form->value( 'Action.action_id' ) ) ); ?></li>
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
                echo $this->Form->input('action_id');
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
                            'Cry'  => 'Cry'
                        )
                    )
                );
		echo $this->Form->input( 'note' );
		echo $this->Form->input
            ( 
                'hunger_inc'
            );
		echo $this->Form->input
            ( 
                'tiredness_inc' 
            );
		echo $this->Form->input
            ( 
                'pain_inc'
            );
		echo $this->Form->input
            ( 
                'boredom_inc'
            );
		echo $this->Form->input
            ( 
                'playfulness_inc'
            );
        echo $this->Form->input
            ( 
                'const_play_dec'
            );
        echo $this->Form->input
            ( 
                'max_random_play_dec'
            );
        echo $this->Form->input
            ( 
                'max_step_num'
            );
        echo $this->Form->input
            ( 
                'cry_hunger_dec'
            );
	?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>