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
 * ############################################################################
 * ####### This class implements the object Agent which represents    #########
 * ####### the agent as a skeleton and provides it with actions it.   #########
 * ####### it can perform.                                            #########
 * ############################################################################
 */

var interval = undefined;
/**
 * @param {JSON} active_agent
 * @param {Map} map
 */
function Agent( active_agent, map ) {
    this.real_time = 0;
    this.is_random = false;
    this.map = map;
    this.width = this.map.canvas.width / this.map.size;
    this.x = -1;
    this.y = -1;
    this.agent_field_val = EMPTY;
    this.init_coordinates();

    if ( this.x === -1 ) {
        return;
    }
    this.title = active_agent.Agent.name;
    this.note = active_agent.Agent.note;
    this.agent_id = active_agent.Agent.agent_id;

    this.danger_encounter = 0;
    this.hunger = Number( active_agent.Agent.strt_hunger_val );
    this.hunger_deficit_region = Number( active_agent.Agent.hunger_deficit_region );
    this.hunger_deficit_reward = Number( active_agent.Agent.hunger_deficit_reward );

    this.tiredness = Number( active_agent.Agent.strt_tiredness_val );
    this.tiredness_deficit_region = Number( active_agent.Agent.tiredness_deficit_region );
    this.tiredness_deficit_reward = Number( active_agent.Agent.tiredness_deficit_reward );

    this.pain = Number( active_agent.Agent.strt_pain_val );
    this.pain_deficit_region = Number( active_agent.Agent.pain_deficit_region );
    this.pain_deficit_reward = Number( active_agent.Agent.pain_deficit_reward );

    this.boredom = Number( active_agent.Agent.strt_boredom_val );
    this.playfulness = Number( active_agent.Agent.strt_playfulness_val );
    this.cur_dist = this.getDistanceFromEquilibrium();

    this.eye_sight = Number( active_agent.Agent.eye_sght );
    this.reach = Number( active_agent.Agent.range );

    this.play_thr_const = active_agent.Agent.play_thr_const;
    this.play_thr_rand  = active_agent.Agent.play_thr_rand;

    this.cry_thr_eat = active_agent.Agent.cry_thr_eat;
    this.cry_thr_danger  = active_agent.Agent.cry_thr_danger;

    this.move = undefined;
    this.eat = undefined;
    this.sleep = undefined;
    this.play = undefined;
    this.cry = undefined;
    this.actor_actions = [];
    this.init_actions( active_agent );

    this.lastAction = undefined;

    this.visibleNodes = undefined;

    this.possibleActions = undefined;

    // Actor Critic parameters
    this.p_beta = Number( active_agent.Agent.ac_p_beta );
    this.q_beta = Number( active_agent.Agent.ac_q_beta );
    this.gama = Number( active_agent.Agent.gama_discount );
    this.surprise_threshold = Number( active_agent.Agent.surprise_threshold );
    this.boredom_inc = Number( active_agent.Agent.boredom_increment );
    this.boredom_dec = Number( active_agent.Agent.boredom_decrement );
    this.beta = this.computeBeta( this.p_beta, this.q_beta );
    this.actor = undefined;
    this.critic = undefined;
    this.actor_critic = undefined;

    //play_network
    this.play_mlp = undefined;
    this.play_p_beta = Number( active_agent.Agent.play_p_beta );
    this.play_q_beta = Number( active_agent.Agent.play_q_beta );
    //cry_network
    this.cry_mlp = undefined;
    this.cry_p_beta = Number( active_agent.Agent.cry_p_beta );
    this.cry_q_beta = Number( active_agent.Agent.cry_q_beta );

    this.region_multiplier = 1.0;
    this.reward_diff = undefined;
    this.boredom_reward = undefined;
    this.logs = [];

} // constructor Agent

/**
 * Determines if the keys for the actions exist in the JSON.
 * If yes, it creates an instance of the action object in the agent.
 * @param {JSON} active_agent
 */
Agent.prototype.init_actions = function( active_agent ) {
    var move_data = this.getAction( active_agent, 'Move' );
    if ( move_data !== undefined ) {
        this.move = new MoveAction( this, move_data );
        this.actor_actions.push( "Up" );
        this.actor_actions.push( "Down" );
        this.actor_actions.push( "Left" );
        this.actor_actions.push( "Right" );
    }
    var eat_data = this.getAction( active_agent, 'Eat' );
    if ( eat_data !== undefined ) {
        this.eat = new EatAction( this, eat_data );
        this.actor_actions.push( "Eat" );
    }

    var sleep_data = this.getAction( active_agent, 'Sleep' );
    if ( sleep_data !== undefined ) {
        this.sleep = new SleepAction( this, sleep_data );
        this.actor_actions.push( "Sleep" );
    }

    var cry_data = this.getAction( active_agent, 'Cry' );
    if ( cry_data !== undefined ) {
        this.cry = new CryAction( this, cry_data );
        this.actor_actions.push( "Cry" );
    }

    var play_data = this.getAction( active_agent, 'Play' );
    if ( play_data !== undefined ) {
        this.play = new PlayAction( this, play_data );
        this.actor_actions.push( "Play" );
    }
}; // init_actions

/**
 * @param active_agent
 * @returns {void}
 */
Agent.prototype.initAI = function( active_agent ) {
    this.setVisibleNodes(
        getVisibleNodes(
            this.map.getAgentNode(),
            this.eye_sight,
            this.map.getNodes(),
            this.map.getSize()
        )
    );

    var input_size = 5 + this.visibleNodes.length;

    var move_factor = 0;
    for ( var key in active_agent.AgentActionRel ) {
        if ( active_agent.AgentActionRel.hasOwnProperty( key ) ) {
            if ( active_agent.AgentActionRel[key].Action.name === "Move" ) {
                move_factor = 3;
            }
        }
    }

    this.actor = new MLP(
        parseInt( input_size ),
        parseInt( active_agent.Agent.actor_hidden_neuron_count ),
        parseInt( active_agent.AgentActionRel.length ) + move_factor,
        active_agent.Agent.actor_hid_actvt,
        active_agent.Agent.actor_out_actvt,
        undefined,
        parseFloat( active_agent.Agent.learning_rate_actor ),
        0.0,
        true
    );

    this.critic = new MLP(
        parseInt( input_size ),
        parseInt( active_agent.Agent.critic_hidden_neuron_count ),
        1,
        active_agent.Agent.critic_hid_actvt,
        active_agent.Agent.critic_out_actvt,
        undefined,
        parseFloat( active_agent.Agent.learning_rate_critic ),
        0.0,
        false
    );

    this.actor_critic = new ActorCritic(this.actor, this.critic, this);

    this.play_mlp = new MLP(
        parseInt( input_size ),
        parseInt( active_agent.Agent.play_hid_layer ),
        1,
        active_agent.Agent.play_hid_actvt,
        "LIN",
        undefined,
        parseFloat( active_agent.Agent.play_learning_rate ),
        0.0,
        false
    );

    this.cry_mlp = new MLP(
        parseInt( input_size ),
        parseInt( active_agent.Agent.cry_hid_layer ),
        1,
        active_agent.Agent.cry_hid_actvt,
        "LIN",
        undefined,
        parseFloat( active_agent.Agent.cry_learning_rate ),
        0.0,
        false
    );
}; // initAI

/**
 * @returns {String}
 */
Agent.prototype.toString = function() {
    var result = "<br />";
    result += "<h3>" + this.title + "</h3><br />";
    result += "<strong>Last action: </strong>" + this.lastAction + "<br />";
    result += this.note + "<br />";
    result += "<br /><h3>Agents needs</h3>";
    var color = "#000";
    if ( this.hunger > this.hunger_deficit_region ) {
        color = "#F00";
    }
    result += "Hunger <font color='"+color+"'>" + this.hunger + "</font><br />";
    color = "#000";
    if ( this.tiredness > this.tiredness_deficit_region ) {
        color = "#F00";
    }
    result += "Tiredness <font color='"+color+"'>" + this.tiredness + "</font><br />";
    color = "#000";
    if ( this.pain > this.pain_deficit_region ) {
        color = "#F00";
    }
    result += "Pain <font color='"+color+"'>" + this.pain + "</font><br />";
    result += "Boredom " + this.boredom + "<br />";
    result += "Playfulness " + this.playfulness + "<br /><br />";
    result += "Eye sight " + this.eye_sight + "<br />";
    result += "Reach " + this.reach + "<br />";
    result += "Surprise " + this.reward_diff.toFixed( 2 ) + "<br />";
    result += "Boredom reward " + this.boredom_reward + "<br />";

//    result += "X " + this.x + "<br />";
//    result += "Y " + this.y + "<br />";
    result += "<br /><h3>Possible actions</h3>";
    for ( var key in this.possibleActions ) {
        if ( this.possibleActions.hasOwnProperty( key ) ) {
            var new_line = false;
            if ( this.possibleActions[key].title !== undefined ) {
                new_line = true;
                result += this.possibleActions[key].title;
            }
            if ( this.possibleActions[key].x !== undefined ) {
                result += " x: " + this.possibleActions[key].x + " ";
            }
            if ( this.possibleActions[key].y !== undefined ) {
                result += " y: " + this.possibleActions[key].y;
            }
            if ( new_line ) {
                result += ", ";
            }
        }
    }
    return result.substring( 0, result.length - 2 );
}; // toString

/**
 * Searches the input JSON for the action with name
 * as in the action parameter.
 * If it does not exist, returns undefined.
 * @param {String) action
 * @param {JSON}   active_agent
 * @returns {JSON or undefined}
 */
Agent.prototype.getAction = function( active_agent, action ) {
    for ( var i = 0; i < active_agent.AgentActionRel.length; i++ ) {
        if ( active_agent.AgentActionRel[i].Action.name === action ) {
            return active_agent.AgentActionRel[i].Action;
        }
    }
    return undefined;
}; // getAction

/**
 * Initialises the x and y coordinates according to
 * the map representation.
 */
Agent.prototype.init_coordinates = function() {
    var tmpNode = this.map.getAgentNode();
    if ( tmpNode === undefined ) {
        alert (
            "No AGENT node in the map representation!"
        );
        return;
    }
    this.x = Number( tmpNode.x );
    this.y = Number( tmpNode.y );
}; // init_coordinates

Agent.prototype.draw = function() {
    this.map.ctx.fillStyle = AGENT_COLOR;

    this.map.ctx.strokeStyle = "#000";
    this.map.ctx.beginPath();
    this.map.ctx.arc
    (
        this.x * this.width + this.width / 2,
        this.y * this.width + this.width / 2,
        this.width / 2.3,
        0,
        Math.PI * 2,
        true
    );
    this.map.ctx.closePath();
    this.map.ctx.fill();
    this.map.ctx.fillStyle = "#FFF";
    this.map.ctx.font = this.width / 3 + "px Arial";
    this.map.ctx.fillText
    (
        "A",
        this.x * this.width + 1.2 * this.width / 3,
        this.y * this.width + 1.7 * this.width / 3
    );
}; // draw

/**
 * @param {Array} visible_nodes
 * @returns {void}
 */
Agent.prototype.setVisibleNodes = function( visible_nodes ) {
    this.visibleNodes = [];
    this.visibleNodes = visible_nodes;
}; // setVisibleNodes

/**
 * @param {int} speed
 *              => millis
 */
Agent.prototype.start = function( speed ) {
    var _that = this;
    interval = setInterval( function () {
        if ( _that.is_random ) {
            _that.randomAct();
            console.log( "Random act" );
        }
        else {
            _that.act();
            // _that.predefinedAct();
        }
    }, speed );
}; // start

Agent.prototype.pause = function () {
    clearInterval( interval );
}; // pause

/**
 */
Agent.prototype.act = function () {
    // AI PICK AND PERFORM ACTION //;
    var tmp_distance = this.cur_dist;
    var tmp_input = this.prepareInputData(); // get St
    var picked_action = this.actor_critic.chooseAction( tmp_input );
    picked_action = this.getActorActionByID( picked_action ); // action At
    var p_beta = undefined;
    var q_beta = undefined;
    if ( picked_action == "Cry" ) {
        p_beta = this.cry_p_beta;
        q_beta = this.cry_q_beta;
    }

    if ( picked_action == "Play" ) {
        p_beta = this.play_p_beta;
        q_beta = this.play_q_beta;
    }

    var intensity = this.getIntensity( picked_action, tmp_input, p_beta, q_beta );
    this.performAction( picked_action, intensity ); // perform At, is in St+1
    // END PICK AND PERFORM ACTION //
    this.map.drawMap();
    // TRAIN ACTOR & CRITIC ON NEW STATE     //
    var reward_wo_boredom = tmp_distance - this.cur_dist; // compute reward without boredom
    var reward_diff = Math.abs( reward_wo_boredom - this.actor_critic.expected_reward );
    this.updateBoredom( reward_diff );
    var actual_reward = tmp_distance - this.cur_dist; // Rt+1
    actual_reward *= this.region_multiplier;
    this.actor_critic.computeRewardAndTrain(
        actual_reward,
        tmp_input,
        this.prepareInputData(),
        picked_action,
        intensity
    );
    // END TRAIN ACTOR CRITIC ON NEW STATE //
    this.finishAction();
}; // act

/**
* Propagate intensity using cry & play MLPs. If not cry or play, return undefined
* @param {String} picked_action
* @param {Array} input -> same input as actor & critic
* @return {Double} intensity
**/
Agent.prototype.getIntensity = function( picked_action, input, p_beta, q_beta ) {
    if ( !p_beta ) {
        return undefined;
    }
    var beta = this.computeBeta( p_beta, q_beta );
    function beta_intensity( intensity, beta ) {
        var res = Number( intensity ) + ( beta * ( ( Math.random() * 2 ) - 1 ) );
        if ( res < 0 ) return 0;
        return res;
    }
    switch( picked_action ) {
        case "Cry"  :
            return beta_intensity( this.cry_mlp.propagate( input ), beta );
        case "Play" :
            return beta_intensity( this.play_mlp.propagate( input ), beta );
        default:
            return undefined;
    }
}; // getIntensity

/** 
* Finish action
*/
Agent.prototype.finishAction = function() {
    this.logTimeStep();
    this.real_time++;
    this.setPossibleActions();
    $( '#current_needs' ).html( this.toString() );
    $( '#actor_table' ).html( this.actor_critic.getTrainedData() );
}; //finishAction

/**
* Method created for action-testing purposes
**/
Agent.prototype.predefinedAct = function() {
    if ( ( this.real_time == 0 ) || ( this.real_time == 1 ) ) {
        this.performAction( "Up" )
        this.map.drawMap();
        this.pain += Number( this.map.getNode( this.x, this.y ).pain );
        this.finishAction();
        return;
    }
    if ( this.real_time % 2 == 0 )
        this.performAction( "Cry", 0.5 );
    else if ( this.real_time % 3 == 0 )
        this.performAction( "Cry", 0.5 );
    else if ( this.real_time % 5 == 0 ) {
        this.performAction( "Up" );
    }
    else if ( this.real_time % 7 == 0 ) {
        this.performAction( "Cry", 6 );
    }
    this.map.drawMap();
    this.pain += Number( this.map.getNode( this.x, this.y ).pain );
    this.finishAction();
}; // predefinedAct

