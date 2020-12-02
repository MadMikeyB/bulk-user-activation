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

use therefinery\bulkuseractivation\BulkUserActivation;

use Craft;
use craft\base\Component;

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
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     BulkUserActivation::$plugin->bulkUserActivationService->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';

        return $result;
    }
}
