<?php
	require_once ('../MailchimpTransactional/vendor/autoload.php');

	function run($recipient_name, $recipient_email, $recruit_code, $recruit_request, $recruit_title, $recruit_grade) {
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
						'name' => 'RECRUIT_CODE',
						'content' => $recruit_code
					),
					array(
						'name' => 'RECRUIT_REQUEST',
						'content' => $recruit_request
					),
					array(
						'name' => 'RECRUIT_TITLE',
						'content' => $recruit_title
					),
					array(
						'name' => 'RECRUIT_GRADE',
						'content' => $recruit_grade
					)
				)
			);
			
			$response = $mailchimp->messages->sendTemplate([
				"template_name" => "recruitment-processing",
				"template_content" => array(
					array(
						'name' => 'APPROVER',
						'content' => $recipient_name
					),
					array(
						'name' => 'RECRUIT_CODE',
						'content' => $recruit_code
					),
					array(
						'name' => 'RECRUIT_REQUEST',
						'content' => $recruit_request
					),
					array(
						'name' => 'RECRUIT_TITLE',
						'content' => $recruit_title
					),
					array(
						'name' => 'RECRUIT_GRADE',
						'content' => $recruit_grade
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
	$recruit_code = $_GET['recruit_code'];
	$recruit_request = $_GET['recruit_request'];
	$recruit_title = $_GET['recruit_title'];
	$recruit_grade = $_GET['recruit_grade'];

	run($recipient_name, $recipient_email, $recruit_code, $recruit_request, $recruit_title, $recruit_grade);

?>