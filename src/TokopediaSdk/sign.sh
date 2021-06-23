#!/bin/bash

body=$1
privatekey=$2
temp="./tmp"

if [[ $# -lt 2 ]] ; then
  echo "Usage: sign <request_body> <private_key>"
  exit 1
fi

echo -n $body > $temp.key
openssl dgst -sha256 -sigopt rsa_padding_mode:pss -sign $privatekey -out $temp.sha256 $temp.key
openssl base64 -A -in $temp.sha256 -out $temp.base64
# echo -n $body | openssl dgst -sign private.pem -sigopt rsa_padding_mode:pss -sha256 | openssl base64 -A

echo "TKPD-Signature: $(cat $temp.base64)"

rm $temp*