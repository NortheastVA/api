<?php
namespace App\Helpers;
/**
 * Class RoleHelper
 */
class RoleHelper {
    /**
     * Return the name of the role for a given action.
     *
     * @param $action
     * @return null|string
     */
    public static function roleForAction($action) {
        switch($action) {
            case 'airport':
            case 'route':
                return 'OPS';
                break;
            default:
                return null;
        }
    }
}
