<?php

namespace Drupal\Tests\group_node_pevb\Traits;

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\Entity\NodeType;
use Drupal\node\Entity\Node;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a helper method for creating a repository content type with fields.
 */
trait GroupContentTypeTrait {

  /**
   * Creates a repository content type with a field.
   */
  protected function createGroupContentType(): void {
    NodeType::create(['type' => 'group', 'name' => 'Group'])->save();

    // Create custom Body field.
    FieldStorageConfig::create([
      'field_name' => 'field_body',
      'type' => 'text_long',
      'entity_type' => 'node',
      'cardinality' => 1,
    ])->save();
    FieldConfig::create([
      'field_name' => 'field_body',
      'entity_type' => 'node',
      'bundle' => 'group',
      'label' => 'Body',
    ])->save();
  }

  /**
   * Create Group node.
   */
  public function createGroupNode(string $title, NodeType $node_type, string $body, AccountInterface $user) {
    $settings = [
      'title' => $title,
      'type' => $node_type,
      'field_body' => $body,
      'uid' => $user->id(),
    ];
    $node = Node::create($settings);
    return $node;
  }

}
