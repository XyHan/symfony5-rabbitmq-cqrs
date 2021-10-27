# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
    In order to prove that the CQRS pattern is correctly set up
    As a user
    I want to persist data and then list that data

    Scenario: It persists data in db and then read them
        Given I send a "POST" request to "/add" with parameters:
        |   key         |   value        |
        |   requestId   |   myRequestId  |
        |   uuid        |   myUuid       |
        Then the response status code should be 200
        And the response should be in JSON
        And the JSON node "uuid" should be equal to "myUuid"
        Then we should wait 1

        When I send a "GET" request to "/listall"
        Then the response status code should be 200
        And the response should be in JSON
        And the JSON node "entities[0].uuid" should exist
        And the JSON node "entities[0].uuid" should not be null