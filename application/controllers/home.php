<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 为了使用身份验证，改为继承自定义的安全检测控制类MY_Controller
*/
class Home extends CI_Controller {
    public function __construct()
    {
        //构造函数
        parent::__construct();
        //parent::__construct();//必须先继承父构造函数，这样能继承基类
        $this->load->model('database_model','database');

    }
    public function index(){
        $data=$this->database->get_menu_data();
        $data['title']='哈尔滨醇正醇酒曲厂';
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view('index/index_con.html');
        $this->load->view('copyright.html');
        $this->load->view('footer.html');

    }
    public function about(){
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('关于我们');
        $data['TypeName']='关于我们';
        $data['TypeEName']='About Us';
        $this->load($data);

    }
    public function products(){
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('产品中心');
        $data['TypeName']='产品中心';
        $data['TypeEName']='Products Center';
        $this->load($data);

    }
    public function selectedcases(){
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('精选案例');
        $data['TypeName']='精选案例';
        $data['TypeEName']='Selected Cases';
        $this->load($data);

    }
    public function newscenter(){
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('新闻中心');
        $data['TypeName']='新闻中心';
        $data['TypeEName']='News Center';
        $this->load($data);
    }
    public function technology(){
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('研发技术');
        $data['TypeName']='研发技术';
        $data['TypeEName']='Technology';
        $this->load($data);
    }
    public function contact(){
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('联系我们');
        $data['TypeName']='联系我们';
        $data['TypeEName']='Contact Us';
        $this->load($data);

    }
    public function load($data){
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view('index/show.html');
        $this->load->view('copyright.html');
        $this->load->view('footer.html');
    }

}
?>