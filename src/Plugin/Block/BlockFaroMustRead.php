<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroMustRead' Block.
 *
 * @Block(
 *   id = "block_faro_must_read",
 *   admin_label = @Translation("Faro - Noticias mas leidas"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroMustRead extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $data = [
            "news" => [1,2,3],
            "new" => 1
        ];
        return [
            '#theme' => 'block_faro_must_read',
            '#data' => $data
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}