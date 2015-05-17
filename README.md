### Integrating motivation in AI systems
##  A Computational Model of Intrinsic and Extrinsic Motivation for Decision Making and Action-Selection

This is the source code of my master thesis (finishing cognitive science studies) concerning motivation in artificial intelligent systems. The agent (entity driven by AI) is driven by extrinsic (hunger) and intrinsic (curiosity) needs. By performing actions in the environment, the needs are being satiated or increased. From these responses the agent learns how to select different goals in various scenarios. This is peformed in a web application that enables configuration of a large number of scenarios and agents.

To explore the project visit [www.actorcritic.sk](http://www.actorcritic.sk).

### Abstract:

Organisms tend to perform different actions in response to the same stimuli. Taking a domestic cat as an example - if it has constant access to a food source, sometimes it will approach the food source in order to feed itself, while on other occasions it will pass by the resource seemingly uninterested. In the latter case there was no need for the cat to eat.

Motivation has been defined as a reference for a set of needs that activate, direct and sustain goal-directed behavior (Nevid, 2013). Further on, there is a difference between motivation for performing actions like eating or sleeping compared to reading. When eating, we are motivated extrinsically, while our motivation for reading is intrinsic (Oudeyer & Kaplan, 2008).

A model combining intrinsic and extrinsic motivation as needs in internal state space has been proposed (Pileckyte & Takáč, 2013) in order to study the impact of intrinsic motivation on decision making. The main aspect of the proposed model is representing the current state of both intrinsic (boredom, playfullness) and extrinsic (hunger, tiredness, pain) needs as a point in a multidimensional space with each need being one dimension. A general satisfaction level is determined by the distance from a point where each need has a value set to 0 - homeostatic equilibirum. The model proposed an agent embodied in an environment that is able to perform actions in order to satiate needs. 

We implemented the proposed model using neural networks integrated in an actor critic architecture from the computational reinforcement learning framework. The agent learns by performing actions and subsequently retrieving reward signals from the environment. If the agent's internal need point is closer to equilibrium after performing an action, the reward is positive, otherwise it is negative. Learning to perform an action in a given state means the action has a higher priority - the agent will perform this action more often in a similar state. When the agent is bored, the priority is being distributed across all available actions causing the agent to perform a potentially surprising action and lowering the boredom value. 

In order to enable exhaustive research we implemented a rich internet application enabling cognitive science researchers to create a potentially unlimited number of agent and environment configurations. The application can be imagined as a biology laborathory. A researcher prepares an environment (e.g. where a food source is difficult to find), prepares a particular agent to place in this enviornment (e.g. highly motivated for exploration, or already very hungry), observes the behavior of the agent and logs data from the experiment for further analysis. The application runs on [www.actorcritic.sk](http://www.actorcritic.sk)

We performed a number of simulations to obtain preliminary results. The agent was able to learn to cycle between actions in order to satiate extrinsic needs in simple scenarios. In scenarios where the agent had to move around the environment in order to encounter a food source, but was able to sleep in all states, without integrated intrinsic motivation (boredom) it learnt to always perform sleep even tough being increasingly hungry. After integrating intrinsic motivation into the agent in such a scenario, it was able to remain close to homeostatic equilibrium. Even in these simple scenarios, the agent displayed complex behavior. We are curious about the insights this model might provide not only to artificially intelligent systems, but also developmental psychology and motivation behind decision making in organisms.

### References:
Nevid, J. (2013). Psychology: Concepts and applications (4th ed.). Belmont.
Oudeyer, P. Y., & Kaplan, F. (2008). How can we define intrinsic motivation. proceedings of the 8th international conference on epigenetic robotics: modelling cognitive development in robotic systems. lund university cognitive science.
Pileckyte, I., & Takáč, M. (2013). Computational model of intrinsic and extrinsic motivation for decision making and action-selection. Technical report TR-2013-038. Faculty of Mathematics, Physics and Informatics Comenius University, Bratislava.

### [Server side powered by CakePHP v2.2](http://cakephp.org/)
### [Front end is powered by a combination of pure JavaScript & JQuery] (https://jquery.com/)
### [Moving charts in the simulator section are powered by Flot Charts] (http://www.flotcharts.org/)
### [Thanks for sponsoring hosting - AWD Systems] (http://awd.sk/web/src/index.php)
### [Artificial brain powered by my MLP implementation] (https://github.com/LacikIgor/MultiLayer-Perceptron-JavaScript)
### [Released application] (http://www.actorcritic.sk)
