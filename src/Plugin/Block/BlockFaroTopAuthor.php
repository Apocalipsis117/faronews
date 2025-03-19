<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroTopAuthor' Block.
 *
 * @Block(
 *   id = "block_faro_top_authors",
 *   admin_label = @Translation("Faro - Autores destacados"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroTopAuthor extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $data = [
            "authors" => [1,2,3,4]
        ];
        return [
            '#theme' => 'block_faro_top_authors',
            '#data' => $data
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}