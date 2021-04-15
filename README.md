## Grid content layout design
Featured article or info or video contents can be added as grid layout on home page. User has to enable required modules and add tile contents with different type selection article/video/informative with respective fields.

## Installation

 - Copy the libraries and modules folder into fresh Drupal 8.9.x root
 - Enable tiles_grid module, before that dependencies would be enabled during this module installation
 -  Once installed please add tags term as people, planet, food
 - Create a user with content manager role
 - Login with content manager credential and add tile contents. 
 - Please select type of tile so that respective fields will be shown
 - Once tile content is added, please add to tile entity queue.

## Technical Implementation

 - Custom front page is created by custom controller and loading a tile entity queue and fetching the tile and artcile nodes from the queue.
 - Rendred template variables on custom template with Isotope library
 - YouTube video is being played using colorbox module on clicking play button
 - Flaticon is used and icon is generated based on term name
 - Tile layout is validated and designed by tile field type value
