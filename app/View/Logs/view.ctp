<style type="text/css">
    #export {
        text-decoration: none; font: menu;
        font-size: 1.2em;
        display: block; padding-top: 10px;
        background: ButtonFace; color: ButtonText;
        border-style: solid; border-width: 2px;
        border-color: ButtonHighlight ButtonShadow ButtonShadow ButtonHighlight;
        width: 100%;
        text-align: center;
        height: 30px;
    }
    #export:active {
        border-color: ButtonShadow ButtonHighlight ButtonHighlight ButtonShadow;
    }
</style>

<div class="actions">
    <h3><?php echo __( 'Actions' ); ?></h3>
    <ul>
        <li><?php echo $this->Html->link( __( 'Delete' ), array( 'controller' => 'logs', 'action' => 'delete/' . $log['Log']['log_id'] ), array(), "Are you sure you want to delete this log?" ); ?></li>
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>

<div class="myactions index">
    <h2><?php echo __( $log['Log']['name'] ); ?></h2>
    <h3><?php echo __( $log['Log']['note'] ); ?></h3>
    <a download="<?php echo __( $log['Log']['name'] ); ?>.csv" href="#" onclick="return ExcellentExport.csv(this, 'datatable');" id="export">Export to CSV</a>
    <table cellpadding="0" cellspacing="0" id="datatable">
        <thead>
            <tr>
                <th> Time Step </th>
                <th> Hunger </th>
                <th> Tiredness </th>
                <th> Pain </th>
                <th> Boredom </th>
                <th> Playfulness </th>
                <th> Expected cumulative reward </th>
                <th> Critic target </th>
                <th> Cry Intensity </th>
                <th> Play Intensity </th>
                <th> Sum squared error </th>
                <th> Distance </th>
                <th> Picked Action </th>
                <th> Danger encounter </th>
                <th> Up </th>
                <th> Down </th>
                <th> Left </th>
                <th> Right </th>
                <th> Eat </th>
                <th> Sleep </th>
                <th> Play </th>
                <th> Cry </th>
            </tr>
        </thead>
        <tbody>
            <!-- DEBUG TO 0 SO NO NEED TO CHECK UNDEFINED INDEXES AND PRINT EMPTY STRINGS -->
            <?php Configure::write( 'debug', 0 ); ?>
            <?php foreach ( $time_steps as $time_step ): ?>
            <tr>
                <td><?php echo h( $time_step['real_time'] ); ?></td>
                <td><?php echo h( $time_step['hunger'] ); ?></td>
                <td><?php echo h( $time_step['tiredness'] ); ?></td>
                <td><?php echo h( $time_step['pain'] ); ?></td>
                <td><?php echo h( $time_step['boredom'] ); ?></td>
                <td><?php echo h( $time_step['playfulness'] ); ?></td>
                <td><?php echo h( $time_step['expected_rew'] ); ?></td>
                <td><?php echo h( $time_step['target_critic'] ); ?></td>
                <td><?php echo h( $time_step['cry_intensity'] ); ?></td>
                <td><?php echo h( $time_step['play_intensity'] ); ?></td>
                <td><?php echo h( $time_step['sumSquaredErr'] ); ?></td>
                <td><?php echo h( $time_step['distance'] ); ?></td>
                <td><?php echo h( $time_step['picked_action'] ); ?></td>
                <td><?php echo h( $time_step['danger_encounter'] ); ?></td>
                <td><?php echo h( $time_step['Up'] ); ?></td>
                <td><?php echo h( $time_step['Down'] ); ?></td>
                <td><?php echo h( $time_step['Left'] ); ?></td>
                <td><?php echo h( $time_step['Right'] ); ?></td>
                <td><?php echo h( $time_step['Eat'] ); ?></td>
                <td><?php echo h( $time_step['Sleep'] ); ?></td>
                <td><?php echo h( $time_step['Play'] ); ?></td>
                <td><?php echo h( $time_step['Cry'] ); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php Configure::write( 'debug', 2 ); ?>
        </tbody>
    </table>
</div>

    <?php

        echo $this->Html->script
        (
            array
            (
                'data/index_table_manager',
                'plugins/excellentexport.min.js'
            )
        );