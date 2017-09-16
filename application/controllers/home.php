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
        $data['sysinfo']=$this->database->getsysinfo();
        $data['news']=$this->database->getnewslist_top(4);
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view('index/index_con.html');
        $this->load->view('copyright.html');
        $this->load->view('footer.html');

    }
    public function about(){
        $rowid=$this->uri->segment(3);
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('关于我们');
        $data['TypeName']='关于我们';
        $data['TypeEName']='About Us';
        $data['sysinfo']=$this->database->getsysinfo();
        if(strlen($rowid)==32){
            $data['ContentInfo']=$this->database->getContentInfo('childmenu',$rowid);
        }
        $this->load($data);

    }
    public function products(){
        $rowid=$this->uri->segment(3);
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('产品中心');
        $data['TypeName']='产品中心';
        $data['TypeEName']='Products Center';
        $data['sysinfo']=$this->database->getsysinfo();
        if(strlen($rowid)==32){
            $data['ContentInfo']=$this->database->getContentInfo('childmenu',$rowid);
        }
        $this->load($data);

    }
    public function selectedcases(){
        $rowid=$this->uri->segment(3);
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('精选案例');
        $data['TypeName']='精选案例';
        $data['TypeEName']='Selected Cases';
        $data['sysinfo']=$this->database->getsysinfo();

        if(strlen($rowid)==32){
            $data['ContentInfo']=$this->database->getContentInfo('childmenu',$rowid);
        }
        $this->load($data);

    }
    public function newscenter(){
        $rowid=$this->uri->segment(3);
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('新闻中心');
        $data['TypeName']='新闻中心';
        $data['TypeEName']='News Center';
        $data['sysinfo']=$this->database->getsysinfo();

        if(strlen($rowid)==32){
            $data['ContentInfo']=$this->database->getContentInfo('childmenu',$rowid);
        }
        $this->load($data);
    }
    public function technology(){
        $rowid=$this->uri->segment(3);
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('研发技术');
        $data['TypeName']='研发技术';
        $data['TypeEName']='Technology';
        $data['sysinfo']=$this->database->getsysinfo();

        if(strlen($rowid)==32){
            $data['ContentInfo']=$this->database->getContentInfo('childmenu',$rowid);
        }
        $this->load($data);
    }
    public function contact(){
        $rowid=$this->uri->segment(3);
        $data=$this->database->get_menu_data();
        $data['projects']=$this->database->get_menu('联系我们');
        $data['TypeName']='联系我们';
        $data['TypeEName']='Contact Us';
        $data['sysinfo']=$this->database->getsysinfo();

        if(strlen($rowid)==32){
            $data['ContentInfo']=$this->database->getContentInfo('childmenu',$rowid);
        }
        $this->load($data);

    }
    public function display(){
        $tablename=$this->uri->segment(3);
        $rowid=$this->uri->segment(4);
        $data=$this->database->get_menu_data();
        $data['sysinfo']=$this->database->getsysinfo();
        if(strlen($rowid)!=32){
            error('参数错误');
        }
        $data['displayInfo']=$this->database->getDisplayInfo($tablename,$rowid);
        p($data['displayInfo']);
        $data['displayInfo']=$data['displayInfo'][0]['profile'];
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view('index/display.html');
        $this->load->view('copyright.html');
        $this->load->view('footer.html');


    }
    public function displayinfo(){
        $rowid=$this->uri->segment(3);
        $data=$this->database->get_menu_data();
        $data['sysinfo']=$this->database->getsysinfo();
        if(strlen($rowid)!=32){
            error('参数错误');
        }
        $data['displayInfo']=$this->database->getDisplayInfo('content',$rowid);
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view('index/displayinfo.html');
        $this->load->view('copyright.html');
        $this->load->view('footer.html');


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