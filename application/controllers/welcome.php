<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	private $itemBaseUrl;
	private $targetUrl;
	private $tag;
	
	public function __construct(){
		parent::__construct();
		ini_set("max_execution_time", "360000");
	}
	public function index()
	{
		$this->show();//begin show.
	}
	public function show(){
		$sqlPost = $this->input->post('sql');
		if (empty($sqlPost)) {
			//$sqlpre = "SELECT * FROM `ganji` order by id asc";
			$sqlpre=$this->readFromFile();
		}else $sqlpre=$sqlPost;
		
		$sql=$sqlpre;//." limit 0,100";
		
		$this->writeToFile($sql);
		
		$this->load->model('grab_model');
		$rowsArray=$this->grab_model->selectWithSQL($sql);
		$data['rows']=$rowsArray;
		$data['sql']=$sqlpre;
		$this->load->view('show.html',$data);
	}
	private function writeToFile($sql){
		$this->load->helper('file');
		$data =$sql;
		if (!write_file('./sqlTemp.php', $data))
		{
			//echo 'Unable to write the file';
		}
		else
		{
			//echo 'File written!';
		}
	}
	private function readFromFile(){
		$this->load->helper('file');
		$string = read_file('./sqlTemp.php');
		return $string;
	}
	public function updateComment(){
		$id = $this->input->post('id');
		$comment = $this->input->post('comment');
		$sql = $this->readFromFile();
	
		$this->load->model('grab_model');
		$affected_rows=$this->grab_model->updateWithIdAndComent($id,$comment);
		
		$sqlPost = $this->input->post('sql');
		if (empty($sqlPost)) {
			//$sqlpre = "SELECT * FROM `ganji` order by id asc";
			$sqlpre=$this->readFromFile();
		}else $sqlpre=$sqlPost;
		
		$sql=$sqlpre;//." limit 0,100";
		
		$this->load->model('grab_model');
		$rowsArray=$this->grab_model->selectWithSQL($sql);
		$data['rows']=$rowsArray;
		$data['sql']=$sqlpre;
		$this->load->view('show.html',$data);
	}
	public function updatePhone(){
		$id = $this->input->post('id');
		$phone = $this->input->post('phone');
		$sql = $this->readFromFile();
	
		$this->load->model('grab_model');
		$affected_rows=$this->grab_model->updateWithIdAndPhone($id,$phone);
	
		$sqlPost = $this->input->post('sql');
		if (empty($sqlPost)) {
			//$sqlpre = "SELECT * FROM `ganji` order by id asc";
			$sqlpre=$this->readFromFile();
		}else $sqlpre=$sqlPost;
	
		$sql=$sqlpre;//." limit 0,100";
	
		$this->load->model('grab_model');
		$rowsArray=$this->grab_model->selectWithSQL($sql);
		$data['rows']=$rowsArray;
		$data['sql']=$sqlpre;
		$this->load->view('show.html',$data);
	}
	public function grabIpad3(){
		//Target site url
		$this->itemBaseUrl='http://sh.ganji.com';
		$this->tag="ipad3";
		
		header("Content-type:text/html;charset=utf-8;");
		ob_end_flush();
		ob_end_clean();
		ob_implicit_flush();
		echo str_repeat('#','1024').'<br />';
		ob_flush();
		flush();
		for ($i=0;$i<=6;$i++){
			$j=$i*32;
			$this->targetUrl="http://sh.ganji.com/wu/b1/s/f$j/_ipad3/";
			$this->loadAndCatchPage($j);
			ob_flush();
			flush();
			//sleep(2);
		}
		echo "<br/>finished!";
	}
	public function grabIpad4(){
		//Target site url
		$this->itemBaseUrl='http://sh.ganji.com';
		$this->tag="ipad4";
	
		header("Content-type:text/html;charset=utf-8;");
		ob_end_flush();
		ob_end_clean();
		ob_implicit_flush();
		echo str_repeat('#','1024').'<br />';
		ob_flush();
		flush();
		for ($i=0;$i<=6;$i++){
			$j=$i*32;
			$this->targetUrl="http://sh.ganji.com/wu/b1/s/f$j/_ipad4/";
			$this->loadAndCatchPage($j);
			ob_flush();
			flush();
			//sleep(2);
		}
		echo "<br/>finished!";
	}
	private function loadAndCatchPage($i){
		$isLoadedThisPage=self::catch_site_ipad($this->targetUrl, $this->itemBaseUrl);
		if ($isLoadedThisPage) {
			echo "<br/><font color='green'>$i page loaded ok</font><br/>";
		}else {
		echo "<br/><font color='red'>$i page loaded failed</font> url:<a href='".$this->targetUrl."' target='_blank'>".$this->targetUrl."</a><br/>";
				//break;
			sleep(60*5);
			ob_flush();
			flush();
			$this->loadAndCatchPage($i);
		}
	}
	private function catch_site($targetUrl,$itemBaseUrl){
		$this->load->helper('simple_html_dom');
		
		$html = file_get_html($targetUrl);
		
		$ret = $html->find('dl[class=list-bigpic]');
		echo "<pre>";
		foreach ($ret as $item){
			$yuan = $item->children(2)->children(0)->children(0)->plaintext;
			$title = $item->children(1)->children(0)->children(0)->children(0)->children(0)->plaintext;
		
			$link = $item->children(1)->children(0)->children(0)->children(0)->children(0);
			$url=$itemBaseUrl.$link->href;
		
			$content = $item->children(1)->children(1)->plaintext;
		
			$dates=$item->find('i[class=mr8]');
			$date=$dates[0]->plaintext;
		
			$addses=$item->find('a[class=adds]');
			$adds=$addses[0]->plaintext;
				
			$this->load->model('grab_model');
			$row_number=$this->grab_model->new_ganji ($yuan, $title, $content, $date, $adds, $url,$this->tag);
			if (!$row_number) {
				echo "||insert ganji table failed，row：$row_number||";
			}
			echo "$row_number|";
		}
		
		if (count($ret)>0) {
			return true;
		}else {
			echo $html;
			return false;
		}
	}
	private function catch_site_ipad($targetUrl,$itemBaseUrl){
		$this->load->helper('simple_html_dom');
	
		$html = file_get_html($targetUrl);
	
		$ret = $html->find('dl[class=list-sty1-bg]');
		echo "<pre>";
		foreach ($ret as $item){
			$yuan = $item->children(1)->children(0)->children(0)->plaintext;
			$title = $item->children(0)->children(0)->children(0)->plaintext;
			
			$link = $item->children(0)->children(0)->children(0);
			$url=$itemBaseUrl.$link->href;

			$dates=$item->find('p[class=time]');
			$date=$dates[0]->plaintext;
	
			$addses=$item->find('a[class=adds]');
			$adds=$addses[0]->plaintext;
	
			$this->load->model('grab_model');
			$row_number=$this->grab_model->new_ganji ($yuan, $title, '', $date, $adds, $url,$this->tag);
			if (!$row_number) {
				echo "||insert ganji table failed，row：$row_number||";
			}
			echo "$row_number|";
		}
	
		if (count($ret)>0) {
		return true;
		}else {
			echo $html;
		return false;
		}
	}
	private function catch_site_car($targetUrl,$itemBaseUrl){
		$this->load->helper('simple_html_dom');
	
		$html = file_get_html($targetUrl);
	
		$ret = $html->find('dl[class=list-pic]');
		foreach ($ret as $item){
			$yuan = $item->children(1)->children(0)->plaintext;
			$title = $item->children(0)->children(1)->children(0)->children(0)->plaintext;
			
			$content = $item->children(0)->children(1)->children(1)->plaintext;
			$a=trim($content);
			$content_process=str_replace(" ","",$a);
			
			$link = $item->children(0)->children(1)->children(0)->children(0);
			$url=$itemBaseUrl.$link->href;
	
			$dates=$item->find('span[class=gray]');
			$date=$dates[0]->plaintext;
	
			$addses=$item->find('a[class=list-word]');
			$adds=$addses[0]->plaintext;
	
			$this->load->model('grab_model');
			$row_number=$this->grab_model->new_ganji ($yuan, $title, $content_process, $date, $adds, $url,$this->tag);
			if (!$row_number) {
				echo "||insert ganji table failed，row：$row_number||";
			}
			echo "$row_number|";
		}
	
		if (count($ret)>0) {
			return true;
		}else {
			echo $html;
			return false;
		}
		}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */