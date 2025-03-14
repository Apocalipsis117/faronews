<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroNewFeactured' Block.
 *
 * @Block(
 *   id = "block_faro_new_feactured",
 *   admin_label = @Translation("Faro - Noticias recientes (Slider)"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroNewFeactured extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $data = [
            "slider" => [1,2,3],
            "news" => [1,2,3]
        ];
        return [
            '#theme' => 'block_faro_new_feactured',
            '#data' => $data,
            '#title' => $this->t('Noticias recientes (Slider)')
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}