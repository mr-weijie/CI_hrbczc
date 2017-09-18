<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 9:18
 */
class Admin extends MY_Controller{
    public function __construct()
    {
        //构造函数
        parent::__construct();
        //parent::__construct();//必须先继承父构造函数，这样能继承基类
        $this->load->model('database_model','database');
    }


    public function index(){//============
        $this->load->view('admin/index.html');
    }
    public function adm(){//============
        $this->load->view('admin/index.html');

    }
    public function welcome(){
        $this->load->view('admin/welcome.html');
    }

    public function flash(){//==============
        $data['title']='Flash动画设置';
        $this->load->view('admin/header.html',$data);
        $this->load->view('admin/flash.html');
        $this->load->view('admin/footer.html');
    }

    public function sysinfo(){//==============
        $data['sysinfo']=$this->database->getsysinfo();
        $data['title']='Flash动画设置';
        $this->load->view('admin/header.html',$data);
        $this->load->view('admin/sysinfo.html');
        $this->load->view('admin/footer.html');

    }
    public function update_sysinfo(){//===========
        $ID=$this->input->post('ID');
        $data=array(
            'address'      =>$this->input->post('address'),
            'url'          =>$this->input->post('url'),
            'corporation' =>$this->input->post('corporation'),
            'phone'        =>$this->input->post('phone'),
            'servphone'   =>$this->input->post('servphone'),
            'postcode'     =>$this->input->post('postcode'),
        );
        $status=$this->database->update_sysinfo($data,$ID);
        if($status)
        {
            success('admin/sysinfo','系统参数设置成功！');
        }else{
            error('系统参数设置失败！');
        }
    }
    public function upload(){//==============
        $pid=$this->uri->segment(3);
        if(!isset($pid)){
            error('请正确上传图片');
            die();
        }
        $config['upload_path']='./assets/advs/';
        $config['allowed_types']='gif|jpg|png|jpeg';
        $config['overwrite']=true;//遇到同名的覆盖
        // $config['file_name']=time().mt_rand(1000,9999);
        $config['file_name']='flash'.$pid;//用clientID做为图片文件名
//载入上传类
        $this->load->library('upload',$config);
        $status=$this->upload->do_upload('upfile');//此处的参数必须与表单中的文件字段名字相同
        if($status){
            redirect(site_url('admin/flash'));
        }else{
            error('请正确选择图片后再上传！');
        }
    }

    public function profile(){
        $data['profile']=$this->database->getsysinfo();
        $this->load->view('admin/editprofile.html',$data);
        $this->load->view('admin/footer.html');

    }

    public function update_profile(){//===========
        $rowid=$this->input->post('rowid');
        $data=array(
            'profile'      =>$_POST['profile']
        );
        $status=$this->database->update_sysinfo($data,$rowid);
        if($status)
        {
            success('admin/profile','公司简介设置成功！');
        }else{
            error('公司简介设置失败！');
        }
    }
    public function listinfo($parms){
        $this->load->library('pagination');
        $pageNo=$this->uri->segment(3);
        $pageNo=isset($pageNo)?$pageNo:1;
        $perpage=20;
        $config['base_url']=site_url($parms['base_url']);
        $config['total_rows'] = $this->db->count_all_results($parms['tablename']);
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
        $data['info']=$this->database->getrecords($parms['tablename']);
        $data['links']=$links;
        $data['total_rows']= $config['total_rows'];
        $data['cur_page']=$offset;
        $pstart=$offset+1;
        $pstop=$offset+$perpage;
        $pstop=$pstop>$config['total_rows'] ?$config['total_rows']:$pstop;
        $data['offset']=$pstart.'-'.$pstop;
        $data['class']=$parms['class'];
        $data['tablename']=$parms['tablename'];

        $this->load->view('admin/header.html',$data);
        $this->load->view('admin/infolist.html');
        $this->load->view('admin/footer.html');

    }
    public function news(){
        $parms['base_url']='admin/news/';
        $parms['tablename']='news';
        $parms['class']='news';
        $parms['tablename']='news';
        $parms['url']='news';
        $this->listinfo($parms);
    }

    public function addnews(){
        $this->load->library('form_validation');
        $data['title0']='新闻标题';
        $data['title1']='新闻内容';
        $data['url']='admin/news';
        $data['tablename']='news';
        $this->load->view('admin/addrecord.html',$data);
        $this->load->view('admin/footer.html');
    }




    public function products(){
        $parms['base_url']='admin/products/';
        $parms['tablename']='products';
        $parms['class']='product';
        $parms['tablename']='products';
        $this->listinfo($parms);
    }

    public function addproduct(){
        $this->load->library('form_validation');
        $data['title0']='产品标题';
        $data['title1']='产品内容';
        $data['url']='admin/products';
        $data['tablename']='products';
        $this->load->view('admin/addrecord.html',$data);
        $this->load->view('admin/footer.html');
    }



    public function cases(){
        $parms['base_url']='admin/cases/';
        $parms['tablename']='cases';
        $parms['class']='case';
        $parms['tablename']='cases';
        $parms['url']='cases';
        $this->listinfo($parms);
    }

    public function addcase(){
        $this->load->library('form_validation');
        $data['title0']='案例标题';
        $data['title1']='案例内容';
        $data['url']='admin/cases';
        $data['tablename']='cases';
        $this->load->view('admin/addrecord.html',$data);
        $this->load->view('admin/footer.html');
    }



