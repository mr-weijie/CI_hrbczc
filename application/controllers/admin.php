<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
    public function about(){
        $data['menuName']='关于我们';
        $data['base_url']='admin/about/';
        $data['tablename']='childmenu';
        $data['class']='about';
        $this->editmenu($data);
    }
    public function productscenter(){
        $data['menuName']='产品中心';
        $data['base_url']='admin/productscenter/';
        $data['tablename']='childmenu';
        $data['class']='productscenter';
        $this->editmenu($data);
    }
    public function selectedcases(){
        $data['menuName']='精选案例';
        $data['base_url']='admin/selectedcases/';
        $data['tablename']='childmenu';
        $data['class']='selectedcases';
        $this->editmenu($data);
    }
    public function technologies(){
        $data['menuName']='研发技术';
        $data['base_url']='admin/technologies/';
        $data['tablename']='childmenu';
        $data['class']='technologies';
        $this->editmenu($data);
    }
    public function contact(){
        $data['menuName']='联系我们';
        $data['base_url']='admin/contact/';
        $data['tablename']='childmenu';
        $data['class']='contact';
        $this->editmenu($data);
    }
    public function addabout(){
        $data['url']='admin/about';
        $data['menuName']='关于我们';
        $data['class']='about';
        $this->addmenu($data);
    }
    public function addproductscenter(){
        $data['url']='admin/productscenter';
        $data['menuName']='产品中心';
        $data['class']='productscenter';
        $this->addmenu($data);
    }
    public function addselectedcases(){
        $data['url']='admin/selectedcases';
        $data['menuName']='精选案例';
        $data['class']='selectedcases';
        $this->addmenu($data);
    }
    public function addtechnologies(){
        $data['url']='admin/technologies';
        $data['menuName']='研发技术';
        $data['class']='technologies';
        $this->addmenu($data);
    }
    public function addcontact(){
        $data['url']='admin/contact';
        $data['menuName']='联系我们';
        $data['class']='contact';
        $this->addmenu($data);
    }

    public function addmenu($data){
        $this->load->library('form_validation');
        $parms['title0']='项目标题';
        $parms['title1']='项目内容';
        $parms['tablename']='childmenu';
        $parms['url']=$data['url'];
        $parms['menuName']=$data['menuName'];
        $parms['class']=$data['class'];
        $this->load->view('admin/addrecord.html',$parms);
        $this->load->view('admin/footer.html');

    }

    public function editmenu($data){
        $parms['base_url']=$data['base_url'];
        $parms['tablename']=$data['tablename'];
        $parms['class']=$data['class'];
        $parms['html']='admin/menulist.html';
        $parms['where']=array('menuName'=>$data['menuName']);
        $this->listinfo($parms);

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
        $parms['where']=isset($parms['where'])?$parms['where']:array();
        $config['base_url']=site_url($parms['base_url']);
        $config['total_rows'] = $this->db->like($parms['where'],'both')->count_all_results($parms['tablename']);
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
        $data['info']=$this->database->getrecords($parms['tablename'],$parms['where']);
        $data['links']=$links;
        $data['total_rows']= $config['total_rows'];
        $data['cur_page']=$offset;
        $pstart=$offset+1;
        $pstop=$offset+$perpage;
        $pstop=$pstop>$config['total_rows'] ?$config['total_rows']:$pstop;
        $data['offset']=$pstart.'-'.$pstop;
        $data['class']=$parms['class'];
        $data['tablename']=$parms['tablename'];
       // p($data['info']);
        $this->load->view('admin/header.html',$data);
        $this->load->view($parms['html']);
        $this->load->view('admin/footer.html');

    }
    public function news(){
        $parms['base_url']='admin/news/';
        $parms['tablename']='news';
        $parms['class']='news';
        $parms['html']='admin/infolist.html';
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
        $parms['html']='admin/infolist.html';
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
        $parms['html']='admin/infolist.html';
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
    public function clients(){
        $this->load->library('form_validation');
        $parms['base_url']='admin/clients/';
        $parms['tablename']='clients';
        $parms['class']='client';
        $parms['html']='admin/clientlist.html';
        $clientName=$this->input->post('clientName');
        $province=$this->input->post('province');
        $city=$this->input->post('city');
        $phoneNo=$this->input->post('phoneNo');
        $parms['where']=array();
        if(!empty($clientName)) $parms['where']['clientName']=$clientName;
        if(!empty($province))  $parms['where']['province']=$province;
        if(!empty($city))  $parms['where']['city']=$city;
        if(!empty($phoneNo))  $parms['where']['phoneNo']=$phoneNo;
        $this->listinfo($parms);

    }
    public function addclient(){
        $this->load->library('form_validation');
        $data['title']='新增客户资料';
        $this->load->view('admin/addclient.html',$data);
        $this->load->view('admin/footer.html');
    }
    public function editclient(){
        $this->load->library('form_validation');
        $rowid=$this->uri->segment(3);
        $data['record']=$this->database->getrecord('clients',$rowid);
        $this->load->view('admin/editclient.html',$data);
        $this->load->view('admin/footer.html');

    }

    public function insertclient(){
        $data=$this->get_client_data();
        if($data){
            $status=$this->database->insert_record('clients',$data);
            if($status){
                $msg='新增记录成功！';
                success('admin/clients', $msg);
            }
        }else{
            $this->load->helper('form');//加载显示表单错误类
            $this->load->view('admin/addclient.html');
            $this->load->view('admin/footer.html');
        }
    }
    public function updateclient(){
        $rowid=$this->input->post('rowid');
        $data=$this->get_client_data();
        if($data){
            $status=$this->database->updaterecord('clients',$rowid,$data);
            if($status)
            {
                success('admin/clients','记录更新成功！');
            }else{
                error('记录更新失败！');
            }
        }else{
            $this->load->view('admin/editclient.html');
            $this->load->view('admin/footer.html');
        }
    }


    public function get_client_data(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('clientName',"客户姓名",'required');
        $this->form_validation->set_rules('province',"所在省份",'required');
        $this->form_validation->set_rules('city',"所在城市",'required');
        $this->form_validation->set_rules('address',"通讯地址",'required');
        $this->form_validation->set_rules('phoneNo',"联系电话",'required');
        $this->form_validation->set_rules('remark',"备注信息",'max_length[100]');
        $status=$this->form_validation->run();
        if(!$status){
            return false;
        }
            $clientName=$this->input->post('clientName');
            $sex=$this->input->post('sex');
            $province=$this->input->post('province');
            $city=$this->input->post('city');
            $address=$this->input->post('address');
            $phoneNo=$this->input->post('phoneNo');
            $qq=$this->input->post('qq');
            $remark=$this->input->post('remark');
            $data=array(
                'rowid'=>strtoupper(md5($clientName.date("Y-m-d H:i:s"))),//采用系统时间+IdentityID的方法
                'clientName'=>$clientName,
                'sex'=>$sex,
                'province'=>$province,
                'city'=>$city,
                'address'=>$address,
                'phoneNo'=>$phoneNo,
                'qq'=>$qq,
                'remark'=>$remark,
                'modDate'	=> time()
            );
            return $data;
    }

    public function goods(){
        $this->load->library('form_validation');
        $parms['base_url']='admin/goods/';
        $parms['tablename']='goods';
        $parms['class']='goods';
        $parms['html']='admin/goodslist.html';
        $this->listinfo($parms);
    }
    public function addgoods(){
        $this->load->library('form_validation');
        $data['title']='新增商品资料';
        $this->load->view('admin/addgoods.html',$data);
        $this->load->view('admin/footer.html');
    }
    public function editgoods(){
        $this->load->library('form_validation');
        $rowid=$this->uri->segment(3);
        $data['record']=$this->database->getrecord('goods',$rowid);
        $this->load->view('admin/editgoods.html',$data);
        $this->load->view('admin/footer.html');
    }
    public function updategoods(){
        $rowid=$this->input->post('rowid');
        $data=$this->get_goods_data();
        if($data){
            $status=$this->database->updaterecord('goods',$rowid,$data);
            if($status)
            {
                success('admin/goods','记录更新成功！');
            }else{
                error('记录更新失败！');
            }
        }else{
            $this->load->view('admin/editgoods.html');
            $this->load->view('admin/footer.html');
        }
    }


    public function insertgoods(){
        $data=$this->get_goods_data();
        if($data){
            $status=$this->database->insert_record('goods',$data);
            if($status){
                $msg='新增记录成功！';
                success('admin/goods', $msg);
            }
        }else{
            $this->load->helper('form');//加载显示表单错误类
            $this->load->view('admin/addgoods.html');
            $this->load->view('admin/footer.html');
        }
    }
    public function get_goods_data(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('goodsName',"商品名称",'required');
        $this->form_validation->set_rules('unit',"商品单位",'required');
        $this->form_validation->set_rules('specification',"商品规格",'required');
        $this->form_validation->set_rules('price',"商品价格",'required|numeric');
        $status=$this->form_validation->run();
        if(!$status){
            return false;
        }
        $goodsName=$this->input->post('goodsName');
        $unit=$this->input->post('unit');
        $specification=$this->input->post('specification');
        $price=$this->input->post('price');
        $remark=$this->input->post('remark');
        $data=array(
            'rowid'=>strtoupper(md5($goodsName.date("Y-m-d H:i:s"))),//采用系统时间+IdentityID的方法
            'goodsName'=>$goodsName,
            'unit'=>$unit,
            'specification'=>$specification,
            'price'=>$price,
            'remark'=>$remark,
            'modDate'	=> time()
        );
        return $data;
    }
    public function logistics(){
        $this->load->library('form_validation');
        $parms['base_url']='admin/logistics/';
        $parms['tablename']='logistics';
        $parms['class']='logistics';
        $parms['html']='admin/logisticslist.html';
        $this->listinfo($parms);
    }
    public function addlogistics(){
        $this->load->library('form_validation');
        $data['title']='新增物流资料';
        $this->load->view('admin/addlogistics.html',$data);
        $this->load->view('admin/footer.html');
    }
    public function insertlogistics(){
        $data=$this->get_logistics_data();
        if($data){
            $status=$this->database->insert_record('logistics',$data);
            if($status){
                $msg='新增记录成功！';
                success('admin/logistics', $msg);
            }
        }else{
            $this->load->helper('form');//加载显示表单错误类
            $this->load->view('admin/addlogistics.html');
            $this->load->view('admin/footer.html');
        }
    }
    public function editlogistics(){
        $this->load->library('form_validation');
        $rowid=$this->uri->segment(3);
        $data['record']=$this->database->getrecord('logistics',$rowid);
        $this->load->view('admin/editlogistics.html',$data);
        $this->load->view('admin/footer.html');
    }
    public function updatelogistics(){
        $rowid=$this->input->post('rowid');
        $data=$this->get_logistics_data();
        if($data){
            $status=$this->database->updaterecord('logistics',$rowid,$data);
            if($status)
            {
                success('admin/logistics','记录更新成功！');
            }else{
                error('记录更新失败！');
            }
        }else{
            $this->load->view('admin/editlogistics.html');
            $this->load->view('admin/footer.html');
        }
    }

    public function get_logistics_data(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('logisticsName',"物流名称",'required');
        $this->form_validation->set_rules('contact',"联系电话",'required');
        $status=$this->form_validation->run();
        if(!$status){
            return false;
        }
        $logisticsName=$this->input->post('logisticsName');
        $address=$this->input->post('address');
        $contact=$this->input->post('contact');
        $phoneNo=$this->input->post('phoneNo');
        $remark=$this->input->post('remark');
        $data=array(
            'rowid'=>strtoupper(md5($logisticsName.date("Y-m-d H:i:s"))),//采用系统时间+IdentityID的方法
            'logisticsName'=>$logisticsName,
            'address'=>$address,
            'contact'=>$contact,
            'phoneNo'=>$phoneNo,
            'remark'=>$remark,
            'modDate'	=> time()
        );
        return $data;
    }
    public function delivers(){
        $this->load->library('form_validation');
        $parms['base_url']='admin/delivers/';
        $parms['tablename']='delivers';
        $parms['class']='delivers';
        $parms['html']='admin/deliverslist.html';
        $clientName=$this->input->post('clientName');
        $province=$this->input->post('province');
        $city=$this->input->post('city');
        $phoneNo=$this->input->post('phoneNo');
        $goodsName=$this->input->post('goodsName');
        $logisticsName=$this->input->post('logisticsName');
        $deliverDate=$this->input->post('deliverDate');
        $parms['where']=array();
        if(!empty($clientName)) $parms['where']['clientName']=$clientName;
        if(!empty($province))  $parms['where']['province']=$province;
        if(!empty($city))  $parms['where']['city']=$city;
        if(!empty($phoneNo))  $parms['where']['phoneNo']=$phoneNo;
        if(!empty($goodsName))  $parms['where']['goodsName']=$goodsName;
        if(!empty($logisticsName))  $parms['where']['logisticsName']=$logisticsName;
        if(!empty($deliverDate))  $parms['where']['deliverDate']=$deliverDate;
        $this->listinfo($parms);
    }

    public function adddeliver(){
        $this->load->library('form_validation');
        $data['title']='新增发货信息';
        $data['province']=$this->database->getrecords('provinces',array());
        $data['goods']=$this->database->getrecords('goods',array());
        $data['logistics']=$this->database->getrecords('logistics',array());
        $this->load->view('admin/adddeliver.html',$data);
        $this->load->view('admin/footer.html');
    }
    public function insertdelivers(){
        $data=$this->get_delivers_data();
        if($data){
            $status=$this->database->insert_record('delivers',$data);
            if($status){
                $msg='新增记录成功！';
                success('admin/delivers', $msg);
            }
        }else{
            $this->load->helper('form');//加载显示表单错误类
            $data['province']=$this->database->getrecords('provinces',array());
            $data['goods']=$this->database->getrecords('goods',array());
            $data['logistics']=$this->database->getrecords('logistics',array());
            $this->load->view('admin/adddeliver.html',$data);
            $this->load->view('admin/footer.html');
        }
    }
    public function editdeliver(){
        $this->load->library('form_validation');
        $rowid=$this->uri->segment(3);
        $data['record']=$this->database->getrecord('delivers',$rowid);
        $data['province']=$this->database->getrecords('provinces',array());
        $data['goods']=$this->database->getrecords('goods',array());
        $data['logistics']=$this->database->getrecords('logistics',array());
        $this->load->view('admin/editdeliver.html',$data);
        $this->load->view('admin/footer.html');
    }
    public function updatedelivers(){
        $rowid=$this->input->post('rowid');
        $data=$this->get_delivers_data();
        if($data){
            $status=$this->database->updaterecord('delivers',$rowid,$data);
            if($status)
            {
                success('admin/delivers','记录更新成功！');
            }else{
                error('记录更新失败！');
            }
        }else{
            $this->load->view('admin/editdeliver.html');
            $this->load->view('admin/footer.html');
        }
    }

    public function get_delivers_data(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('clientName',"客户名称",'required');
        $this->form_validation->set_rules('address',"收货地址",'required');
        $this->form_validation->set_rules('phoneNo',"联系电话",'required');
        $this->form_validation->set_rules('goodsName',"商品名称",'required');
        $this->form_validation->set_rules('quantity',"发货数量",'required');
        $this->form_validation->set_rules('price',"商品单价",'required');
        $status=$this->form_validation->run();
        if(!$status){
            return false;
        }
        $clientName=$this->input->post('clientName');
        $sex=$this->input->post('sex');
        $provinceId=$this->input->post('province');
        $province=$this->database->getProviceName($provinceId);
        $city=$this->input->post('city');
        $address=$this->input->post('address');
        $phoneNo=$this->input->post('phoneNo');
        $goodsName=$this->input->post('goodsName');
        $specification=$this->input->post('specification');
        $unit=$this->input->post('unit');
        $price=$this->input->post('price');
        $quantity=$this->input->post('quantity');
        $money=$this->input->post('money');
        $logisticsName=$this->input->post('logisticsName');
        $waybillNo=$this->input->post('waybillNo');
        $deliverDate=$this->input->post('deliverDate');
        $deliveryMan=$this->input->post('deliveryMan');
        $status=$this->input->post('status');
        $remark=$this->input->post('remark');
        $data=array(
            'rowid'=>strtoupper(md5($logisticsName.date("Y-m-d H:i:s"))),//采用系统时间+IdentityID的方法
            'clientName'=>$clientName,
            'sex'=>$sex,
            'province'=>$province,
            'city'=>$city,
            'address'=>$address,
            'phoneNo'=>$phoneNo,
            'goodsName'=>$goodsName,
            'specification'=>$specification,
            'unit'=>$unit,
            'price'=>$price,
            'quantity'=>$quantity,
            'money'=>$money,
            'logisticsName'=>$logisticsName,
            'waybillNo'=>$waybillNo,
            'deliverDate'=>$deliverDate,
            'deliveryMan'=>$deliveryMan,
            'status'=>$status,
            'remark'=>$remark,
            'modDate'	=> time()
        );
        return $data;
    }


    public function editrecord(){
        $this->load->library('form_validation');
        $tablename=$this->uri->segment(3);
        $rowid=$this->uri->segment(4);
        $url=$this->uri->segment(5);
        $data['record']=$this->database->getrecord($tablename,$rowid);
        $data['tablename']=$tablename;
        if(isset($url)) $data['url']=$url;
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
                'modDate'=>time()
            );
            if($tablename=='childmenu'){
                $data['menuName']=$this->input->post('menuName');
                $data['class']=$this->input->post('class');
            }
            if($tablename!='childmenu'){
                $data['author']=$this->session->userdata('author');
                $data['addDate']=time();
            }
            $newstype=$this->input->post('newstype');
            if(strlen($newstype)>0) $data['newstype']=$newstype;
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
        $url=$this->uri->segment(5);
        $status=$this->database->deleterecord($tablename,$rowid);
        if(strlen($url)==0)   $url=$tablename;
        $url='admin/'.$url;
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
        $url=$this->input->post('url');
        if (strlen($url )==0)$url=$tablename;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title',"标题",'required');
        $this->form_validation->set_rules('content',"内容",'required');
        $status=$this->form_validation->run();
        if($status){
            $data=array(
                'title'=>$this->input->post('title'),
                'content'=>$_POST['content'],//此处不能采用CI自带的输入模块，否则有些style属性被自动替换成xss=removed
                'modDate'=>time()
            );
            if($tablename=='sysinfo'){
                $data['profile']=$this->input->post('profile');
            }
            if($tablename=='news'){
                $data['newstype']=$this->input->post('newstype');
            }

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

    public function getselectinfo(){
        $tableName=$this->input->post('tableName');
        $fieldName=$this->input->post('fieldName');
        $value=$this->input->post('value');
        $where=array(
            $fieldName=>$value
        );
        $data=$this->database->getrecords($tableName,$where);
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);

    }

    public function getClientInfo(){
        $clientName=$this->input->post('clientName');
        $data=$this->database->getClientInfo($clientName);
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);

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