DEPRECATED! You should probably use https://www.drupal.org/project/viewreference 
unless you really want to just format an existing entity reference field.

INTRODUCTION
------------

The Entity Reference View Formatter module provides a field formatter
for entity reference fields that reference views. With this field formatter, 
it is possible to display the referenced view instead of merely linking
to it.

REQUIREMENTS
------------
This module is for Drupal 8.x only.
It works with core Views and Entity Reference fields.
No other contributed modules are required.


INSTALLATION
------------
Install as you would normally install a contributed Drupal module.


CONFIGURATION
-------------

* For the entity reference field that references a View, go to the
  "Manage display" page for your content type or other entity type:
    - Find your entity reference field.
    - Change the display format to "Rendered View."

* This field formatter will render the view's embed_1 display if it exists. 
  If not, it will render the block_1 display if it exists. If neither 
  embed_1 nor block_1 exist, it will render the default display.

* This field formatter does not let you specify which display to render.
  That is being considered for a future version.
