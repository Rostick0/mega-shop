FROM devopsfaith/krakend:latest

COPY settings /etc/krakend/config/settings
COPY krakend.json /etc/krakend/config/krakend.json

CMD ["run", "-c", "/etc/krakend/config/krakend.json"]