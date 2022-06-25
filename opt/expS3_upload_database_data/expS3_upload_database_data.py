"""
% ./mysqldump-all.py -h
usage: mysqldump-all.py [-h] [-u USERNAME] [-p PASSWORD] [-x PREFIX] outdir

Dump all mysql databases

positional arguments:
  outdir       directory to make dump files

optional arguments:
  -h, --help   show this help message and exit
  -u USERNAME  mysql username
  -p PASSWORD  mysql password
  -x PREFIX    file prefix
"""

#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
import argparse
import subprocess
import sys
import boto3
from botocore.client import Config
from datetime import datetime as dt

class MySQLDump:


    # バックアップデータの置き場
    BK_FILE_NAME = 'backup_data.dmp'

    # S3のバケットや情報
    BUCKET = 'kumamoto-yoshida-farm.net'
    KEY = 'backup_data/'

    # S3へのアクセスキー
    ACCESS_KEY_ID = os.getenv('ACCESS_KEY_ID')
    SECRET_ACCESS_KEY = os.getenv('SECRET_ACCESS_KEY')

    # MySQLへのアクセスキー
    DATABASE_SCHEMA_NAME = os.getenv('DATABASE_SCHEMA_NAME')
    DATABASE_ID = os.getenv('DATABASE_ID')
    DATABASE_PASS = os.getenv('DATABASE_PASS')

    def __init__(self, options):
        self.username = self.DATABASE_ID
        self.password = self.DATABASE_PASS
   	# S3アップロードパス
        self.outdir   = '/opt/expS3_upload_database_data/'
   	# ダンプファイル名プリフィックス
        self.prefix   = 'dmp_'

    def dump(self):
        self._check_outdir()
        self._dump_database(self.DATABASE_SCHEMA_NAME)

    def _check_outdir(self):
        if os.path.isdir(self.outdir) == False:
            raise Exception("Out directory '%s' not found." % self.outdir)

    def _dump_database(self, database):
        print ("Dumping database %s..." % database) 
        filename = self.prefix + database + '.sql.gz'
        filedirname = self.outdir + '/' + filename
        command = "mysqldump %s %s | gzip > %s" % (self._get_options(), database, filedirname)
        
        print(command)
        result = subprocess.call(command, shell=True)
        print (filedirname)

        self._upload_S3(filename)

    def _get_options(self):
        options = []

        if self.username:
            options.append("-u %s" % self.username)

        if self.password:
            options.append("-p%s" % self.password)

        return ' '.join(options)

    def _upload_S3(self,filename):
        s3 = boto3.client('s3',
                        aws_access_key_id=self.ACCESS_KEY_ID,
                        aws_secret_access_key=self.SECRET_ACCESS_KEY,
                        region_name='ap-northeast-1', 
                        )
        s3.upload_file(
            filename,
            Bucket=self.BUCKET,
            Key=self.KEY + dt.now().strftime('%Y%m%d%H') + filename,
            ExtraArgs={"ContentType": "application/gzip"}
        )

def main():
    parser = argparse.ArgumentParser(description='Dump all mysql databases')
    args = parser.parse_args()

    try:
        mysqldump = MySQLDump(args)
        mysqldump.dump()
    except Exception as e:
        print (e)
        exit(1)

if __name__ == "__main__":
    main()
