# 環境センサーシステムのファイル置き場

## 当レポジトリについて
当レポジトリは、環境センサーシステムのプログラムや関連ファイルなどを配置しています。

***

## 開発の背景
関東から九州に移住しました。  
同じ日本とはいえ九州に住んだことが無かったので、営農環境を調べようと思いました。  
熊本市のようなメジャーな場所は気象庁の過去のデータが残っていますが、今の山鹿市の気温等のデータは残っていませんでした。  
山鹿市内からも離れた中山間地のため、自分でデータを残すことにしました。  

****

## 仕組みの概要
気温・湿度・照度を5分に1回計測・記録して、
- 1時間単位
- 1日単位
- 1月単位

に結果を集計して、ホームページにアップロードする仕組みです。  
  
測定結果は、ホームページで公開しています。「測定結果」ボタンをクリック  
スマホでご覧いただく場合は、横画面にしてから開いた方がグラフが綺麗です。  
https://kumamoto-yoshida-farm.net/iot.html  
  
  
仕組みの全貌は、下記文書をまずご覧いただくと把握しやすいと思います。  
- /Documents/Keisoku-PHP_概要.pptx
- /Documents/機能一覧.xlsx

  
****

## 仕組みの解説
Youtubeで紹介しています。ぜひご覧ください。 
チャンネル登録も、是非宜しくお願い致します。

◇Youtube再生リスト　【IoT/IT】環境センサー計測・表示装置  
https://youtube.com/playlist?list=PLWImbCHDGxLpZNRsIzMHUKGW7EpCRgF5-  

***

## 調達した資材たち
主に以下の資材を調達しています。  

- Seed Wio Node  
https://wiki.seeedstudio.com/Wio_Node/
- Grove - Temperature&Humidity Sensor Pro(DHT22)  
https://wiki.seeedstudio.com/Grove-Temperature_and_Humidity_Sensor_Pro/
- **[後に非採用]**Grove - 温度および湿度センサー (DHT11)   
マイナスの気温が測れなかったので、上記DHT22に後で変えました  
https://jp.seeedstudio.com/Grove-Temperature-Humidity-Sensor-DHT11.html
- Grove 光センサー v1.2 - Grove Light Sensor  
https://jp.seeedstudio.com/Grove-Light-Sensor-v1-2-LS06-S-phototransistor.html
- Raspberry Pi4  
https://www.raspberrypi.com/
***

