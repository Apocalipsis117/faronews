<?php

namespace Drupal\faronews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'BlockFaroWeeklyHighlint' Block.
 *
 * @Block(
 *   id = "block_faro_weekly_hightlint",
 *   admin_label = @Translation("Faro - Noticias de la semana"),
 *   category = @Translation("Custom")
 * )
 */
class BlockFaroWeeklyHighlint extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $data = [
            "news" => [1,2,3,4,5,6,7]
        ];
        return [
            '#theme' => 'block_faro_weekly_hightlint',
            '#data' => $data,
            '#title' => $this->t('Autores destacados')
        ];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }
}