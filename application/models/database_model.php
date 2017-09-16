<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/28
 * Time: 13:41
 */
class Database_model extends CI_Model{
    public function get_menu($type){
        $data=$this->db->select('rowid,Title,Type,Class,Content')->where(array( 'MenuName'=>$type))->order_by('OrderNo','asc')->get('ChildMenu')->result_array();
        return $data;
    }
    public function get_menu_data(){
        $data['about']=$this->get_menu('关于我们');
        $data['products']=$this->get_menu('产品中心');
        $data['selectedcases']=$this->get_menu('精选案例');
        $data['newscenter']=$this->get_menu('新闻中心');
        $data['technology']=$this->get_menu('研发技术');
        $data['contact']=$this->get_menu('联系我们');
        return $data;

    }

}