<?php


$access_token = 'ixp9bkbDiucV1rB5KIxGDwRLHeeaZD+wa2BfsBUUULPEc0Tzab4pMBk7w/knX8LaDSrmdmkOLuLI2LO9wsQDMvqnyr56kucCjJE+uvEkH+I+7U/AeL7oaWEC2UfYn983rxCiRbNBu9BREkc8qo94EwdB04t89/1O/w1cDnyilFU=';
// $access_token = 'aa';

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
			// $text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

      $userId = $event['source']['userId'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => getMassage($text)
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

				// "type" => "template",
				// "altText" => "this is a buttons template",
				// "template" => {
				// 		"type" => "buttons",
				// 		"thumbnailImageUrl" => "https://upload.wikimedia.org/wikipedia/commons/thumb/3/37/Small-world-network-example.png/220px-Small-world-network-example.png",
				// 		"title" => "Menu",
				// 		"text" => "Please select",
				// 		"actions" = [
				// 								{
				// 									"type"=> "uri",
				// 									"label"=> "View detail",
				// 									"uri"=> "http://www.google.com"
				// 								}
				// ]
				// }

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

				'type' => 'text',
				'text' => json_encode($event)

				// 'type' => 'sticker',
				// 'packageId' => '1',
				// 'stickerId' => (rand(1,17))
			];

			// Make a POST Request to Messaging API to reply to sender
			// $url = 'https://api.line.me/v2/bot/message/reply';

			$url = 'https://api.line.me/v2/bot/profile/'.$userId.'';


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

function getMassage($text)
{
    $massage = ‘’;
    $file = file_get_contents(‘text.json’);
    $data = json_decode($file, true);
    unset($file);//prevent memory leaks for large json.

    if (isset($data[$text])) {
        return $data[$text];
    }else{
        $data[$text] = ‘’;
        //save the file
        file_put_contents(‘text.json’,json_encode($data));
        unset($data);//release memory
        return $text;
    }
}
echo "OK";
