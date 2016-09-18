<?php
class PzkAdminCronController extends PzkController {
	public function indexAction() {
		
	}
	public function backupAction() {
		// Create Backup image Folder
        $folder = 'backupfilemedia/';
        if (!is_dir($folder))
            mkdir($folder, 0777, true);
        chmod($folder, 0777);
        //get all file in tinymce
        $parent_files = glob('3rdparty/Filemanager/source/*');
        $sub_files1 = glob('3rdparty/Filemanager/source/*/*');
        $sub_files2 = glob('3rdparty/Filemanager/source/*/*/*');

        //get all file in upload
        $parentUploadFiles = glob('3rdparty/uploads/*');
        $subUploadFiles = glob('3rdparty/uploads/*/*');
		
        $allfile = array_merge($parent_files?$parent_files: array(), $sub_files1?$sub_files1: array(), $sub_files2?$sub_files2: array(),$parentUploadFiles?$parentUploadFiles: array(),$subUploadFiles?$subUploadFiles: array());
        // increase script timeout value
        ini_set('max_execution_time', 5000);

        // create object
        $zip = new ZipArchive();
        //set date
		$time = time();
		$timeCrop = date('YmdH', $time-3600);
		$timeEnd = date('YmdH', $time);
		$file =  $timeCrop. '.zip';
		@unlink('backupfilemedia/' . $file);
        if ($zip->open('backupfilemedia/' . $file, ZIPARCHIVE::CREATE) !== TRUE) {
            die ("Could not open archive");
        }

        foreach ($allfile as $key=>$value) {
            if(is_file($value) && date('YmdH', filemtime($value)) >=$timeCrop 
				&& date('YmdH', filemtime($value)) < $timeEnd ) {
                $zip->addFile($value) ;
            }
        }

        $zip->close();
	}
	
	const STATUS_SENT = 1; 
	
	public function newsletterAction() {
		$model = pzk_model('Newsletter');
		
		$newsletter = $model->getNewsletter();
		if($newsletter) {
			$subscribers = $model->getSubscribers();
			
			$mailer = pzk_mailer();
			
			$mailer->CharSet = "UTF-8";
			$mailer->AddAddress('kientrungle2001@gmail.com');
			
			foreach($subscribers as $subscriber) {
				$mailer->AddBcc($subscriber['email']);
			}
			
			ob_start();
			eval('?>' . PzkParser::parseTemplate($newsletter->getSubject(), false) . '<?php');
			$subject = ob_get_contents();
			ob_end_clean();
			$mailer->Subject = $subject;
			
			ob_start();
			eval('?>' . PzkParser::parseTemplate($newsletter->getBody(), false) . '<?php');
			$body = ob_get_contents();
			ob_end_clean();
			$mailer->Body = $body;
			if(!$mailer->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mailer->ErrorInfo;
			}
			$newsletter->update(array('status' => self::STATUS_SENT));
		}
		
	}
	
	public function facebookAction($id) {
		$entity = _db()->getTableEntity('social_app');
		$entity->load($id);
		require_once(BASE_DIR.'/3rdparty/Facebook/autoload.php');
  		$fb = new Facebook\Facebook([
		  'app_id' => $entity->getAppId(),
		  'app_secret' => $entity->getAppSecret(),
		  'default_graph_version' => 'v2.2',
		  ]);
		
		$helper = $fb->getRedirectLoginHelper();

		$permissions = array('email',
		  'user_location',
		  'user_birthday',
		  'publish_actions',
		  'publish_pages',
		  'user_managed_groups',
		  'manage_pages',
		  'public_profile'
		); // Optional permissions
		$loginUrl = $helper->getLoginUrl(BASE_REQUEST . '/admin_cron/fblogin/' . $id, $permissions);

		echo '<a href="' . $loginUrl . '">Đăng nhập ứng dụng '. $entity->getName() .'!</a>';
	}
	
	public function fbloginAction($id) {
		$entity = _db()->getTableEntity('social_app');
		$entity->load($id);
		require_once(BASE_DIR.'/3rdparty/Facebook/autoload.php');
		$fb = new Facebook\Facebook([
		  'app_id' => $entity->getAppId(),
		  'app_secret' => $entity->getAppSecret(),
		  'default_graph_version' => 'v2.2',
		  ]);
		  

		$helper = $fb->getRedirectLoginHelper();

		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		
		if (! isset($accessToken)) {
		  if ($helper->getError()) {
			header('HTTP/1.0 401 Unauthorized');
			echo "Error: " . $helper->getError() . "\n";
			echo "Error Code: " . $helper->getErrorCode() . "\n";
			echo "Error Reason: " . $helper->getErrorReason() . "\n";
			echo "Error Description: " . $helper->getErrorDescription() . "\n";
		  } else {
			header('HTTP/1.0 400 Bad Request');
			echo 'Bad request';
		  }
		  exit;
		}

		// Logged in
		echo '<h3>Access Token</h3>';
		var_dump($accessToken->getValue());

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		echo '<h3>Metadata</h3>';
		var_dump($tokenMetadata);

		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId($entity->getAppId());
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (Facebook\Exceptions\FacebookSDKException $e) {
			echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
			exit;
		  }

		  echo '<h3>Long-lived</h3>';
		  var_dump($accessToken->getValue());
		}
		$fb_access_token = (string) $accessToken;
		
		try {
		  // Returns a `Facebook\FacebookResponse` object
		  $response = $fb->get('/me?fields=id, name', $fb_access_token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		$user = $response->getGraphUser();
		
		$userEntity = _db()->getTableEntity('social_account');
		$userEntity->loadWhere(array('fbId', $user['id']));
		$userEntity->setFbId($user['id']);
		$userEntity->setName($user['name']);
		$userEntity->setTokenId(base64_encode($fb_access_token));
		
		$userEntity->setExpiredAt($tokenMetadata->getField('expires_at')->format('Y-m-d H:i:s'));
		$userEntity->setCreated(date('Y-m-d H:i:s'));
		$userEntity->setCreatorId(pzk_session()->getAdminId());
		$userEntity->setStatus(1);
		$userEntity->setAppId($id);
		$userEntity->setType('profile');
		$userEntity->save();
		
		$this->redirect('admin_socialapp/index');
	}
}