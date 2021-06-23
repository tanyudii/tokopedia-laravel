#!/bin/bash

private=$1
temp="./tmp"
out=$3

if [[ $# -lt 2 ]] ; then 
    echo "Usage: decrypt <private_key> <encrypted_secret> <optional:output_file>"
    exit
fi
echo $2 > $temp.base64
encrypt=$temp.base64

# decryption logic
openssl base64 -A -d -in $encrypt > $temp.bin
openssl pkeyutl -decrypt -inkey $private -in $temp.bin -out $temp.txt -pkeyopt rsa_padding_mode:oaep -pkeyopt rsa_oaep_md:sha256 
# end of decryption logic

cat $temp.txt

if [[ $out != "" ]]; then 
    echo "result: $out"
    cat $temp.txt > $out
fi

rm $temp*