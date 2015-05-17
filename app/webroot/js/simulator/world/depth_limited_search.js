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
 * ####### An implementation of depth limited search for determining  #########
 * ####### which nodes are in the visual field                        #########
 * ############################################################################
 */

/**
 * 
 * @param {Node} root
 * @param {int} depth
 * @param {Array} nodes
 * @param {int} size
 * @returns {Array}
 */
function depth_limited_search( 
        root, 
        depth, 
        nodes, 
        size 
    )
{
    var queue = [];
    var visited = [];
    
    var currentDepth = 0;
    var elementsToDepthIncrease = 1;
    var nextElementsToDepthIncrease = 0;
    
    root.text = depth;
    queue.push( root );
    if ( !visitedContains( root, visited ) )
    {
        visited.push( root );
    }
    while ( ( queue.length != 0 ) )
    {
        var curNode = queue.shift();
        if ( !visitedContains( curNode, visited ) )
        {
            visited.push( curNode );
        }
        var neighbours = getNeighbours( curNode, nodes, size );

        nextElementsToDepthIncrease += neighbours.length;
        elementsToDepthIncrease--;
        if ( elementsToDepthIncrease == 0 )
        {
            currentDepth++;
            if ( currentDepth > depth )
            {
                return visited;
            }
            elementsToDepthIncrease = nextElementsToDepthIncrease;
            nextElementsToDepthIncrease = 0;
        }
        
        for ( var key in neighbours )
        {
            if ( neighbours.hasOwnProperty( key ) )
            {
                var nextNode = neighbours[key];
                queue.push( nextNode );
            }
        }
    }
    
    return visited;
} // brebreadth_first_search

/**
 * 
 * @param {Node} node
 * @param {int} range
 * @param {Array} nodes
 * @param {int} size
 * @returns {Array}
 */
function getVisibleNodes( 
        node, 
        range, 
        nodes, 
        size 
    )
{
    return depth_limited_search( 
        node, 
        range, 
        nodes, 
        size 
    );
} // getVisibleNodes

/**
 * @param {Node} node
 * @param {Array} visited
 * @returns {boolean}
 */
function visitedContains( node, visited )
{
    for ( var key in visited )
    {
        if ( visited.hasOwnProperty( key ) )
        {
            if ( ( visited[key].x == node.x ) && 
                 ( visited[key].y == node.y ) 
                )
            {
                return true;
            }
        }
    }
    return false;
} // visitedContains

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size 
 * @returns {Array}
 */
function getNeighbours( root, nodes, size )
{
    var result = [];
    result.push( upperLeftNeighbour( root, nodes, size ) );
    result.push( upperNeighbour( root, nodes, size ) );
    result.push( upperRightNeighbour( root, nodes, size ) );
    
    result.push( centerLeftNeighbour( root, nodes, size ) );
    result.push( centerRightNeighbour( root, nodes, size ) );
    
    result.push( bottomLeftNeighbour( root, nodes, size ) );
    result.push( bottomNeighbour( root, nodes, size ) );
    result.push( bottomRightNeighbour( root, nodes, size ) );
    
    return result;
} // getNeighbours

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function upperLeftNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.x == 0 ) 
    {
        x = size - 1;
    }
    else
    {
        x--;
    }
    if ( root.y == 0 )
    {
        y = size-1;
    }
    else
    {
        y--;
    }
    return nodes[y][x];
} // uppupperLeftNeighbour

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function upperNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.y == 0 )
    {
        y = size-1;
    }
    else
    {
        y--;
    }
    return nodes[y][x];
} // upperNeighbour

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function upperRightNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.x == ( size-1 ) ) 
    {
        x = 0;
    }
    else
    {
        x++;
    }
    if ( root.y == 0 )
    {
        y = size-1;
    }
    else
    {
        y--;
    }
    return nodes[y][x];
} // upperRightNeighbour

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function centerRightNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.x == ( size-1 ) ) 
    {
        x = 0;
    }
    else
    {
        x++;
    }
    return nodes[y][x];
} // centerRightNeighbour

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function centerLeftNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.x == 0 ) 
    {
        x = size-1;
    }
    else
    {
        x--;
    }
    return nodes[y][x];
} // centerLeftNeighbour

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function bottomRightNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.x == ( size-1 ) ) 
    {
        x = 0;
    }
    else
    {
        x++;
    }
    if ( root.y == ( size-1 ) )
    {
        y = 0;
    }
    else
    {
        y++;
    }
    return nodes[y][x];
} // bottomRightNeighbour

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function bottomLeftNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.x == 0 ) 
    {
        x = size-1;
    }
    else
    {
        x--;
    }
    if ( root.y == ( size-1 ) )
    {
        y = 0;
    }
    else
    {
        y++;
    }
    return nodes[y][x];
} // bottomLeftNeighbour

/**
 * @param {Node} root
 * @param {Array} nodes
 * @param {int} size
 * @returns {Node}
 */
function bottomNeighbour( root, nodes, size )
{
    var x = root.x;
    var y = root.y;
    if ( root.y == ( size-1 ) )
    {
        y = 0;
    }
    else
    {
        y++;
    }
    return nodes[y][x];
} // bottomNeighbour