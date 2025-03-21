# Do not let apache serve flag.txt files or markdown files
cat > .htaccess <<EOL
<Files "flag.txt">
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