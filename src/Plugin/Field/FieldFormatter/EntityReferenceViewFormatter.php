<?php
namespace Drupal\er_view_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\views\Entity\View;

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

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      if ($entity instanceof View) {
        // Use the first embed display if available.
        if ($entity->getDisplay('embed_1')) {
          $display_id = 'embed_1';
        }
        // Otherwise, use first block display if available.
        elseif ($entity->getDisplay('block_1')) {
          $display_id = 'block_1';
        }
        // Last resort: use default display.
        else {
          $display_id = 'default';
        }
        $executable = $entity->getExecutable();
        $executable->setDisplay($display_id);

        $elements[$delta] = [
          '#type' => 'container',
          'view' => $executable->render(),
        ];
      }
      else {
        $elements[$delta] = array('#markup' => t('This is not a view'));
      }
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
