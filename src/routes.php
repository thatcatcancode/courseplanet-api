<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

//Gets all registrations for admin view
$app->get('/registrations', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM registration");
    $sth->execute();
    $registrations = $sth->fetchAll();
        return $this->response->withJson($registrations);
});

//Gets all registrations for course 
$app->get('/registrations/course/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM registration WHERE course_id=:id");
           $sth->bindParam("id", $args['id']);
    $sth->execute();
    $registrations = $sth->fetchAll();
        return $this->response->withJson($registrations);
});

//Gets course by id
$app->get('/course/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM course WHERE course_id=:id");
           $sth->bindParam("id", $args['id']);
    $sth->execute();
    $courses = $sth->fetchObject();
        return $this->response->withJson($courses);
});
