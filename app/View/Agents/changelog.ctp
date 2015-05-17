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

<div class="agents index">
    <h2><?php echo __('ChangeLog'); ?></h2>
    <div style="padding-bottom: 10px;">
        <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [30.10.2014]Boredom dependent exploration</h6>
        <p> The exploration is now parameterized using the agents <i> boredom increment, boredom decrement, p beta, q beta, surprise threshold and discount factor </i> values. </p>
        <p> Bugfixes </p>
        <p> <strong> MISSING: </strong> Saving agents weights to database </p>
        </div>
    </div>
    <div style="padding-bottom: 10px;">
        <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [15.10.2014]Testing learning</h6>
        <p> Sum squarred error plot has been added. </p>
        <p> <strong> MISSING: </strong> Saving agents weights to database, boredom dependent exploration </p>
        </div>
    </div>
    <div style="padding-bottom: 10px;">
        <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [16.9.2014]Fixing bugs</h6>
        <p> The Boltzmann selection has been fixed. </p>
        <p> The bug in the reward plot has been removed. </p>
        <p> <strong> MISSING: </strong> Saving agents weights to database, boredom dependent exploration </p>
        </div>
    </div>
    <div style="padding-bottom: 10px;">
        <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [13.8.2014]Actor Critic Ready</h6>
        <p> By examining the agents dataset, the actor appears to be learning correctly in a trivial environment. </p>
        <p> There is a bug in the reward plot. </p>
        <p> There is a bug in the Boltzmann selection causing the agent to act like it picked an action it is not allowed to make. </p>
        <p> Need to implement sum square error function to find out if the agent is learning </p>
        <p> <strong> MISSING: </strong> Saving agents weights to database, fix bugs </p>    
        </div>
    </div>
    <div style="padding-bottom: 10px;">
        <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [11.8.2014]MLP customization ready</h6>
        <p> The hidden neuron count, the activation functions and the learning rates can be set in the agents edit view both for actor and critic perceptrons. </p>
        <p> The number of output neurons for actor depends on the number of active agent actions(also editable in the agents edit view). </p>
        <p> Actor uses SoftMax algorithm. </p>
        <p> Critic has a constant number of 1 output neurons. </p>
        <p> The input size for both actor and critic depends on the size of the visual field plus constant 5 for 5 needs. </p>
        <p> A small bug in the surrounding pain(red circles) in agents visual field may cause the agent not to learn correctly. This will need to be fixed or not used (only square danger objects).</p>
        <p> <strong> MISSING: </strong> Saving agents weights to database, Actor/Critic algorithm, fix bug </p>    
        </div>
    </div>
     <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [07.8.2014]Softmax is ready</h6>
        <p> I implemented the SoftMax algorithm and tried it on the <a href="http://en.wikipedia.org/wiki/Iris_flower_data_set"> IRIS data set</a>. </p>
        <p> 
            <a href="http://www.actorcritic.sk/agents/mlp">An example of my functionality can be viewed here.</a> 
            The network is trained on 46 examples of flowers of each of the 3 categories. Then I display results for 4 examples of first category (am looking for the first output neuron to be around 0.9 - meaning 90% sure it is first category),
            4 examples of the second category and 4 examples of the third category. These have not been shown to the network during training, yet it is able to produce awesome results.
        </p>
        <p> <strong> MISSING: </strong> Logging to database, saving agent weights to database, actor critic algorithm, customization logic of the actor and critic MLP. </p>
    </div>
    <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [28.7.2014] MultiLayer Perceptron is done </h6>
        <p> I have implemented the MultiLayer Perceptron which will serve as the basic element of our agents brain. </p>
        <p> <strong> MISSING: </strong> Saving agent weights to database, softmax algorithm, actor critic algorithm. </p>
    </div>
    <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [10.7.2014]Logging is completed </h6>
        <p> The logic for storing agent data is ready. </p>
        <p> <strong> MISSING: </strong> Saving agent weights to database, any sense of an AI. </p>
    </div>
    <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [18.5.2014]Simulator mostly ready </h6>
        <p> A range for agents reach was added. This means that the agent sees to the eye sight distance, but can perform only actions that are in the reach distance. </p>
        <p> A collection of possible actions is being generated every time step and visible in the left (in case of small resolution monitors bottom) side of the simulator. </p>
        <p> All outcome of the objects interaction with agent are properly affecting the agents needs (This I believed was working, but tested it just now). </p>
        <p> A real-time plot has been added to the simulator that shows how well the agent performs after each of its action. This is for demonstration purposes also, so my supervisors have an idea on what can be achieved. </p>
        <p> <strong> MISSING: </strong> Logging to database, saving agent weights to database, any sense of an AI. </p>
    </div>
    <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [17.5.2014]Simulator mostly ready </h6>
        <p> Manhattan distance for vision is now a simple square. ( Accomplished by DLBFS Algorithm that was the first thing that came to my mind ) </p>
        <p> The range of pain is visible and the non-pain attributes only cause 80% damage of the danger object. </p>
        <p> Agent and its vision look cooler. </p>
        <p> The last action performed is shown in the paragraph next to the agent. </p>
        <p> <strong> MISSING: </strong> Logging, graph creation from the logs. </p>
        <p> <strong> MISSING: </strong> Agent can perform eating, etc. actions, but does not have a representation of which actions can be used in which situation( does not prune on having food only when on food ). </p>
    </div>
    <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [11.5.2014]Simulator mostly ready </h6>
        <p> Agent is moving as well as it's vision. </p>
        <p> Agents attributes are taken from database. </p>
        <p> Agents needs are changing every action according to the information of the action from database. </p>
        <p> You can pause and change speed of the agent </p>
        <p> <strong> MISSING: </strong> Logging, graph creation from the logs. </p>
        <p> <strong> MISSING: </strong> Agent can perform eating, etc. actions, but does not have a representation of which actions can be used in which situation( does not prune on having food only when on food ). </p>
        <p> <strong> MISSING: </strong> The range of pain, food, etc. is not displayed on the map. If you want to check on the strength of the map, you have to click on the node that is supposed to be affected by an object. </p>
    </div>
    <div style="padding-bottom: 10px;">
        <h6 style="font-size: 0.9em;"> [10.5.2014]Map and agent vision ready </h6>
        <p> The function for Manhattan distance for toroids has been implemented. </p>
        <p> The function for simulating the agent vision has been implemented. </p>
        <p> All the objects now contain information from the database. </p>
        <p> Before the AI can be implemented, only the agents skeleton has to be programmed. </p>
    </div>
    <div style="padding-top: 10px;">

        <div style="padding-bottom: 10px;">
            <h6 style="font-size: 0.9em;"> [21.4.2014]Map creation </h6>
            <p> The map is being represented as an HTML canvas script. There is a GUI environment for map creation and editing. </p>
            <p> 
                The GUI environment can be accessed by checking the checkbox for Edit Map in the <a href="http://www.actorcritic.sk/pages">Simulator</a>. 
                When you change the size, you will create a square size*size map. Than you can check a radio button for Empty, Danger, Bed, etc. 
                Now when you click on a node in the map, it will be set to this value (red for danger.) For now there is no graphical hint for which color
                is what object.
            </p>
            <p> Upon saving the current map, the scenario, that is currently active 
                will have it's map representation saved. The raw format can be viewed and copied to other scenarios (ctrl+c) by double-clicking a scenario. 
            </p>
            <p> 
                <strong> TODO: </strong> 
                    <br />
                    Pass scenario attributes to the client, so the nodes act like objects from dataset.
                    <br />
                    Pass agent parameters from server and create the agent. Represent the agent as a circle, so it is more obvious which object is the agent.
                    <br />
                    Have the agent move around and be affected by objects in the environment.
            </p>
        </div>

        <div style="padding-bottom: 10px;">
            <h6 style="font-size: 0.9em;"> [20.4.2014]ChangeLog </h6>
            <p> This ChangeLog site will display all the changes made in the application. </p>
        </div>

        <div style="padding-bottom: 10px;">
            <h6 style="font-size: 0.9em;"> [6.4.2014]Data management </h6>
            <p> 
                Visitors can create new datasets for agents, actions, objects and scenarios representation. 
                Scenarios are in a one-to-many relation with objects and agents are in a one-to-many relation with actions.
                Only one scenario and one agent can be active for a simulation in one browser tab. The data can be filtered
                using the <a href="http://www.picnet.com.au/picnet-table-filter.html" style="">PicNet Table Filter</a>.
            </p>
        </div>

    </div>
</div>
