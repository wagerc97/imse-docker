FROM alpine

RUN apk --no-cache add \
  python3 \
  py3-pip \
  py3-sqlalchemy \
  py3-mysqlclient \
  && mkdir -p /opt/db_import
#RUN pip3 install mysql-connector-python
#COPY db_import/db_import.py /opt/db_import/db_import.py
COPY db_import/db_import.py /opt/db_import/db_import.py
COPY db_import/db_import.env /opt/db_import/

# The following does the following (in order)
# 1. expose port 80 of this container by default
# 2. Mount a docker volume on /data to store the default sqlite database
# 3. Sets the working directory in the container to /opt/db_import
# 4. Sets the entrypoint to python3: running `docker run <image_name> <args...>` results in the following command being executed in the container:
#         python3 <args...>
# 5. Sets a default command (the <args...> part) to the program.
EXPOSE 80
VOLUME [ "/data" ]
WORKDIR /opt/db_import
ENTRYPOINT [ "python3" ]
CMD [ "db_import.py" ]

