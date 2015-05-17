<div class="environmentObjects form">
<?php echo $this->Form->create('EnvironmentObject'); ?>
	<fieldset>
		<legend><?php echo __('Add Environment Object'); ?></legend>
	<?php
                echo $this->Form->input( 'environment_object_id' );
		echo $this->Form->input
                ( 
                    'title',
                    array
                    (
                        'options' => array
                        (
                            'Danger' => 'Danger',
                            'Toy'    => 'Toy',
                            'Food'   => 'Food',
                            'Sleep'  => 'Sleep'
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
                    'env_obj_range',
                    array
                    (
                        'lable' => 'range'
                    )
                );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EnvironmentObject.environment_object_id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('EnvironmentObject.environment_object_id'))); ?></li>
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>