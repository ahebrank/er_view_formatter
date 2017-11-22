<?php
namespace Drupal\er_view_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\views\Views;

/**
 * Plugin implementation of the Entity Reference View Formatter.
 *
 * @FieldFormatter(
 *   id = "er_view_formatter",
 *   label = @Translation("Rendered view"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityReferenceViewFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $view_name = $item->getValue()['target_id'];
      $view = Views::getView($view_name);

      // make sure it's a View
      if (!$view instanceof \Drupal\views\ViewExecutable) {
        continue;
      }

      $storage = $view->storage;

      // Use the first embed display if available.
      if ($storage->getDisplay('embed_1')) {
        $display_id = 'embed_1';
      }
      // Otherwise, use first block display if available.
      elseif ($storage->getDisplay('block_1')) {
        $display_id = 'block_1';
      }
      // Last resort: use default display.
      else {
        $display_id = 'default';
      }
      
      $view->setDisplay($display_id);

      // check access
      if (!$view->access($display_id)) {
        continue;
      }

      $view->build($display_id);
      $view->preExecute();
      $view->execute($display_id);

      $elements[$delta] = $view->buildRenderable($display_id);
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    // This formatter is only available for view entities.
    $target_type = $field_definition->getFieldStorageDefinition()->getSetting('target_type');
    return $target_type == 'view';
  }

}
