#!/bin/bash

PS3='Please enter your choice: '
options=("ClearCache 1" "LancerIDE 2" "StopIDE 3" "Quit")
select opt in "${options[@]}"
do
    case $opt in
        "ClearCache 1")
            docker-compose exec phpapp bin/console cache:clear --no-warmup
            docker-compose exec phpapp bin/console cache:warmup
            ;;
        "LancerIDE 2")
            docker run -it -d -p 8878:80 -v $(pwd):/workspace/ --name c9 kdelfour/cloud9-docker
            ;;
        "StopIDE 3")
            docker stop c9
            ;;
        "Quit")
		    echo "Bye !"
            break
            ;;
        *) echo invalid option;;
    esac
done