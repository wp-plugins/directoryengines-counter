<?php
/**
 * Project : de-counter_tmp
 * User: thuytien
 * Date: 01/12/2015
 * Time: 11:01 PM
 */

abstract class DE_Base_Counter {
    abstract function increate($postid = -1);
    abstract function setCount($count = 0, $postid = -1);
    abstract function delete($post_id = -1);
    abstract function getCount($postid = -1);
}