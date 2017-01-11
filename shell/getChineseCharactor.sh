#!/bin/bash

filename=$1
rownum=1
cat ${filename} | while read line
do

  #駅名取得
  station_name=`expr ${line} | cut -d'^' -f2`
  
  tmp_file=tmp/tmp${rownum}
  #日本語取得
  curl -o ${tmp_file} --data-urlencode jtext=${station_name} http://kanconvit.ta2o.net/api.cgi?&format=xml
  sleep 1s
  cat ${tmp_file} >> result
  
  rownum=$(($rownum + 1))
done

