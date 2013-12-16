<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	var $page_title = "";
	var $page_keywords = "";
	var $page_desc = "";
	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'image'));
		$this->load->model(array('commonmodel','homemodel'));
	}

	/**
	 * Index Page for this controller.
	 */
	
	public function index()
	{
		
		if($this->commonmodel->isLoggedIn())
		{
			redirect('post/showposts/all');
		}
		else
		{ 
			redirect('user/login');die();
			$this->load->helper('captcha');

			$vals = array(
						'word'		 => '',
						'img_path'	 => './captcha/',
						'img_url'	 => base_url().'captcha/',
						'font_path'	 => 'verdana.ttf',
						'img_width'	 => '119',
						'img_height' => 45,
						'expiration' => 7200
					);
			
			$captcha = create_captcha($vals);
			$data['captcha']=$captcha;
			
		$this->page_title = 'Get Paid to Share Your Interests with the World';
		//$this->page_keywords = $post['title'];
		$this->page_desc = "Get Paid to Share Your Interests with the World. Select your pick and make a post.  It can be a gallery, videos, blogs, recipes, anything you wish to create.";
		//print_r($data['tags']);
		$this->page_keywords = array(array('name'=>'gallery'),array('name'=>'videos'),array('name'=>'blogs'),array('name'=>'recipes'));
			
			$this->load->view('includes/header');
			$this->load->view('home', $data);
			$this->load->view('includes/footer');
		}
	}

	/*function _remap($user_name){
		if($user_name){
			$this->load->view('includes/header');
			$this->load->view('user/user-profile');
			$this->load->view('includes/footer');
		}		
	}*/
	

	

	function amazon()
	{
		$this->load->library('amazon');
		//http://www.amazon.com/gp/product/B0053NBLFW?ie=UTF8&tag=rtco01-20&linkCode=xm2&camp=1789&creativeASIN=B0053NBLFW
		$response = $this->amazon_client->responseGroup('Large')->optionalParameters(array('Condition' => 'New'))->lookup('B0053NBLFW');
		print_r($response->Items);
	}
	
	function fmpg(){
	
		//echo $ffmpeg_command = "ffmpeg -itsoffset -4  -i $url/video.mp4 -vcodec mjpeg -vframes 1 -an -f rawvideo -s 150x150 $url/video1.jpg";
		//echo $debug = exec($ffmpeg_command);
		
		$upload_path = realpath('uploads');
		$movie = new ffmpeg_movie($upload_path."/video.mp4");
		$frame=$movie->getFrame(2);
		$img=$frame->toGDImage();

		//header('Content-type: image/jpeg');

		// Output the image
		imagejpeg($img,$upload_path."/video2.jpg");

		// Free up memory
		imagedestroy($img);
	}

	function emailtest()
	{ 
		//mail("neelesh@vinfotech.com","test","test");exit;
		$this->commonmodel->setMailConfig();
						
		$this->email->clear();
		//$this->email->set_newline("\r\n");
		$this->email->from(FROM_EMAIL, 'InkSmash');
		$this->email->to("pradeep.vinfotech@gmail.com");
		$this->email->subject("Admin");
		$this->email->message("TEST");

		$this->commonmodel->sendEmail();
		echo $this->email->print_debugger();
		
	}
	
	function test($admin_percent=85)
	{ 
		$user_percent = 100-$admin_percent;
		
		if($admin_percent%5 != 0)
		{
			echo "Please enter a value in multiples of 5 and 10 only.";
			return;
		}

		if(!isset($_SESSION['google_add']['post_id']['count']))
		{
			$_SESSION['google_add']['post_id']['count'] = 0;
		}
		else
		{
			$_SESSION['google_add']['post_id']['count'] = $_SESSION['google_add']['post_id']['count']+1;
		}

		$total_hits = $_SESSION['google_add']['post_id']['count'];

		if($admin_percent%10 == 0)
		{ 
			$admin_hits = $admin_percent/10;
			$user_hits = $user_percent/10;
			$hit_count = $total_hits%10;
			
		}
		else
		{
			$admin_hits = $admin_percent/5;
			$user_hits = $user_percent/5;
			$hit_count = $total_hits%20;
		}

		if($hit_count<$user_hits)
		{	
			// user google ad client
			$google_ad_client = 'ca-pub-1248623191743021';
		}
		else
		{
			// admin google ad client
			$google_ad_client = 'ca-pub-1248623191743022';
		}
	
		echo '<pre>';
		echo 'user hits:'.$user_hits;
		echo '<br>admin hits:'.$admin_hits;
		echo '<br>total hits:'.$total_hits;
		echo '<br>hit count:'.$hit_count;
		echo '<br>google ad client:'.$google_ad_client;
		echo '<br>';

		print_r($_SESSION);
		
		exit;

		
	}
	
	function google_ad(){
		?>
	client	
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1543487476074640";
/* Jeff Test Unit */
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>

<!-- Google adsense code for ad 1 in main post starts --> 
admin 1
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1423997403947770";
/* Main Post top */
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script> 
admin 2
<!-- Google adsense code for ad 1 in main post ends -->  

<!-- Google adsense code for ad 2 in main post starts --> 
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1423997403947770";
/* Main post ad 2 */
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<!-- Google adsense code for ad 2 in main post ends --> 
admin 3
<!-- Google adsense code for ad 3 in main post starts --> 
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1423997403947770";
/* Main post ad 3 */
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<!-- Google adsense code for ad 3 in main post ends --> 
admin 4
<!-- Google adsense code for ad 4 on left side not a part of revenue model starts --> 
<script type="text/javascript"><!--
google_ad_client = "ca-pub-1423997403947770";
/* Ad 4 for left side not having revenue model */
google_ad_slot = "1235345396";
google_ad_width = 180;
google_ad_height = 150;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<!-- Google adsense code for ad 4 on left side not a part of revenue model ends -->

<?php
	}
		
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
?>