/** Perform random actions for real-time comparison with a AI **/
Agent.prototype.randomAct = function() {
    var selected_action = this.getActorActionByID( 
        Math.floor(
            ( Math.random() * this.actor_actions.length )
        ) 
    );
    var counter = 0;
    while ( !this.canPerform( selected_action ) ) {
        selected_action = this.getActorActionByID( 
            Math.floor(
                ( Math.random() * this.actor_actions.length )
            ) 
        );    
        if ( counter > 2000 )
            break;
        counter++;
    }
    this.performAction( selected_action, Math.floor( Math.random() * 20 ) - 10 );
    this.map.drawMap();
    this.pain += Number( this.map.getNode( this.x, this.y ).pain );
    this.finishAction();
}; //randomAct

/**
 * Set the possible actions class variable
 * to represent which actions can be performed
 * during this timestep. This currently depends
 * on the location of the agent in the environment
 */
Agent.prototype.setPossibleActions = function() {
    this.possibleActions = [];
    var objects_in_range = this.getObjectsInRange();
    if ( this.eat !== undefined ) {
        var eat = this.can_reach_object( 
            FOOD, 
            objects_in_range 
        );
        if ( eat ) {
            for ( var key in eat ) {
                if ( eat.hasOwnProperty( key ) ) {
                    this.possibleActions.push( eat[key] );
                }
            }
        }
    }
    if ( this.sleep !== undefined ) {
        var sleep = {
            title: "Sleep"
        };
        this.possibleActions.push( sleep );
    };

    if ( this.cry !== undefined ) {
        var cry = {
            title: "Cry"
        };
        this.possibleActions.push( cry );
    };

    if ( this.move !== undefined ) {
        var move = {
            title: "Move"
        };
        this.possibleActions.push( move );
    }
    if ( this.play !== undefined ) {
        var play = this.can_reach_object( TOY, objects_in_range );
        if ( play ) {
            for ( var key in play ) {
                if ( play.hasOwnProperty( key ) ) {
                    this.possibleActions.push( play[key] );
                }
            }
        }
    }
}; // setPossibleActions

/**
 * @returns {Array} all objects the agent can reach
 */
Agent.prototype.getObjectsInRange = function() {
    return getVisibleNodes
    (
        this.map.getNode( this.x, this.y ),
        this.reach,
        this.map.nodes,
        this.map.size
    );
}; // getObjectsInRange

/**
 * @param {String} obj_type_id ObjectTypeID from enum.js
 * @param {Array}  nodes_in_range
 * @returns {Array of actions of the type type that can be performed | false}
 */
Agent.prototype.can_reach_object = function( obj_type_id, nodes_in_range ) {
    var result = [];
    for ( var key in nodes_in_range ) {
        if ( nodes_in_range.hasOwnProperty( key ) ) {
            if ( nodes_in_range[key].value == obj_type_id ) {
                result.push( {
                    title: getActionTitle( obj_type_id ),
                    x: nodes_in_range[key].x,
                    y: nodes_in_range[key].y
                } );
            }
        }
    }
    if ( result.length > 0 ) {
        return result;
    }
    return false;
}; // can_reach_object

/**
 * @param {String} action_title
 * @returns {boolean} => true if the action with title action_title
 *                    => is in the possible actions collection
 */
Agent.prototype.canPerform = function( action_title ) {
    for ( var key in this.possibleActions ) {
        if ( this.possibleActions.hasOwnProperty( key ) ) {
            if ( this.possibleActions[key].title === "Move" ) {
                switch ( action_title ) {
                    case "Up"    :
                        return true;
                    case "Down"  :
                        return true;
                    case "Left"  :
                        return true;
                    case "Right" :
                        return true;
                }
            }
            if ( this.possibleActions[key].title === action_title ) {
                return true;
            }
        }
    }
    return false;
}; // canPerform

