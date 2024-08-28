# Bulk User Activation plugin for Craft CMS

Activate multiple user accounts at once

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires [PHP](https://www.php.net/) 7.4 - 8.2 and supports [Craft CMS](https://www.craftcms.com/) 3.x and 4.x.

| Bulk User Activation  | Craft 3            | Craft 4            |
|----------|--------------------|--------------------|
| 1.x      | :white_check_mark: | :x:                |
| 2.x      | :x:                | :white_check_mark: |


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

<a href="https://github.com/the-refinery/bulk-user-activation/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=the-refinery/bulk-user-activation" />
</a>