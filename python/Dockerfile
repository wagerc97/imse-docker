FROM alpine

RUN apk --no-cache add \
  python3 \
  py3-pip \
  py3-mysqlclient \
  py3-pandas\
  && mkdir -p /opt/db_import
RUN pip install mysql-connector 
RUN pip install python-dotenv
RUN pip install python-decouple


#COPY db_import /opt/db_import/
# resources are copied via volume in compose file

EXPOSE 80
VOLUME [ "/data" ]
WORKDIR /opt/db_import
ENTRYPOINT [ "python3" ]
CMD [ "db_import.py" ]
