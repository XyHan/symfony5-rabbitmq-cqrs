# symfony5-rabbitmq-cqrs
This short example shows how to consume a Rabbitmq queue, handle the command and then send an event in another Rabbitmq queue.

### Quick Start
This project runs with docker. To start the needed containers, simply use the command<br />`make start`

### Persist data using the command bus
From a terminal, send the following POST request<br />
`curl -X POST --data "requestId=myRequestId&uuid=myUuid" http://localhost:8080/add`

The controller will dispatch a command *MyCommand* using Messenger component's command bus.
The related command handler *MyCommandHandler* will persist the well completed entity *MyEntity* into our database.<br/>
Then the command handler sends an event *MyEvent* using the Messenger component's event bus.

Meanwhile, the controller considers that its job has been done, so it returns the response<br />
`{"requestId":"myRequestId","userUuid":"d3d2186c-c1a7-42ba-8cf3-46722f864bc8","uuid":"myUuid","name":"App\\Application\\Command\\MyCommand\\MyCommand"}`

### Query data using the query bus
From a terminal, send the following GET request<br />
`curl -X GET http://localhost:8080/listall`

This query should return a response as following
`[{"id":1,"uuid":"myUuid"}]`
