/* 
 * The MIT License
 *
 * Copyright 2014 Igor Lacik.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation and source code files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The Software shall be used for Good, not Evil.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/* #############################################################################
 * ##################   GUI IMPLEMENTATION FOR THE SIMULATOR   #################
 * ############################################################################# 
 */

 // Change history:
 // ilacik 1.0 -> Initial Release 

/**
 * ######################################################
 * ###### This class implements the actor critic  #######
 * ###### architecture. It serves for selecting   #######
 * ###### actions that will be performed by the   #######
 * ###### agent in the next step.                 #######
 * ######################################################
 */

/**
 * Constructor
 * @param {MLP} actor
 * @param {MLP} critic
 * @param {Agent} agent
 */
function ActorCritic( actor, critic, agent ) {
    this.actor  = actor;
    this.critic = critic;
    this.agent  = agent;
    this.expected_reward = undefined;
    // for logging purposes
    this.target_for_critic  = [];
    this.curr_critic_output = [];
    this.computed_actions = undefined;
    this.computed_actions_after_boltzmann = undefined;
    this.picked_action = undefined;
    this.actual_reward = undefined;
    this.target_time_steps = [];
    this.output_time_steps = [];
    this.sumSquaredErr = undefined;
    this.cry_intensity = undefined;
    this.play_intensity = undefined;
} // ActorCritic

/**
 * @param {Array} input
 * @returns {Action}
 */
ActorCritic.prototype.chooseAction = function( input ) {
    this.expected_reward = this.critic.propagate( input )[0];
    if ( this.expected_reward == undefined ) {
        alert( "Actor/critic => Choose action => expected reward is undefined - check agent.critic MLP confguration" );
    }
    if ( this.expected_reward == NaN ) {
        alert( "Actor/critic => Choose action => expected reward is NaN - check agent.critic MLP confguration" );
        this.agent.pause();
    }
    this.computed_actions = this.actor.propagate( input );
    if ( this.computed_actions == undefined ) {
        alert( "Actor/critic => Choose action => softmax actor actions are undefined - check agent.actor MLP confguration" );
    }
    this.picked_action = this.boltzmannSelection( this.computed_actions, this.agent.beta );
    if ( this.picked_action == undefined ) {
        alert( "Actor/critic => Choose action => picked action is undefined - check agent.actor_beta confguration" );
    }
    return this.picked_action;
}   ; // chooseAction

/**
* @param{Double} actual_reward The computed reward serves as information for actor critic to decide if actor has to be trained
* @param{Array}  old_input => the environment perceived by the agent before it took the picked_action
* @param{Array}  new_input => the environment perceived by the agent after it took the picked_action
* @param{String} picked_action
* @param{Double} intensity
**/
ActorCritic.prototype.computeRewardAndTrain = function( 
    actual_reward, 
    old_input,
    new_input,
    picked_action,
    intensity
) {
    this.actual_reward = actual_reward;
    var new_state_reward = this.critic.propagate( new_input ); // Vt(St+1)
    this.target_for_critic[0] = this.getCriticTrainingTarget( 
        this.actual_reward, // Rt+1
        this.agent.gama,
        new_state_reward // Vt(St+1)
    ); // will get target Vt+1(St)
    this.critic.train( old_input, this.target_for_critic );
    this.curr_critic_output = this.critic.propagate( new_input ); // for sum squared error
    this.setSumOfSquares();
    if ( this.expected_reward < this.target_for_critic[0] ) {
        this.actor.train( old_input, this.getActorTargets( picked_action ) );
        if ( picked_action == "Cry" ) {
            this.agent.cry_mlp.train( old_input, [intensity] );
            this.cry_intensity = intensity;
        }
        if ( picked_action == "Play" ) {
            this.agent.play_mlp.train( old_input, [intensity] );
            this.play_intensity = intensity;
        }
    }
    if ( ( picked_action == "Play" ) && ( intensity !== undefined ) ) {
        this.play_intensity = intensity;
    }
    else {
        this.play_intensity = "n/a";
    }
    if ( ( picked_action == "Cry" ) && ( intensity !== undefined ) ) {
        this.cry_intensity = intensity;
    }
    else {
        this.cry_intensity  = "n/a";
    }
}; // compute reward

/** Put a 20 timestep window into the sum of squares log JSON **/
ActorCritic.prototype.setSumOfSquares = function() {
    if ( this.output_time_steps.length == 20 ) {
        this.output_time_steps.shift();
        this.target_time_steps.shift();
    }
    this.output_time_steps.push( this.curr_critic_output );
    this.target_time_steps.push( this.target_for_critic );
    this.sumSquaredErr = sumSquaredErr( 
        this.output_time_steps, 
        this.target_time_steps 
    );
}; // setSumOfSquares

ActorCritic.prototype.getCriticTrainingTarget = function( 
    actual_reward, 
    gama,  
    new_state_predicted_reward
) {
    return actual_reward + gama * new_state_predicted_reward;
}; // getCriticTrainingTarget

/**
 * @param {type} picked_action
 * @returns {Array} [0, 0, 0, 0, 1, 0, 0] - picked eat => (left, right, up, down, EAT, sleep, play)
 * (represents which actions have been picked)
 */
