<div class="actions">
    <h3><?php echo __( 'Actions' ); ?></h3>
    <ul>
        <li><?php echo $this->Html->link( __( 'New Action' ), array( 'action' => 'add' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>

<div class="myactions index">
    <h2><?php echo __( 'Actions' ); ?></h2>
    <table cellpadding="0" cellspacing="0" id="filtertable">
        <thead>
            <tr>
                <th> ID </th>
                <th> Title </th>
                <th> Note </th>
                <th>Hunger inc.</th>
                <th>Tiredness inc.</th>
                <th>Pain inc.</th>
                <th>Boredom inc.</th>
                <th>Playfulness inc.</th>
                <th>Const play dec.</th>
                <th>Max random play dec.</th>
                <th>Max step num</th>
                <th>Cry hunger dec.</th>
                <th>Created</th>
                <th>Modified</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $actions as $action ): ?>
            <tr>
                <td><?php echo h( $action['Action']['action_id'] ); ?></td>
                <td><?php echo h( $action['Action']['name'] ); ?></td>
                <td><?php echo h( $action['Action']['note'] ); ?></td>
                <td><?php echo h( $action['Action']['hunger_inc'] ); ?></td>
                <td><?php echo h( $action['Action']['tiredness_inc'] ); ?></td>
                <td><?php echo h( $action['Action']['pain_inc'] ); ?></td>
                <td><?php echo h( $action['Action']['boredom_inc'] ); ?></td>
                <td><?php echo h( $action['Action']['playfulness_inc'] ); ?></td>
                <td><?php echo h( $action['Action']['const_play_dec'] ); ?></td>
                <td><?php echo h( $action['Action']['max_random_play_dec'] ); ?></td>
                <td><?php echo h( $action['Action']['max_step_num'] ); ?></td>
                <td><?php echo h( $action['Action']['cry_hunger_dec'] ); ?></td>
                <td><?php echo h( $action['Action']['created'] ); ?></td>
                <td><?php echo h( $action['Action']['modified'] ); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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