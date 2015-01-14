<?php
/**
 * Project : de-counter_tmp
 * User: thuytien
 * Date: 01/12/2015
 * Time: 11:01 PM
 */

require_once dirname(__FILE__)."/DE_Base_Counter.php";

class DE_View_Counter extends DE_Base_Counter {

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function increate($post_id = NULL, $count = 1)
    {
        global $wpdb;
        $increased_count = $this->getCount($post_id);
        $increased_count += $count;
        if($increased_count == 1){
            $wpdb->insert(
                $wpdb->prefix.DE_COUNTER_TABLE,
                array(
                    'post_id' =>$post_id,
                    'view_count' =>$increased_count
                ),
                array(
                    '%d'
                )
            );
        }
        else{
            $wpdb->update(
                $wpdb->prefix.DE_COUNTER_TABLE,
                array(
                    'view_count' =>$increased_count
                ),
                array( 'post_id' => $post_id ),
                array(
                    '%d'
                ),
                array( '%d' )
            );
        }
        return apply_filters('de_counter_increaseed_view', $increased_count);
    }

    function setCount($count = 0, $postid = -1)
    {

    }

    function delete($post_id = -1)
    {
        global $wpdb;
        $wpdb->delete( $wpdb->prefix . DE_COUNTER_TABLE, array( 'post_id' =>  $post_id), array( '%d' ) );
    }

    function getCount($postid = -1)
    {
        global $wpdb;
        $query = $wpdb->prepare("
                        SELECT view_count
                        FROM " . $wpdb->prefix . DE_COUNTER_TABLE . "
                        WHERE post_id = %d
                    ",
            $postid
        );
        $viewCount = $wpdb->get_var($query);
        if (!$viewCount) {
            $viewCount = 0;
        }
        return apply_filters("de_view_count", $viewCount, $postid);
    }
}