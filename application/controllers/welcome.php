<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	private $itemBaseUrl;
	private $targetUrl;
	private $tag;
	
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		//$this->load->view('welcome_message');
		//Target site url
		$this->itemBaseUrl='http://sh.ganji.com';
		$this->tag="iphone4s";
		for ($i=1;$i<=31;$i++){
			$this->targetUrl="http://sh.ganji.com/iphone-iphone-4s/o$i/";
			$isLoadedThisPage=self::catch_site($this->targetUrl, $this->itemBaseUrl);
			if ($isLoadedThisPage) {
				echo "<br/><font color='green'>$i page loaded ok</font><br/>";
			}else {
				echo "<br/><font color='red'>$i page loaded failed</font><br/>";
			}
		}
		echo "<br/>finished!";
	}
	private function catch_site($targetUrl,$itemBaseUrl){
		$this->load->helper('simple_html_dom');
		
		$html = file_get_html($targetUrl);
		
		header("Content-type:text/html;charset=utf-8;");
		
		
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
			return false;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */