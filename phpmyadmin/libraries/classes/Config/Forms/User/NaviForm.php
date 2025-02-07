<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * User preferences form
 *
 * @package PhpMyAdmin
 */
declare(strict_types=1);

namespace PhpMyAdmin\Config\Forms\User;

use PhpMyAdmin\Config\Forms\BaseForm;

/**
 * Class NaviForm
 * @package PhpMyAdmin\Config\Forms\User
 */
class NaviForm extends BaseForm
{
    /**
     * @return array
     */
    public static function getForms()
    {
        return [
            'Navi_panel' => [
                'ShowDatabasesNavigationAsTree',
                'NavigationLinkWithMainPanel',
                'NavigationDisplayLogo',
                'NavigationLogoLink',
                'NavigationLogoLinkWindow',
                'NavigationTreePointerEnable',
                'FirstLevelNavigationItems',
                'NavigationTreeDisplayItemFilterMinimum',
                'NumRecentTables',
                'NumFavoriteTables',
                'NavigationWidth',
            ],
            'Navi_tree' => [
                'MaxNavigationItems',
                'NavigationTreeEnableGrouping',
                'NavigationTreeEnableExpansion',
                'NavigationTreeShowTables',
                'NavigationTreeShowViews',
                'NavigationTreeShowFunctions',
                'NavigationTreeShowProcedures',
                'NavigationTreeShowEvents',
                'NavigationTreeAutoexpandSingleDb',
            ],
            'Navi_servers' => [
                'NavigationDisplayServers',
                'DisplayServersList',
            ],
            'Navi_databases' => [
                'NavigationTreeDisplayDbFilterMinimum',
                'NavigationTreeDbSeparator',
            ],
            'Navi_tables' => [
                'NavigationTreeDefaultTabTable',
                'NavigationTreeDefaultTabTable2',
                'NavigationTreeTableSeparator',
                'NavigationTreeTableLevel',
            ],
        ];
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return __('Navigation panel');
    }
}
