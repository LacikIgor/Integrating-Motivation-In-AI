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
 * ####### This class implements the object Map which represents the  #########
 * ####### environment in which the actor critic agent will function. #########
 * ############################################################################
 */

/**
 * @param {String} map_representation
 *        1. Map is always a square.
 *        2. Map is a torroid.
 *        3. Map is represented by a string looking like this:
 *           0 0 0 1,
 *           0 2 0 0,
 *           0 0 3 0,
 *           4 0 0 0,
 *           --->> NewLines are not necessary, the comma acts as line separator
 *  @param {JSON} active_agent      
 *  @param {Canvas} canvas
 *        HTML5 canvas object where the environment is drawn
 */
function Map( map_representation, active_agent, canvas )
{
    if ( !canvas.getContext )
    {
        alert( "Archaic browser detected. Your browser does not support HTML5 Canvas. \n\
                Please update your browser." );
        return;
    }
    this.canvas = canvas;
    this.ctx    = canvas.getContext( '2d' );
    this.size   = map_representation.split( ',' ).length;
    this.foo    = 5;
    this.nodes  = this.createMap( map_representation, canvas );
    this.affectNeighbouringNodes();
    
    this.agent = undefined;
    if ( !is_edit_map )
    {
        this.agent = new Agent( active_agent, this );
    }
    
    this.drawMap();
    this.addMouseListener();
} // Map

/** 
 * @param {String} map_representation
 * @returns {Array} of objects of the type Node
 */
Map.prototype.createMap = function( map_representation )
{   
    var result_arr = strToArr( map_representation );
    
    var size   = result_arr.length;
    var result = [];
    for ( line in result_arr )
    {
        if ( arrayHasOwnIndex( result_arr, line ) )
        {
            result[line] = [];
            for ( key in result_arr[line] )
            {
                if ( arrayHasOwnIndex( result_arr[line], key ) )
                {
                    result[line][key] = new Node( this, result_arr[line][key], size, key, line );
                }
            }
        }
    }
    
    return result;
}; // createMap

/**
 * All nodes with ranges higher than zero affect the needs that can be gained on
 * other nodes.
 */
Map.prototype.affectNeighbouringNodes = function()
{
    for ( line in this.nodes )
    {
        if ( arrayHasOwnIndex( this.nodes, line ) )
        {
            for ( key in this.nodes[line] )
            {
                if ( arrayHasOwnIndex( this.nodes[line], key ) )
                {
                    if ( this.nodes[line][key].range > 0 )
                    {
                        this.nodes[line][key].affectNeighbours();
                    }
                }
            }
        }
    }
}; // affectNeighbouringNodes

/*
 * Draws the map
 */
Map.prototype.drawMap = function()
{
    var self = this;
    var also_agent = is_edit_map;
    var visible_nodes = undefined;
    if ( this.agent !== undefined )
    {
        visible_nodes = getVisibleNodes
        ( 
            this.nodes[this.agent.y][this.agent.x], 
            this.agent.eye_sight, 
            this.nodes,
            this.size
        );
        this.agent.setVisibleNodes( visible_nodes );
    }
    for ( line in this.nodes )
    {
        if ( arrayHasOwnIndex( this.nodes, line ) )
        {
            for ( key in this.nodes[line] )
            {
                if ( arrayHasOwnIndex( this.nodes[line], key ) )
                {
                    var darken = true;
                    if ( this.agent !== undefined )
                    {
                        if ( self.node_is_visible( visible_nodes, this.nodes[line][key].x, this.nodes[line][key].y ) )
                        {
                            darken = false;
                        }
                    }
                    else
                    {
                        darken = false;
                    }
                    this.nodes[line][key].drawNode( darken, also_agent );
                }
            }
        }
    }
    
    if ( this.agent !== undefined )
    {
        this.agent.draw();
    }
}; // drawMap

/**
 * @param {Array} _nodes
 * @param {int} x
 * @param {int} y
 * @returns {boolean}
 */
Map.prototype.node_is_visible = function( _nodes, x, y )
{
    for ( var i = 0; i < _nodes.length; i++ )
    {
        if ( ( _nodes[i].x == x ) && ( _nodes[i].y == y ) )
        {
            return true;
        }
    }
    return false;
}; // node_is_visible

/**
 * Adds mouseclick listener to the map 
 * Handles click events ( only in edit mode )
 *  - left click adds selected node type to the field
 */
Map.prototype.addMouseListener = function()
{
    self = this;
    this.canvas.addEventListener( 'click', function( e )
    {
        var rect = canvas.getBoundingClientRect();
        var e_x = Math.round( e.clientX - rect.left );
        var e_y = Math.round( e.clientY - rect.top );
        var tmp = self.getClickedNode( e_x, e_y );
        if ( is_edit_map )
        {
            if ( ( selected_value == AGENT ) && ( self.getStringRepr().indexOf( AGENT ) > -1 ) )
            {
                alert( "Only one instance of the agent is allowed" );
                return;
            }
            if ( tmp !== undefined )
            {
                tmp.setVal( selected_value );
                tmp.drawNode( false, is_edit_map );
            }
        }
        else
        {
            if ( tmp !== undefined )
            {
                alert( tmp );
            }
        }
    }, false );
}; //addMouseClickListener

/*
 * @param {int} e_x
 * @param {int} e_y
 * @return Node
 *      The Node on which the user clicked according
 *      to the mouse-click event coordinates    
 */
Map.prototype.getClickedNode = function( e_x, e_y )
{
    for ( line in this.nodes )
    {
        if ( arrayHasOwnIndex( this.nodes, line ) )
        {
            for ( key in this.nodes[line] )
            {
                if ( arrayHasOwnIndex( this.nodes[line], key ) )
                {
                    if ( this.nodes[line][key].isClickedNode( e_x, e_y ) )
                    {
                        return this.nodes[line][key];
                    }
                }
            }
        }
    }
}; // getClickedNode

/**
 * returns the String representation corresponding to
 * the constructor for the current map layout
 */
Map.prototype.getStringRepr = function()
{
    var result = "";
    for ( line in this.nodes )
    {
        if ( arrayHasOwnIndex( this.nodes, line ) )
        {
            for ( key in this.nodes[line] )
            {
                if ( arrayHasOwnIndex( this.nodes[line], key ) )
                {
                    // not !== -> doesnt work???
                    if ( key != 0 )
                    {
                        result += " " + this.nodes[line][key].getVal();
                    }
                    else
                    {
                        result += this.nodes[line][key].getVal();
                    }
                }
            }
            // not !== -> doesnt work???
            if ( line != ( this.size-1 ) )
            {
                result += ',';
            }
        }
    }
    return result;
}; // toString

/**
 * @returns {undefined or Node}
 */
Map.prototype.getAgentNode = function()
{
    for ( line in this.nodes )
    {
        if ( arrayHasOwnIndex( this.nodes, line ) )
        {
            for ( key in this.nodes[line] )
            {
                if ( arrayHasOwnIndex( this.nodes[line], key ) )
                {
                    if ( this.nodes[line][key].value === AGENT )
                    {
                        return this.nodes[line][key];
                    }
                }
            }
        }
    }
    return undefined;
}; // getAgentNode

/**
 * @param {type} x
 * @param {type} y
 * @returns {undefined}
 */
Map.prototype.getNode = function( x, y )
{
    return this.nodes[y][x];
};  // getNode

Map.prototype.getNodes = function()
{
    return this.nodes;
}; // getNodes

Map.prototype.getSize = function()
{
    return this.size;
}; // getSize

/**
 * @param {String} data_type
 * @returns {Array}
 */
Map.prototype.getAgentData = function( data_type )
{
    if ( this.agent === undefined )
        return undefined;
    if ( data_type === "distance" )
    {
        return this.agent.getDistanceData();
    }
    else if ( data_type === "reward" )
    {
        return this.agent.getRewardData();
    }
    else {
        return this.agent.getSumSquaredData();
    }
}; // getAgentData

/**
 * @param {int} millis
 **/
Map.prototype.start = function( millis )
{
    this.agent.start( millis );
}; // start

Map.prototype.pause = function()
{
    this.agent.pause();
}; // pause

Map.prototype.getAgent = function()
{
    return this.agent;
}; // getAgent

/**
 * This function takes a String representation of the map and returns an array
 * of numeric values that represent the nodes in the map.
 * @param {String}  map_representation
 * @returns {Array} 
 */
function strToArr( map_representation )
{
    var result_arr = [];
    var repr = map_representation.split( ',' );
    for ( line in repr )
    {
        if ( arrayHasOwnIndex( repr, line ) )
        {
            result_arr[line] = repr[line].split( ' ' );
        }
    }
    return result_arr;
} // strToArr

/**
 * @param {Node} node1
 * @param {Node} node2
 * @param {int} size
 * @returns {int}
 */
function getManhattanDistance( node1, node2, size )
{
    return getManhattanDistance1( node1, node2.x, node2.y, size );
} // getMangetManhattanDistance
   
/**
 * @param {Node} node1
 * @param {int}  x1
 * @param {int}  y1
 * @param {int}  size
 * @returns {int}
 */
function getManhattanDistance1( node1, x1, y1, size )
{
    var dx = Math.min( Math.abs( node1.x - x1 ), size - Math.abs( x1 - node1.x ) );
    var dy = Math.min( Math.abs( node1.y - y1 ), size - Math.abs( y1 - node1.y ) );
    return dx + dy;    
//    return Math.sqrt( Math.pow( node1.x - x1 ) + Math.pow( node1.y - y1 ) );
} // getMangetManhattanDistance

/**
 * @param {Node} node1
 * @param {Node} node2
 * @returns {boolean}
 */
function isSameNode( node1, node2 )
{
    return ( node1.x === node2.x ) && ( node1.y === node2.y );
} // isSameNode