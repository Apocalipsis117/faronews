<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'FaroNewsBlock' block.
 *
 * @Block(
 *   id = "faro_news_block",
 *   admin_label = @Translation("Faro News Block"),
 *   category = @Translation("Custom")
 * )
 */
class FaroNewsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Welcome to Faro News! This is a custom block.'),
    ];
  }
}
