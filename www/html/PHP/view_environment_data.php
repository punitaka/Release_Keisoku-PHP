<?php
    mb_language("uni");
    mb_internal_encoding("utf-8"); //内部文字コードを変更
    mb_http_input("auto");
    mb_http_output("utf-8");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="IoT,農業 IT,スマート農業">
<meta name="description" content="熊本県山鹿市の中山間地にある小さな農園です。趣味のIoT機器を製作しています。">
<!--文字コードの指定htmlファイル内で指定する場合-->
<meta http-equiv="Content-Type" content="text/html;charset = utf-8" />
<title>センサー観測データ | くまもと山鹿 吉田農園 熊本県山鹿市の小さな農園</title><!--[if lt IE 9]>
<script src="../html5.js" type="text/javascript"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="../style.css">

		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script>
		google.load('visualization', '1', {
		  packages: ['corechart']
		});
		google.setOnLoadCallback(drawChartD);
            
		google.load('visualization', '1', {
		  packages: ['corechart']
		});
		google.setOnLoadCallback(drawChartH);
            
		google.load('visualization', '1', {
		  packages: ['corechart']
		});
		google.setOnLoadCallback(drawChartM);

		// データ読み込み
        function drawChartH() {
          var data = google.visualization.arrayToDataTable([
            ['時間', '平均気温', '平均湿度', '平均気圧', '平均照度'], 
            <?php
                  //おまじない - 関数を定義した別のPHPファイルを読み込む
                  require_once __DIR__.'/libs/db_util.php';
                  require_once __DIR__.'/libs/GoogChart.class.php';

                  //DB　テーブルの指定
                  $db_name = 'db_kumikomi';

                  //指定DBファイルのPDOインスタンスを取得
                  $dbh = initDB($db_name);

                  $sql = '';
                  $sql .= 'SELECT ';
                  $sql .= '    v_YYYYMMDDHH, ';
                  $sql .= '    ROUND(d_a_temperature, 2)      AS d_a_temperature, ';
                  $sql .= '    ROUND(d_a_humidity,    2)      AS d_a_humidity, ';
                  $sql .= '    ROUND(d_a_pressure,    2)      AS d_a_pressure, ';
                  $sql .= '    ROUND(d_a_Illuminance, 2) / 10 AS d_a_Illuminance ';
                  $sql .= 'FROM ';
                  $sql .= '    t_summary_h ';
                  $sql .= 'WHERE ';
                  $sql .= "    DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 7 DAY), '%Y%m%d') <= LEFT(v_YYYYMMDDHH, 8) ";
                  $sql .= 'order by ';
                  $sql .= '    v_YYYYMMDDHH ';

                  $stmt = $dbh->query($sql);
                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // 行の長さ取得
                  $length = $stmt->rowCount();
                  // カウント
                  $no = 0;
                  foreach ($result as $value) {
                      echo '[\''.$value['v_YYYYMMDDHH'].'\', '.$value['d_a_temperature'].', '.$value['d_a_humidity'].', '.$value['d_a_pressure'].', '.$value['d_a_Illuminance'].']';
                      ++$no;
                      if ($no !== $length) {
                          echo ",\n";
                      }
                  }
          ?>
          ]);
          var options = {
            width: '100%',
            height: 500,
            chartArea: {
              width: '90%',
              height: '75%',
              top: 40,
              left: 40
            },
            fontName: 'PibotoLt',
            backgroundColor: '#EFF4F5',
            isStacked: true,
            colors: ['#2E8EF6', '#DA3A29', '#ff8c00', '#8EC43C'],
            bar: {
              groupWidth: 20
            },
            hAxis: {
              title: '年月日時(過去7日間)',
              titleTextStyle: {
                fontName: 'PibotoLt',
                fontSize: 16,
                italic: false,
                bold: false,
                color: '#696969'
              },
              textStyle: {
                fontSize: 12,
                color: '#696969',
                fontName: 'PibotoLt'
              },
              slantedText: true
            },
            vAxis: {
              title: 'センサー取得値',
              titleTextStyle: {
                fontName: 'PibotoLt',
                fontSize: 16,
                italic: false,
                bold: false,
                color: '#696969'
              },
              textStyle: {
                fontSize: 12,
                color: '#696969',
                fontName: 'PibotoLt'
              }
            },
            legend: {
              position: 'top',
              textStyle: {
                fontName: 'PibotoLt',
                color: '#696969',
                fontSize: 16
              }
            }
          };
          var chart = new google.visualization.LineChart(document.getElementById('graphH'));
          chart.draw(data, options);
        }

      // データ読み込み
      function drawChartD() {
            var data = google.visualization.arrayToDataTable([
              ['日付', '平均気温', '平均湿度', '平均気圧', '平均照度'],
              <?php
                  //おまじない - 関数を定義した別のPHPファイルを読み込む
                  require_once __DIR__.'/libs/db_util.php';
                  require_once __DIR__.'/libs/GoogChart.class.php';

                  //DB　テーブルの指定
                  $db_name = 'db_kumikomi';

                  //指定DBファイルのPDOインスタンスを取得
                  $dbh = initDB($db_name);

                  $sql = '';
                  $sql .= 'SELECT ';
                  $sql .= '    v_YYYYMMDD, ';
                  $sql .= '    ROUND(d_a_temperature, 2)      AS d_a_temperature, ';
                  $sql .= '    ROUND(d_a_humidity,    2)      AS d_a_humidity, ';
                  $sql .= '    ROUND(d_a_pressure,    2)      AS d_a_pressure, ';
                  $sql .= '    ROUND(d_a_Illuminance, 2) / 10 AS d_a_Illuminance ';
                  $sql .= 'FROM ';
                  $sql .= '    t_summary_d ';
                  $sql .= 'WHERE ';
                  $sql .= "    v_YYYYMMDD < DATE_FORMAT(CURDATE(), '%Y%m%d')";
                  $sql .= 'order by ';
                  $sql .= '    v_YYYYMMDD ';

                  $stmt = $dbh->query($sql);
                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // 行の長さ取得
                  $length = $stmt->rowCount();
                  // カウント
                  $no = 0;
                  foreach ($result as $value) {
                      echo '[\''.$value['v_YYYYMMDD'].'\', '.$value['d_a_temperature'].', '.$value['d_a_humidity'].', '.$value['d_a_pressure'].', '.$value['d_a_Illuminance'].']';
                      ++$no;
                      if ($no !== $length) {
                          echo ",\n";
                      }
                  }
            ?>
            ]);
            var options = {
              width: '100%',
              height: 500,
              chartArea: {
                width: '90%',
                height: '75%',
                top: 40,
                left: 40
              },
              fontName: 'メイリオ',
              backgroundColor: '#EFF4F5',
              isStacked: true,
              colors: ['#2E8EF6', '#DA3A29', '#ff8c00', '#8EC43C'],
              bar: {
                groupWidth: 20
              },
              hAxis: {
                title: '年月日',
                titleTextStyle: {
                  fontName: 'メイリオ',
                  fontSize: 16,
                  italic: false,
                  bold: false,
                  color: '#696969'
                },
                textStyle: {
                  fontSize: 12,
                  color: '#696969',
                  fontName: 'メイリオ'
                },
                slantedText: true
              },
              vAxis: {
                title: 'センサー取得値',
                titleTextStyle: {
                  fontName: 'メイリオ',
                  fontSize: 16,
                  italic: false,
                  bold: false,
                  color: '#696969'
                },
                textStyle: {
                  fontSize: 12,
                  color: '#696969',
                  fontName: 'メイリオ'
                }
              },
              legend: {
                position: 'top',
                textStyle: {
                  fontName: 'メイリオ',
                  color: '#696969',
                  fontSize: 16
                }
              }
            };
            var chart = new google.visualization.LineChart(document.getElementById('graphD'));
            chart.draw(data, options);
        }


        function drawChartM() {
    	    var data = google.visualization.arrayToDataTable([
    	    ['時間', '平均気温', '平均湿度', '平均気圧', '平均照度'],
    	    <?php
                //おまじない - 関数を定義した別のPHPファイルを読み込む
                require_once __DIR__.'/libs/db_util.php';
                require_once __DIR__.'/libs/GoogChart.class.php';

                //DB　テーブルの指定
                $db_name = 'db_kumikomi';

                //指定DBファイルのPDOインスタンスを取得
                $dbh = initDB($db_name);

                $sql = '';
                $sql .= 'SELECT ';
                $sql .= '    v_YYYYMM, ';
                $sql .= '    ROUND(d_a_temperature, 2)      AS d_a_temperature, ';
                $sql .= '    ROUND(d_a_humidity,    2)      AS d_a_humidity, ';
                $sql .= '    ROUND(d_a_pressure,    2)      AS d_a_pressure, ';
                $sql .= '    ROUND(d_a_Illuminance, 2) / 10 AS d_a_Illuminance ';
                $sql .= 'FROM ';
                $sql .= '    t_summary_m ';
                $sql .= 'order by ';
                $sql .= '    v_YYYYMM ';

                $stmt = $dbh->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 行の長さ取得
                $length = $stmt->rowCount();
                // カウント
                $no = 0;
                foreach ($result as $value) {
                    echo '[\''.$value['v_YYYYMM'].'\', '.$value['d_a_temperature'].', '.$value['d_a_humidity'].', '.$value['d_a_pressure'].', '.$value['d_a_Illuminance'].']';
                    ++$no;
                    if ($no !== $length) {
                        echo ",\n";
                    }
                }
            ?>
    	    ]);
    	    var options = {
              width: '100%',
              height: 500,
    	      chartArea: {
    	        width: '90%',
    	        height: '75%',
    	        top: 40,
    	        left: 40
    	      },
    	      fontName: 'メイリオ',
    	      backgroundColor: '#EFF4F5',
    	      isStacked: true,
    	      colors: ['#2E8EF6', '#DA3A29', '#ff8c00', '#8EC43C'],
    	      bar: {
    	        groupWidth: 20
    	      },
    	      hAxis: {
    	        title: '年月',
    	        titleTextStyle: {
    	          fontName: 'メイリオ',
    	          fontSize: 16,
    	          italic: false,
    	          bold: false,
    	          color: '#696969'
    	        },
    	        textStyle: {
    	          fontSize: 12,
    	          color: '#696969',
    	          fontName: 'メイリオ'
    	        },
    	        slantedText: true
    	      },
    	      vAxis: {
    	        title: 'センサー取得値',
    	        titleTextStyle: {
    	          fontName: 'メイリオ',
    	          fontSize: 16,
    	          italic: false,
    	          bold: false,
    	          color: '#696969'
    	        },
    	        textStyle: {
    	          fontSize: 12,
    	          color: '#696969',
    	          fontName: 'メイリオ'
    	        }
    	      },
    	      legend: {
    	        position: 'top',
    	        textStyle: {
    	          fontName: 'メイリオ',
    	          color: '#696969',
    	          fontSize: 16
    	        }
    	      }
    	    };
    	    var chart = new google.visualization.LineChart(document.getElementById('graphM'));
    	    chart.draw(data, options);
        }
      </script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-TGCV1BH2DY"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-TGCV1BH2DY');
  </script>
