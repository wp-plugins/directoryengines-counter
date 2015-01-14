<?php

/**
 * Project : de-counter_tmp
 * User: thuytien
 * Date: 01/12/2015
 * Time: 8:33 PM
 */
require_once dirname(__FILE__)."/DE_Base_Counter.php";
require_once dirname(__FILE__)."/DE_View_Counter.php";

class De_Counter
{

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function register()
    {
        add_action('de_show_view_count', array(self::getInstance(), 'show_view_count'), 8);
        add_action('de_loop_after_rate', array(self::getInstance(), 'show_view_count'));
        add_action('de_single_after_rate', array(self::getInstance(), 'increase_view_count'),8);
        add_action('increase_view_count', array(self::getInstance(), 'increase_view_count'),8);
        add_action('de_increase_view_count', array(self::getInstance(), 'increase_then_show'),8);
        add_action('delete_post', array(self::getInstance(), 'delete_view_row'));
        add_action('wp_insert_post', array(self::getInstance(), 'insert_post'));
    }

    public function insert_post($post_id = null){
        $viewed_count = $this->increase_view_count($post_id, rand(20,100));
    }

    public function increase_then_show($post_id = null, $count = 1){
        $viewed_count = $this->increase_view_count($post_id, $count);
        echo sprintf('%1$d', $viewed_count);
    }

    public function increase_view_count($post_id = null, $count = 1)
    {
        global $wpdb, $post;
        if (!isset($post_id) || ($post_id == '')) {
            if (isset($post->ID)) {
                $post_id = $post->ID;
            } else {
                return;
            }
        }
        $viewed_count = DE_View_Counter::getInstance()->increate($post_id, $count);
        return $viewed_count;
    }

    public function delete_view_row($post_id = null)
    {
        $viewCount = $this->getCount($post_id);
        if($viewCount != 0) {
            DE_View_Counter::getInstance()->delete($post_id);
        }
    }

    /**
     * @param int $post_id
     */
    public function show_view_count($post_id = null)
    {
        $viewCount = $this->getCount($post_id);
        ?>
        <div class="col-md-6 card_bottom_right">
            <i class="fa fa-eye"></i>&nbsp;<?php echo $viewCount; ?>
        </div>
        <?php

    }

    public function getCount($post_id = null)
    {
        global $wpdb, $post;
        if (!isset($post_id) || ($post_id == '')) {
            if (isset($post->ID)) {
                $post_id = $post->ID;
            } else {
                return;
            }
        }
        return DE_View_Counter::getInstance()->getCount($post_id);
    }
}