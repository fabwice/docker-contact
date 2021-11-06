#!/bin/bash

docker build . -t fabwice/docker-contact --no-cache


docker push fabwice/docker-contact:latest
