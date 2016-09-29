# Entity Reference View Formatter

The Entity Reference View Formatter module provides a field formatter
for entity reference fields that reference views. With this field formatter, 
it is possible to display the referenced view instead of merely linking
to it.

This is a lightly updated and repackaged version of [paulmckibben's sandboxed module](https://www.drupal.org/sandbox/paulmckibben/2481503)

## Quickstart

- For the entity reference field that references a View, go to the
  "Manage display" page for your content type or other entity type:
    - Find your entity reference field.
    - Change the display format to "Rendered View."

- This field formatter will render the view's embed_1 display if it exists. 
  If not, it will render the block_1 display if it exists. If neither 
  embed_1 nor block_1 exist, it will render the default display.
