<?php
/**
 * @package		Extension for OpenCart: MultiReplacer.
 * @author		Roman Sha
 * @copyright	2022 © All Rights Reserved
 * @license		Commercial
 * @link		https://opencartforum.com/files/developer/678008-sha/?utm_medium=profilecpage
 */
class ModelExtensionModuleMultiReplacer extends Model {
    public function replace($data) {
        // Search and replace
        if (
            !isset($data['search'])
            || !isset($data['replace'])
            || !count($data['tasks'])
            || !isset($this->session->data['multi_edit_products'])
        )
            return false;

        $implode = array();

        foreach (explode(',', $this->session->data['multi_edit_products']) as $product_id) {
            $implode[] = "'" . (int)$product_id . "'"; // (int) sanitize
        }

        $search = $this->db->escape($data['search']); // sanitize

        $replace = $this->db->escape($data['replace']); // sanitize

        foreach ($data['tasks'] as $task) {
            $field = $this->db->escape($task['value']); // sanitize
            $language_id = $this->db->escape($task['language_id']); // sanitize

            $sql = "UPDATE " . DB_PREFIX . "product_description 
                            SET " . (string)$field . " = REPLACE(
                            " . (string)$field . ", 
                            '" . (string)$search . "', 
                            '" . (string)$replace . "' 
                            ) WHERE product_id IN ( 
                            " . implode(",", $implode) . "
                            ) AND language_id = 
                            '" . (int)$language_id . "'";

            $query = $this->db->query($sql);
        }

        return $query;
    }
}