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

			$servername = "ap-cdbr-azure-southeast-b.cloudapp.net";
			$username = "bc4dcc5c7e5a47";
			$password = "7de74729";
			$dbname = "chatbot_db";
			$conn = mysqli_connect($servername, $username, $password, $dbname);

			$sql = "SELECT * FROM users WHERE id_card='".$text."' or uid_line='".$userId."'";
		 	$resultUser = $conn->query($sql);

			if($resultUser->num_rows > 0){
	 		 while($rowuser = $resultUser->fetch_assoc()) {
	 			 if($rowuser["status"]==0 && $rowuser["uid_line"]==null){

	 				$sql 	= "UPDATE users SET uid_line='$userId' WHERE id_card='".$text."'";
	 				$result = $conn->query($sql);

					$messages = getConfirm($rowuser["firstname"],$rowuser["lastname"]);
					// $messages = [
					// 	'type' => 'text',
					// 	'text' => $ans
					// ];


					}else if ($text=='ใช่'){
					$sql2 	= "UPDATE users SET status=1 WHERE uid_line='".$userId."'";
	 				$result2 = $conn->query($sql2);
					$ans = "สวัสดีค่ะคุณ ".$rowuser["firstname"]." 🤗";
					$messages = [
						'type' => 'text',
						'text' => $ans
					];
				}else if ($text=='ไม่ใช่'){
					$sql22 	= "UPDATE users SET uid_line=null, status=0 WHERE uid_line='".$userId."'";
	 				$result22 = $conn->query($sql22);
					$ans = "รบกวนกรอกรหัสประชาชนของคุณอีกครั้งค่ะ 😁";
					$messages = [
						'type' => 'text',
						'text' => $ans
					];
				}

		if($rowuser["status"]==1 || $rowuser["status"]==99){
			$key = "SELECT id_key FROM msg_key WHERE text_key = '".$text."'";
	    $result = $conn->query($key);

			if ($result->num_rows > 0) {

	     // output data of each row
	     while($row = $result->fetch_assoc()) {

	 			if($row["id_key"]==1 ){
					if($rowuser["status"]==1){
						$messages = getTemplate($rowuser["id"]);
					}else{
							$ans = "ไม่สามารถใช้งานระบบได้ค่ะ 😰";
							$messages = [
								'type' => 'text',
								'text' => $ans
							];
					}

	  		 }else{
					 $messages = [
		 				'type' => 'text',
		 				'text' => getMassage($text,$userId)
		 			];
				 }
	     }
	 	}else if($rowuser["uid_line"]!=$userId){
			$ans = "รหัสประจำตัวประชาชนซ้ำค่ะ รบกวนกรอกรหัสประชาชนของคุณอีกครั้งค่ะ 😁";
			$messages = [
				'type' => 'text',
				'text' => $ans
			];
		}else{
			$messages = [
				'type' => 'text',
				'text' => getMassage($text,$userId)
			];
	  }
}

	}

}else if($text=='Help' || $text=='help'){
	$ans = "การเข้าใช้งานครั้งแรกต้องกรอกรหัสประจำตัวประชาชนเพื่อยืนยันตนก่อนนะค่ะ 😉

วาซาบิทำอะไรได้บ้างน๊าา ? 😁 😚

	🤓 ลองพิมพ์ \"ลา\" หรือ \"ขอลา\" ดูสิ เค้าเรียกฟอร์มการลามาให้ได้น้าา ~
	😎 ลองพิมพ์ \"เช็คโควต้าการลา\" ดูสิ เค้าจะส่งโควต้าการลาที่เหลือให้นะ ~
	🤠 ลองพิมพ์ \"เช็คการลา\" ดูสิ เค้าจะส่งข้อมูลการลาของตัวเองให้ดู ~
	🤡 พิมพ์คุยกับเราได้นะ เราอยากคุยกับทุกๆคนเลย >.< " ;
	$messages = [
		'type' => 'text',
		'text' => $ans
	];
}
else{
	if(preg_match('/[0-9]/', $text)){
		$messages = [
			'type' => 'text',
			'text' => "วาซาบิ ไม่เจอข้อมูลของคุณค่ะ
รบกวนกรอกรหัสประจำตัวประชาชนอีกครั้งค่ะ😥 "
		];
	}else{
			// $sql = " * FROM users WHERE uid_line='".$uid."'";
			// $sql 	= "UPDATE users SET uid_line='$uid', status=0.5 WHERE id_card='".$text."' ";
			// $result = $conn->query($sql);
			$messages = [
				'type' => 'text',
				'text' => "ไม่แน่ใจว่าเราเข้าใจผิดอะไรหรือเปล่านะค่ะ พิมพ์ใหม่อีกทีได้ไหมเอ่ย? 😙 ไม่งั้นลองพิมพ์ \"Help\" ดูเนอะ 😊 "
			];}
		}

			// Build message to reply back



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
				'type' => 'sticker',
				'packageId' => '1',
				'stickerId' => (rand(1,17))
			];

			// $messages = [
			//
			//
			// 	"type" => "image",
    	// 	"originalContentUrl" => "https://pbs.twimg.com/profile_images/655066410087940096/QSUlrrlm.png",
    	// 	"previewImageUrl" => "https://pbs.twimg.com/profile_images/655066410087940096/QSUlrrlm.png"
			//
			//
			// ];

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
				'type' => 'sticker',
				'packageId' => '1',
				'stickerId' => (rand(1,17))
			];

			// $messages = [
			//
			// 	"type"=> "template",
		  // "altText"=> "this is a confirm template",
		  // "template"=> [
		  //     "type"=> "confirm",
		  //     "text"=> "Are you sure?",
		  //     "actions"=> [
		  //         [
		  //           "type"=> "message",
		  //           "label"=> "Yes",
		  //           "text"=> "yes"
		  //         ],
		  //         [
		  //           "type"=> "message",
		  //           "label"=> "No",
		  //           "text"=> "no"
		  //         ]
		  //     ]
		  // ]

				// 'type' => 'sticker',
				// 'packageId' => '1',
				// 'stickerId' => (rand(1,17))
			// ];

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


