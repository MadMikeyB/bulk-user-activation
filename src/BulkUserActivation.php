<?php
/**
 * Bulk User Activation plugin for Craft CMS 3.x
 *
 * Activate multiple user accounts at once
 *
 * @link      https://the-refinery.io
 * @copyright Copyright (c) 2020 The Refinery
 */

namespace therefinery\bulkuseractivation;

use therefinery\bulkuseractivation\services\BulkUserActivationService as BulkUserActivationServiceService;
use therefinery\bulkuseractivation\utilities\BulkUserActivationUtility as BulkUserActivationUtilityUtility;

use Craft;
use craft\base\Plugin;
use craft\services\Utilities;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://docs.craftcms.com/v3/extend/
 *
 * @author    The Refinery
 * @package   BulkUserActivation
 * @since     1.0.0
 *
 * @property  BulkUserActivationServiceService $bulkUserActivationService
 */
class BulkUserActivation extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * BulkUserActivation::$plugin
     *
     * @var BulkUserActivation
     */
    public static $plugin;

    const PERMISSION_BULKUSERACTIVATION_USERS = 'PERMISSION_BULKUSERACTIVATION_USERS';

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public string $schemaVersion = '1.1.0';

    /**
     * Set to `true` if the plugin should have a settings view in the control panel.
     *
     * @var bool
     */
    public bool $hasCpSettings = false;

    /**
     * Set to `true` if the plugin should have its own section (main nav item) in the control panel.
     *
     * @var bool
     */
    public bool $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * BulkUserActivation::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register our utilities
        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITIES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = BulkUserActivationUtilityUtility::class;
            }
        );

        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function (RegisterUserPermissionsEvent $event) {
                $permissions = [];
                $permissions[self::PERMISSION_BULKUSERACTIVATION_USERS] = [
                    'label' => Craft::t('bulk-user-activation', 'Activate Users')
                ];
                $event->permissions[] = [
                    'heading' => Craft::t('bulk-user-activation', 'Bulk User Activation Utility'),
                    'permissions' => $permissions,
                ];
            }
        );

        Craft::info(
            Craft::t(
                'bulk-user-activation',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
}
