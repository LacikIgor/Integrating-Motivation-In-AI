<?php 
    echo $this->Html->css( 'simulator/simulator' );
    
    function cleanSelectFillObjects( $options, $active_obj_titles )
    {
        $active_obj_titles[] = "Agent";
        $active_obj_titles[] = "Empty";
        $i = 0;
        foreach ( $options as $option )
        {
            $contains = false;
            foreach( $active_obj_titles as $act )
            {
                if ( strpos( $option, $act ) !== false )
                {
                    $contains = true;
                    break;
                }
            }
            if ( !$contains )
            {
                unset( $options[$i] );
            }
            $i++;
        }
        return $options;
    }
?>
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

<div class="agents simulator">
    <h2><?php echo __('Simulator'); ?></h2>
    <div id="simulator_box">
        <div id="actor_table" style="width: 400px; overflow: hidden;">
        </div>
        <canvas id="simulator_canvas" width="400px" height="400px">
        </canvas>
    </div>
    <div id="simulator_options">
        <?php 
            echo $this->Form->create();
            echo $this->Form->input
            ( 
                'Edit map', array 
                (
                    'type' => 'checkbox',
                    'id'   => 'edit_toggle',
                )
            );
            echo "<br />";
            echo "<span id = 'options_form'>";
            echo $this->Form->input
            ( 
                'Size', array
                (
                    'type'   => 'text',
                    'id'     => 'size_input',
                    'value'  => '5' 
                )
            );
            $options = array
            (
                '0' => 'Empty',
                '1' => '<font color="EE9B0F">Agent</font>',
                '2' => '<font color="E21A00">Danger</font>',
                '3' => '<font color="EE129D">Toy</font>',
                '4' => '<font color="000093">Sleep</font>',
                '5' => '<font color="036204">Food</font>',
            );
            
            $options = cleanSelectFillObjects( $options, $active_objects_titles );
                
            $attributes = array( 'id' => 'radio_obj' );
            echo $this->Form->radio
            (
                'Select Fill Object',
                $options,
                $attributes
            );
            echo $this->Form->end( 'Save changes' );
            echo "</span>";
            
            echo "<span id='start_form'>";
            echo $this->Form->input
            (
                'Start simulation',
                array
                (
                    'type'  => 'submit',
                    'id'    => 'start_button',
                    'label' => '',
                    'title' => 'Start the simulation with the current Scenario.'
                )
            );
            echo "<br />";
            echo $this->Form->input
            (
                'Random',
                array
                (
                    'type'  => 'checkbox',
                    'id'    => 'random_agent',
                    'title' => 'Check to start a random behavior (instead of one based on the implemented Artificial intelligence)'
                )
            );
            echo "<br />";
            echo "<span id='speed_span'>";
            echo $this->Form->input
            (
                'Speed',
                array
                (
                    'type'  => 'text',
                    'id'    => 'speed',
                    'value' => '500',
                    'title' => 'The time between an action in milliseconds'
                )
            );
            echo "<br />";
            echo "<hr />";
            echo "<br />";
            echo $this->Form->input
            (
                'Name',
                array
                (
                    'type'  => 'text',
                    'id'    => 'data_name',
                    'placeholder' => 'The name under which you want to store your data',
                    'title' => 'The name under which you want to store your data'
                )
            );
            echo "<br />";
            echo $this->Form->input
            (
                'Note',
                array
                (
                    'type'  => 'textarea',
                    'id'    => 'data_note',
                    'placeholder' => 'Write a note to understand the data later during testing',
                    'title' => 'Write a note to understand the data later during testing'
                )
            );
            echo "<br />";
            echo $this->Form->input
            (
                'Save agent data',
                array
                (
                    'type'  => 'submit',
                    'id'    => 'save_data_button',
                    'label' => '',
                    'title' => 'Save logs and weights of the agent to the database.'
                )
            );
            echo "</span>";
            echo "<div id='current_needs'></div>";
            echo "</span>";
        ?>
        
    </div>
</div>

<div id="plot_placeholder">
    <h2> Needs-equilibrium distance </h2>
    <div class="flot_placeholder" id="time_need_distance_plot"></div>
    <h2> Reward plot </h2>
    <div class="flot_placeholder" id="reward_plot"></div>
    <h2> Sum Squared Error </h2>
    <div class="flot_placeholder" id="sum_squared_err"></div>
</div>

<!-- Retrieve the map representation from server -->
<script>
    var active_representation = '<?php echo $active_representation; ?>';
    var active_objects = jQuery.parseJSON( '<?php echo $active_objects; ?>' );
    var active_agent = jQuery.parseJSON( '<?php echo $active_agent; ?>' );

    if ( active_agent["AgentActionRel"].length == 0 ) {
        var elem = document.getElementById( "simulator_box" );
        var options = document.getElementById( "simulator_options" );
        var plots = document.getElementById( "plot_placeholder" );
        options.innerHTML = "";
        plots.innerHTML = "";
        elem.innerHTML = "<h3>There are no actions defined for this agent. Please select the actions desired in the agents edit section.</h3>";
    }   
</script>

<?php

    echo $this->Html->script
    (
        array
        (
            'plugins/jquery.flot.min',
            'simulator/brain/mlp/mlp.min.js',
            'simulator/agent/agent',
            'simulator/agent/eat_action',
            'simulator/agent/move_action',
            'simulator/agent/play_action',
            'simulator/agent/sleep_action',
            'simulator/agent/cry_action',
            'simulator/world/node',
            'simulator/world/depth_limited_search',
            'simulator/world/map',
            'simulator/world/enum',
            'simulator/agent/actor_critic',
            'simulator/main',
            
        )
    );