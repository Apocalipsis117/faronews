<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroFooter' Block.
 *
 * @Block(
 *   id = "block_faro_footer",
 *   admin_label = @Translation("Faro - Footer"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroFooter extends BlockBase implements ContainerFactoryPluginInterface
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
            '#theme' => 'block_faro_footer',
            '#data' => $data,
            '#title' => $this->t('Footer')
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}