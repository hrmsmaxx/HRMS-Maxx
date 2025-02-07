<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Links configuration for MySQL system tables
 *
 * @package PhpMyAdmin
 */
declare(strict_types=1);

namespace PhpMyAdmin\Config;

use PhpMyAdmin\Util;

/**
 * Class SpecialSchemaLinks
 * @package PhpMyAdmin\Config
 */
class SpecialSchemaLinks
{
    /**
     * This array represent the details for generating links inside
     * special schemas like mysql, information_schema etc.
     * Major element represent a schema.
     * All the strings in this array represented in lower case
     *
     * Array structure ex:
     * array(
     *     // Database name is the major element
     *     'mysql' => array(
     *         // Table name
     *         'db' => array(
     *             // Column name
     *             'user' => array(
     *                 // Main url param (can be an array where represent sql)
     *                 'link_param' => 'username',
     *                 // Other url params
     *                 'link_dependancy_params' => array(
     *                     0 => array(
     *                         // URL parameter name
     *                         // (can be array where url param has static value)
     *                         'param_info' => 'hostname',
     *                         // Column name related to url param
     *                         'column_name' => 'host'
     *                     )
     *                 ),
     *                 // Page to link
     *                 'default_page' => './server_privileges.php'
     *             )
     *         )
     *     )
     * );
     *
     * @return array
     */
    public static function get(): array
    {
        global $cfg;

        $defaultPage = './' . Util::getScriptNameForOption(
            $cfg['DefaultTabTable'],
            'table'
        );

        return [
            'mysql' => [
                'columns_priv' => [
                    'user' => [
                        'link_param' => 'username',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'hostname',
                                'column_name' => 'host',
                            ],
                        ],
                        'default_page' => './server_privileges.php',
                    ],
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'Db',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                    'column_name' => [
                        'link_param' => 'field',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'Db',
                            ],
                            1 => [
                                'param_info' => 'table',
                                'column_name' => 'Table_name',
                            ],
                        ],
                        'default_page' => './tbl_structure.php?change_column=1',
                    ],
                ],
                'db' => [
                    'user' => [
                        'link_param' => 'username',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'hostname',
                                'column_name' => 'host',
                            ],
                        ],
                        'default_page' => './server_privileges.php',
                    ],
                ],
                'event' => [
                    'name' => [
                        'link_param' => 'item_name',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'db',
                            ],
                        ],
                        'default_page' => './db_events.php?edit_item=1',
                    ],

                ],
                'innodb_index_stats' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'database_name',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                    'index_name' => [
                        'link_param' => 'index',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'database_name',
                            ],
                            1 => [
                                'param_info' => 'table',
                                'column_name' => 'table_name',
                            ],
                        ],
                        'default_page' => './tbl_structure.php',
                    ],
                ],
                'innodb_table_stats' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'database_name',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                ],
                'proc' => [
                    'name' => [
                        'link_param' => 'item_name',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'db',
                            ],
                            1 => [
                                'param_info' => 'item_type',
                                'column_name' => 'type',
                            ],
                        ],
                        'default_page' => './db_routines.php?edit_item=1',
                    ],
                    'specific_name' => [
                        'link_param' => 'item_name',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'db',
                            ],
                            1 => [
                                'param_info' => 'item_type',
                                'column_name' => 'type',
                            ],
                        ],
                        'default_page' => './db_routines.php?edit_item=1',
                    ],
                ],
                'proc_priv' => [
                    'user' => [
                        'link_param' => 'username',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'hostname',
                                'column_name' => 'Host',
                            ],
                        ],
                        'default_page' => './server_privileges.php',
                    ],
                    'routine_name' => [
                        'link_param' => 'item_name',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'Db',
                            ],
                            1 => [
                                'param_info' => 'item_type',
                                'column_name' => 'Routine_type',
                            ],
                        ],
                        'default_page' => './db_routines.php?edit_item=1',
                    ],
                ],
                'proxies_priv' => [
                    'user' => [
                        'link_param' => 'username',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'hostname',
                                'column_name' => 'Host',
                            ],
                        ],
                        'default_page' => './server_privileges.php',
                    ],
                ],
                'tables_priv' => [
                    'user' => [
                        'link_param' => 'username',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'hostname',
                                'column_name' => 'Host',
                            ],
                        ],
                        'default_page' => './server_privileges.php',
                    ],
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'Db',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                ],
                'user' => [
                    'user' => [
                        'link_param' => 'username',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'hostname',
                                'column_name' => 'host',
                            ],
                        ],
                        'default_page' => './server_privileges.php',
                    ],
                ],
            ],
            'information_schema' => [
                'columns' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                    'column_name' => [
                        'link_param' => 'field',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                            1 => [
                                'param_info' => 'table',
                                'column_name' => 'table_name',
                            ],
                        ],
                        'default_page' => './tbl_structure.php?change_column=1',
                    ],
                ],
                'key_column_usage' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'constraint_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                    'column_name' => [
                        'link_param' => 'field',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                            1 => [
                                'param_info' => 'table',
                                'column_name' => 'table_name',
                            ],
                        ],
                        'default_page' => './tbl_structure.php?change_column=1',
                    ],
                    'referenced_table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'referenced_table_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                    'referenced_column_name' => [
                        'link_param' => 'field',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'referenced_table_schema',
                            ],
                            1 => [
                                'param_info' => 'table',
                                'column_name' => 'referenced_table_name',
                            ],
                        ],
                        'default_page' => './tbl_structure.php?change_column=1',
                    ],
                ],
                'partitions' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                ],
                'processlist' => [
                    'user' => [
                        'link_param' => 'username',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'hostname',
                                'column_name' => 'host',
                            ],
                        ],
                        'default_page' => './server_privileges.php',
                    ],
                ],
                'referential_constraints' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'constraint_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                    'referenced_table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'constraint_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                ],
                'routines' => [
                    'routine_name' => [
                        'link_param' => 'item_name',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'routine_schema',
                            ],
                            1 => [
                                'param_info' => 'item_type',
                                'column_name' => 'routine_type',
                            ],
                        ],
                        'default_page' => './db_routines.php',
                    ],
                ],
                'schemata' => [
                    'schema_name' => [
                        'link_param' => 'db',
                        'default_page' => $defaultPage,
                    ],
                ],
                'statistics' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                    'column_name' => [
                        'link_param' => 'field',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                            1 => [
                                'param_info' => 'table',
                                'column_name' => 'table_name',
                            ],
                        ],
                        'default_page' => './tbl_structure.php?change_column=1',
                    ],
                ],
                'tables' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                ],
                'table_constraints' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                ],
                'views' => [
                    'table_name' => [
                        'link_param' => 'table',
                        'link_dependancy_params' => [
                            0 => [
                                'param_info' => 'db',
                                'column_name' => 'table_schema',
                            ],
                        ],
                        'default_page' => $defaultPage,
                    ],
                ],
            ],
        ];
    }
}
