<?php
/**
 * Bulk User Activation plugin for Craft CMS 3.x
 *
 * Activate multiple user accounts at once
 *
 * @link      https://the-refinery.io
 * @copyright Copyright (c) 2020 The Refinery
 */

namespace therefinery\bulkuseractivation\utilities;

use therefinery\bulkuseractivation\BulkUserActivation;
use therefinery\bulkuseractivation\models\BulkUserActivation_UsersModel;
use therefinery\bulkuseractivation\assetbundles\bulkuseractivationutilityutility\BulkUserActivationUtilityUtilityAsset;

use Craft;
use craft\base\Utility;
use craft\elements\User;

/**
 * Bulk User Activation Utility
 *
 * Utility is the base class for classes representing Control Panel utilities.
 *
 * https://craftcms.com/docs/plugins/utilities
 *
 * @author    The Refinery
 * @package   BulkUserActivation
 * @since     1.0.0
 */
class BulkUserActivationUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * Returns the display name of this utility.
     *
     * @return string The display name of this utility.
     */
    public static function displayName(): string
    {
        return Craft::t('bulk-user-activation', 'Bulk User Activation Utility');
    }

    /**
     * Returns the utility’s unique identifier.
     *
     * The ID should be in `kebab-case`, as it will be visible in the URL (`admin/utilities/the-handle`).
     *
     * @return string
     */
    public static function id(): string
    {
        return 'bulkuseractivation-bulk-user-activation-utility';
    }

    /**
     * Returns the path to the utility's SVG icon.
     *
     * @return string|null The path to the utility SVG icon
     */
    public static function iconPath()
    {
        return Craft::getAlias("@therefinery/bulkuseractivation/assetbundles/bulkuseractivationutilityutility/dist/img/BulkUserActivationUtility-icon.svg");
    }

    /**
     * Returns the number that should be shown in the utility’s nav item badge.
     *
     * If `0` is returned, no badge will be shown
     *
     * @return int
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * Returns the utility's content HTML.
     *
     * @return string
     */
    public static function contentHtml(): string
    {
        // $currentUser = new CurrentUser;
        $hasPermission = Craft::$app->user->checkPermission(BulkUserActivation::PERMISSION_BULKUSERACTIVATION_USERS);

        $view = Craft::$app->getView();

        $view->registerAssetBundle(BulkUserActivationUtilityUtilityAsset::class);
        $view->registerJs('new Craft.BulkUserActivationUtility(\'bulk-user-activation\');');

        $users = new BulkUserActivation_UsersModel();
        $pendingUsers = $users->getPendingUsers();

        return $view->renderTemplate(
            'bulk-user-activation/_components/utilities/BulkUserActivationUtility_content',
            [
                'pendingUsersCount' => count($pendingUsers),
                'hasPermission' => $hasPermission 
            ]
        );
    }
}
