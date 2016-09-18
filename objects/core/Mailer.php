<?php
class PzkCoreMailer extends PzkObjectLightWeight {
	/**
	 * Host để gửi mail
	 * @var string
	 */
	public $host = false;
	/**
	 * Username đăng nhập vào hệ thống mail
	 * @var string
	 */
	public $username = false;
	/**
	 * Password đăng nhập vào hệ thống mail
	 * @var string
	 */
	public $password = false;
	/**
	 * Kiểu kết nối: ssl hay tls
	 * @var string
	 */
	public $secure = 'ssl';
	/**
	 * Cổng kết nối
	 * @var int
	 */
	public $port = 465;
	/**
	 * Gửi từ địa chỉ email
	 * @var string
	 */
	public $from = 'nextnobels.jsc.edu@gmail.com';
	/**
	 * Gửi từ tên
	 * @var string
	 */
	public $fromName = 'NextNobels';
	
	/**
	 * Trả về mailer của hệ thống
	 * @return PHPMailer
	 */
	public function getMail() {
		require_once BASE_DIR .'/3rdparty/PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $this->host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $this->username;                 // SMTP username
		$mail->Password = $this->password;                           // SMTP password
		$mail->SMTPSecure = $this->secure;                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = $this->port;                                    // TCP port to connect to
		$mail->From = $this->from;
		$mail->FromName = $this->fromName;
		$mail->isHTML(true);
		$mail->CharSet = "UTF-8";
		return $mail;
	}
}
/**
 * Trả về mailer của hệ thống
 * @return PHPMailer
 */
function pzk_mailer() {
	return pzk_element('mailer')->getMail();
}