# xhprof

## install

    pecl config-set preferred_state beta
    pecl install xhprof
    
    mkdir /var/www/xhprof 
    mkdir /var/www/xhprof/output
    
    sudo vim /etc/php5/mods-available/xhprof.ini
    
    extension=xhprof.so
    xhprof.output_dir=/var/www/xhprof/output
    
    sudo sh -c "echo 'extension=xhprof.so' > /etc/php5/mods-available/xhprof.ini"
    cd /etc/php5/cli/conf.d
    sudo ln -s ../../mods-available/xhprof.ini
    cd /etc/php5/fpm/conf.d
    sudo ln -s ../../mods-available/xhprof.ini
    sudo service php5-fpm restart
    
    
    sudo cp -R /usr/share/php/xhprof_html  /var/www/xhprof/
    sudo cp -R /usr/share/php/xhprof_lib /var/www/xhprof/
    
    sudo vim /etc/nginx/sites-enabled/xhprof.conf
    
    server {
        listen 80;
    
        server_name xhprof.edusoho.net;
    
        root /var/www/xhprof/xhprof_html;
    
        access_log /var/log/nginx/xhprof.access.log;
        error_log /var/log/nginx/xhprof.error.log;
    
        location / git {
            index index.php;
        }
    
        location ~ ^/(index)\.php(/|$) {
            fastcgi_pass   unix:/var/run/php5-fpm.sock;
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params; 
            fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
            fastcgi_buffer_size 128k;
            fastcgi_buffers 8 128k;
        }
    }
    
## usage

    compose install 
    
    $xhprof = new FSth\XHProf\XHProf('test', true);
    $xhprof->setLibPath($libPath)->set($url)->init();
    or
    $xhprof = new FSth\XHProf\XHProf('test', true, array(
        'libPath' => $libPath,
        'url' => $url
    ));
    $xhprof->init();
    
    $xhprof->start();
    $a = [];
    $b = [];
    for ($i = 0; $i < 10000; $i++) {
        $a[] = $i;
        $b[] = $i % 100;
    }
    array_diff($a, $b);
    $xhprof->stop();
    
 