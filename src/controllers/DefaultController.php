<?php
/**
 * Bulk User Activation plugin for Craft CMS 3.x
 *
 * Activate multiple user accounts at once
 *
 * @link      https://the-refinery.io
 * @copyright Copyright (c) 2020 The Refinery
 */

namespace therefinery\bulkuseractivation\controllers;

use therefinery\bulkuseractivation\BulkUserActivation;
use therefinery\bulkuseractivation\jobs\BulkUserActivationTask as BulkUserActivationJob;

use Craft;
use craft\web\Controller;

/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    The Refinery
 * @package   BulkUserActivation
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Public Methods
    // =========================================================================

    public function actionActivateUsers()
    {
        $hasPermission = Craft::$app->user->checkPermission(BulkUserActivation::PERMISSION_BULKUSERACTIVATION_USERS);

        if( !$hasPermission ) {
            return $this->asJson([
                'success' => false
            ]);
        }

        $pendingUsersCount = BulkUserActivation::$plugin->bulkUserActivationService->getPendingUsersCount();
        $params = Craft::$app->getRequest()->getBodyParam('params', []);
        $suppressEmails = $params['suppressEmails'] ?? true;

        if (is_array($suppressEmails)) {
            $suppressEmails = end($suppressEmails);
        }

        $suppressEmails = filter_var($suppressEmails, FILTER_VALIDATE_BOOLEAN);

        $queue = Craft::$app->getQueue();
        $jobId = $queue->push(new BulkUserActivationJob([
            'pendingUsersCount' => $pendingUsersCount,
            'suppressEmails' => $suppressEmails,
        ]));

        if( $jobId ) {
            return $this->asJson([
                'success' => true,
                'jobId' => $jobId,
                'suppressEmails' => $suppressEmails,
            ]);
        }

        return $this->asJson([
            'success' => false,
        ]);
    }
}
