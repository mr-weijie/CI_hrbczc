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
        $data['products']=$this->database->getrecords('products',array());
        $data['cases']=$this->database->getrecords('cases',array());
        $data['delivers']=$this->database->getlastdelivers();
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
    public function productscenter(){
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
        $data['displayInfo']=$data['displayInfo'][0]['profile'];
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view('index/display.html');
        $this->load->view('copyright.html');
        $this->load->view('footer.html');


    }
    public function displayinfo(){
        $tablename=$this->uri->segment(3);
        $rowid=$this->uri->segment(4);
        $data=$this->database->get_menu_data();
        $data['sysinfo']=$this->database->getsysinfo();
        if(strlen($rowid)!=32){
            error('参数错误');
        }
        $data['displayInfo']=$this->database->getDisplayInfo($tablename,$rowid);
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
    public function news(){
        $parms['base_url']='home/news/';
        $parms['tablename']='news';
        $parms['html']='index/infolist.html';
        $newstype=$this->uri->segment(3);
        if($newstype=='company'||$newstype=='industry')  $parms['newstype']=$this->uri->segment(3);
        $this->listinfo($parms);
    }
    public function companynews(){
        $parms['base_url']='home/companynews/';
        $parms['tablename']='news';
        $parms['html']='index/newscenterlist.html';
        $parms['newstype']='company';
        $this->listinfo($parms);
    }
    public function industrynews(){
        $parms['base_url']='home/industrynews/';
        $parms['tablename']='news';
        $parms['html']='index/newscenterlist.html';
        $parms['newstype']='industry';
        $this->listinfo($parms);
    }
    public function leavingmsg(){
        $this->load->helper('form');//加载显示表单错误类
        $data=$this->database->get_menu_data();
        $data['sysinfo']=$this->database->getsysinfo();
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view('index/leavingmsg.html');
        $this->load->view('copyright.html');
        $this->load->view('footer.html');

    }
    public function insertleavingmsg(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('clientName',"留言人尊名",'required');
        $this->form_validation->set_rules('phoneNo',"电话号码",'required');
        $this->form_validation->set_rules('email',"电子邮箱",'valid_email');
        $this->form_validation->set_rules('content',"留言内容",'required|max_length[200]');
        $this->form_validation->set_rules('captcha',"验证码",'required');
        $status=$this->form_validation->run();
        if($status){
            $captcha=strtoupper($this->input->post('captcha'));

            if(!isset($_SESSION)){
                session_start();//开启session,只有开启session后，所有session操作才能有效
            }
            if($captcha!=$_SESSION ['code']){
                error('验证码错误！');
            }

            $clientName=$this->input->post('clientName');
            $phoneNo=$this->input->post('phoneNo');
            $email=$this->input->post('email');
            $qq=$this->input->post('qq');
            $content=$this->input->post('content');
            $data=array(
                'rowid'=>strtoupper(md5($clientName.date("Y-m-d H:i:s"))),//采用系统时间+IdentityID的方法
                'clientName'=>$clientName,
                'phoneNo'=>$phoneNo,
                'email'=>$email,
                'qq'=>$qq,
                'content'=>$content,
                'modDate'=>time()
            );
            $status=$this->database->insert_record('leavingmsg',$data);
            if($status){
                $msg='新增记录成功！';
                success('home/leavingmsg', $msg);
            }else{
                error('对不起，留言失败!');
            }
        }else{
            $data=$this->database->get_menu_data();
            $data['sysinfo']=$this->database->getsysinfo();
            $this->load->helper('form');//加载显示表单错误类
            $this->load->view('header.html',$data);
            $this->load->view('index/nav.html');
            $this->load->view('index/ad.html');
            $this->load->view('index/leavingmsg.html');
            $this->load->view('copyright.html');
            $this->load->view('footer.html');

        }



    }


    public function cases(){
        $parms['base_url']='home/cases/';
        $parms['tablename']='cases';
        $parms['html']='index/infolist.html';
        $this->listinfo($parms);
    }
    public function products(){
        $parms['base_url']='home/products/';
        $parms['tablename']='products';
        $parms['html']='index/infolist.html';
        $this->listinfo($parms);
    }
    public function delivers(){
        $parms['base_url']='home/delivers/';
        $parms['tablename']='delivers';
        $parms['html']='index/deliverslist.html';
        $this->listinfo($parms);

    }



    public function listinfo($parms){
        $this->load->library('form_validation');
        $data=$this->database->get_menu_data();
        $this->load->library('pagination');
        $pageNo=$this->uri->segment(3);
        $pageNo=isset($pageNo)?$pageNo:1;
        $perpage=20;
        $config['base_url']=site_url($parms['base_url']);
//        $config['total_rows'] = $this->db->count_all_results($parms['tablename']);
        $where=array();
        if(isset($parms['newstype'])) $where['newstype']=$parms['newstype'];

        $config['total_rows'] = $this->db->like($where,'both')->count_all_results($parms['tablename']);
        $config['uri_segment']=3;
        $config['per_page']=$perpage;

        $config['first_link'] = '第一页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '最后一页';

        $this->pagination->initialize($config);//初始化
        $links = $this->pagination->create_links();
        $offset=$this->uri->segment( $config['uri_segment']);
        // p($offset);
        $this->db->limit($perpage, $offset);
        $data['info']=$this->database->getrecords($parms['tablename'],$where);
        $data['links']=$links;
        $data['total_rows']= $config['total_rows'];
        $data['cur_page']=$offset;
        $pstart=$offset+1;
        $pstop=$offset+$perpage;
        $pstop=$pstop>$config['total_rows'] ?$config['total_rows']:$pstop;
        $data['offset']=$pstart.'-'.$pstop;
        $data['tablename']=$parms['tablename'];
        $html=$parms['html'];

        $data['sysinfo']=$this->database->getsysinfo();
        if($parms['tablename']=='news'){
            $data['TypeName']='新闻中心';
            $data['TypeEName']='News Center';
            $data['projects']=$this->database->get_menu('新闻中心');
            $data['newstype']=$parms['newstype'];

        }
        $this->load->view('header.html',$data);
        $this->load->view('index/nav.html');
        $this->load->view('index/ad.html');
        $this->load->view($html);
        $this->load->view('copyright.html');
        $this->load->view('footer.html');
    }

    public function captcha(){
        $config=array(
            'width'=>80,
            'height'=>30,
            'codeLen'=>4,
            'fontSize'=>18,
            'bgColor' =>'',
            'fontColor'=> ''
        );
        $this->load->library('code',$config);//加载自定义的验证码库
        $this->code->show();
        //  var_dump($_SESSION);
    }
}
?>