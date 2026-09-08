<?php
/**
 * Bulk User Activation plugin for Craft CMS 3.x
 *
 * Activate multiple user accounts at once
 *
 * @link      https://the-refinery.io
 * @copyright Copyright (c) 2020 The Refinery
 */

namespace therefinery\bulkuseractivation\services;

use Craft;
use craft\base\Component;
use craft\elements\User;
use craft\mail\Mailer as CraftMailer;

/**
 * BulkUserActivationService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    The Refinery
 * @package   BulkUserActivation
 * @since     1.0.0
 */
class BulkUserActivationService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Returns users that can be activated by this plugin.
     *
     * @return array
     */
    public function getPendingUsers(): array
    {
        return User::find()->status(['pending', 'inactive'])->all();
    }

    /**
     * Returns the number of users that can be activated by this plugin.
     *
     * @return int
     */
    public function getPendingUsersCount(): int
    {
        return count($this->getPendingUsers());
    }

    /**
     * Activates the supplied users.
     *
     * @param array $users
     * @param bool $suppressEmails
     * @param callable|null $progressCallback
     */
    public function activateUsers(array $users, bool $suppressEmails = true, ?callable $progressCallback = null): void
    {
        $usersService = Craft::$app->getUsers();
        $mailer = Craft::$app->getMailer();
        $totalUsers = count($users);
        $emailSuppressionStatus = $suppressEmails ? 'suppressed' : 'not suppressed';
        $suppressEmail = null;

        if ($totalUsers === 0) {
            return;
        }

        if ($suppressEmails) {
            $suppressEmail = static function ($event) {
                $event->isValid = false;
            };
            $mailer->on(CraftMailer::EVENT_BEFORE_SEND, $suppressEmail);
        }

        try {
            foreach($users as $i => $user) {
                if ($progressCallback !== null) {
                    $progressCallback($i / $totalUsers);
                }

                try {
                    $usersService->activateUser($user);
                } catch (\Throwable $e) {
                    Craft::error("BulkUserActivation: Attempting to activate UserID='{$user->id}' failed: \n".$e->getTraceAsString());
                    continue;
                }

                Craft::info("BulkUserActivation: Successfully activated user UserID='{$user->id}'! Emails were {$emailSuppressionStatus}.");
            }
        } finally {
            if ($suppressEmail !== null) {
                $mailer->off(CraftMailer::EVENT_BEFORE_SEND, $suppressEmail);
            }
        }
    }
}
