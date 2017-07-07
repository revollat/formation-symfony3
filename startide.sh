#!/bin/bash
docker run -it -d -p 8878:80 -v $(pwd):/workspace/ --name c9 kdelfour/cloud9-docker
