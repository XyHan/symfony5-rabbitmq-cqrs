# symfony5-rabbitmq-cqrs
This short example shows how to consume a Rabbitmq queue, handle the command and then, send an event in another Rabbitmq queue.

### Quick Start
This project runs with docker. To start the needed containers, simply use the command<br />`make start`

### Persist data using the command bus inside a controller
From a terminal, send the following POST request<br />
`curl -X POST --data "requestId=myRequestId&uuid=myUuid" http://localhost:8080/add`

The controller will dispatch a command *MyCommand* using Messenger component's command bus.
The related command handler *MyCommandHandler* will persist the well completed entity *MyEntity* into our database.<br/>
Then the command handler sends an event *MyEvent* using the Messenger component's event bus.

Meanwhile, the controller considers that its job has been done, so it returns the response<br />
`{"requestId":"myRequestId","userUuid":"d3d2186c-c1a7-42ba-8cf3-46722f864bc8","uuid":"myUuid","name":"App\\Application\\Command\\MyCommand\\MyCommand"}`

### Persist data using the command bus connected to rabbitmq
Rabbitmq's graphic interface is available at `localhost:15672` using `rabbitmq/rabbitmq` or `user/user123` as credentials.

From `http://localhost:15672/#/queues/%2F/q_gw_to_api_command`, we can add some messages to send to our app's command but.

Click on __Publish message__.<br/>
In __Headers__, add **class** = **MyCommand**, then in __Payload__'s textarea, add `{"requestId":"myRequestId", "userUuid":"myUserUuid", "uuid":"myUuid"}`

The consumption command is already started and handled by supervisor<br/>
`[program:messenger-consume]`<br/>
`command = /usr/local/bin/php /var/www/bin/console --env=dev messenger:consume amqp_command_transport -vv`

Go to `http://localhost:15672/#/queues/%2F/q_api_to_gw_event` and click sur __Get  messages__ -> **Get Message(s)**.<br/>
A message must appears with the following payload `{"uuid":"myUuid","name":"App\\Application\\Event\\MyEvent\\MyEvent"}`

### Query data using the query bus
From a terminal, send the following GET request<br />
`curl -X GET http://localhost:8080/listall`

This query should return a response as following
`[{"id":1,"uuid":"myUuid"}]`

### Testing
#### Functional tests (Behat)
`./vendor/bin/behat`

#### Unit tests (PhpUnit)
`./vendor/bin/phpunit tests`