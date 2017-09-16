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
    public function getsysinfo(){
        $data=$this->db->get('sysinfo')->result_array();
        return $data;
    }

    public function getContentInfo($table,$rowid){
        $data=$this->db->select('rowid,Title,Content')->where(array('rowid'=>$rowid))->get($table)->result_array();
        return $data;
    }
    public function update_sysinfo($data,$rowid){
        $status=$this->db->update('sysinfo',$data,array('rowid'=>$rowid));
        return $status;
    }
    public function updateprofilepic($rowid,$photofile){
        $data=array(
            'profile_pic'=>$photofile
        );
        $status=$this->db->update('sysinfo',$data,array('rowid'=>$rowid));
        return $status;

    }
    public function getDisplayInfo($tablename,$rowid){
        $data=$this->db->where(array('rowid'=>$rowid))->get($tablename)->result_array();
       // p($data);
        return $data;
    }
    public function getnewslist(){
        $data=$this->db->select('rowid,title,addDate,modDate,author,source,clicks')->where(array('rectype'=>'news'))-> get('content')->result_array();
        return $data;
    }
    public function getnewslist_top($num){
        $data=$this->db->select('rowid,title,modDate')->limit($num)->where(array('rectype'=>'news'))-> get('content')->result_array();
        return $data;
    }
    public function getnews($rowid){
        $data=$this->db->where(array('rowid'=>$rowid))->get('content')->result_array();
        return $data;
    }
    public function update_content($rowid,$data){
        $status=$this->db->update('content',$data,array('rowid'=>$rowid));
        return $status;

    }
    public function deletenews($rowid){
        $status=$this->db->delete('content',array('rowid'=>$rowid));
        return $status;
    }
    public function insertnews($data){
        $status=$this->db->insert('content',$data);
        return $data;
    }



}