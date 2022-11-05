<?php

namespace Drupal\group_node_pevb\EntityViewBuilder;

use Drupal\pluggable_entity_view_builder\EntityViewBuilderPluginAbstract;
use Drupal\group_node_pevb\ElementWrapTrait;
use Drupal\group_node_pevb\ProcessedTextBuilderTrait;

/**
 * An abstract class for Node View Builders classes.
 */
abstract class NodeViewBuilderAbstract extends EntityViewBuilderPluginAbstract {

  use ElementWrapTrait;
  use ProcessedTextBuilderTrait;

}
