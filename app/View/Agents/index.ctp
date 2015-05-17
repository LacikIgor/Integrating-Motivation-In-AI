<div class="agents index">
    <h2><?php echo __('Agents'); ?></h2>
    <table cellpadding="0" cellspacing="0" id="filtertable">
        <thead>
            <tr>
                <th filter="false">ID</th>
                <th filter="false" title="Checked agent is active in the simulator">Active</th>
                <th filter="false">&nbsp;</th>
                <th>Title</th>
                <th>Note</th>
                <th>Starting hunger</th>
                <th>Hunger deficit region</th>
                <th>Hunger deficit reward multiplier</th>
                <th>Starting tiredness</th>
                <th>Tiredness deficit region</th>
                <th>Tiredness deficit reward multiplier</th>
                <th>Starting pain</th>
                <th>Pain deficit region</th>
                <th>Pain deficit reward multiplier</th>
                <th>Starting boredom</th>
                <th>Starting playfulness</th>
                <th>Eye sight distance</th>
                <th>Reach distance</th>
                <th>Actor Learning rate</th>
                <th>Critic Learning rate</th>
                <th>Actor Hidden layer neurons count</th>
                <th>Critic Hidden layer neurons count</th>
                <th>Actor Hidden Activation Function</th>
                <th>Critic Hidden Activation Function</th>
                <th>Actor Output Activation Function</th>
                <th>Critic Output Activation Function</th>
                <th title="beta = boredom * p_beta + q_beta">AC P_Beta</th>
                <th title="beta = boredom * p_beta + q_beta">AC Q_Beta</th>
                <th>Discount factor &Gamma;</th>
                <th>Surprise threshold</th>
                <th>Boredom increment</th>
                <th>Boredom decrement</th>
                <th>Play threshold const</th>
                <th>Play threshold random</th>
                <th>Play hidden layer</th>
                <th>Play learning rate</th>
                <th>Play hid actvt</th>
                <th title="beta = boredom * p_beta + q_beta">Play P_Beta</th>
                <th title="beta = boredom * p_beta + q_beta">Play Q_Beta</th>
                <th>Cry threshold eat</th>
                <th>Cry threshold danger</th>
                <th>Cry hidden layer</th>
                <th>Cry learning rate</th>
                <th>Cry hid actvt</th>
                <th title="beta = boredom * p_beta + q_beta">Cry P_Beta</th>
                <th title="beta = boredom * p_beta + q_beta">Cry Q_Beta</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Duplicate record</th>
            </tr>
        <thead>
        <tbody>
        <?php
        foreach( $agents as $agent )
        {
            echo "<tr>";
            foreach( $agent['Agent'] as $key => $value )
            {
                if ( $key === 'modified' ) {
                    echo "<td>" . $value . "</td>";
                    echo "<td>";
                    echo $this->Html->link
                    ( 
                        'Duplicate', array
                        (
                            'controller' => 'agents',
                            'action'     => 'duplicate/' . $agent['Agent']['agent_id']
                        )
                    );
                    echo "</td>";
                    continue;
                }
                if ( $key === 'active' )
                {
                    echo "<td>";
                    if ( $value > 0 ) {
                        echo $this->Form->input
                        (
                            '', 
                            array
                            (
                                'class' => 'active_checkbox',
                                'type'  => 'checkbox',
                                'checked'
                            ) 
                        );
                    }
                    else {
                        echo $this->Form->input
                        (
                            '', 
                            array
                            (
                                'class' => 'active_checkbox',
                                'type'  => 'checkbox'
                            ) 
                        );
                    }
                    echo "</td>";
                    echo "<td>";
                    echo $this->Html->link
                    ( 
                        'Edit', array
                        (
                            'controller' => 'agents',
                            'action'     => 'edit/' . $agent['Agent']['agent_id']
                        )
                    );
                    echo "</td>";
                }
                else {
                    echo "<td>" . $value . "</td>";
                }
            }    
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__( 'New Agent'), array( 'action' => 'add')); ?></li>
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