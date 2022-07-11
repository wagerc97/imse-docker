FROM python

COPY . /app

WORKDIR /app

RUN pip install --upgrade pip \
	&& pip install -r requirements.txt \
	&& rm -rf /var/cache/apk/*

EXPOSE 5000

ENTRYPOINT [ "python" ]

CMD [ "app.py" ]