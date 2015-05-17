<div class="environmentObjects form">
<?php echo $this->Form->create('EnvironmentObject'); ?>
	<fieldset>
		<legend><?php echo __('Add Environment Object'); ?></legend>
	<?php
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
                    'env_obj_range',
                    array
                    (
                        'value' => 0,
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
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>
