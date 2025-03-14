# Do not let apache serve flag.txt files
cat > .htaccess <<EOL
<Files "flag.txt">
    Order Allow,Deny
    Deny from all
</Files>
EOL

# create flag.txt files
echo "CYCWRU{test_flag_1}" > ./admin_panel/flag.txt
