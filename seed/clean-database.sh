#! /bin/sh
set -e

# Clear existing application data
HOST=mongo1
NETWORK=opencrvs_default

# Clean data from MongoDB
docker run --rm --network=$NETWORK mongo:4.4 mongo --host $HOST --eval "\
db.getSiblingDB('hearth-dev').dropDatabase();\
db.getSiblingDB('openhim-dev').dropDatabase();\
db.getSiblingDB('user-mgnt').dropDatabase();\
db.getSiblingDB('application-config').dropDatabase();\
db.getSiblingDB('metrics').dropDatabase();\
db.getSiblingDB('reports').dropDatabase();\
db.getSiblingDB('config').dropDatabase();\
db.getSiblingDB('webhooks').dropDatabase();"

# Clean data from Elasticsearch
docker run --rm --network=$NETWORK appropriate/curl curl -XDELETE 'http://elasticsearch:9200/*' -v

# Delete data from InfluxDB
docker run --rm --network=$NETWORK appropriate/curl curl -X POST 'http://influxdb:8086/query?db=ocrvs' --data-urlencode "q=DROP SERIES FROM /.*/" -v