ActorCritic.prototype.getActorTargets = function( picked_action ) {
    var result = [];
    for ( var key in this.agent.getActorActions() ) {
        if ( this.agent.getActorActions().hasOwnProperty( key ) ) {
            if ( this.agent.getActorActions()[key] === picked_action )
                result.push(1);
            else
                result.push(0);
        }
    }
    return result;
}; // getActorTargets

/**
 * Pics the winning action index as in roulette
 * @param {type} softmax_outputs ( from actor )
 * @param {type} invTemp (beta_actor)
 * @returns {undefined}
 */
ActorCritic.prototype.boltzmannSelection = function(
    softmax_outputs,
    invTemp
) {
    if ( invTemp === 0 )  {
        invTemp = 1;
    }
    var powered = initArrayZeros( softmax_outputs.length );
    softmax_outputs = this.nullUnpermittedActions( softmax_outputs );
    var sum = 0.0;
    for ( var i = 0; i < softmax_outputs.length; i++ ) {
        powered[i] = Math.pow( softmax_outputs[i], invTemp );
        sum += powered[i];
    }
    this.computed_actions_after_boltzmann = powered;
    var p = sum * Math.random();
    var sumPending = 0.0;
    var i;
    for ( i = 0; i < softmax_outputs.length; i++ ) {
        sumPending += powered[i];
        if ( sumPending > p ) {
            break;
        }
    }
    return i;
}; // boltzmannSelection

/**
* @param {Array} softmax_outputs 
*        -> e.g. default actions are Up,Down,Left,Right,Eat
*        -> represented respectively as 0.10,0.51,0.28,0.01,0.07 in the softmax_outputs
* @return {Array} -> if eat is not permitted in this state (e.g. too far from reach),
*                 -> return represented softmax actions like this: 0.10 (Up),0.51 (Down),0.28 (Left),0.01 (Right),0 (eat)
*/
ActorCritic.prototype.nullUnpermittedActions = function( softmax_outputs ) {
    for ( var i = 0; i < softmax_outputs.length; i++ ) {
        if ( !this.agent.canPerform( this.agent.getActorActionByID( i ) ) ) {
            softmax_outputs[i] = 0.0;
        }
    }
    return softmax_outputs;
} // nullUnpermittedActions

/**
 * @param {Array} actions
 * @returns {String}
 */
ActorCritic.prototype.actionsToString = function( actions ) {
    var result = "";
    for ( var key in actions ) {
        if ( actions.hasOwnProperty( key ) ) {
            result += this.agent.getActorActionByID( key );
            result += " => ";
            result += actions[key];
            result += "  ||  ";
        }
    }
    return result;
}; // actionsToString

ActorCritic.prototype.getLogTimeStep = function() {
    var res = {};
    res.picked_action  = this.agent.getActorActionByID( this.picked_action );
    res.expected_rew   = this.expected_reward;
    res.target_critic  = this.target_for_critic[0];
    res.actual_reward  = this.actual_reward;
    res.cry_intensity  = this.cry_intensity;
    res.play_intensity = this.play_intensity
    res.sumSquaredErr  = this.sumSquaredErr;
    for ( var key in this.computed_actions ) {
        if ( this.computed_actions.hasOwnProperty( key ) ) {
            var name = this.agent.getActorActionByID( key );
            res[name] = this.computed_actions[key];
        }
    }
    return res;
}; // getLogTimeStep

ActorCritic.prototype.getTrainedData = function() {
    var res = "<table><tr>";
    for ( var key in this.computed_actions ) {
        if ( this.computed_actions.hasOwnProperty( key ) ) {
            res += "<th>" + this.agent.getActorActionByID( key ) + "</th>";
        }
    }
    res += "<th>Critic</th>";
    res += "</tr><tr>";
    for ( var key in this.computed_actions ) {
        if ( this.computed_actions.hasOwnProperty( key ) ) {
            res += "<td title='Before Boltzmann distribution'>" + Math.round( this.computed_actions[key] * 100 ) / 100 + "</td>";
        }
    }
    var color = "#F00";
    if ( this.expected_reward < this.target_for_critic[0] ) {
        color = "#50B948";
    }
    res += "<td title='Expected cumulative reward - if read, the agent did not train to perform this action'><font color='"+ color +"'>" + Math.round( this.expected_reward * 100 ) / 100 + "</font></td>";
    res += "</tr><tr>";
    for ( var key in this.computed_actions_after_boltzmann ) {
        if ( this.computed_actions_after_boltzmann.hasOwnProperty( key ) ) {
            res += "<td title='After Boltzmann distribution'>" + Math.round( this.computed_actions_after_boltzmann[key] * 100 ) / 100 + "</td>";
        }
    }
    res += "<td title='Critic target'><font color='"+ color +"'>" + Math.round( this.target_for_critic[0] * 100 ) / 100 + "</font></td>";
    res += "</tr></table>"
    return res;
}; // actionPrioritiesToString

/**
* @param  {Array} output
* @param  {Array} target
* @return {Integer} sum
*/
function sumSquaredErr( output, target ) {
    var sum = 0.0;
    for ( var i = 0; i < output.length; i++ ) {
        sum += Math.pow( target[i] - output[i], 2 );
    }
    return 0.5 * sum;
} // sumSquaredErr