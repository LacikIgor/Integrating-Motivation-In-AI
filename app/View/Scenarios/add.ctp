<div class="scenarios form">
<?php echo $this->Form->create('Scenario'); ?>
    <fieldset>
        <legend><?php echo __('Add Scenario'); ?></legend>
	<?php
            echo $this->Form->input( 'title' );
            echo $this->Form->input( 'note', array(
                    'placeholder' => 'Detailed describtion of the scenario..'
                ) 
            );
            echo $this->Form->input(
                'map_representation', array(
                    'value' => '1 0,0 0'
                )
            );
            echo $this->Form->input
            ( 
                'active',
                array
                (
                    'type'  => 'hidden',
                    'value' => 0
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
