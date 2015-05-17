<div class="actions">
    <h3><?php echo __( 'Actions' ); ?></h3>
    <ul>
        <li><?php echo $this->Html->link( __( 'Simulator' ), array( 'controller' => 'agents', 'action' => 'simulator' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Agents' ), array( 'controller' => 'agents', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Actions' ), array( 'controller' => 'actions', 'action' => 'index' ) ); ?></li>
        <li><?php echo $this->Html->link( __( 'Scenarios' ), array( 'controller' => 'scenarios', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'Objects' ), array( 'controller' => 'EnvironmentObjects', 'action' => 'index' ) ); ?></li>  
        <li><?php echo $this->Html->link( __( 'ChangeLog' ), array( 'controller' => 'agents', 'action' => 'changelog' ) ); ?></li>
    </ul>
</div>

<div class="myactions index">
    <h2><?php echo __( 'Agent logs' ); ?></h2>
    <table cellpadding="0" cellspacing="0" id="filtertable">
        <thead>
            <tr>
                <th> ID </th>
                <th> Name </th>
                <th> Note </th>
                <th> Created </th>
                <th> Modified </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $logs as $log ): ?>
            <tr>
                <?php echo "<td> " . $this->Html->link( 'Detail', array( 'controller' => 'logs', 'action' => 'view', $log['Log']['log_id'] ) ) . " </td>"; ?>
                <td><?php echo h( $log['Log']['name'] ); ?></td>
                <td><?php echo h( $log['Log']['note'] ); ?></td>
                <td><?php echo h( $log['Log']['created'] ); ?></td>
                <td><?php echo h( $log['Log']['modified'] ); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $( document ).ready( function() 
    {
        $( '#filtertable' ).tableFilter();
    });
</script>