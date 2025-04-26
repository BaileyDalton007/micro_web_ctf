#!/bin/bash

# Check for input
if [ -z "$1" ]; then
  echo "Usage: create_challenge.sh <flag>"
  exit 1
fi

input="$1"

# delete any existing files from past runs.
rm -rf "file"
rm "file.zip"
#rm "games.pgn"

# create zip archive from flag
b64flag=$(echo -n "$input" | base64)
./nest_dirs.sh "$b64flag"
zip -r file.zip file/

python3 encode.py
python3 populate_metadata.py

# delete everything but the PGN output
rm -rf "file"
rm "file.zip"
