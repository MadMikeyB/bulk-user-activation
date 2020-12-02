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
use craft\elements\User;
use craft\services\Users;

/**
 * BulkUserActivationTask job
 *
 * Jobs are run in separate process via a Queue of pending jobs. This allows
 * you to spin lengthy processing off into a separate PHP process that does not
 * block the main process.
 *
 * You can use it like this:
 *
 * use therefinery\bulkuseractivation\jobs\BulkUserActivationTask as BulkUserActivationTaskJob;
 *
 * $queue = Craft::$app->getQueue();
 * $jobId = $queue->push(new BulkUserActivationTaskJob([
 *     'description' => Craft::t('bulk-user-activation', 'This overrides the default description'),
 *     'someAttribute' => 'someValue',
 * ]));
 *
 * The key/value pairs that you pass in to the job will set the public properties
 * for that object. Thus whatever you set 'someAttribute' to will cause the
 * public property $someAttribute to be set in the job.
 *
 * Passing in 'description' is optional, and only if you want to override the default
 * description.
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

    // private $pending = null;

    // function __construct() {
    //     $this->pending = User::find()->status('pending')->all();
    // }

    // Public Methods
    // =========================================================================

    /**
     * When the Queue is ready to run your job, it will call this method.
     * You don't need any steps or any other special logic handling, just do the
     * jobs that needs to be done here.
     *
     * More info: https://github.com/yiisoft/yii2-queue
     */
    public function execute($queue)
    {
        // $pendingUsers = User::find()->status('pending')->all();
        $UsersService = new Users;
        $totalUsers = count($this->users);

        foreach($this->users as $i => $user) {
            $this->setProgress($queue, $i / $totalUsers);

            try {
                $UsersService->activateUser($user);
            } catch (\Throwable $e) {

                Craft::error("BulkUserActivation: Attempting to activate UserID='{$user->id}' failed: \n".$e->getTraceAsString());
                continue;
                // throw $e;
            }

            Craft::info("BulkUserActivation: Successfully activated user UserID='{$user->id}'!");
        }
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
            'usersCount' => count($this->users)
        ]);
    }
}
