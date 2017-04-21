<?php

$access_token = 'ixp9bkbDiucV1rB5KIxGDwRLHeeaZD+wa2BfsBUUULPEc0Tzab4pMBk7w/knX8LaDSrmdmkOLuLI2LO9wsQDMvqnyr56kucCjJE+uvEkH+I+7U/AeL7oaWEC2UfYn983rxCiRbNBu9BREkc8qo94EwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

      $userId = $event['source']['userId'];

			// Build message to reply back
			$messages = [
				;
			];


			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

      echo $result . "\r\n";

		}
		else if($event['type'] == 'message' && $event['message']['type'] == 'sticker'){

			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'sticker',
				'packageId' => '1',
				'stickerId' => (rand(1,17))
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";

		} else if($event['type'] == 'message' && $event['message']['type'] == 'image'){

			// Get replyToken
			$replyToken = $event['replyToken'];
			$userId = $event['source']['userId'];


			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $userId
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";

		}else if($event['type'] == 'message' && $event['message']['type'] == 'video'){

			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'sticker',
				'packageId' => '1',
				'stickerId' => (rand(1,17))
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";

		}else if($event['type'] == 'message' && $event['message']['type'] == 'audio'){

			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [


				"type" => "image",
    		"originalContentUrl" => "https://pbs.twimg.com/profile_images/655066410087940096/QSUlrrlm.png",
    		"previewImageUrl" => "https://pbs.twimg.com/profile_images/655066410087940096/QSUlrrlm.png"


			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";

		}else if($event['type'] == 'message' && $event['message']['type'] == 'location'){

			// Get replyToken
			$replyToken = $event['replyToken'];
			$userId = $event['source']['userId'];

			// Build message to reply back
			$messages = [

				"type" => "template",
				"altText" => "this is a buttons template",
				"template" => [
						"type" => "buttons",
						"thumbnailImageUrl" => "https://f.ptcdn.info/308/047/000/ogtr5llydKGk55LG7kM-o.jpg",
						"title" => "Menu",
						"text" => "Please select",
						"actions" => [
												[
            							"type"=> "message",
            							"label"=> "Add to cart",
            							"text"=> "yyyyyyy"
          							],
												[
													"type"=> "uri",
													"label"=> "View detail",
													"uri"=> "https://www.google.co.th"
												]
											]
				]

				// 'type' => 'sticker',
				// 'packageId' => '1',
				// 'stickerId' => (rand(1,17))
			];

			// Make a POST Request to Messaging API to reply to sender

			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";

		}
	}
}


function getMassage($text,$uid)
{
   $file = file_get_contents('text.json');
   $data = json_decode($file, true);
   unset($file);
  //  return "uid";
   // Create connection
	 $servername = "ap-cdbr-azure-southeast-b.cloudapp.net";
	 $username = "bc4dcc5c7e5a47";
	 $password = "7de74729";
	 $dbname = "chatbot_db";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   // Check connection
   if (!$conn) {
       // die(“Connection failed: ” . mysqli_connect_error());
      //  return mysqli_connect_error();
			return "can't connect to db";
   }

   $sql = "SELECT * FROM users WHERE uid_line='".$uid."'";
	 $resultUser = $conn->query($sql);

	 if($resultUser->num_rows > 0){
		 while($rowuser = $resultUser->fetch_assoc()) {
			 if($rowuser["status"]==0){
				 if ($rowuser["id_card"] == null) {
					$sql 	= "UPDATE users SET id_card='".$text."' WHERE uid_line='".$uid."'";
					$result = $conn->query($sql);
					return "วาซาบิ รบกวนตัวเองบอกชื่อหน่อยน้าา (> _ <)";
				}else if($rowuser["name"] == null){
					$sql 	= "UPDATE users SET name='".$text."', status=1 WHERE uid_line='".$uid."'";
					$result = $conn->query($sql);
					return "สวัสดีค่ะ คุณ   ".$text;
				}
			 }
			 else if($rowuser["status"]==1){

	 $key = "SELECT id_key FROM msg_key WHERE text_key = '".$text."'";
   $result = $conn->query($key);
	 if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
			$val = "SELECT text_val FROM msg_val WHERE id = '".$row["id_key"]."'";
			$resultVal = $conn->query($val);
        while($row2 = $resultVal->fetch_assoc()) {
					if($row["id_key"]==2){
					$ss = "UPDATE users SET status=2 WHERE uid_line='".$uid."'";
					$up = $conn->query($ss);
					return $row2["text_val"];
				}else if($row["id_key"]==3){
					$ss = "UPDATE users SET status=3 WHERE uid_line='".$uid."'";
					$up = $conn->query($ss);
					return $row2["text_val"];
				}else if($row["id_key"]==4){
					$ss = "UPDATE users SET status=4 WHERE uid_line='".$uid."'";
					$up = $conn->query($ss);
					return $row2["text_val"];
				}else{
					return $row2["text_val"];
				}
				}
    }
	}else{
     return "ยังไม่เข้าใจคำนี้ค่ะ ไว้โอกาศหน้าเนอะะ >o<";
 }
}
else if ($rowuser["status"]==2){
	$s = "INSERT INTO leaving (day,name,type) VALUES ('".$text."','".$rowuser["name"]."','ลาป่วย')";
	$updateInfo = $conn->query($s);
	$updateStatus = "UPDATE users SET status=1 WHERE uid_line='".$uid."'";
	$up = $conn->query($updateStatus);

	return "ขอบคุณค่าา >.<";
}else if ($rowuser["status"]==3){
	$ss = "INSERT INTO leaving (day,name,type) VALUES ('".$text."','".$rowuser["name"]."','ลากิจ')";
	$updateInfo = $conn->query($ss);
	$updateStatus = "UPDATE users SET status=1 WHERE uid_line='".$uid."'";
	$up = $conn->query($updateStatus);

	return "ขอบคุณค่าา >.<";
}else if($rowuser["status"]==4){
	$sss = "INSERT INTO leaving (day,name,type) VALUES ('".$text."','".$rowuser["name"]."','ลาพักร้อน')";
	$updateInfo = $conn->query($sss);
	$updateStatus = "UPDATE users SET status=1 WHERE uid_line='".$uid."'";
	$up = $conn->query($updateStatus);

	return "ขอบคุณค่าา >.<";
}
}
}else{
		// $sql = " * FROM users WHERE uid_line='".$uid."'";
		$sql 	= "INSERT INTO users (uid_line) VALUES ('".$uid."')";
		$result = $conn->query($sql);
		return "วาซาบิ ขอทราบหมายเลขบัตรประชาชนด้วยค่ะ >_< ";
	}


   mysqli_close($conn);


   //prevent memory leaks for large json.
   if (isset($data[$text])) {
       return $data[$text];
   }else{
       $data[$text] = '';
       //save the file
       file_put_contents('text.json',json_encode($data));
       //release memory
       unset($data);
       return $text;
   }
}

function getTemplate(){
	return "type" => "template",
	"altText" => "this is a buttons template",
	"template" => [
			"type" => "buttons",
			"thumbnailImageUrl" => "https://f.ptcdn.info/308/047/000/ogtr5llydKGk55LG7kM-o.jpg",
			"title" => "Menu",
			"text" => "Please select",
			"actions" => [
									[
										"type"=> "message",
										"label"=> "Add to cart",
										"text"=> "yyyyyyy"
									],
									[
										"type"=> "uri",
										"label"=> "View detail",
										"uri"=> "https://www.google.co.th"
									]
								]
	];
}
echo "OK";