/**
* Affect internal states and (or) move 
*      -> get to state St+1
* @param {String} action_title
*/
Agent.prototype.performAction = function( action_title, intensity ) {
    if ( action_title === undefined ) {
        return;
    }
    if ( !this.canPerform( action_title ) ) {
        console.log( "Trying to perform unavailable action " + action_title );
        return;
    }
    var tmp_hunger    = this.hunger;
    var tmp_tiredness = this.tiredness;
    var tmp_pain      = this.pain;
    switch ( action_title ) {
        case "Eat":
            this.eat.affectAgent();
            break;
        case "Play":
            this.play.affectAgent( intensity );
            break;
        case "Sleep":
            this.sleep.affectAgent();
            break;
        case "Cry":
            this.cry.affectAgent( intensity );
            break;
        default:
            this.move.move( action_title );
    }
    // Dont heal pain when on danger object 
    var node_pain_val = this.map.getNode( this.x, this.y ).pain;
    if ( node_pain_val > 0 ) {
        this.danger_encounter = 1;
        this.pain = Number( tmp_pain ) + Number( node_pain_val );
    }
    else {
        this.danger_encounter = 0;
    }
    // if performed a needed action, get higher reward
    this.region_multiplier = this.setRegionMultiplier( tmp_hunger, tmp_tiredness, tmp_pain );
    this.cur_dist = this.getDistanceFromEquilibrium();
}; // perform action

/**
* @param {Double} need value before action
* @param {Double} need value before action
* @param {Double} need value before action
* @return {Double} deficit region multiplier
**/
Agent.prototype.setRegionMultiplier = function( tmp_hunger, tmp_tiredness, tmp_pain ) {
    var region_multiplier = 1.0;
    if ( this.hunger < tmp_hunger ) {
        if ( tmp_hunger > this.hunger_deficit_region ) {
            region_multiplier = this.hunger_deficit_reward;
        }
    } 
    else if ( this.tiredness < tmp_tiredness ) {
        if ( tmp_tiredness > this.tiredness_deficit_region ) {
            region_multiplier = this.tiredness_deficit_reward;
        }
    }
    else if ( this.pain < tmp_pain ) {
        if ( tmp_pain > this.pain_deficit_region ) {
            region_multiplier = this.pain_deficit_reward;
        }
    }
    return region_multiplier;
}; // setRegionMultiplier

/**
 * Combines the agent's needs with the visual node fields
 * to prepare the input data for the actor/critic architecture
 * @returns {Array}
 */
Agent.prototype.prepareInputData = function() {
    var result = [];
    result.push( parseFloat( this.hunger ) );
    result.push( parseFloat( this.tiredness ) );
    result.push( parseFloat( this.pain ) );
    result.push( parseFloat( this.boredom ) );
    result.push( parseFloat( this.playfulness ) );

    for ( var key in this.visibleNodes ) {
        if ( this.visibleNodes.hasOwnProperty( key ) ) {
            if ( this.visibleNodes[key].value === AGENT ) {
                this.visibleNodes[key].value = this.agent_field_val;
                if ( this.visibleNodes[key].value == AGENT ) {
                    console.log( "ERROR: SEES AGENT" );
                }
            }
            result.push( 
                parseInt( this.visibleNodes[key].value ) 
            );
        }
    }
    return result;
}; // prepareInputData

/**
 * @returns {undefined}
 */
Agent.prototype.getDistanceFromEquilibrium = function() {
    return Math.sqrt
    (
        Math.pow( this.boredom, 2 ) +
        Math.pow( this.playfulness, 2 ) +
        Math.pow( this.hunger, 2 ) +
        Math.pow( this.pain, 2 ) +
        Math.pow( this.tiredness, 2 )
    );
}; // getDistanceFromEquilibrium

/**
 * @returns {undefined}
 */
