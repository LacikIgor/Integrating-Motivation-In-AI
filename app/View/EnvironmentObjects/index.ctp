<div class="environmentObjects index">
    <h2><?php echo __('Environment Objects'); ?></h2>
    <table cellpadding="0" cellspacing="0" id="filtertable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Note</th>
                <th>Hunger inc.</th>
                <th>Tiredness inc.</th>
                <th>Pain inc.</th>
                <th>Boredom inc.</th>
                <th>Playfulness inc.</th>
                <th>Range</th>
                <th>Created</th>
                <th>Modified</th>
            </tr>
        </thead>
        <tbody>
	<?php foreach ( $environmentObjects as $environmentObject ): ?>
            <tr>
                <td><?php echo h( $environmentObject['EnvironmentObject']['environment_object_id'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['title'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['note'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['hunger_inc'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['tiredness_inc'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['pain_inc'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['boredom_inc'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['playfulness_inc'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['env_obj_range'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['created'] ); ?></td>
                <td><?php echo h( $environmentObject['EnvironmentObject']['modified'] ); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
    	<li><?php echo $this->Html->link(__('New Object'), array('action' => 'add')); ?></li>
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