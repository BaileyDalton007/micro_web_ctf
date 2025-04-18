# Do not let apache serve flag.txt files or markdown files
cat > .htaccess <<EOL
<Files "flag.txt">
    Order Allow,Deny
    Deny from all
</Files>

<Files ".sh$">
    Order Allow,Deny
    Deny from all
</Files>

<Files "gentlemans_game/*.py$">
    Order Allow,Deny
    Deny from all
</Files>

<FilesMatch "\.md$">
    Order Allow,Deny
    Deny from all
</FilesMatch>
EOL

# create flag.txt files
echo "CYCWRU{test_flag_1}" > ./admin_panel/flag.txt

echo "CYCWRU{test_flag_2}" > ./awkward_astrology/flag.txt

echo "CYCWRU{test_flag_3}" > ./milk_clicker/flag.txt

# this challenge uses a submodule for encoding the file as a chess game
git submodule update --init --recursive
cd gentlemans_game; ./create_challenge.sh "CYCWRU{test_flag_4}"; cd ..

