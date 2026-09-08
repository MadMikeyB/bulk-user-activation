<?php
/**
 * Bulk User Activation plugin for Craft CMS 3.x
 *
 * Activate multiple user accounts at once
 *
 * @link      https://the-refinery.io
 * @copyright Copyright (c) 2020 The Refinery
 */

namespace therefinery\bulkuseractivation\jobs;

use therefinery\bulkuseractivation\BulkUserActivation;

use Craft;
use craft\queue\BaseJob;

/**
 * BulkUserActivationTask job
 *
 * Jobs are run in separate process via a Queue of pending jobs. This allows
 * you to spin lengthy processing off into a separate PHP process that does not
 * block the main process.
 *
 * More info: https://github.com/yiisoft/yii2-queue
 *
 * @author    The Refinery
 * @package   BulkUserActivation
 * @since     1.0.0
 */
class BulkUserActivationTask extends BaseJob
{
    // Public Properties
    // =========================================================================
    
    /**
     * Users elements
     * 
     * @var object|null
     */
    public $users = null;

    /**
     * Whether emails should be suppressed while users are activated.
     *
     * @var bool
     */
    public $suppressEmails = true;

    // Public Methods
    // =========================================================================

    /**
     * When the Queue is ready to run your job, it will call this method.
     * You don't need any steps or any other special logic handling, just do the
     * jobs that needs to be done here.
     *
     * More info: https://github.com/yiisoft/yii2-queue
     */
    public function execute($queue) : void
    {
        BulkUserActivation::$plugin->bulkUserActivationService->activateUsers(
            $this->users ?: [],
            $this->suppressEmails,
            function ($progress) use ($queue) {
                $this->setProgress($queue, $progress);
            }
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * Returns a default description for [[getDescription()]], if [[description]] isn’t set.
     *
     * @return string The default task description
     */
    protected function defaultDescription(): string
    {
        return Craft::t('bulk-user-activation', 'Activating {usersCount} pending user accounts', [
            'usersCount' => count($this->users ?: [])
        ]);
    }
}
