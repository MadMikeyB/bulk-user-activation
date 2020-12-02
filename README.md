# Bulk User Activation plugin for Craft CMS 3.x

Activate multiple user accounts at once

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Add a reference to this repo in the `repositories` array in `composer.json`:

        "repositories": [
                ...
                {
                        "type": "vcs",
                        "url": "https://github.com/the-refinery/bulk-user-activation.git"
                }
        ]

3. Then tell Composer to load the plugin:

        composer require therefinery/bulk-user-activation

4. In the Control Panel, go to Settings → Plugins and click the “Install” button for Bulk User Activation.

## Bulk User Activation Overview

This utility creates a queued task to activate all users that are currently in the "pending" status. Normally, one would need to open each user account individually to manually activate them, making for tedious work if there are more than a few pending users.

## Configuring Bulk User Activation

No configuration necessary.

## Using Bulk User Activation

1. In Craft Control Panel, go to Utilities → Bulk User Activation Utility

2. Click the button to queue the activation job. Pending jobs will appear at the bottom of the navigation sidebar.

## Bulk User Activation Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [The Refinery](https://the-refinery.io)
