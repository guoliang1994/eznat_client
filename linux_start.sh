#!/usr/bin/env bash
cd $(dirname $(readlink -f "$0"));
chmod +x ./php -R;
cd ./php/;

CMD=$1

case $CMD in
    "start")
        linux_php/php ../client.php start -d;
     ;;
    "stop")
        linux_php/php ../client.php stop;
    ;;
    "status")
       linux_php/php ../client.php status;
    ;;
    "reload")
       linux_php/php ../client.php reload;
    ;;
    "debug")
       linux_php/php ../client.php start;
     ;;
    *)
        echo "start|status|stop|reload|debug"
esac
