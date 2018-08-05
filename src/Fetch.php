<?php
/**
 * Guzzle plugin for Craft CMS 3.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/wyveo
 * @copyright Copyright (c) 2018 wyveo
 */

namespace wyveo\guzzle;

use wyveo\guzzle\variables\GuzzleVariable;
use wyveo\guzzle\twigextensions\GuzzleTwigExtension;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class Guzzle
 *
 * @author    Colin Wilson
 * @package   Guzzle
 * @since     1.0.0
 *
 */
class Guzzle extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Guzzle
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::$app->view->registerTwigExtension(new GuzzleGuzzleTwigExtension());

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('guzzle', GuzzleVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'guzzle',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
