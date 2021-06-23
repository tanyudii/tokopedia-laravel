#!/bin/bash

body=$1
publickey=$2
signature=$3
temp="./tmp"

if [[ $# -lt 3 ]] ; then
  echo "Usage: verify <request_body> <public_key> <signature>"
  exit 1
fi

echo -n $body > $temp.key
echo -n $signature > $temp.sign
openssl base64 -A -d -in $temp.sign -out $temp.sha256
openssl dgst -sha256 -sigopt rsa_padding_mode:pss -verify $publickey -signature $temp.sha256 $temp.key

rm $temp*