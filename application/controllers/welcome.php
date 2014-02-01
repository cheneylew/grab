<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->load->helper('simple_html_dom');
		//Target site url
		$targetUrl='http://sh.ganji.com/iphone-iphone-5/o3/';
		$itemBaseUrl='http://sh.ganji.com';
		
		$html = file_get_html($targetUrl);
		
		header("Content-type:text/html;charset=utf-8;");

	
		$ret = $html->find('dl[class=list-bigpic]');
		echo "<pre>";
		foreach ($ret as $item){
			$yuan = $item->children(2)->children(0)->children(0)->plaintext;
			$title = $item->children(1)->children(0)->children(0)->children(0)->children(0)->plaintext;
		
			$link = $item->children(1)->children(0)->children(0)->children(0)->children(0);
			$linkSite=$itemBaseUrl.$link->href;
		
			$content = $item->children(1)->children(1)->plaintext;
			//$date = $item->children(2)->children(2)->plaintext;
			//$location = $item->children(2)->children(3)->children(0)->plaintext;
			//$date=$item->find('i[class=mr8]')->outertext;
			$dates=$item->find('i[class=mr8]');
			$date=$dates[0]->plaintext;
		
			$addses=$item->find('a[class=adds]');
			$adds=$addses[0]->plaintext;
		
			echo "|$date |$adds|$yuan|$title |$linkSite |$content |<br/>";
		}
		echo count($ret);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */