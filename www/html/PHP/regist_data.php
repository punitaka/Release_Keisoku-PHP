<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
</head>
<body>

	<?php
        const TOKEN = "ひみつ";
		$db_name = "ひみつ";
		
		//t_data1
		$sql_R  = "";
		$sql_R .= "INSERT INTO `t_data1`(					";
		$sql_R .= "    `d_datetime`,						";
		$sql_R .= "    `v_YYYYMMDD`,						";
		$sql_R .= "    `v_HHMISS`,							";
		$sql_R .= "    `d_temperature`,						";
		$sql_R .= "    `d_humidity`	,						";
		$sql_R .= "    `d_pressure`	,						";
		$sql_R .= "    `d_Illuminance`	,					";
		$sql_R .= "    `v_memo`								";
		$sql_R .= ")										";
		$sql_R .= "VALUES(									";
		$sql_R .= "    now(),								";
		$sql_R .= "    DATE_FORMAT(d_datetime, '%Y%m%d'),	";
		$sql_R .= "    DATE_FORMAT(d_datetime, '%H%i%s'),	";
		$sql_R .= "    ?,									";
		$sql_R .= "    ?,									";
		$sql_R .= "    0,								";
		$sql_R .= "    ?,									";
		$sql_R .= "    null									";
		$sql_R .= "    )									";
		$sql_R .= ";										";

		//insert
		$sql_R;
		
		$illumi	= get_lux(TOKEN);
		$temp	= get_temp(TOKEN);
		$humi	= get_humi(TOKEN);

		$sleepRes	= set_sleep_sec(TOKEN,240);

		require_once(__DIR__ . "/libs/db_util.php");

		$dbh = initDB($db_name);
		
		if(!$dbh)
		{
			//echo "Error:-1:DB接続エラーです1";
			//var_dump($dbh->errorInfo());
			//return -1;
		}

		// insertSQL実行
		$stmt = $dbh->prepare($sql_R);
		
		if (!$stmt)
		{
			echo "Error:-1:DB接続エラーです2";
			var_dump($dbh->errorInfo());
			return -1;
		}
		
		echo "temp:" . $temp . "\n"; 
		echo "humi:" . $humi . "\n"; 
		echo "illumi:" . $illumi . "\n"; 
		
		$flag = $stmt->execute(array($temp, $humi, $illumi));
		
		echo "flag = " . $flag;
		if (!$flag)
		{
			//echo "Error:-1:DB接続エラーです3";
			//var_dump($dbh->errorInfo());
			//return -1;
		}
		
		echo "Done:0:正常終了";


        function get_lux($token)
        {
            $url = "https://wiolink.seeed.co.jp/v1/node/GroveLuminanceA0/luminance?access_token=";
            return curl($token,$url,"GET","lux");
        }
        
        function get_temp($token)
        {
            $url = "https://wiolink.seeed.co.jp/v1/node/GroveTempHumD0/temperature?access_token=";
            return curl($token,$url,"GET","celsius_degree");
        }
        
        function get_humi($token)
        {
            $url = "https://wiolink.seeed.co.jp/v1/node/GroveTempHumD0/humidity?access_token=";
            return curl($token,$url,"GET","humidity");
        }
        
        function get_waltertemp($token)
        {
            $url = "https://wiolink.seeed.co.jp/v1/node/GroveTemp1WireD1/temp?access_token=";
            return curl($token,$url,"GET","temperature");
        }
        
        function get_range_cm($token)
        {
            $url = "https://wiolink.seeed.co.jp/v1/node/GroveUltraRangerD0/range_in_cm?access_token=";
            return curl($token,$url,"GET","range_cm");
        }
        
        function set_sleep_sec($token,$sec)
        {
            $url = "https://wiolink.seeed.co.jp/v1/node/pm/sleep/$sec?access_token=";
            return curl($token,$url,"POST","result");
        }
        
        function get_led_on_off($token)
        {
            $url = "https://us.wio.seeed.io/v1/node/GenericDOutD0/onoff_status?access_token=";
            return curl($token,$url,"GET","onoff");
        }
        
        function set_led_on_off($token,$ison)
        {
            $url = "https://us.wio.seeed.io/v1/node/GenericDOutD0/onoff/$ison?access_token=";
            return curl($token,$url,"POST","result");
        }
        
        function set_led_highPulse($token,$val)
        {
            $url = "https://us.wio.seeed.io/v1/node/GenericDOutD0/high_pulse/$val?access_token=";
            return curl($token,$url,"POST","result");
        }
        
        function set_led_lowPulse($token,$val)
        {
            $url = "https://us.wio.seeed.io/v1/node/GenericDOutD0/low_pulse/$val?access_token=";
            return curl($token,$url,"POST","result");
        }
		
        function curl($token,$url,$get_set,$key)
        {
            $url .= $token;
            echo "...Info... Start:" . "function curl" . "\n";  
            echo "url:" . $url . "\n";  
            echo "...Info... End:" . "function curl" . "\n";
	    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $get_set);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $res = curl_exec($ch);
            
            if($res == false)
            {
                echo "!!!Error!!! Start:" . "function curl" . "\n";  
                var_dump(curl_error($ch));
                echo "<br/>";
                var_dump(curl_errno($ch));
                echo "<br/>";
                echo "!!!Error!!! End:" . "function curl" . "\n"; 
            }

            curl_close($ch);
            
            echo "...Info... Start:" . "function curl" . "\n";  
            echo $res. "\n";  
            echo "...Info... End:" . "function curl" . "\n"; 
            
            $result = json_decode($res, true);
            return $result[$key];
        }
	?>
</body>
</html>
