# Do not let apache serve flag.txt files or markdown files
cat > .htaccess <<EOL
<Files "flag.txt">
    Order Allow,Deny
    Deny from all
</Files>

<Files "breach.txt">
    Order Allow,Deny
    Deny from all
</Files>

<Files "create_posts_db.php">
    Order Allow,Deny
    Deny from all
</Files>

<Files "create_users_db.php">
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

cd gentlemans_game; ./create_challenge.sh "CYCWRU{test_flag_4}"; cd ..


echo "CYCWRU{test_flag_5}" > ./lebreach_james/flag.txt

chmod -R 777 ./lebreach_james/assets/