    public function editrecord(){
        $this->load->library('form_validation');
        $tablename=$this->uri->segment(3);
        $rowid=$this->uri->segment(4);
        $data['record']=$this->database->getrecord($tablename,$rowid);
        $data['tablename']=$tablename;
        switch ($tablename){
            case 'news':
                $data['title0']='新闻标题';
                $data['title1']='新闻内容';
                break;
            case 'products':
                $data['title0']='产品名称';
                $data['title1']='产品简介';
                break;
            case 'cases':
                $data['title0']='案例标题';
                $data['title1']='案例内容';
                break;
            default:
                $data['title0']='标题';
                $data['title1']='内容';
        }
        $this->load->view('admin/editrecord.html',$data);
        $this->load->view('admin/footer.html');

    }
    public function insertrecord(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title',"标题",'required');
        $this->form_validation->set_rules('content',"内容",'required');
        $status=$this->form_validation->run();
        if($status){
            $title=$this->input->post('title');
            $content=$_POST['content'];
            $tablename=$this->input->post('tablename');
            $url=$this->input->post('url');
            $data=array(
                'rowid'=>strtoupper(md5($title.date("Y-m-d H:i:s"))),//采用系统时间+IdentityID的方法
                'title'=>$title,
                'content'=>$content,
                'author'=>$this->session->userdata('author'),
                'addDate'	=> time(),
                'modDate'	=> time()
            );
            $status=$this->database->insert_record($tablename,$data);
            if($status){
                $msg='新增记录成功！';
                success($url, $msg);
            }

        }else
        {
            $this->load->helper('form');//加载显示表单错误类
            $this->load->view('admin/addrecord.html');
            $this->load->view('admin/footer.html');
        }
    }
    public function deleterecord(){
        $tablename=$this->uri->segment(3);
        $rowid=$this->uri->segment(4);
        $status=$this->database->deleterecord($tablename,$rowid);
        $url='admin/'.$tablename;
        if($status)
        {
            success($url,'记录删除成功！');
        }else{
            error('记录删除失败！');
        }
    }

    public function updaterecord(){
        $rowid=$this->input->post('rowid');
        $tablename=$this->input->post('tablename');
        $url=$tablename;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title',"标题",'required');
        $this->form_validation->set_rules('content',"内容",'required');
        $status=$this->form_validation->run();
        if($status){
            $data=array(
                'title'=>$this->input->post('title'),
                'profile'=>$this->input->post('profile'),
                'content'=>$_POST['content'],//此处不能采用CI自带的输入模块，否则有些style属性被自动替换成xss=removed
                'modDate'=>time()
            );
            $status=$this->database->updaterecord($tablename,$rowid,$data);
            if($status)
            {
                success('admin/'.$url,'记录更新成功！');
            }else{
                error('记录更新失败！');
            }
        }else{
            $this->load->view('admin/editrecord.html');
            $this->load->view('admin/footer.html');
        }


    }
    public function uploadpic(){
        $rowid=$this->input->post("rowid");
        $url=$this->input->post("url");
        $tablename=$this->input->post("tablename");
        $config['upload_path']='./assets/images/';
        $config['allowed_types']='gif|jpg|png|jpeg';
        $config['overwrite']=true;//遇到同名的覆盖
        // $config['file_name']=time().mt_rand(1000,9999);
        $config['file_name']=$tablename.'_'.$rowid;//图片文件名
//载入上传类
        $this->load->library('upload',$config);
        $status=$this->upload->do_upload('upfile');//此处的参数必须与表单中的文件字段名字相同
        if($status){
            $photofile=$this->upload->data('file_name');//返回已保存的文件名
            $data=array(
                'pics'=>$photofile
            );
            $status=$this->database->update_record_pic($tablename,$rowid,$data);
            if($status)
            {
                redirect(site_url($url));
            }else{
                error("对不起！图片上传失败！");
            }
        }else
        {
            error('请正确选择图片后再上传！');
        }
    }














    public function modifypwd(){
        $this->load->library('form_validation');//加载表单验证类库
        $this->load->view('admin/modifypwd.html');
    }
    public function update_passwd(){
        $this->load->library('form_validation');//加载表单验证类库
        $this->form_validation->set_rules('passwd','原始密码','required');//设置验证规则
        $this->form_validation->set_rules('passwdF','新密码','required');//设置验证规则
        $this->form_validation->set_rules('passwdS','确认密码','required');//设置验证规则
        $status = $this->form_validation->run();//执行验证

        if($status){
            $passwdF = $this->input->post('passwdF');
            $passwdS = $this->input->post('passwdS');
            if($passwdF != $passwdS) error('两次密码不相同');

            $usrid=$this->session->userdata('usrid');
            $pwd0=$this->input->post('passwd');
            $data=$this->database->chkuser($usrid,$pwd0);
            p($data);
            if(empty($data)){
                error('原密码错误，密码修改操作失败');
            }else{
                $pwd=$this->input->post('passwdF');
                $pwd=md5($pwd);
                $data=array(
                    'pwd'=>$pwd
                );
                $status=$this->database->update_pwd($usrid,$data);
                if($status)
                {
                    $url='admin';
                    success($url,'密码修改成功！');
                }else{
                    error('密码修改失败！');
                }

            }
        }else{
            $this->load->view('admin/modifypwd.html');

        }

    }


}