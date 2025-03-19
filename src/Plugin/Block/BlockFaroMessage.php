<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroMessage' Block.
 *
 * @Block(
 *   id = "block_faro_message",
 *   admin_label = @Translation("Faro - message alert"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroMessage extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $data = [
            "title" => 'Hola'
        ];
        return [
            '#theme' => 'block_faro_message',
            '#data' => $data
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}