<?php
function read_and_delete_first_line($filename) {
  $file = file($filename);
  $output = $file[0];
  unset($file[0]);
  file_put_contents($filename, $file);
  return $output;
}

function add_msg ($author, $content) {
if(!isset($_GET["c"]) OR $_GET["c"] == "") {
        echo "400 Bad Request";
        die();
    }
	$mesgs = fopen("messages.dat", "a") or die("unable to open file!");
    #echo("<br />---<br />");
    $tw = $_GET["a"].";".$_GET["c"]."\n";
    #echo($tw);
    fwrite($mesgs, $tw);
	#$mesgs[] = "0";
    echo("200 OK");
    
    $file="messages.dat";
    $linecount = 0;
    $handle = fopen($file, "r");
    while(!feof($handle)){
      $line = fgets($handle);
      $linecount++;
    }

    fclose($handle);
    
    if($linecount > 11) {
        $e = read_and_delete_first_line("messages.dat");
        echo $e;
    }
}
function get_msgs () {
    echo nl2br(file_get_contents("messages.dat"));
}
?>

<?php
if (!isset($_GET['q'])) {
	header("HTTP/1.1 400 Bad Request");
	?><h1>400 Bad Request</h1><?php
	die();
} else {
	switch ($_GET['q']) {
		case 'send':
			#echo "sending ".$_GET["c"]." from ".$_GET["a"];
			add_msg($_GET["c"], $_GET["a"]);
			die();
        case 'get':
            get_msgs();
            die();
		break;
		default:
			header("HTTP/1.1 400 Bad Request");
			?><h1>400 Bad Request</h1><?php
			die();
	}
}
?>