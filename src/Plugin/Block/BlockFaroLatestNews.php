<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroLatestNews' Block.
 *
 * @Block(
 *   id = "block_faro_latest_news",
 *   admin_label = @Translation("Faro - Ultimas noticias"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroLatestNews extends BlockBase implements ContainerFactoryPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {

        $data = [
            "news" => [1,2,3,4,5,6]
        ];

        return [
            '#theme' => 'block_faro_latest_news',
            '#data' => $data,
            '#title' => $this->t('Ultimas noticias'),
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}