Agent.prototype.logTimeStep = function() {
    var tmpTs = {};
    tmpTs.real_time = this.real_time;
    tmpTs.hunger = this.hunger;
    tmpTs.tiredness = this.tiredness;
    tmpTs.pain = this.pain;
    tmpTs.boredom = this.boredom;
    tmpTs.playfulness = this.playfulness;
    tmpTs.distance = this.cur_dist;
    tmpTs.danger_encounter = this.danger_encounter;
    $.extend( tmpTs, this.actor_critic.getLogTimeStep() );
    this.logs.push( tmpTs );
}; // log

/**
 * @return {Array} agentData for plots
 */
Agent.prototype.getDistanceData = function() {
    var res = [];
    for ( var key in this.logs ) {
        if ( this.logs.hasOwnProperty( key ) ) {
            res.push( this.logs[key].distance );
        }
    } 
    return res;
}; // getDistanceData

Agent.prototype.getRewardData = function() {
    var res = [];
    for ( var key in this.logs ) {
        if ( this.logs.hasOwnProperty( key ) ) {
            res.push( this.logs[key].actual_reward );
        }
    }
    return getTimeWindow( res, 20 );
}; // getRewardData

Agent.prototype.getSumSquaredData = function() {
    var res = [];
    for ( var key in this.logs ) {
        if ( this.logs.hasOwnProperty( key ) ) {
            res.push( this.logs[key].sumSquaredErr );
        }
    }
    return getTimeWindow( res, 20 );
}; // getSumSquaredData

Agent.prototype.getID = function() {
    return this.agent_id;
}; // getName

Agent.prototype.getLogs = function() {
    return this.logs;
}; // getLogs 

Agent.prototype.getActorActions = function() {
    return this.actor_actions;
}; // getActorActions

Agent.prototype.getActorActionByID = function( actor_action_id ) {
    return this.actor_actions[actor_action_id];
}; // getActorActionByIDs

/** Computes the beta factor used in Boltzmann selection **/
Agent.prototype.computeBeta = function( p_beta, q_beta ) {
    return this.boredom * parseFloat( p_beta ) 
                        + parseFloat( q_beta );
}; // computeBeta

Agent.prototype.updateBoredom = function( reward_diff ) {
    this.reward_diff = reward_diff;
    if ( reward_diff > this.surprise_threshold ) {
        this.boredom -= Math.abs( this.boredom_dec );
        this.boredom_reward = Math.abs( this.boredom_dec );
    }
    else {
        this.boredom += Math.abs( this.boredom_inc );
        this.boredom_reward = Math.abs( this.boredom_inc );
    }
    if ( this.boredom < 0 ) {
        this.boredom = 0;
    }
    this.cur_dist = this.getDistanceFromEquilibrium();
    this.beta = this.computeBeta( this.p_beta, this.q_beta );
}; // updateBoredom

/**
* E.g. To test the critic with SumSquared error, the data needs to be smoothened
* @param {Array} an input array containing data to represent in time windows
* @param {Integer} the number of timesteps in a window
* @ 
*/
function getTimeWindow( arr, timesteps ) {
    var res = [];
    var tmp = [];
    var length = arr.length;
    for ( var i = 0; i < arr.length; i++ ) {
        tmp.push( arr[i] );
        if ( tmp.length === timesteps ) {
            res.push( getAverage( tmp ) );
            tmp.length = 0;
        }
    }
    if ( tmp.length > 0 ) {
        res.push( getAverage( tmp ) );
    }
    return res;
} // getSumSquaredTimeWindow

/**
* @param {Array} array of numbers
* @return {Double} average from the numbers in data
*/
function getAverage( arr ) {
    if ( arr.length === 0 ) {
        return 0;
    }
    var result = 0;
    for ( var i = 0; i < arr.length; i++ ) {
        result += arr[i];
    }
    return result / arr.length;
} // getAverage