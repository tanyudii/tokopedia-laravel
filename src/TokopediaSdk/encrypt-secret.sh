#!/bin/bash

public=$1
temp="./tmp"
out=$3

if [[ $# -lt 2 ]] ; then 
    echo "Usage: encrypt <public_key> <secret> <optional:output_file>"
    exit
fi
echo $2 > $temp.txt
data=$temp.txt

# encryption logic
openssl pkeyutl -encrypt -inkey $public -pubin -in $data -out $temp.enc -pkeyopt rsa_padding_mode:oaep -pkeyopt rsa_oaep_md:sha256 
openssl base64 -A -in $temp.enc -out $temp.res
# end of encryption logic

cat $temp.res

if [[ $out != "" ]]; then 
    echo "result: $out"
    cat $temp.res > $out
fi

rm $temp*