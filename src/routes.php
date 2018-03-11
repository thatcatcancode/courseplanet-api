<?php

require_once('config.php');

use Slim\Http\Request;
use Slim\Http\Response;

//CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
            //->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Headers', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

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
    $course = $sth->fetchObject();
        return $this->response->withJson($course);
});

$app->post('/pay', function ($request, $response) {
    $input = $request->getParsedBody();

    // Token is created using Checkout or Elements
    // Get the payment token ID submitted by the form:
    $token = $input['stripeToken'];
    $courseId = $input['courseId'];
    $amount = $input['amount'];
    
    //get course by id 
    $sth = $this->db->prepare("SELECT * FROM course WHERE course_id=:id");
    $sth->bindParam("id", $courseId);
    $sth->execute();
    $course = $sth->fetchObject();
    
    // Charge the user's card:
    $charge = \Stripe\Charge::create(array(
    "amount" => $amount,
    "currency" => "usd",
    "description" => $course->{'name'},
    "source" => $token,
    ));

    //increment registrations
    $sql = "INSERT INTO registration (course_id) VALUES ($courseId)";
    $sth = $this->db->prepare($sql);
    $sth->execute();

    //get registrations
    $sth = $this->db->prepare("SELECT * FROM registration WHERE course_id=:id");
    $sth->bindParam("id", $courseId);
    $sth->execute();
    $registrations = $sth->fetchAll();
        return $this->response->withJson($registrations);

});



// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

// // get all todos
// $app->get('/todos', function ($request, $response, $args) {
//     $sth = $this->db->prepare("SELECT * FROM tasks ORDER BY task");
//     $sth->execute();
//     $todos = $sth->fetchAll();
//         return $this->response->withJson($todos);
//     });
    
//     // Retrieve todo with id 
//     $app->get('/todo/[{id}]', function ($request, $response, $args) {
//     $sth = $this->db->prepare("SELECT * FROM tasks WHERE id=:id");
//            $sth->bindParam("id", $args['id']);
//     $sth->execute();
//     $todos = $sth->fetchObject();
//         return $this->response->withJson($todos);
//     });
    
    
//     // Search for todo with given search teram in their name
//     $app->get('/todos/search/[{query}]', function ($request, $response, $args) {
//     $sth = $this->db->prepare("SELECT * FROM tasks WHERE UPPER(task) LIKE :query ORDER BY task");
//            $query = "%".$args['query']."%";
//            $sth->bindParam("query", $query);
//     $sth->execute();
//     $todos = $sth->fetchAll();
//         return $this->response->withJson($todos);
//     });
    
//     // Add a new todo
//     $app->post('/todo', function ($request, $response) {
//            $input = $request->getParsedBody();
//            $sql = "INSERT INTO tasks (task) VALUES (:task)";
//     $sth = $this->db->prepare($sql);
//            $sth->bindParam("task", $input['task']);
//     $sth->execute();
//     $input['id'] = $this->db->lastInsertId();
//         return $this->response->withJson($input);
//     });
           
    
//     // DELETE a todo with given id
//     $app->delete('/todo/[{id}]', function ($request, $response, $args) {
//     $sth = $this->db->prepare("DELETE FROM tasks WHERE id=:id");
//            $sth->bindParam("id", $args['id']);
//     $sth->execute();
//     $todos = $sth->fetchAll();
//         return $this->response->withJson($todos);
//     });
    
//     // Update todo with given id
//     $app->put('/todo/[{id}]', function ($request, $response, $args) {
//            $input = $request->getParsedBody();
//            $sql = "UPDATE tasks SET task=:task WHERE id=:id";
//     $sth = $this->db->prepare($sql);
//            $sth->bindParam("id", $args['id']);
//            $sth->bindParam("task", $input['task']);
//     $sth->execute();
//            $input['id'] = $args['id'];
//         return $this->response->withJson($input);
//     });