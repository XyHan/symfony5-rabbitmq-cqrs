FROM rabbitmq:3.9.5

COPY conf/rabbitmq.conf /etc/rabbitmq/rabbitmq.conf
COPY conf/definitions.json /etc/rabbitmq/definitions.json

RUN chown rabbitmq:rabbitmq /etc/rabbitmq/rabbitmq.conf

RUN rabbitmq-plugins enable --offline rabbitmq_mqtt rabbitmq_federation_management rabbitmq_stomp
EXPOSE 15671 15672 5671 5672