</head>
<body class="basic2" id="hpb-sp-20-0027-48">
  <div id="page" class="site">
    <header id="masthead" class="site-header sp-part-top sp-header2" role="banner">
      <div id="masthead-inner" class="sp-part-top sp-header-inner">
        <div id="sp-site-branding2-1" class="sp-part-top sp-site-branding2">
          <h1 class="site-title sp-part-top sp-site-title" id=""><a href="../index.html">くまもと山鹿 吉田農園 熊本県山鹿市の小さな農園</a></h1>
          <h2 class="site-description sp-part-top sp-catchphrase" id="">くまもと山鹿 吉田農園は熊本県山鹿市にある中山間地の小さな農園です。</h2>
          <div class="extra sp-part-top sp-site-branding-extra" style="min-height: 20px" id="sp-site-branding-extra-1"></div>
        </div>
      </div>
    </header>
    <div id="main" class="site-main sp-part-top sp-main">
      <div id="contenthead" class="sp-part-top sp-content-header">
        <nav id="sp-site-navigation-1" class="navigation-main button-menu sp-part-top sp-site-navigation horizontal" role="navigation">
          <h1 class="menu-toggle">メニュー</h1>
          <div class="screen-reader-text skip-link"><a title="コンテンツへスキップ" href="#content">コンテンツへスキップ</a></div>
          <ul id="menu-mainnav">
            <li class="menu-item"><a href="../index.html">トップページ</a>
              <li class="menu-item"><a href="../gallery.html">農園ギャラリー</a>
                <li class="menu-item"><a href="../iot.html">ちょこっとIT</a>
                  <li class="menu-item current_page_item"><a href="../okome2022.html">特別栽培米 お米の販売</a>
                    <li class="menu-item"><a href="../chestnut.html">自然栽培 栗の販売</a></ul>
        </nav>
        <div id="breadcrumb-list" itemscope="" itemtype="http://schema.org/BreadcrumbList" class="sp-part-top sp-bread-crumb">
          <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemprop="item" href="../index.html"><span itemprop="name">トップ</span></a>
            <meta itemprop="position" content="1">
          </div>
          <div>›</div>
          <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="../iot.html" itemprop="item"><span itemprop="name">ちょこっとIT</span></a>
            <meta itemprop="position" content="2">
          </div>
          <div>›</div>
          <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><span itemprop="name">センサー観測データ</span>
            <meta itemprop="position" content="3">
          </div>
        </div>
      </div>
      <div id="main-inner">
        <div id="primary" class="content-area">
          <div id="content" class="site-content sp-part-top sp-content page-blog" role="main">
            <header id="sp-page-title-5" class="entry-header sp-part-top sp-page-title">
              <h1 class="entry-title">センサー観測データ</h1>
            </header>
            <article>
              <div id="page-content" class="sp-part-top sp-block-container">
                <p class="paragraph">3時間毎に更新。<br> 5分ごとにセンサーの値を記録しその平均値を表示しています。</p>
                <p class="paragraph">データ更新日時&nbsp;:&nbsp;
                <?php
                  $today = date("Y/m/d H:i:s");
                  print_r($today);
            	?>
                </p>
                <h3 class="paragraph">1時間平均(過去7日間)</h3>
                <div id="graphH"></div>
                <h3 class="paragraph">1日平均(昨日以前)</h3>
                <p class="paragraph">
                  <div id="graphD"></div>
                </p>
                <h3 class="paragraph" style="text-align : left;">1ヵ月平均</h3>
                <p class="paragraph">
                  <div id="graphM"></div>
                </p>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
    <footer id="colophon" class="site-footer sp-part-top sp-footer2" role="contentinfo">
      <div id="colophon-inner" class="sp-part-top sp-footer-inner">
        <nav id="sp-site-navigation-2" class="navigation-main sp-part-top sp-site-navigation minimal" role="navigation">
          <h1 class="menu-toggle">メニュー</h1>
          <div class="screen-reader-text skip-link"><a title="コンテンツへスキップ" href="#content">コンテンツへスキップ</a></div>
          <ul id="menu-mainnav">
            <li class="menu-item"><a href="../index.html">トップページ</a>
              <li class="menu-item"><a href="../gallery.html">農園ギャラリー</a>
                <li class="menu-item"><a href="../iot.html">ちょこっとIT</a>
                  <li class="menu-item current_page_item"><a href="../okome2022.html">特別栽培米 お米の販売</a>
                    <li class="menu-item"><a href="../chestnut.html">自然栽培 栗の販売</a>
                      <li class="menu-item"><a href="../privacy.html">プライバシーポリシー</a></ul>
        </nav>
        <div id="sp-block-container-6" class="sp-part-top sp-block-container">
          <p class="copyright paragraph">Copyright &copy; Kumamoto Yamaga Yoshida Farm, All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
  <script type="text/javascript" src="../navigation.js"></script>
</body>
</html>