<?php

namespace Kanboard\Model;

use Kanboard\Core\Base;

/**
 * User Notification Type
 *
 * @package  model
 * @author   Frederic Guillot
 */
class UserNotificationType extends NotificationType
{
    /**
     * SQL table name
     *
     * @var string
     */
    const TABLE = 'user_has_notification_types';

    /**
     * Get selected notification types for a given user
     *
     * @access public
     * @param integer  $user_id
     * @return array
     */
    public function getSelectedTypes($user_id)
    {
        $types = $this->db->table(self::TABLE)->eq('user_id', $user_id)->asc('notification_type')->findAllByColumn('notification_type');
        return $this->filterTypes($types);
    }

    /**
     * Save notification types for a given user
     *
     * @access public
     * @param  integer  $user_id
     * @param  string[] $types
     * @return boolean
     */
    public function saveSelectedTypes($user_id, array $types)
    {
        $results = array();
        $this->db->table(self::TABLE)->eq('user_id', $user_id)->remove();

        foreach ($types as $type) {
            $results[] = $this->db->table(self::TABLE)->insert(array('user_id' => $user_id, 'notification_type' => $type));
        }

        return ! in_array(false, $results, true);
    }
}