function getMassage($text,$uid){
  //  $file = file_get_contents('text.json');
  //  $data = json_decode($file, true);
  //  unset($file);
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

   $sql = "SELECT * FROM users WHERE id_card='".$text."' or uid_line='".$uid."'";
	 $resultUser = $conn->query($sql);


	 if($resultUser->num_rows > 0){
		 while($rowuser = $resultUser->fetch_assoc()) {
			 if($rowuser["status"]==0){
				//  if ($rowuser["id_card"] == null) {
				// 	$sql 	= "UPDATE users SET id_card='".$text."' WHERE uid_line='".$uid."'";
				// 	$result = $conn->query($sql);
				// 	return "วาซาบิ รบกวนตัวเองบอกชื่อหน่อยน้าา (> _ <)";
				// }else
				// $sql 	= "UPDATE users SET uid_line='$uid', status=0.5 WHERE id_card='".$text."' ";
				// $result = $conn->query($sql);
				// if($rowuser["name"] != null){

				// }

				$sql 	= "UPDATE users SET uid_line='$uid',status=1 WHERE id_card='".$text."'";
				$result = $conn->query($sql);
				return "สวัสดีค่ะคุณ ".$rowuser["name"]." 🤗";

			 }
	else if($rowuser["status"]==1 || $rowuser["status"]==99){

	 $key = "SELECT id_key FROM msg_key WHERE status=1 AND text_key = '".$text."'";
   $result = $conn->query($key);
	 if ($result->num_rows > 0) {

    // output data of each row
    while($row = $result->fetch_assoc()) {
//เรียกเทมเพลทการลา
		// 	if($row["id_key"]==1){
 	// 		 return getTemplate();
 	// 	 }
//เช็คโควต้าลา
		//  else if ($row["id_key"]==6){
		 //
		//  $quotaP = "SELECT * FROM leaving_quota WHERE type='ลาป่วย' AND id_card = '".$rowuser["id_card"]."'";
		//  $quotaK = "SELECT * FROM leaving_quota WHERE type='ลากิจ' AND id_card = '".$rowuser["id_card"]."'";
		//  $quotaS = "SELECT * FROM leaving_quota WHERE type='ลาพักร้อน' AND id_card = '".$rowuser["id_card"]."'";
		//  $result = $conn->query($quotaP);
		//  $result2 = $conn->query($quotaK);
		//  $result3 = $conn->query($quotaS);
		//  $text = 'จำนวนวันลาของคุณเหลือ		';
		//  if ($result->num_rows > 0) {
		// 	 while($roww = $result->fetch_assoc()) {
		// 		 $text.=  "ลาป่วย ".$roww["quota"]." วัน 								";
		// 	 }
		// 	 while($roww = $result2->fetch_assoc()) {
		// 		 $text.="ลากิจ ".$roww["quota"]." วัน 									";
		// 	}
		// 	while($roww = $result3->fetch_assoc()) {
		// 		$text.="ลาพักร้อน ".$roww["quota"]." วันค่ะ 😙 ";
		//  }
		 //
		// 	 return $text;
		//  }
		 //
		//  }

			$val = "SELECT * FROM msg_val WHERE id_val = '".$row["id_key"]."' order by RAND() LIMIT 1 ";
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
	}else if($text=="Help" || $text=="help"){

	return "การเข้าใช้งานครั้งแรกต้องกรอกรหัสประจำตัวประชาชนเพื่อยืนยันตนก่อนนะค่ะ 😉

วาซาบิทำอะไรได้บ้างน๊าา ? 😁 😚

	🤓 ลองพิมพ์ \"ลา\" หรือ \"ขอลา\" ดูสิ เค้าเรียกฟอร์มการลามาให้ได้น้าา ~
	😎 ลองพิมพ์ \"เช็คโควต้าการลา\" ดูสิ เค้าจะส่งโควต้าการลาที่เหลือให้นะ ~
	🤠 ลองพิมพ์ \"เช็คการลา\" ดูสิ เค้าจะส่งข้อมูลการลาของตัวเองให้ดู ~
	🤡 พิมพ์คุยกับเราได้นะ เราอยากคุยกับทุกๆคนเลย >.< ";
}
		else{
		$key = "SELECT text FROM msg_unknow WHERE text = '".$text."'";
    $result = $conn->query($key);
 	 		if ($result->num_rows > 0) {
			$sql = "SELECT * FROM msg_auto order by RAND() LIMIT 7";
			$resultMsg = $conn->query($sql);
			while($row = $resultMsg->fetch_assoc()) {
				return $row["text"];
			}

		// return "ไปกินก๋วยเตี๋ยวเรือดีกว่าา 😜";
			}else{
			$s = "INSERT INTO msg_unknow (text) VALUES ('".$text."')";
			$updateInfo = $conn->query($s);
			$sql = "SELECT * FROM msg_auto order by RAND() LIMIT 7";
			$resultMsg = $conn->query($sql);
			while($row = $resultMsg->fetch_assoc()) {
				return $row["text"];
			}
	}
 }
}
// else if ($rowuser["status"]==2){
// 	$s = "INSERT INTO leaving (cause,firstname,lastname,type,status) VALUES ('".$text."','".$rowuser["firstname"]."','".$rowuser["lastname"]."','ลาป่วย',1)";
// 	$updateInfo = $conn->query($s);
// 	$updateStatus = "UPDATE users SET status=2.1 WHERE uid_line='".$uid."'";
// 	$rowuser["status"] = 2.1;
// 	$up = $conn->query($updateStatus);
//
// 	$val2 = "SELECT text_val FROM msg_val WHERE id_val = '".$rowuser["status"]."'";
// 	$resultVal2 = $conn->query($val2);
// 		while($row3 = $resultVal2->fetch_assoc()) {
// 			return $row3["text_val"];
// 		}
//
// }else if ($rowuser["status"]==2.1){
// 	$sss = "UPDATE leaving SET day='$text' WHERE status=1";
// 	$updateInfo = $conn->query($sss);
// 	$updateStatus = "UPDATE users SET status=1 WHERE uid_line='".$uid."'";
// 	$up = $conn->query($updateStatus);
// 	$updateStatus2 = "UPDATE leaving SET status=2 WHERE status=1";
// 	$up2 = $conn->query($updateStatus2);
//
// 	return "ขอบคุณค่าา 😍";
// }else if ($rowuser["status"]==3){
// 	$ss = "INSERT INTO leaving (cause,firstname,lastname,type,status) VALUES ('".$text."','".$rowuser["firstname"]."','".$rowuser["lastname"]."','ลากิจ',1)";
// 	$updateInfo = $conn->query($ss);
// 	$updateStatus = "UPDATE users SET status=3.1 WHERE uid_line='".$uid."'";
// 	$rowuser["status"] = 3.1;
// 	$up = $conn->query($updateStatus);
//
// 	$val2 = "SELECT text_val FROM msg_val WHERE id_val = '".$rowuser["status"]."'";
// 	$resultVal2 = $conn->query($val2);
// 		while($row3 = $resultVal2->fetch_assoc()) {
// 			return $row3["text_val"];
// 		}
//
// }else if ($rowuser["status"]==3.1){
// 	$sss = "UPDATE leaving SET day='$text' WHERE status=1";
// 	$updateInfo = $conn->query($sss);
// 	$updateStatus = "UPDATE users SET status=1 WHERE uid_line='".$uid."'";
// 	$up = $conn->query($updateStatus);
// 	$updateStatus2 = "UPDATE leaving SET status=2 WHERE status=1";
// 	$up2 = $conn->query($updateStatus2);
//
// 	return "ขอบคุณค่าา 😍";
// }else if($rowuser["status"]==4){
// 	$sss = "INSERT INTO leaving (cause,firstname,lastname,type,status) VALUES ('".$text."','".$rowuser["firstname"]."','".$rowuser["lastname"]."','ลาพักร้อน',1)";
// 	$updateInfo = $conn->query($sss);
// 	$updateStatus = "UPDATE users SET status=4.1 WHERE uid_line='".$uid."'";
// 	$rowuser["status"] = 4.1;
// 	$up = $conn->query($updateStatus);
//
// 	$val2 = "SELECT text_val FROM msg_val WHERE id_val = '".$rowuser["status"]."'";
// 	$resultVal2 = $conn->query($val2);
// 		while($row3 = $resultVal2->fetch_assoc()) {
// 			return $row3["text_val"];
// 		}
// }else if ($rowuser["status"]==4.1){
// 	$sss = "UPDATE leaving SET day='$text' WHERE status=1";
// 	$updateInfo = $conn->query($sss);
// 	$updateStatus = "UPDATE users SET status=1 WHERE uid_line='".$uid."'";
// 	$up = $conn->query($updateStatus);
// 	$updateStatus2 = "UPDATE leaving SET status=2 WHERE status=1";
// 	$up2 = $conn->query($updateStatus2);
//
// 	return "ขอบคุณค่าา 😍";
// }

}

}else{
		// $sql = " * FROM users WHERE uid_line='".$uid."'";
		// $sql 	= "UPDATE users SET uid_line='$uid', status=0.5 WHERE id_card='".$text."' ";
		// $result = $conn->query($sql);
		return "วาซาบิ ไม่เจอข้อมูลของคุณค่ะ 😥 รบกวนกรอกรหัสประจำตัวประชาชนใหม่อีกครั้งค่ะ ";
	}


   mysqli_close($conn);


   //prevent memory leaks for large json.
  //  if (isset($data[$text])) {
  //      return $data[$text];
  //  }else{
  //      $data[$text] = '';
  //      //save the file
  //      file_put_contents('text.json',json_encode($data));
  //      //release memory
  //      unset($data);
  //      return $text;
  //  }
}

function getTemplate($id){
	return
		["type" => "template",
		"altText" => "this is a buttons template",
		"template" => [
				"type" => "buttons",
				"thumbnailImageUrl" => "https://f.ptcdn.info/308/047/000/ogtr5llydKGk55LG7kM-o.jpg",
				"title" => "เมนูการลา ",
				"text" => "กรุณาเลือกรูปแบบการลาค่ะ 😊",
				"actions" => [
										[
											"type"=> "uri",
											"label"=> "ลางาน 🤔",
											"uri"=> "https://google.co.th/"."$id"
										],
										[
											"type"=> "uri",
											"label"=> "เช็คการลา & โควต้า 😉",
											"uri"=> "https://google.co.th/"."$id"."/report"
										]
									]
		]
	];
}

function getConfirm($fn,$ln){
	return [
		"type"=> "template",
  "altText"=> "this is a confirm template",
  "template"=> [
      "type"=> "confirm",
      "text"=> "ใช่คุณ ".$fn." ".$ln." รึป่าวคะ ?",
      "actions"=> [
          [
            "type"=> "message",
            "label"=> "ใช่",
            "text"=> "ใช่"
          ],
          [
            "type"=> "message",
            "label"=> "ไม่ใช่",
            "text"=> "ไม่ใช่"
          ]
      ]
  ]
];
}

echo "OK";
