#!/bin/bash

# Check for input
if [ -z "$1" ]; then
  echo "Usage: $0 <string>"
  exit 1
fi

input="$1"
path="file"

# Loop through each character
for ((i=0; i<${#input}; i++)); do
  char="${input:$i:1}"
  # Append the character to the path
  path="$path/$char"
  mkdir -p "$path"
done

echo "Nested directories created under: $path"
