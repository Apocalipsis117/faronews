<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroNew' Block.
 *
 * @Block(
 *   id = "block_faro_new",
 *   admin_label = @Translation("Faro - Noticia contenido"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroNew extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $data = [
            "new" => null,
            "new_related" => [1,2]
        ];
        return [
            '#theme' => 'block_faro_new',
            '#data' => $data
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}