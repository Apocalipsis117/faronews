<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroMenuTop' Block.
 *
 * @Block(
 *   id = "block_faro_menu_top",
 *   admin_label = @Translation("Faro - Navegacion top"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroMenuTop extends BlockBase implements ContainerFactoryPluginInterface
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
            '#theme' => 'block_faro_menu_top',
            '#data' => $data,
            '#title' => $this->t('Menu de navegacion principal')
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}