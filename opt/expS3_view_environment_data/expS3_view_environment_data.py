import os
import boto3
from botocore.client import Config
import requests

# 環境データの取り元
HTML_INPUT_URL = 'http://localhost/PHP/view_environment_data.php'
HTML_FILE_NAME = 'view_environment_data.html'

# S3のバケットや情報
BUCKET = 'homemap'
KEY = 'view_env/' + HTML_FILE_NAME

# S3へのアクセスキー
ACCESS_KEY_ID = 'ひみつ'
SECRET_ACCESS_KEY = 'ひみつ'

ACCESS_KEY_ID = os.getenv('ACCESS_KEY_ID')
SECRET_ACCESS_KEY = os.getenv('SECRET_ACCESS_KEY')

responsePhp = requests.get(HTML_INPUT_URL)
f = open(HTML_FILE_NAME, 'wb')
data = responsePhp.text.encode('utf-8')
f.write(data)
f.close()

s3 = boto3.client('s3',
                  aws_access_key_id=ACCESS_KEY_ID,
                  aws_secret_access_key=SECRET_ACCESS_KEY,
                  region_name='ap-northeast-1', 
                  )
s3.upload_file(
    Filename=HTML_FILE_NAME,
    Bucket=BUCKET,
    Key=KEY,
    ExtraArgs={"ContentType": "text/html"}
)
