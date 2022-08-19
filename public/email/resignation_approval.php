<?php
	require_once ('../MailchimpTransactional/vendor/autoload.php');

	function run($recipient_name, $recipient_email, $resign_code, $requested_user, $resign_user_department, $resign_user_title,$resign_user_grade,$type) {
		print_r($_GET);
		try {
			$mailchimp = new MailchimpTransactional\ApiClient();
			$mailchimp->setApiKey('y7TPHN7MBAI5m3Ti3Ru1Xw');
			
			$message = array(
				// 'text' => "Absensi \n\n This message is generated automatically from the system",
				// 'subject' => 'This Recruitment Need Your Approval',
				// 'from_email' => 'imawiproites@wipro-unza.co.id',
				// 'from_name' => 'I Am A Wiproites',
				'to' => array(
					array(
						'email' => $recipient_email,
						'name' => $recipient_name,
						'type' => 'to'
					)
				),
				'global_merge_vars' => array(
					array(
						'name' => 'APPROVER',
						'content' => $recipient_name
					),
					array(
						'name' => 'TYPE',
						'content' => $type
					),
					array(
						'name' => 'RESIGN_CODE',
						'content' => $resign_code
					),
					array(
						'name' => 'RESIGN_USER',
						'content' => $requested_user
					),
					array(
						'name' => 'RESIGN_USER_DEPARTMENT',
						'content' => $resign_user_department
					),
					array(
						'name' => 'RESIGN_USER_TITLE',
						'content' => $resign_user_title
					),
					array(
						'name' => 'RESIGN_USER_GRADE',
						'content' => $resign_user_grade
					)
				)
			);
			
			$response = $mailchimp->messages->sendTemplate([
				"template_name" => "resignation-approval",
				"template_content" => array(
					array(
						'name' => 'APPROVER',
						'content' => $recipient_name
					),
					array(
						'name' => 'TYPE',
						'content' => $type
					),
					array(
						'name' => 'RESIGN_CODE',
						'content' => $resign_code
					),
					array(
						'name' => 'RESIGN_USER',
						'content' => $requested_user
					),
					array(
						'name' => 'RESIGN_USER_DEPARTMENT',
						'content' => $resign_user_department
					),
					array(
						'name' => 'RESIGN_USER_TITLE',
						'content' => $resign_user_title
					),
					array(
						'name' => 'RESIGN_USER_GRADE',
						'content' => $resign_user_grade
					)
				),
				"message" => $message
			]);
			print_r($response);
		} catch (Error $e) {
			echo 'Error: ',  $e->getMessage(), "\n";
		}
	}
	
	$recipient_name = $_GET['recipient_name'];
	$recipient_email = $_GET['recipient_email'];
	$resign_code = $_GET['resign_code'];
	$requested_user = $_GET['requested_user'];
	$resign_user_department = $_GET['resign_user_department'];
	$resign_user_title = $_GET['resign_user_title'];
	$resign_user_grade = $_GET['resign_user_grade'];
	$type = $_GET['type'];

	run($recipient_name, $recipient_email, $resign_code, $requested_user, $resign_user_department, $resign_user_title,$resign_user_grade,$type);

?>