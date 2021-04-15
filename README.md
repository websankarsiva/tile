## Grid content layout design
Featured article or info or video contents can be added as a grid layout on home page. User has to enable the required modules and add tile contents with different type selection such as article/video/informative with respective fields.

## Installation

 - Copy the libraries and modules folder into fresh Drupal 8.9.x root
 - Enable tiles_grid module, before that dependencies would be enabled during this module installation
 - Once installed, please add the tags term as people, planet, food
 - Create a user with content manager role
 - Login with the content manager credential and add the tile contents. 
 - Please select the type of tile so that respective fields will be shown
 - Once tile content is added, please add to the tile entity queue.

## Technical Implementation

 - Custom front page is created by custom controller and loading a tile entity queue and fetching the tile and artcile nodes from the queue.
 - Rendered template variables on custom template with Isotope library
 - YouTube video is played on colorbox popup by clicking play button
 - Flaticon is used and icon is generated based on term name
 - Tile layout is validated and designed by a tile field type value
