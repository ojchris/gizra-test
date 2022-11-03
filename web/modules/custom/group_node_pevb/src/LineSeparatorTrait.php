<?php

namespace Drupal\group_node_pevb;

/**
 * Helper methods for a line separator.
 */
trait LineSeparatorTrait {

  /**
   * Build a line separator.
   *
   * @return array
   *   Render array.
   */
  protected function buildLineSeparator(): array {
    return [
      '#theme' => 'server_theme_line_separator',
    ];
  }

}
