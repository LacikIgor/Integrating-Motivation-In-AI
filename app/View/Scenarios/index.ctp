<div class="scenarios index">
    <h2><?php echo __('Scenarios'); ?></h2>
    <table cellpadding="0" cellspacing="0" id="filtertable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Note</th>
                <th filter="false">Active</th>
                <th>Created</th>
                <th>Modified</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($scenarios as $scenario): ?>
            <tr>
                <td><?php echo h( $scenario['Scenario']['scenario_id'] ); ?></td>
                <td><?php echo h( $scenario['Scenario']['title'] ); ?></td>
                <td><?php echo h( $scenario['Scenario']['note'] ); ?></td>
                <td>
                    <?php 
                        if ( $scenario['Scenario']['active'] > 0 )
                        {
                            echo $this->Form->input
                            (
                                '', 
                                array
                                (
                                    'class'   => 'active_checkbox',
                                    'type'    => 'checkbox',
                                    'checked' => true
                                ) 
                            );
                        }
                        else 
                        {
                            echo $this->Form->input
                            (
                                '', 
                                array
                                (
                                    'class'   => 'active_checkbox',
                                    'type'    => 'checkbox',
                                    'checked' => false
                                ) 
                            );
                        }
                    ?>
                    
                </td>
                <td><?php echo h( $scenario['Scenario']['created'] ); ?>      </td>
                <td><?php echo h( $scenario['Scenario']['modified'] ); ?>     </td>
            </tr>
        <?php endforeach; ?>   
        </tbody>
    </table>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Scenario'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>

<script>
    var controller = '<?php echo $controller_name; ?>';
</script>

    <?php

        echo $this->Html->script
        (
            array
            (
                'data/index_table_manager'
            )
        );
